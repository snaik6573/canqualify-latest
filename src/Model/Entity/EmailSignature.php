<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailSignature Entity
 *
 * @property int $id
 * @property string|null $signature_name
 * @property string|null $name
 * @property string|null $title
 * @property string|null $company_name
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $website
 * @property string|null $address
 * @property int|null $template_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property string|null $profile_photo
 * @property string|null $signature_email
 *
 * @property \App\Model\Entity\Template $template
 */
class EmailSignature extends Entity
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
        'signature_name' => true,
        'name' => true,
        'title' => true,
        'company_name' => true,
        'phone' => true,
        'mobile' => true,
        'website' => true,
        'address' => true,
        'template_id' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'profile_photo' => true,
        'signature_email' => true,
        'template' => true
    ];
}
