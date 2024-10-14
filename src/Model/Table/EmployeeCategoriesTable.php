<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeCategories Model
 *
 * @property \App\Model\Table\EmployeeCategoriesTable|\Cake\ORM\Association\BelongsTo $EmployeeCategories
 * @property \App\Model\Table\EmployeeCategoriesTable|\Cake\ORM\Association\HasMany $EmployeeCategories
 * @property \App\Model\Table\EmployeeQuestionsTable|\Cake\ORM\Association\HasMany $EmployeeQuestions
 *
 * @method \App\Model\Entity\EmployeeCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeeCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeeCategoriesTable extends Table
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

        $this->setTable('employee_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('EmployeeQuestions', [
            'foreignKey' => 'employee_category_id'
        ]);
		
		$this->hasMany('ClientEmployeeQuestions', [
            'foreignKey' => 'employee_category_id'
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
            ->maxLength('name', 255)
            ->allowEmptyString('name', false, 'Please enter name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->boolean('is_parent')
            ->allowEmptyString('is_parent');

        $validator
            ->integer('employee_category_order')
            ->allowEmptyString('employee_category_order');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->allowEmptyString('created_by', false);

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
        //$rules->add($rules->existsIn(['employee_category_id'], 'EmployeeCategories'));

        return $rules;
    }
}
