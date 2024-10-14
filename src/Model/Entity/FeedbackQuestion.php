<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FeedbackQuestion Entity
 *
 * @property int $id
 * @property string|null $question
 * @property string|null $question_options
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\FeedbackAnswer[] $feedback_answers
 */
class FeedbackQuestion extends Entity
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
        'created' => true,
        'modified' => true,
        'feedback_answers' => true
    ];
}
