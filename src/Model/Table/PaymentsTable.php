<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payments Model
 *
 * @property \App\Model\Table\ContractorsTable|\Cake\ORM\Association\BelongsTo $Contractors
 * @property \App\Model\Table\ContractorInvoicesTable|\Cake\ORM\Association\HasMany $ContractorInvoices
 * @property \App\Model\Table\PaymentDetailsTable|\Cake\ORM\Association\HasMany $PaymentDetails
 *
 * @method \App\Model\Entity\Payment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Payment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Payment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Payment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payment|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Payment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Payment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentsTable extends Table
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

        $this->setTable('payments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Contractors', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->hasMany('ContractorInvoices', [
            'foreignKey' => 'payment_id'
        ]);
        $this->hasMany('PaymentDetails', [
            'foreignKey' => 'payment_id'
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
            ->scalar('response')
            ->allowEmptyString('response');

        $validator
            ->numeric('totalprice')
            ->allowEmptyString('totalprice');

        $validator
            ->scalar('secret_link')
            ->maxLength('secret_link', 255)
            ->allowEmptyString('secret_link');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        $validator
            ->numeric('p_amt')
            ->allowEmptyString('p_amt');

        $validator
            ->date('subscription_date')
            ->allowEmptyDate('subscription_date');

        $validator
            ->scalar('transaction_status')
            ->allowEmptyString('transaction_status');

        $validator
            ->scalar('p_transactionid')
            ->maxLength('p_transactionid', 155)
            ->allowEmptyString('p_transactionid');

	$validator
            ->requirePresence('email')
            ->add('email', 'validFormat', ['rule' => 'email', 'message' => 'Email id must be valid'])
            ->maxLength('email', 150)
            ->allowEmptyString('email', false, 'Please enter your email id');

	$validator
            ->scalar('ccnumber')            
            ->maxLength('ccnumber', 150)
            ->allowEmptyString('ccnumber', false, 'Please enter valid credit card number');

	$validator
            ->scalar('ccname')            
            ->maxLength('ccname', 150)
            ->allowEmptyString('ccname', false, 'Please enter correct name on the card');

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
        $rules->add($rules->existsIn(['contractor_id'], 'Contractors'));

        return $rules;
    }
}
