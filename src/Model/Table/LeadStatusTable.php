<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LeadStatus Model
 *
 * @method \App\Model\Entity\LeadStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\LeadStatus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LeadStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeadStatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeadStatus|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeadStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LeadStatus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeadStatus findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeadStatusTable extends Table
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

        $this->setTable('lead_status');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

          $this->hasMany('Leads', [
            'foreignKey' => 'lead_status_id'
        ]);

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
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        $validator
            ->scalar('status')
            ->maxLength('status', 155)
            ->allowEmptyString('status');

        return $validator;
    }
}
