<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property string|null $response
 * @property int|null $contractor_id
 * @property float|null $totalprice
 * @property string|null $secret_link
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property float|null $p_amt
 * @property \Cake\I18n\FrozenDate|null $subscription_date
 * @property string|null $transaction_status
 * @property string|null $p_transactionid
 *
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\ContractorInvoice[] $contractor_invoices
 * @property \App\Model\Entity\PaymentDetail[] $payment_details
 */
class Payment extends Entity
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
        'response' => true,
        'contractor_id' => true,
        'totalprice' => true,
        'secret_link' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'p_amt' => true,
        'subscription_date' => true,
        'transaction_status' => true,
        'p_transactionid' => true,
        'contractor' => true,
        'contractor_invoices' => true,
        'payment_details' => true,
        'payment_type' => true,
        'is_refunded'=>true,
		'payment_start'=>true,
		'payment_end' =>true,
		'reactivation_fee' =>true,
        'canqualify_discount' =>true,
    ];
}
