<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Contractor Entity
 *
 * @property int $id
 * @property string|null $company_name
 * @property string|null $addressline_1
 * @property string|null $addressline_2
 * @property string|null $city
 * @property int|null $state_id
 * @property int|null $country_id
 * @property int|null $zip
 * @property string|null $pri_contact_fn
 * @property string|null $pri_contact_ln
 * @property string|null $pri_contact_pn
 * @property bool|null $is_safety_sensitive
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $registration_status
 * @property int|null $user_id
 * @property bool|null $payment_status
 * @property bool|null $is_locked
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\User $user
 */
class Contractor extends Entity
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
        'addressline_1' => true,
        'addressline_2' => true,
        'city' => true,
        'state_id' => true,
        'country_id' => true,
        'zip' => true,
        'pri_contact_fn' => true,
        'pri_contact_ln' => true,
        'pri_contact_pn' => true,
        'is_safety_sensitive' => true,
        'created' => true,
        'modified' => true,
        'registration_status' => true,
        'user_id' => true,
        'payment_status' => true,
        'is_locked' => true,
        'waiting_on' => true,
        'state' => true,
        'country' => true,
        'user' => true,
        'latitude' => true,
        'longitude' => true,
        'company_tin' => true,
        'pri_contact_title' => true,
        'customer_rep_id' => true,
        'tnc' => true,
		'company_logo' => true,
        'customer_representative_id' => true,
        'send_invoice' => true,
        'is_safety_contact'=> true,
		'data_submit'=> true,
        'data_read'=> true,
		'forced_renew'=> true,
        'emp_req'=> true,
        'expired' => true,
        'gc_client_id' => true
    ];
}
