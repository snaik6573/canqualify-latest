<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IndustryAverages Model
 *
 * @property \App\Model\Table\NaiscCodesTable|\Cake\ORM\Association\BelongsTo $NaiscCodes
 *
 * @method \App\Model\Entity\IndustryAverage get($primaryKey, $options = [])
 * @method \App\Model\Entity\IndustryAverage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IndustryAverage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IndustryAverage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IndustryAverage|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IndustryAverage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IndustryAverage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IndustryAverage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IndustryAveragesTable extends Table
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

        $this->setTable('industry_averages');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('NaiscCodes', [
            'foreignKey' => 'naisc_code_id'
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
            ->numeric('total_recordable_cases')
            ->allowEmptyString('total_recordable_cases');

        $validator
            ->numeric('total')
            ->allowEmptyString('total');

        $validator
            ->numeric('cases_with_days_away_from_work')
            ->allowEmptyString('cases_with_days_away_from_work');

        $validator
            ->numeric('cases_with_days_of_job_transfer_or_restriction')
            ->allowEmptyString('cases_with_days_of_job_transfer_or_restriction');

        $validator
            ->numeric('other_recordable_cases')
            ->allowEmptyString('other_recordable_cases');

        $validator
            ->numeric('industry_average')
            ->allowEmptyString('industry_average');

        $validator
            ->integer('year')
            ->allowEmptyString('year');

        $validator
            ->integer('created_by')
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
        $rules->add($rules->existsIn(['naisc_code_id'], 'NaiscCodes'));

        return $rules;
    }
}
