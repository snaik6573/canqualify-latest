<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
/**
 * Users Model
 *
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\HasMany $Clients
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

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'			
        ]);
        $this->hasOne('Clients', [
            'foreignKey' => 'user_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasOne('Contractors', [
            'foreignKey' => 'user_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
		$this->hasOne('Employees', [
            'foreignKey' => 'user_id'            
        ]);
        $this->hasOne('ClientUsers', [
            'foreignKey' => 'user_id'
        ]);
		$this->hasOne('CustomerRepresentative', [
            'foreignKey' => 'user_id'            
        ]);
		$this->hasOne('ContractorUsers', [
            'foreignKey' => 'user_id'            
        ]);		
		 $this->hasMany('Documents', [
            'foreignKey' => 'client_id'           
        ]);
        $this->hasMany('CanqualifyUsers', [
            'foreignKey' => 'user_id'
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
            ->allowEmptyString('id', 'create');

        $validator
            ->requirePresence('username')
            ->add('username', 'validFormat', ['rule' => 'email', 'message' => 'Email id must be valid'])
            ->maxLength('username', 150)
            ->allowEmptyString('username', false, 'Please enter your email id');

        $validator
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
            'message'=>'The old password does not match the current password!',
            ])
            ->allowEmptyString('current_password', false, 'Please enter old password');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->add('password', 'minLength', ['rule' => ['minLength', 4], 'message' => 'Password must be at least 4 characters long'])
            ->allowEmptyString('password', false, 'Please enter password');

        $validator
            ->allowEmptyString('confirm_password', false)
            ->add('confirm_password', ['compare' => ['rule' => ['compareWith', 'password'], 'message' => 'Password must be matched']])
            ->allowEmptyString('confirm_password', false, 'Password must be matched');

        $validator
            ->allowEmptyString('active');

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
        $rules->add($rules->isUnique(['username'],'Email entered is already exists'));  
        $rules->add($rules->isUnique(['login_username'],'Username entered is already exists'));      
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
    public function findAuth(Query $query, array $options)
    {
       /* $query
            ->orWhere(['Users.username' => $options['username']])
            ->orWhere(['Users.login_username' => $options['username']]);*/
         $query->where([
            'OR' => [ //<-- we use OR operator for our SQL
                ['Users.username' => $options['username']], //<-- username column
                ['Users.login_username' => $options['username']] //<-- email column
            ]], [], true); // <-- true here means overwrite original query !IMPORTANT. 

        return $query;
    }


}
