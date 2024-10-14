<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * BillingDetail Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property array $billing_address
 * @property int $state_id
 * @property int $country_id
 * @property array $card_details
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime|null $created_on
 * @property int|null $updated_by
 * @property \Cake\I18n\FrozenTime|null $updated_on
 * @property int|null $deleted_by
 * @property \Cake\I18n\FrozenTime|null $deleted_on
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\Country $country
 */
class BillingDetail extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'billing_address' => true,
        'state_id' => true,
        'country_id' => true,
        'card_details' => true,
        'created_by' => true,
		'modified_by' => true,
        'created_on' => true,
        'updated_by' => true,
        'updated_on' => true,
        'deleted_by' => true,
        'deleted_on' => true,
        'state' => true,
        'country' => true
    ];
}
