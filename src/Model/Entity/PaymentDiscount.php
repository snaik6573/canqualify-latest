<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PaymentDiscount Entity
 *
 * @property int $id
 * @property int|null $contractor_id
 * @property int|null $discount_price
 * @property \Cake\I18n\FrozenDate|null $valid_date
 *
 * @property \App\Model\Entity\Contractor $contractor
 */
class PaymentDiscount extends Entity
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
        'discount_price' => true,
        'valid_date' => true,
        'contractor' => true
    ];
}
