<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientNotes Model
 *
 * @property \App\Model\Table\ContractorsTable|\Cake\ORM\Association\BelongsTo $Contractors
 * @property \App\Model\Table\CustomerRepresentativesTable|\Cake\ORM\Association\BelongsTo $CustomerRepresentatives
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\ClientNote get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientNote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientNote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientNote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientNote|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientNote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientNote findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ClientNotesTable extends Table
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

        $this->setTable('client_notes');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Contractors', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->belongsTo('CustomerRepresentatives', [
            'foreignKey' => 'customer_representative_id'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
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
            ->allowEmptyString('id');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 200)
            ->allowEmptyString('subject');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->boolean('show_to_contractor')
            ->allowEmptyString('show_to_contractor');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        $validator
            ->boolean('is_read')
            ->allowEmptyString('is_read');

        $validator
            ->boolean('follow_up')
            ->allowEmptyString('follow_up');

        $validator
            ->dateTime('feature_date')
            ->allowEmptyDateTime('feature_date');

        $validator
            ->boolean('show_to_client')
            ->allowEmptyString('show_to_client');

        $validator
            ->scalar('client_ids')
            ->allowEmptyString('client_ids');

        $validator
            ->boolean('is_completed')
            ->allowEmptyString('is_completed');

        $validator
            ->scalar('company_name')
            ->maxLength('company_name', 155)
            ->allowEmptyString('company_name');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 155)
            ->allowEmptyString('icon');

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
        $rules->add($rules->existsIn(['customer_representative_id'], 'CustomerRepresentatives'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
