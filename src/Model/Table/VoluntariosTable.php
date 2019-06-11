<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Voluntarios Model
 *
 * @method \App\Model\Entity\Voluntario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Voluntario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Voluntario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Voluntario|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Voluntario|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Voluntario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Voluntario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Voluntario findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VoluntariosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');    
        $this->setTable('voluntarios');
        $this->setPrimaryKey('id');
        
        $this->setDisplayField('full_name');
        
        // Previo a tabla through
        // $this->belongsToMany('Brigadas'); // https://book.cakephp.org/3.0/en/orm/associations.html#belongstomany-associations        
        
        // https://book.cakephp.org/3.0/en/orm/associations.html#using-the-through-option
        $this->belongsToMany('Brigadas', [
            // 'alias' => 'Brigadas',
            'foreignKey' => 'voluntario_id',
            'targetForeignKey' => 'brigada_id',
            'joinTable' => 'participaciones',
            'through' => 'Participaciones',
            'sort' => ['Brigadas.id' => 'ASC'],
        ]);

        // https://stackoverflow.com/questions/29758841/saving-additional-data-to-a-joint-table-in-cakephp-3-0
        // $this->hasMany('Participaciones', [
            // 'foreignKey' => 'voluntario_id',
        // ]);
        
        $this->addBehavior('Timestamp');
        // http://www.naidim.org/cakephp-3-tutorial-2-database-and-model
        //  $this->displayField('full_name'); // field or virtual field used for default display in associated models, if absent 'id' is assumed
        
        
        // Add the behaviour to your table
        $this->addBehavior('Search.Search');
        $this->addBehavior('Muffin/Trash.Trash', [
            'field' => 'deleted'
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
                'field' => ['firstName', 'middleName', 'lastName']
            ])
            ->add('firstName', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['firstName']
            ])
            ->add('lastName', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['lastName']
            ])
            ->add('gender', 'Search.Like', [
                // 'before' => true,
                // 'after' => true,
                // 'fieldMode' => 'OR',
                // 'comparison' => 'LIKE',
                // 'wildcardAny' => '*',
                // 'wildcardOne' => '?',
                'field' => ['gender']
            ])
            ->add('country', 'Search.Like', [
                // 'before' => true,
                // 'after' => true,
                // 'fieldMode' => 'OR',
                // 'comparison' => 'LIKE',
                // 'wildcardAny' => '*',
                // 'wildcardOne' => '?',
                'field' => ['passportCountry', 'residenceCountry']
            ])
            ->add('state', 'Search.Like', [
                // 'before' => true,
                // 'after' => true,
                // 'fieldMode' => 'OR',
                // 'comparison' => 'LIKE',
                // 'wildcardAny' => '*',
                // 'wildcardOne' => '?',
                'field' => ['state']
            ])
            ->add('email', 'Search.Like', [
                // 'before' => true,
                // 'after' => true,
                // 'fieldMode' => 'OR',
                // 'comparison' => 'LIKE',
                // 'wildcardAny' => '*',
                // 'wildcardOne' => '?',
                'field' => ['email']
            ])
            ->add('residence', 'Search.Like', [
                // 'before' => true,
                // 'after' => true,
                // 'fieldMode' => 'OR',
                // 'comparison' => 'LIKE',
                // 'wildcardAny' => '*',
                // 'wildcardOne' => '?',
                'field' => ['city', 'state', 'postalCode']
            ])
            ->add('foo', 'Search.Callback', [
                'callback' => function ($query, $args, $filter) {
                // Modify $query as required
                }
            ]);
            
    }

    
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->boolean('status')
            ->allowEmpty('status');

        $validator
            ->scalar('firstName')
            ->maxLength('firstName', 255)
            ->notEmpty('firstName');

        $validator
            ->scalar('lastName')
            ->maxLength('lastName', 255)
            ->notEmpty('lastName');

        $validator
            // Eliminado por errores. Ver Vol #218
            // ->date('birth')
            ->allowEmpty('birth');

        $validator
            ->scalar('state')
            ->maxLength('state', 255)
            ->allowEmpty('state');

        $validator
            ->scalar('residenceCountry')
            ->maxLength('residenceCountry', 255)
            ->allowEmpty('residenceCountry');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 255)
            ->allowEmpty('phone');

        $validator
            ->scalar('passportNumber')
            ->maxLength('passportNumber', 255)
            ->allowEmpty('passportNumber');

        $validator
            ->scalar('passportCountry')
            ->maxLength('passportCountry', 255)
            ->allowEmpty('passportCountry');

        $validator
            ->scalar('postalCode')
            ->maxLength('postalCode', 255)
            ->allowEmpty('postalCode');

        $validator
            ->scalar('spanishLevel')
            ->maxLength('spanishLevel', 255)
            ->allowEmpty('spanishLevel');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 255)
            ->allowEmpty('gender');

        $validator
            ->scalar('tShirt')
            ->maxLength('tShirt', 255)
            ->allowEmpty('tShirt');

        $validator
            ->scalar('emergencyContact')
            ->maxLength('emergencyContact', 255)
            ->allowEmpty('emergencyContact');

        $validator
            ->scalar('emergencyNumber')
            ->maxLength('emergencyNumber', 255)
            ->allowEmpty('emergencyNumber');

        $validator
            ->scalar('dietaryRestrictions')
            ->maxLength('dietaryRestrictions', 255)
            ->allowEmpty('dietaryRestrictions');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->scalar('allergies')
            ->maxLength('allergies', 255)
            ->allowEmpty('allergies');

        $validator
            ->scalar('healthConsiderations')
            ->maxLength('healthConsiderations', 255)
            ->allowEmpty('healthConsiderations');

        $validator
            ->scalar('middleName')
            ->maxLength('middleName', 255)
            ->allowEmpty('middleName');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->allowEmpty('city');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmpty('address');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        // $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
