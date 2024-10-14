<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Contact Entity
 *
 * @property int $id
 * @property string|null $fname
 * @property string|null $lname
 * @property string|null $email
 * @property string|null $phone_no
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class Contact extends Entity
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
        'fname' => true,
        'lname' => true,
        'email' => true,
        'phone_no' => true,
        'created' => true,
        'modified' => true,
		'created_by' => true,
        'modified_by' => true,
		'created_by' => true,
        'company_name' => true
    ];
}
