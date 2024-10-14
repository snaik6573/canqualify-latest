<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;/**
 * NaiscViews Model
 *
 * @property \App\Model\Table\ContractorsTable|\Cake\ORM\Association\BelongsTo $Contractors
 * @property \App\Model\Table\QuestionsTable|\Cake\ORM\Association\BelongsTo $Questions
 *
 * @method \App\Model\Entity\NaiscView get($primaryKey, $options = [])
 * @method \App\Model\Entity\NaiscView newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NaiscView[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NaiscView|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NaiscView|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NaiscView patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NaiscView[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NaiscView findOrCreate($search, callable $callback = null, $options = [])
 */
class NaiscViewsTable extends Table
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
        $this->setTable('naisc_views');
        $this->setDisplayField('title');

        $this->belongsTo('Contractors', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->belongsTo('Questions', [
            'foreignKey' => 'question_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {        $validator->scalar('naisc_code')->maxLength('naisc_code', 45)->allowEmptyString('naisc_code');        $validator->scalar('answer')->allowEmptyString('answer');        $validator->scalar('title')->maxLength('title', 255)->allowEmptyString('title');        return $validator;
    }
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {        $rules->add($rules->existsIn(['contractor_id'], 'Contractors'));        $rules->add($rules->existsIn(['question_id'], 'Questions'));
        return $rules;
    }}
