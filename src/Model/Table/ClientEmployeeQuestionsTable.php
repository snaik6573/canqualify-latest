<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientEmployeeQuestions Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\EmployeeQuestionsTable|\Cake\ORM\Association\BelongsTo $EmployeeQuestions
 * @property |\Cake\ORM\Association\BelongsTo $EmployeeCategories
 *
 * @method \App\Model\Entity\ClientEmployeeQuestion get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientEmployeeQuestion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientEmployeeQuestion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientEmployeeQuestion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientEmployeeQuestion|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientEmployeeQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientEmployeeQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientEmployeeQuestion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ClientEmployeeQuestionsTable extends Table
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

        $this->setTable('client_employee_questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('EmployeeQuestions', [
            'foreignKey' => 'employee_question_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('EmployeeCategories', [
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
            ->boolean('is_compulsory')
            ->allowEmptyString('is_compulsory');

        $validator
            ->scalar('correct_answer')
            ->maxLength('correct_answer', 155)
            ->allowEmptyString('correct_answer');

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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['employee_question_id'], 'EmployeeQuestions'));
        $rules->add($rules->existsIn(['employee_category_id'], 'EmployeeCategories'));

        return $rules;
    }
}
