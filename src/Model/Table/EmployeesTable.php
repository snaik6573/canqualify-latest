<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employees Model
 *
 * @property \App\Model\Table\StatesTable|\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ContractorsTable|\Cake\ORM\Association\BelongsTo $Contractors
 * @property |\Cake\ORM\Association\HasMany $EmployeeSites
 *
 * @method \App\Model\Entity\Employee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeesTable extends Table
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

        $this->setTable('employees');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('States', [
            'foreignKey' => 'state_id'
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        // $this->belongsTo('Contractors', [
        //     'foreignKey' => 'contractor_id'
        // ]);
        $this->hasMany('EmployeeSites', [
            'foreignKey' => 'employee_id',
            'dependent'  => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('EmployeeExplanations', [
            'foreignKey' => 'employee_id',
            'dependent'  => true,
            'cascadeCallbacks' => true
        ]);
		$this->hasMany('EmployeeAnswers', [
            'foreignKey' => 'employee_id',
            'dependent'  => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('TrainingAnswers', [
            'foreignKey' => 'employee_id',
            'dependent'  => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('EmployeeContractors', [
            'foreignKey' => 'employee_id',
            'dependent'  => true,
            'cascadeCallbacks' => true
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
            ->scalar('addressline_1')
            ->maxLength('addressline_1', 255)
            ->allowEmptyString('addressline_1');
            //->allowEmptyString('addressline_1', false, 'Please enter your address');

        $validator
            ->scalar('addressline_2')
            ->maxLength('addressline_2', 255)
            ->allowEmptyString('addressline_2');

        $validator
            ->scalar('city')
            ->maxLength('city', 50)
            ->allowEmptyString('city');

       /* $validator
            ->scalar('country_id')
            ->allowEmptyString('country_id', false, 'Please select your country');

        $validator
            ->scalar('state_id')
            ->allowEmptyString('state_id', false, 'Please select your state');*/

        $validator
            ->scalar('zip')
            ->maxLength('zip', 45)
            ->allowEmptyString('zip');

        $validator
            ->scalar('pri_contact_fn')
            ->maxLength('pri_contact_fn', 45)
            ->allowEmptyString('pri_contact_fn', false, 'Please enter your first name');

        $validator
            ->scalar('pri_contact_ln')
            ->maxLength('pri_contact_ln', 45)
            ->allowEmptyString('pri_contact_ln', false, 'Please enter your last name');

        /*$validator
            ->scalar('pri_contact_pn')
            ->maxLength('pri_contact_pn', 45)
            ->allowEmptyString('pri_contact_pn', false, 'Please enter your phone no.');*/

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->allowEmptyString('created_by', false);

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        $validator
            ->boolean('tnc')
            ->allowEmptyString('tnc')
            ->add('tnc', [ 'bool' => [
                'rule' => array('comparison', '!=', 0),
                'message' => 'Please read Terms & Conditions'
            ]
            ]);

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
       /* $rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));*/
        $rules->add($rules->existsIn(['user_id'], 'Users'));
       // $rules->add($rules->existsIn(['contractor_id'], 'Contractors'));

        return $rules;
    }
}
