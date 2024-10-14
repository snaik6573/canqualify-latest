<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clients Model
 *
 * @property \App\Model\Table\AccountTypesTable|\Cake\ORM\Association\BelongsTo $AccountTypes
 * @property \App\Model\Table\StatesTable|\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\CountriesTable|\Cake\ORM\Association\BelongsTo $Countries
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ClientQuestionsTable|\Cake\ORM\Association\HasMany $ClientQuestions
 * @property \App\Model\Table\ClientServicesTable|\Cake\ORM\Association\HasMany $ClientServices
 * @property \App\Model\Table\QuestionsTable|\Cake\ORM\Association\HasMany $Questions
 * @property \App\Model\Table\RegionsTable|\Cake\ORM\Association\HasMany $Regions
 * @property \App\Model\Table\SitesTable|\Cake\ORM\Association\HasMany $Sites
 *
 * @method \App\Model\Entity\Client get($primaryKey, $options = [])
 * @method \App\Model\Entity\Client newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Client[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Client|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Client|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Client patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Client[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Client findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ClientsTable extends Table
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

        $this->setTable('clients');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('AccountTypes', [
            'foreignKey' => 'account_type_id'
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id'
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType'   => 'INNER' 
        ]);
        $this->belongsTo('CustomerReps', [
            'foreignKey' => 'customer_rep_id'
        ]);
        $this->hasMany('Benchmarks', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('ClientModules', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('ClientQuestions', [
            'foreignKey' => 'client_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('ClientRequests', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('ClientServices', [
            'foreignKey' => 'client_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('ClientUsers', [
            'foreignKey' => 'client_id'
        ]);
    
        $this->hasMany('ContractorAnswers', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('ContractorDocs', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('ContractorInvoices', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('ContractorSites', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('ContractorTempsites', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Documents', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('FormsNDocs', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Icons', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Leads', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('OverallIcons', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Questions', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Regions', [
            'foreignKey' => 'client_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Sites', [
            'foreignKey' => 'client_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('SuggestedIcons', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('SuggestedOverallIcons', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('TrainingQuestions', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Trainings', [
            'foreignKey' => 'client_id'
        ]);
		$this->hasMany('EmployeeAnswers', [
            'foreignKey' => 'client_id'
        ]);
		$this->hasMany('ClientEmployeeQuestions', [
            'foreignKey' => 'client_id'
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
            ->allowEmptyString('company_name', false, 'Please enter your company_name');

        $validator
            ->scalar('addressline_1')
            ->maxLength('addressline_1', 155)
            ->allowEmptyString('addressline_1', false, 'Please enter your addressline_1');

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

       /* $validator
            ->scalar('country')
            ->allowEmptyString('country', false, 'Please select your country');

        $validator
            ->scalar('state')
            ->allowEmptyString('state', false, 'Please select your state');*/

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
            ->allowEmptyString('pri_contact_pn', false, 'Please enter phone no.');

        $validator
            ->dateTime('membership_startdate')
            ->allowEmptyDateTime('membership_startdate');

        $validator
            ->dateTime('membership_enddate')
            ->allowEmptyDateTime('membership_enddate');

        $validator
            ->scalar('registration_status')
            ->maxLength('registration_status', 45)
            ->allowEmptyString('registration_status');

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
        $rules->add($rules->existsIn(['account_type_id'], 'AccountTypes'));
        /*$rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));*/
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
