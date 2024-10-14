<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Benchmarks Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $BenchmarkCategories
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\BenchmarkTypesTable|\Cake\ORM\Association\BelongsTo $BenchmarkTypes
 *
 * @method \App\Model\Entity\Benchmark get($primaryKey, $options = [])
 * @method \App\Model\Entity\Benchmark newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Benchmark[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Benchmark|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Benchmark|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Benchmark patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Benchmark[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Benchmark findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BenchmarksTable extends Table
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

        $this->setTable('benchmarks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('BenchmarkCategories', [
            'foreignKey' => 'benchmark_category_id'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        $this->belongsTo('BenchmarkTypes', [
            'foreignKey' => 'benchmark_type_id'
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
            ->numeric('range_from')
            ->allowEmptyString('range_from');

        $validator
            ->numeric('range_to')
            ->allowEmptyString('range_to');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 155)
            ->allowEmptyString('icon');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        $validator
            ->scalar('conclusion')
            ->allowEmptyString('conclusion');

        $validator
            ->boolean('is_percentage')
            ->allowEmptyString('is_percentage');

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
        $rules->add($rules->existsIn(['benchmark_category_id'], 'BenchmarkCategories'));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['benchmark_type_id'], 'BenchmarkTypes'));

        return $rules;
    }
}
