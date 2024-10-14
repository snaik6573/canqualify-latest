<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeQuestion Entity
 *
 * @property int $id
 * @property string|null $question
 * @property string|null $question_options
 * @property int|null $question_type_id
 * @property bool|null $allow_multiselect
 * @property string|null $help
 * @property int|null $employee_category_id
 * @property bool|null $allow_multiple_answers
 * @property int|null $ques_order
 * @property string|null $correct_answer
 * @property bool $client_based
 * @property bool $is_parent
 * @property int|null $employee_question_id
 * @property string|null $parent_option
 * @property bool|null $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\QuestionType $question_type
 * @property \App\Model\Entity\EmployeeCategory $employee_category
 * @property \App\Model\Entity\EmployeeQuestion[] $employee_questions
 * @property \App\Model\Entity\EmployeeAnswer[] $employee_answers
 */
class EmployeeQuestion extends Entity
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
        'question' => true,
        'question_options' => true,
        'question_type_id' => true,
        'allow_multiselect' => true,
        'help' => true,
        'employee_category_id' => true,
        'allow_multiple_answers' => true,
        'ques_order' => true,
        'correct_answer' => true,
        'client_based' => true,
        'is_parent' => true,
        'employee_question_id' => true,
        'parent_option' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'question_type' => true,
        'employee_category' => true,
        'employee_questions' => true,
        'employee_answers' => true,
        'client_id' => true
    ];
}
