<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Question Entity
 *
 * @property int $id
 * @property string|null $question
 * @property string|null $question_options
 * @property int|null $question_type_id
 * @property int|null $category_id
 * @property int|null $client_id
 * @property bool|null $active
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\QuestionType $question_type
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Client $client
 */
class Question extends Entity
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
        'help' => true,
        'question_type_id' => true,
        'allow_multiselect' => true,
		'allow_multiple_answers' => true,
        'category_id' => true,
        'client_id' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'question_type' => true,
        'category' => true,
        'client' => true,
		'ques_order' => true,
        'created_by' => true,
        'modified_by' => true,
		'show_on_register_form' => true,
		'valid_cls' => true,
		'client_based' => true,
		'correct_answer' => true,
        'is_parent' => true,
        'question_id' => true,
        'parent_option' => true,
		'document'=>true        
    ];
}
