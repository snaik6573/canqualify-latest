<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailCampaigns Model
 *
 * @method \App\Model\Entity\EmailCampaign get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailCampaign newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailCampaign[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaign|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailCampaign|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailCampaign patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaign[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailCampaign findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailCampaignsTable extends Table
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

        $this->setTable('email_campaigns');
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
            ->integer('to_mail')
            ->allowEmptyString('to_mail');

        $validator
            ->integer('from_mail')
            ->allowEmptyString('from_mail');

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
