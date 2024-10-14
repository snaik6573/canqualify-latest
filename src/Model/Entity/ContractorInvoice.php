<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * ContractorInvoice Entity
 *
 * @property int $id
 * @property int|null $contractor_id
 * @property int|null $service_id
 * @property int|null $service_qty
 * @property int|null $payment_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\Service $service
 * @property \App\Model\Entity\Payment $payment
 */
class ContractorInvoice extends Entity
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
        'service_id' => true,
        'service_qty' => true,
        'payment_id' => true,
		'service_price' => true,
        'created' => true,
        'modified' => true,
		'created_by' => true,
        'modified_by' => true,
        'contractor' => true,
        'service' => true,
        'payment' => true
    ];
}
