<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SuggestedIcons Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\ContractorsTable|\Cake\ORM\Association\BelongsTo $Contractors
 * @property \App\Model\Table\SuggestedOverallIconsTable|\Cake\ORM\Association\BelongsTo $SuggestedOverallIcons
 *
 * @method \App\Model\Entity\SuggestedIcon get($primaryKey, $options = [])
 * @method \App\Model\Entity\SuggestedIcon newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SuggestedIcon[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SuggestedIcon|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SuggestedIcon|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SuggestedIcon patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SuggestedIcon[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SuggestedIcon findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SuggestedIconsTable extends Table
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

        $this->setTable('suggested_icons');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        $this->belongsTo('Contractors', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->belongsTo('SuggestedOverallIcons', [
            'foreignKey' => 'suggested_overall_icon_id'
        ]);
        $this->belongsTo('BenchmarkTypes', [
            'foreignKey' => 'benchmark_type_id'
        ]);
        $this->belongsTo('BenchmarkCategories', [
            'foreignKey' => 'category'
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
            ->scalar('bench_type')
            ->maxLength('bench_type', 155)
            ->allowEmptyString('bench_type');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 155)
            ->allowEmptyString('icon');

        $validator
            ->scalar('category')
            ->maxLength('category', 155)
            ->allowEmptyString('category');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        $validator
            ->boolean('is_forced')
            ->allowEmptyString('is_forced');

        $validator
            ->scalar('documents')
            ->allowEmptyString('documents');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->boolean('show_to_contractor')
            ->allowEmptyString('show_to_contractor');

        $validator
            ->boolean('show_to_clients')
            ->allowEmptyString('show_to_clients');

        $validator
            ->integer('icon_from')
            ->allowEmptyString('icon_from');

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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['contractor_id'], 'Contractors'));
        $rules->add($rules->existsIn(['suggested_overall_icon_id'], 'SuggestedOverallIcons'));

        return $rules;
    }
}
