<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;
/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        // $this->addBehavior('Acl.Acl', ['controlled']);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        // $validator
            // ->integer('id')
            // ->notEmpty('id', 'create');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 150)
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 150)
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('rol')
            ->requirePresence('rol', 'create')
            ->notEmpty('rol')
            ->add('role', 'inList', [
                'rule' => ['inList', ['admin', 'manager', 'user']],
                'message' => 'Please enter a valid role'
            ]);

        $validator
            ->scalar('username')
            ->maxLength('username', 20)
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->requirePresence(['password', 're_password'], 'create')
            ->scalar('password')
            ->scalar('re_password')
            ->minLength('password', 6)
            ->maxLength('re_password', 6)
            ->maxLength('password',30)
            ->maxLength('re_password', 30)
            ->notEmpty('password', 're_password')
            ->add('re_password', [
                'compareWith' => [
                    'rule' => ['compareWith', 'password'],
                    'message' => __("Your password confirmation must match with your password.")

                ]
            ]);
            // https://stackoverflow.com/questions/34245778/validation-doesnt-work-cakephp-3        
        
        $validator
            ->scalar('current_password')
            ->scalar('new_password')
            ->scalar('re_new_password')
            ->minLength('current_password', 6)
            ->minLength('new_password', 6)
            ->minLength('re_new_password', 6)
            ->maxLength('current_password', 30)
            ->maxLength('new_password', 30)
            ->maxLength('re_new_password', 30)
            ->allowEmpty('new_password', true)
            ->allowEmpty('re_new_password', true)
            ->add('current_password','custom',[
                'rule'=>  function($value, $context){
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
                    }
                    return false;
                },
                'message'=>'Password does not mach with current password.',
            ])
            ->add('new_password','custom',[
                'rule'=>  function($value, $context){
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return false;
                        }
                    }
                    return true;
                },
                'message'=>'New password should not mach with current one.',
            ])
            ->add('re_new_password', [
                'compareWith' => [
                    'rule' => ['compareWith', 'new_password'],
                    'message' => __("New passwords do not match.")
                ]
            ]);

        $validator
            ->scalar('remember_token')            
            ->allowEmpty('password');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['username']));

        return $rules;
    }
}
