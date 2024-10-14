<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PaymentDetail Entity
 *
 * @property int $id
 * @property int|null $payment_id
 * @property int|null $service_id
 * @property int|null $price
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property array|null $client_ids
 *
 * @property \App\Model\Entity\Payment $payment
 * @property \App\Model\Entity\Service $service
 */
class PaymentDetail extends Entity
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
        'payment_id' => true,
        'service_id' => true,
        'price' => true,
        'created_by' => true,
        'modified_by' => true,
        'created' => true,
        'modified' => true,
        'client_ids' => true,
        'payment' => true,
        'service' => true,
        'product_price' =>true,
        'discount'=>true
    ];
}
