<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LeadNote Entity
 *
 * @property int $id
 * @property string|null $subject
 * @property string|null $notes
 * @property int|null $lead_id
 * @property int|null $customer_representative_id
 * @property bool|null $follow_up
 * @property \Cake\I18n\FrozenTime|null $feature_date
 * @property bool|null $is_completed
 * @property bool|null $show_to_client
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\Lead $lead
 * @property \App\Model\Entity\CustomerRepresentative $customer_representative
 */
class LeadNote extends Entity
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
        'lead_id' => true,
        'customer_representative_id' => true,
        'follow_up' => true,
        'feature_date' => true,
        'is_completed' => true,
        'show_to_client' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'lead' => true,
        'customer_representative' => true,
        'note_type' =>true,
        'email_count'=>true,
        'phone_count'=>true
    ];
}
