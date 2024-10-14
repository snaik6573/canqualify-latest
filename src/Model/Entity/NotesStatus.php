<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotesStatus Entity
 *
 * @property int $id
 * @property int|null $contractor_id
 * @property int|null $user_id
 * @property string|null $old_status
 * @property string|null $new_status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property int|null $lead_id
 *
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Lead $lead
 */
class NotesStatus extends Entity
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
        'user_id' => true,
        'old_status' => true,
        'new_status' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'lead_id' => true,
        'contractor' => true,
        'user' => true,
        'lead' => true
    ];
}
