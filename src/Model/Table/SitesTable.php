<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sites Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\RegionsTable|\Cake\ORM\Association\BelongsTo $Regions
 *
 * @method \App\Model\Entity\Site get($primaryKey, $options = [])
 * @method \App\Model\Entity\Site newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Site[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Site|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Site|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Site patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Site[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Site findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SitesTable extends Table
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

        $this->setTable('sites');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'			
        ]);
        $this->belongsTo('Regions', [
            'foreignKey' => 'region_id'			
        ]);
        $this->belongsTo('States', [
            'foreignKey' => 'state_id'
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id'
        ]);
        $this->hasMany('ContractorSites', [
            'foreignKey' => 'site_id'
        ]);
		$this->hasMany('ContractorTempsites', [
            'foreignKey' => 'site_id'
        ]);
		$this->hasMany('EmployeeSites', [
            'foreignKey' => 'site_id'
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
            ->maxLength('name', 155)
            ->allowEmptyString('name', false, 'Please enter name');

        $validator
            ->scalar('country_id')
            ->allowEmptyString('country_id', false, 'Please select your country');

        $validator
            ->scalar('state_id')
            ->allowEmptyString('state_id', false, 'Please select your state');

        $validator
            ->scalar('addressline_1')
            ->maxLength('addressline_1', 155)
            ->allowEmptyString('addressline_1', false, 'Please enter your address');

        $validator
            ->scalar('addressline_2')
            ->maxLength('addressline_2', 155)
            ->allowEmptyString('addressline_2');

        $validator
            ->scalar('city')
            ->maxLength('city', 45)
            ->allowEmptyString('city', false, 'Please enter your city');

        $validator
            ->scalar('zip')
            ->allowEmptyString('zip');

        $validator
            ->scalar('contact_phone')
            ->allowEmptyString('contact_phone',false,'Please enter your phone number');

        $validator
            ->scalar('contact_email')
            ->allowEmptyString('contact_email',false,'Please enter your email');


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
        $rules->add($rules->existsIn(['region_id'], 'Regions'));


        return $rules;
    }
}
