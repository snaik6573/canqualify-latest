<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * TrainingAnswer Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property int $training_questions_id
 * @property string|null $answer
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\TrainingQuestion $training_question
 */
class TrainingAnswer extends Entity
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
        'training_questions_id' => true,
        'answer' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'employee' => true,
        'training_question' => true
    ];
}
