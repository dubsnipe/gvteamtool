<?php
// src/Model/Table/BrigadasTable.php
namespace App\Model\Table;


use Cake\ORM\Table;
use Cake\Validation\Validator;

// https://github.com/cakephp/cakephp/issues/7864
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;

// Import the Query class https://book.cakephp.org/3.0/en/tutorials-and-examples/cms/tags-and-users.html
use Cake\ORM\Query;

class BrigadasTable extends Table 
{
    
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Tags');
        $this->belongsToMany('Sites');
        $this->belongsToMany('Traductores');
        
        $this->setTable('brigadas');
        
        
        // https://book.cakephp.org/3.0/en/orm/associations.html#using-the-through-option
        $this->belongsToMany('Voluntarios', [
            'foreignKey' => 'brigada_id',
            'targetForeignKey' => 'voluntario_id',
            'joinTable' => 'participaciones',
            'saveStrategy' => 'replace',
            'through' => 'Participaciones',
            'sort' => ['Voluntarios.id' => 'ASC'],
        ]);
        
        
        // Custom plugin behaviors
        $this->addBehavior('Search.Search');
        $this->addBehavior('Muffin/Trash.Trash', [
            'field' => 'deleted'
        ]);
        
        // http://josediazgonzalez.com/2015/12/05/uploading-files-and-images/
        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'photo' => [
                'fields' => [
                    'dir' => 'dir',
                    'size' => 'photo_size', // defaults to `size`
                    'type' => 'photo_type', // defaults to `type`
                ],
                
                'nameCallback' => function ($table, $entity, $data, $field, $settings) {
                    if ($entity->gvCode){
                        $array = explode(".", $data['name']);
                        return strtolower($entity->gvCode) . '_' . date("Ymd-hisa") . '.jpg';
                        
                    } else{
                        $array = explode(".", $data['name']);
                        $newArray = array_pop($array);
                        return strtolower(join('_', $array)) . '_' . date("Ymd-hisa") . '.jpg';
                    }
                },
                
                'transformer' =>  function ($table, $entity, $data, $field, $settings) {

                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);

                    // Store the thumbnail in a temporary file
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    
                    // Use the Imagine library to DO THE THING
                    $size = new \Imagine\Image\Box(640, 640);
                    $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                    $imagine = new \Imagine\Gd\Imagine();
                    
                    // Save that modified file to our temp file
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp);

                    $filenameTmp = explode('.', $data['name']);
                    array_pop($filenameTmp);
                    $filenameTmp = join('_', $filenameTmp) . '.jpg';
                    // return debug($filenameTmp);
                    
                    // Now return the original *and* the thumbnail
                    return [
                        $data['tmp_name'] => $filenameTmp,
                        $tmp => 'thumbnail-' . $filenameTmp,
                    ];
                },
                
                'deleteCallback' => function ($path, $entity, $field, $settings) {
                    // When deleting the entity, both the original and the thumbnail will be removed
                    // when keepFilesOnDelete is set to false
                    
                    $entity->{$field} = null;
                    
                    return [
                        $path . $entity->{$field},
                        $path . 'thumbnail-' . $entity->{$field}

                    ];
                },
                'keepFilesOnDelete' => false
            ]
        ]);
        
        // Setup search filter using search manager
        // https://stackoverflow.com/questions/33146453/how-to-search-type-datetime-in-friendsofcake-search-plugin
        $this->searchManager()
            ->value('id')
            // Here we will alias the 'q' query param to search the `Articles.title`
            // field and the `Articles.content` field, using a LIKE match, with `%`
            // both before and after.
            ->add('name', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['name']
            ])
            ->add('arrivalBefore', 'Search.Like', [
                'comparison' => '<=',
                'field' => ['arrival']
            ])
            ->add('arrivalAfter', 'Search.Like', [
                'comparison' => '>=',
                'field' => ['arrival']
            ])
            ->add('region', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['region']
            ])
            ->add('gvCode', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['gvCode']
            ])
            ->add('team_type', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['team_type']
            ])

                ->add('foo', 'Search.Callback', [
                'callback' => function ($query, $args, $filter) {
                // Modify $query as required
                }
            ]);

        
    }

    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('name');
        // https://stackoverflow.com/questions/53015027/how-to-allow-empty-on-file-types-for-cakephp-3-validation

        $validator
            ->allowEmpty('photo', 'create')
            ->allowEmpty('photo', 'update');

        $validator
            ->allowEmpty('dir', 'create')
            ->allowEmpty('dir', 'update');
        
        return $validator;
    }


    public function findTagged(Query $query, array $options)
    {
        $columns = [
            'Brigadas.id', 'Brigadas.created', 'Brigadas.modified', 'Brigadas.status', 'Brigadas.name',
        ];

        $query = $query
            ->select($columns)
            ->distinct($columns);

        if (empty($options['tags'])) {
            // If there are no tags provided, find articles that have no tags.
            $query->leftJoinWith('Tags')
                ->where(['Tags.title IS' => null]);
        } else {
            // Find articles that have one or more of the provided tags.
            $query->innerJoinWith('Tags')
                ->where(['Tags.title IN' => $options['tags']]);
        }

        return $query->group(['Brigadas.id']);
    }

    

    // https://book.cakephp.org/3.0/en/tutorials-and-examples/cms/tags-and-users.html
    
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->tag_string) {
            $entity->tags = $this->_buildTags($entity->tag_string);
        }

    
    }

    
    protected function _buildTags($tagString)
    {
        // Trim tags
        $newTags = array_map('trim', explode(',', $tagString));
        // Remove all empty tags
        $newTags = array_filter($newTags);
        // Reduce duplicated tags
        $newTags = array_unique($newTags);

        $out = [];
        $query = $this->Tags->find()
            ->where(['Tags.title IN' => $newTags]);

        // Remove existing tags from the list of new tags.
        foreach ($query->extract('title') as $existing) {
            $index = array_search($existing, $newTags);
            if ($index !== false) {
                unset($newTags[$index]);
            }
        }
        // Add existing tags.
        foreach ($query as $tag) {
            $out[] = $tag;
        }
        // Add new tags.
        foreach ($newTags as $tag) {
            $out[] = $this->Tags->newEntity(['title' => $tag]);
        }
        return $out;
    }
    
}