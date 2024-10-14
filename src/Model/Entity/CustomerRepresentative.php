<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * CustomerRepresentative Entity
 *
 * @property int $id
 * @property string|null $pri_contact_fn
 * @property string|null $pri_contact_ln
 * @property string|null $pri_contact_pn
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\User $user
 */
class CustomerRepresentative extends Entity
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
        'pri_contact_fn' => true,
        'pri_contact_ln' => true,
        'pri_contact_pn' => true,
        'created' => true,
        'modified' => true,
		'created_by' => true,
        'modified_by' => true,
        'user_id' => true,
        'extension' => true,
        'user' => true,
        'default_cr' =>true
    ];
}
