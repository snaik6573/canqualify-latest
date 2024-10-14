<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WatchLists Model
 *
 * @property \App\Model\Table\ContractorsTable|\Cake\ORM\Association\BelongsTo $Contractors
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 *
 * @method \App\Model\Entity\WatchList get($primaryKey, $options = [])
 * @method \App\Model\Entity\WatchList newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WatchList[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WatchList|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WatchList|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WatchList patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WatchList[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WatchList findOrCreate($search, callable $callback = null, $options = [])
 */
class WatchListsTable extends Table
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

        $this->setTable('watch_lists');

        $this->belongsTo('Contractors', [
            'foreignKey' => 'contractor_id'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
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
            ->scalar('company_name')
            ->maxLength('company_name', 155)
            ->allowEmptyString('company_name');

        $validator
            ->scalar('company_logo')
            ->maxLength('company_logo', 155)
            ->allowEmptyString('company_logo');

        $validator
            ->scalar('waiting_on')
            ->maxLength('waiting_on', 45)
            ->allowEmptyString('waiting_on');

        $validator
            ->boolean('active')
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
        $rules->add($rules->existsIn(['contractor_id'], 'Contractors'));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));

        return $rules;
    }
}
