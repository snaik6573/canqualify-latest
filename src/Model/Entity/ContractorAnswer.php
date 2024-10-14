<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContractorAnswer Entity
 *
 * @property int $id
 * @property int|null $contractor_id
 * @property int|null $question_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\Question $question
 */
class ContractorAnswer extends Entity
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
        'question_id' => true,
        'answer' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'contractor' => true,
        'question' => true,
        'uploadfile' => true,
        'year' => true,
	'client_id' => true
    ];
}
