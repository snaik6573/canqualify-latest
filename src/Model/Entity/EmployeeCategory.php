<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeCategory Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $is_parent
 * @property int|null $employee_category_id
 * @property int|null $employee_category_order
 * @property bool|null $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\EmployeeCategory[] $employee_categories
 * @property \App\Model\Entity\EmployeeQuestion[] $employee_questions
 */
class EmployeeCategory extends Entity
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
        'description' => true,
        'is_parent' => true,
        'employee_category_id' => true,
        'employee_category_order' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'employee_categories' => true,
        'employee_questions' => true,
        'client_id' => true
    ];
}
