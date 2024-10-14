<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FeedbackQuestions Model
 *
 * @property \App\Model\Table\FeedbackAnswersTable|\Cake\ORM\Association\HasMany $FeedbackAnswers
 *
 * @method \App\Model\Entity\FeedbackQuestion get($primaryKey, $options = [])
 * @method \App\Model\Entity\FeedbackQuestion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FeedbackQuestion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FeedbackQuestion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FeedbackQuestion|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FeedbackQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FeedbackQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FeedbackQuestion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FeedbackQuestionsTable extends Table
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

        $this->setTable('feedback_questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('FeedbackAnswers', [
            'foreignKey' => 'feedback_question_id'
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

        return $validator;
    }
}
