<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientQuestion Entity
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $question_id
 * @property bool|null $is_safety_sensitive
 * @property bool|null $is_safety_nonsensitive
 * @property bool|null $is_compulsory
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Question $question
 */
class ClientQuestion extends Entity
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
        'question_id' => true,
        'is_safety_sensitive' => true,
        'is_safety_nonsensitive' => true,
        'is_compulsory' => true,
        'created' => true,
        'modified' => true,
        'client' => true,
        'question' => true,
        'created_by' => true,
        'modified_by' => true,
	    'correct_answer'=>true,
        'ques_order'=>true
    ];
}
