<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lead Entity
 *
 * @property int $id
 * @property string|null $company_name
 * @property string|null $contact_name_first
 * @property string|null $contact_name_last
 * @property string|null $phone_no
 * @property string|null $email
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $description_of_work
 * @property int|null $client_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property int|null $contractor_id
 * @property int|null $lead_status_id
 * @property string|null $address
 * @property int|null $email_count
 * @property int|null $phone_count
 * @property int|null $cr_id
 *
 * @property \App\Model\Entity\Client $client
 */
class Lead extends Entity
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
        'company_name' => true,
        'contact_name_first' => true,
        'contact_name_last' => true,
        'phone_no' => true,
        'email' => true,
        'city' => true,
        'state' => true,
        'zip_code' => true,
        'description_of_work' => true,
        'client_id' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'contractor_id' => true,
        'lead_status_id' => true,
        'address' => true,
        'email_count' => true,
        'phone_count' => true,
        'cr_id' => true,
        'client' => true,
		'updated_fields' => true,
		'is_read' => true		
    ];
}
