<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeTrainings Model
 *
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 * @property \App\Model\Table\TrainingsTable|\Cake\ORM\Association\BelongsTo $Trainings
 *
 * @method \App\Model\Entity\EmployeeTraining get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeTraining newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeeTraining[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeTraining|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeTraining|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeTraining patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeTraining[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeTraining findOrCreate($search, callable $callback = null, $options = [])
 */
class EmployeeTrainingsTable extends Table
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

        $this->setTable('employee_trainings');
        $this->setDisplayField('name');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id'
        ]);
        $this->belongsTo('Trainings', [
            'foreignKey' => 'training_id'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('pri_contact_fn')
            ->maxLength('pri_contact_fn', 45)
            ->allowEmptyString('pri_contact_fn');

        $validator
            ->scalar('pri_contact_ln')
            ->maxLength('pri_contact_ln', 45)
            ->allowEmptyString('pri_contact_ln');

        $validator
            ->numeric('percentage')
            ->allowEmptyString('percentage');

        $validator
            ->dateTime('completed_on')
            ->allowEmptyDateTime('completed_on');

        $validator
            ->dateTime('expires_on')
            ->allowEmptyDateTime('expires_on');

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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        $rules->add($rules->existsIn(['training_id'], 'Trainings'));

        return $rules;
    }
}
