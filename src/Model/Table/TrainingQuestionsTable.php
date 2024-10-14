<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TrainingQuestions Model
 *
 * @property \App\Model\Table\QuestionTypesTable|\Cake\ORM\Association\BelongsTo $QuestionTypes
 * @property \App\Model\Table\TrainingsTable|\Cake\ORM\Association\BelongsTo $Trainings
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 *
 * @method \App\Model\Entity\TrainingQuestion get($primaryKey, $options = [])
 * @method \App\Model\Entity\TrainingQuestion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TrainingQuestion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TrainingQuestion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TrainingQuestion|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TrainingQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TrainingQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TrainingQuestion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TrainingQuestionsTable extends Table
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

        $this->setTable('training_questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('QuestionTypes', [
            'foreignKey' => 'question_type_id'
        ]);
        $this->belongsTo('Trainings', [
            'foreignKey' => 'training_id'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('TrainingAnswers', [
            'foreignKey' => 'training_questions_id'			
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
            ->allowEmptyString('question');

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
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->allowEmptyString('created_by', false);

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        $validator
            ->scalar('safety_type')
            ->maxLength('safety_type', 45)
            ->allowEmptyString('safety_type');

        $validator
            ->boolean('allow_multiple_answers')
            ->allowEmptyString('allow_multiple_answers');

        $validator
            ->integer('ques_order')
            ->allowEmptyString('ques_order');

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
        $rules->add($rules->existsIn(['training_id'], 'Trainings'));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));

        return $rules;
    }
}
