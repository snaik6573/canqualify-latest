<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailQueues Model
 *
 * @method \App\Model\Entity\EmailQueue get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailQueue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailQueue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailQueue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailQueue|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailQueue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailQueue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailQueue findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailQueuesTable extends Table
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

        $this->setTable('email_queues');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('campaign_name')
            ->maxLength('campaign_name', 45)
            ->allowEmptyString('campaign_name');

        $validator
            ->scalar('to_mail')
            ->maxLength('to_mail', 120)
            ->allowEmptyString('to_mail');

        $validator
            ->scalar('from_mail')
            ->maxLength('from_mail', 120)
            ->allowEmptyString('from_mail');

        $validator
            ->scalar('cc_mail')
            ->maxLength('cc_mail', 120)
            ->allowEmptyString('cc_mail');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 120)
            ->allowEmptyString('subject');

        $validator
            ->scalar('template_content')
            ->allowEmptyString('template_content');

        $validator
            ->scalar('email_signature_content')
            ->allowEmptyString('email_signature_content');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        return $validator;
    }
}
