<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sites Model
 *
 * @method \App\Model\Entity\Site get($primaryKey, $options = [])
 * @method \App\Model\Entity\Site newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Site[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Site|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Site|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Site patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Site[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Site findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SitesTable extends Table
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

        $this->setTable('sites');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('identifier')
            ->maxLength('identifier', 255)
            ->allowEmpty('identifier');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            // ->requirePresence('address', 'create')
            ->allowEmpty('address');

        $validator
            ->scalar('region')
            ->maxLength('region', 255)
            // ->requirePresence('region', 'create')
            ->allowEmpty('region');

        $validator
            ->scalar('area_0')
            ->maxLength('area_0', 255)
            // ->requirePresence('area_0', 'create')
            ->allowEmpty('area_0');

        $validator
            ->scalar('area_1')
            ->maxLength('area_1', 255)
            ->allowEmpty('area_1');

        $validator
            ->scalar('area_2')
            ->maxLength('area_2', 255)
            ->allowEmpty('area_2');

        $validator
            ->scalar('area_3')
            ->maxLength('area_3', 255)
            ->allowEmpty('area_3');

        $validator
            ->decimal('lat')
            ->allowEmpty('lat');

        $validator
            ->decimal('lng')
            ->allowEmpty('lng');

        $validator
            ->scalar('project')
            ->maxLength('project', 255)
            // ->requirePresence('project', 'create')
            ->allowEmpty('project');

        $validator
            ->scalar('telephone')
            ->maxLength('telephone', 255)
            // ->requirePresence('telephone', 'create')
            ->allowEmpty('telephone');

        $validator
            ->scalar('masons')
            ->maxLength('masons', 255)
            // ->requirePresence('masons', 'create')
            ->allowEmpty('masons');

        $validator
            ->scalar('helpers')
            ->maxLength('helpers', 255)
            // ->requirePresence('helpers', 'create')
            ->allowEmpty('helpers');

        $validator
            ->scalar('notes')
            ->maxLength('notes', 16777215)
            ->allowEmpty('notes');

        $validator
            // ->requirePresence('followup', 'create')
            ->allowEmpty('followup');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
