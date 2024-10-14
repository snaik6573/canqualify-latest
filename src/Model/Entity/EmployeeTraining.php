<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeTraining Entity
 *
 * @property int|null $employee_id
 * @property int|null $training_id
 * @property string|null $name
 * @property string|null $pri_contact_fn
 * @property string|null $pri_contact_ln
 * @property float|null $percentage
 * @property \Cake\I18n\FrozenTime|null $completed_on
 * @property \Cake\I18n\FrozenTime|null $expires_on
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\Training $training
 */
class EmployeeTraining extends Entity
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
        'training_id' => true,
        'name' => true,
        'pri_contact_fn' => true,
        'pri_contact_ln' => true,
        'percentage' => true,
        'completed_on' => true,
        'expires_on' => true,
        'employee' => true,
        'training' => true
    ];
}
