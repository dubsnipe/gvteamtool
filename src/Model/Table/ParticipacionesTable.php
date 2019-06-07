<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Participaciones Model
 *
 * @property \App\Model\Table\BrigadasTable|\Cake\ORM\Association\BelongsTo $Brigadas
 * @property \App\Model\Table\VoluntariosTable|\Cake\ORM\Association\BelongsTo $Voluntarios
 *
 * @method \App\Model\Entity\Participacione get($primaryKey, $options = [])
 * @method \App\Model\Entity\Participacione newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Participacione[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Participacione|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Participacione|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Participacione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Participacione[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Participacione findOrCreate($search, callable $callback = null, $options = [])
 */
class ParticipacionesTable extends Table
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

        $this->setTable('participaciones');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Brigadas', [
            'foreignKey' => 'brigada_id',
            'joinType' => 'INNER',
            // https://book.cakephp.org/3.0/en/orm/associations.html#using-the-through-option
            // [Considerar] Dependent: When dependent is set to true, recursive model deletion is possible. In this example, Comment records will be deleted when their associated Article record has been deleted.
            // 'dependent' => true,
        ]);
        $this->belongsTo('Voluntarios', [
            'foreignKey' => 'voluntario_id',
            'joinType' => 'INNER',
            
        ]);
        // $this->table('participaciones');
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
            ->boolean('lider')
            ->requirePresence('lider', 'create')
            ->notEmpty('lider');

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
        $rules->add($rules->existsIn(['brigada_id'], 'Brigadas'));
        $rules->add($rules->existsIn(['voluntario_id'], 'Voluntarios'));

        return $rules;
    }
}
