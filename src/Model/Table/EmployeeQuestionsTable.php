<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeQuestions Model
 *
 * @property \App\Model\Table\QuestionTypesTable|\Cake\ORM\Association\BelongsTo $QuestionTypes
 * @property \App\Model\Table\EmployeeCategoriesTable|\Cake\ORM\Association\BelongsTo $EmployeeCategories
 * @property \App\Model\Table\EmployeeQuestionsTable|\Cake\ORM\Association\BelongsTo $EmployeeQuestions
 * @property \App\Model\Table\EmployeeAnswersTable|\Cake\ORM\Association\HasMany $EmployeeAnswers
 * @property \App\Model\Table\EmployeeQuestionsTable|\Cake\ORM\Association\HasMany $EmployeeQuestions
 *
 * @method \App\Model\Entity\EmployeeQuestion get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeQuestion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeeQuestion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeQuestion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeQuestion|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeQuestion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeeQuestionsTable extends Table
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

        $this->setTable('employee_questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('QuestionTypes', [
            'foreignKey' => 'question_type_id'
        ]);
        $this->belongsTo('EmployeeCategories', [
            'foreignKey' => 'employee_category_id'
        ]);
        $this->belongsTo('EmployeeQuestions', [
            'foreignKey' => 'employee_question_id'
        ]);
		$this->hasMany('EmployeeQuestions', [
            'foreignKey' => 'employee_question_id'
        ]);
        $this->hasMany('EmployeeAnswers', [
            'foreignKey' => 'employee_question_id'
        ]);
		$this->hasMany('ClientEmployeeQuestions', [
            'foreignKey' => 'employee_question_id'
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
            ->scalar('question')
            ->allowEmptyString('question', false, 'Please enter question');

        $validator
            ->scalar('question_options')
            ->allowEmptyString('question_options');

        $validator
            ->boolean('allow_multiselect')
            ->allowEmptyString('allow_multiselect');

        $validator
            ->scalar('help')
            ->allowEmptyString('help');

        $validator
            ->boolean('allow_multiple_answers')
            ->allowEmptyString('allow_multiple_answers');

        $validator
            ->integer('ques_order')
            ->allowEmptyString('ques_order');

        $validator
            ->scalar('correct_answer')
            ->maxLength('correct_answer', 155)
            ->allowEmptyString('correct_answer');

        $validator
            ->boolean('client_based')
            ->requirePresence('client_based', 'create')
            ->allowEmptyString('client_based', false);

        $validator
            ->boolean('is_parent')
            ->requirePresence('is_parent', 'create')
            ->allowEmptyString('is_parent', false);

        $validator
            ->scalar('parent_option')
            ->maxLength('parent_option', 155)
            ->allowEmptyString('parent_option');

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
        $rules->add($rules->existsIn(['question_type_id'], 'QuestionTypes'));
        $rules->add($rules->existsIn(['employee_category_id'], 'EmployeeCategories'));
        $rules->add($rules->existsIn(['employee_question_id'], 'EmployeeQuestions'));

        return $rules;
    }
}
