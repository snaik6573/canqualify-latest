<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BenchmarkTypes Model
 *
 * @property \App\Model\Table\BenchmarksTable|\Cake\ORM\Association\HasMany $Benchmarks
 *
 * @method \App\Model\Entity\BenchmarkType get($primaryKey, $options = [])
 * @method \App\Model\Entity\BenchmarkType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BenchmarkType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BenchmarkType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BenchmarkType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BenchmarkType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BenchmarkType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BenchmarkType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BenchmarkTypesTable extends Table
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

        $this->setTable('benchmark_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Benchmarks', [
            'foreignKey' => 'benchmark_type_id'
        ]);
        $this->hasMany('SuggestedIcons', [
            'foreignKey' => 'benchmark_type_id'
        ]);
        $this->hasMany('Icons', [
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
            ->scalar('name')
            ->maxLength('name', 155)
            ->allowEmptyString('name');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        return $validator;
    }
}
