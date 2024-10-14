<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Questions Model
 *
 * @property \App\Model\Table\QuestionTypesTable|\Cake\ORM\Association\BelongsTo $QuestionTypes
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 *
 * @method \App\Model\Entity\Question get($primaryKey, $options = [])
 * @method \App\Model\Entity\Question newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Question[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Question|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Question|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Question patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Question[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Question findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class QuestionsTable extends Table
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

        $this->setTable('questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('QuestionTypes', [
            'foreignKey' => 'question_type_id'			
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id'			
        ]);	
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'			
        ]);
        $this->hasMany('ClientQuestions', [
            'foreignKey' => 'question_id'			
        ]);
        $this->hasMany('ContractorAnswers', [
            'foreignKey' => 'question_id',
			'dependent' => true,
			'cascadeCallbacks' => true
        ]);
        $this->hasOne('Contractors', [
            'foreignKey' => 'Contractors_id',
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
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->boolean('client_based')
            ->allowEmptyString('active');

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
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        //$rules->add($rules->existsIn(['client_id'], 'Clients'));

        return $rules;
    }
}
