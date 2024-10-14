<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contractors Model
 *
 * @property \App\Model\Table\StatesTable|\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Contractor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Contractor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Contractor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Contractor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contractor|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contractor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Contractor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Contractor findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContractorsTable extends Table
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

        $this->setTable('contractors');
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
        $this->hasMany('Payments', [
            'foreignKey' => 'contractor_id'			
        ]);
        $this->hasMany('ContractorSites', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('Icons', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('OverallIcons', [
            'foreignKey' => 'contractor_id'
        ]);
		$this->hasMany('SuggestedIcons', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('ClientRequests', [
            'foreignKey' => 'contractor_id'
        ]);
		$this->hasMany('ContractorServices', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('ContractorInvoices', [
            'foreignKey' => 'contractor_id'
        ]);
	   $this->hasMany('ContractorTempsites', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('ContractorDocs', [
            'foreignKey' => 'contractor_id'
        ]);
		$this->hasMany('ContractorAnswers', [
            'foreignKey' => 'contractor_id'
        ]);
		$this->hasMany('ContractorUsers', [
            'foreignKey' => 'contractor_id'            
        ]);
        $this->belongsTo('CustomerRepresentative', [
            'foreignKey' => 'customer_representative_id'
        ]);
        $this->hasMany('ContractorClients', [
            'foreignKey' => 'contractor_id'
        ]);
        // $this->hasMany('Employees', [
        //     'foreignKey' => 'contractor_id'
        // ]);        
        $this->hasMany('Notes', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('FinalOverallIcons', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('EmployeeContractors', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('NaiscViews', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('ContractorTins', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('ContractorSiteLists', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'gc_client_id'
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
            ->scalar('company_name')
            ->maxLength('company_name', 155)
            ->allowEmptyString('company_name', false, 'Please enter your company name');

        $validator
            ->scalar('addressline_1')
            ->maxLength('addressline_1', 155)
            ->allowEmptyString('addressline_1', false, 'Please enter your address');

        $validator
            ->scalar('addressline_2')
            ->maxLength('addressline_2', 155)
            ->allowEmptyString('addressline_2');

        $validator
            ->scalar('city')
            ->maxLength('city', 45)
            ->allowEmptyString('city', false, 'Please enter your city');

        $validator
            ->scalar('country_id')
            ->allowEmptyString('country_id', false, 'Please select your country');

        $validator
            ->scalar('state_id')
            ->allowEmptyString('state_id', false, 'Please select your state');

        $validator
            ->scalar('zip')
            ->allowEmptyString('zip');

        $validator
            ->scalar('pri_contact_fn')
            ->maxLength('pri_contact_fn', 45)
            ->allowEmptyString('pri_contact_fn', false, 'Please enter your first name');

        $validator
            ->scalar('pri_contact_ln')
            ->maxLength('pri_contact_ln', 45)
            ->allowEmptyString('pri_contact_ln', false, 'Please enter your last name');

        $validator
            ->scalar('pri_contact_pn')
            ->maxLength('pri_contact_pn', 45)
            ->allowEmptyString('pri_contact_pn', false, 'Please enter your phone no.');

        $validator
            ->boolean('is_safety_sensitive')
            ->allowEmptyString('is_safety_sensitive');

        $validator
            ->integer('registration_status')
            ->allowEmptyString('registration_status');

        $validator
            ->boolean('tnc')
            ->allowEmptyString('tnc')
            ->add('tnc', [ 'bool' => [
		'rule' => array('comparison', '!=', 0),
		'message' => 'Please read Terms & Conditions'
		]
	    ]);

        $validator->add('company_tin', [
            'size' => ['rule' => ['maxLength', 10], 'message' => 'Company TIN must be 9 characters long'],
            'size' => ['rule' => ['minLength', 10], 'message' => 'Company TIN must be 9 characters long'],
            'valid' => ['rule' => ['custom', '/^([0-9 \-]+)$/'], 'message' => 'Company TIN must be numbers and hyphen only']
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
        /*$rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));*/
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->isUnique(['company_tin'],'An account with this TIN already exists, please contact customer support at (801) 851-1810.'));

        return $rules;
    }
}
