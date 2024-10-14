<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Employee Entity
 *
 * @property int $id
 * @property string|null $addressline_1
 * @property string|null $addressline_2
 * @property string|null $city
 * @property int|null $state_id
 * @property int|null $country_id
 * @property string|null $zip
 * @property string|null $pri_contact_fn
 * @property string|null $pri_contact_ln
 * @property string|null $pri_contact_pn
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 * @property int|null $user_id
 * @property int|null $contractor_id
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Contractor $contractor
 */
class Employee extends Entity
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
        'addressline_1' => true,
        'addressline_2' => true,
        'city' => true,
        'state_id' => true,
        'country_id' => true,
        'zip' => true,
        'pri_contact_fn' => true,
        'pri_contact_ln' => true,
        'pri_contact_pn' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'user_id' => true,
        'contractor_id' => true,
        'state' => true,
        'country' => true,
        'user' => true,
        'contractor' => true,
	    'registration_status' => true,
        'emergency_contact_name'=>true,
        'emergency_contact_number'=>true,
        'emp_position'=>true,
        'is_login_enable'=>true,
        'addr_sameas_company'=> true,
        'user_entered_email'=>true,
        'profile_search'=>true,
        'about'=>true,
        'skills'=>true,
        'work_experience'=>true,
        'tnc' => true

    ];
}
