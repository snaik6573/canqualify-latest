<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LeadNotes Model
 *
 * @property \App\Model\Table\LeadsTable&\Cake\ORM\Association\BelongsTo $Leads
 * @property \App\Model\Table\CustomerRepresentativeTable&\Cake\ORM\Association\BelongsTo $CustomerRepresentative
 *
 * @method \App\Model\Entity\LeadNote get($primaryKey, $options = [])
 * @method \App\Model\Entity\LeadNote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LeadNote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeadNote|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeadNote saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeadNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LeadNote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeadNote findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeadNotesTable extends Table
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

        $this->setTable('lead_notes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Leads', [
            'foreignKey' => 'lead_id'
        ]);
        $this->belongsTo('CustomerRepresentative', [
            'foreignKey' => 'customer_representative_id'
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
            ->scalar('subject')
            ->allowEmptyString('subject');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->boolean('follow_up')
            ->allowEmptyString('follow_up');
    

       /* $validator
            ->dateTime('feature_date')
            ->allowEmptyDateTime('feature_date');*/

        $validator
            ->boolean('is_completed')
            ->allowEmptyString('is_completed');

        $validator
            ->boolean('show_to_client')
            ->allowEmptyString('show_to_client');

        $validator
            ->integer('created_by')
            //->requirePresence('created_by', 'create')
            //->notEmptyString('created_by');
            ->allowEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

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
        $rules->add($rules->existsIn(['lead_id'], 'Leads'));
        $rules->add($rules->existsIn(['customer_representative_id'], 'CustomerRepresentative'));

        return $rules;
    }
}
