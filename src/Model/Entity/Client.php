<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Client Entity
 *
 * @property int $id
 * @property string|null $company_name
 * @property int|null $account_type_id
 * @property string|null $addressline_1
 * @property string|null $addressline_2
 * @property string|null $city
 * @property int|null $state_id
 * @property int|null $country_id
 * @property int|null $zip
 * @property string|null $pri_contact_fn
 * @property string|null $pri_contact_ln
 * @property string|null $pri_contact_pn
 * @property \Cake\I18n\FrozenDate|null $membership_startdate
 * @property \Cake\I18n\FrozenDate|null $membership_enddate
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $registration_status
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\AccountType $account_type
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ClientQuestion[] $client_questions
 * @property \App\Model\Entity\ClientService[] $client_services
 * @property \App\Model\Entity\Question[] $questions
 * @property \App\Model\Entity\Region[] $regions
 * @property \App\Model\Entity\Site[] $sites
 */
class Client extends Entity
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
        'account_type_id' => true,
        'addressline_1' => true,
        'addressline_2' => true,
        'city' => true,
        'state_id' => true,
        'country_id' => true,
        'zip' => true,
        'pri_contact_fn' => true,
        'pri_contact_ln' => true,
        'pri_contact_pn' => true,
        'membership_startdate' => true,
        'membership_enddate' => true,
        'created' => true,
        'modified' => true,
        'registration_status' => true,
        'user_id' => true,
        'account_type' => true,
        'state' => true,
        'country' => true,
        'user' => true,
        'client_questions' => true,
        'client_services' => true,
        'client_modules' => true,
        'questions' => true,
        'regions' => true,
        'sites' => true,
        'created_by' => true,
        'modified_by' => true,
        'customer_rep_id' => true,
		'company_logo' => true,
        'customer_representative_id' =>true,
        'lead_custrep_id' =>true,
        'client_service_rep' =>true,
        'site_visited'=>true,
        'is_gc'=>true
    ];
}
