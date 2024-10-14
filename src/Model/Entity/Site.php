<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Site Entity
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $client_id
 * @property int|null $region_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Region $region
 */
class Site extends Entity
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
        'name' => true,
        'client_id' => true,
        'region_id' => true,
        'addressline_1' => true,
        'addressline_2' => true,
        'city' => true,
        'state_id' => true,
        'country_id' => true,
        'zip' => true,
        'latitude' => true,
        'longitude' => true,
		'contact_phone' => true,
        'contact_email' => true,
        'created' => true,
        'modified' => true,
        'client' => true,
        'region' => true,
        'created_by' => true,
        'modified_by' => true,
        'she_fname' => true,
        'she_lname' => true,
        'she_title' => true,
        'she_phone' => true,
        'she_email' => true,
        'facility_fname' => true,
        'facility_lname' => true,
        'facility_title' => true,
        'facility_phone' => true,
        'facility_email' => true
    ];
}
