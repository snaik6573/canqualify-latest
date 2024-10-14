<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeAnswer Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property int $employee_question_id
 * @property string|null $answer
 * @property int|null $client_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\EmployeeQuestion $employee_question
 * @property \App\Model\Entity\Client $client
 */
class EmployeeAnswer extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'employee_id' => true,
        'employee_question_id' => true,
        'answer' => true,
        'client_id' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'employee' => true,
        'employee_question' => true,
        'client' => true
    ];
}
