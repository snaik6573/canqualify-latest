<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailQueue Entity
 *
 * @property int $id
 * @property string|null $campaign_name
 * @property string|null $to_mail
 * @property string|null $from_mail
 * @property string|null $cc_mail
 * @property string|null $subject
 * @property string|null $template_content
 * @property string|null $email_signature_content
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 */
class EmailQueue extends Entity
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
        'campaign_name' => true,
        'to_mail' => true,
        'from_mail' => true,
        'cc_mail' => true,
        'subject' => true,
        'template_content' => true,
        'email_signature_content' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'pri_contact_fn'=>true,
        'pri_contact_ln'=>true,
        'supplier_name'=>true,
        'client_company_name'=>true
    ];
}
