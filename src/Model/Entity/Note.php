<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Note Entity
 *
 * @property int $id
 * @property string|null $subject
 * @property string|null $notes
 * @property int|null $contractor_id
 * @property string|null $client_ids
 * @property bool|null $visibility
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\Contractor $contractor
 */
class Note extends Entity
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
        'subject' => true,
        'notes' => true,
        'contractor_id' => true,
        'show_to_contractor' => true,
		'show_to_client' => true,
        'client_ids' => true,
		'is_read' => true,
		'role_id' => true,
        'follow_up' => true,
		'feature_date' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'contractor' => true,
        'is_completed' =>true       
    ];
}
