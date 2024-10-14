<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeExplanation Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $document
 * @property int|null $employee_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\Employee $employee
 */
class EmployeeExplanation extends Entity
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
        'name' => true,
        'document' => true,
        'employee_id' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'employee' => true,
		'training_date' =>true,
		'expiration_date' =>true,
		'document_type_id' =>true
    ];
}
