<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WaitingOnLog Entity
 *
 * @property int $id
 * @property int $contractor_id
 * @property string|null $from_status
 * @property string|null $to_status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\Contractor $contractor
 */
class WaitingOnLog extends Entity
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
        'from_status' => true,
        'to_status' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'contractor' => true,
		'saved_from' => true
    ];
}
