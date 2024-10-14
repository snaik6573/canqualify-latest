<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientEmployeeQuestion Entity
 *
 * @property int $id
 * @property int $client_id
 * @property int $employee_question_id
 * @property bool|null $is_compulsory
 * @property string|null $correct_answer
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 * @property int|null $employee_category_id
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\EmployeeQuestion $employee_question
 */
class ClientEmployeeQuestion extends Entity
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
        'client_id' => true,
        'employee_question_id' => true,
        'is_compulsory' => true,
        'correct_answer' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'employee_category_id' => true,
        'client' => true,
        'employee_question' => true
    ];
}
