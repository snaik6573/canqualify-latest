<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * CustomerrNote Entity
 *
 * @property int $id
 * @property string|null $subject
 * @property string|null $notes
 * @property int|null $contractor_id
 * @property bool|null $show_to_contractor
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 * @property bool|null $is_read
 * @property int|null $customer_representative_id
 *
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\CustomerRepresentative $customer_representative
 */
class CustomerrNote extends Entity
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
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'is_read' => true,
        'customer_representative_id' => true,
        'contractor' => true,
        'follow_up' => true,
	'feature_date' => true		
    ];
}
