<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * ClientUser Entity
 *
 * @property int $id
 * @property string|null $pri_contact_fn
 * @property string|null $pri_contact_ln
 * @property string|null $pri_contact_pn
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string|null $site_ids
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Client $client
 */
class ClientUser extends Entity
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
        'client_id' => true,
        'site_ids' => true,
        'user' => true,
        'client' => true
    ];
}
