<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TrainingQuestion Entity
 *
 * @property int $id
 * @property string|null $question
 * @property string|null $question_options
 * @property int|null $question_type_id
 * @property bool|null $allow_multiselect
 * @property string|null $help
 * @property int|null $training_id
 * @property int|null $client_id
 * @property bool|null $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 * @property string|null $safety_type
 * @property bool|null $allow_multiple_answers
 * @property int|null $ques_order
 *
 * @property \App\Model\Entity\QuestionType $question_type
 * @property \App\Model\Entity\Training $training
 * @property \App\Model\Entity\Client $client
 */
class TrainingQuestion extends Entity
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
        'training_id' => true,
        'client_id' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'safety_type' => true,
        'allow_multiple_answers' => true,
        'ques_order' => true,
        'question_type' => true,
        'training' => true,
        'client' => true,
	    'correct_answer' => true,
        'data_attribute'=>true,
        'is_video'=>true

    ];
}
