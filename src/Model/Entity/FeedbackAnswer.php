<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FeedbackAnswer Entity
 *
 * @property int $id
 * @property int|null $contractor_id
 * @property int|null $feedback_question_id
 * @property string|null $answer
 *
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\FeedbackQuestion $feedback_question
 */
class FeedbackAnswer extends Entity
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
        'contractor_id' => true,
        'feedback_question_id' => true,
        'answer' => true,
        'contractor' => true,
        'feedback_question' => true
    ];
}
