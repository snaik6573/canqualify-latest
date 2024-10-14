<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserDetail Entity
 *
 * @property int|null $id
 * @property int|null $role_id
 * @property string|null $username
 * @property bool|null $active
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $company_name
 * @property string|null $phone
 *
 * @property \App\Model\Entity\Role $role
 */
class UserDetail extends Entity
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
        'id' => true,
        'role_id' => true,
        'username' => true,
        'active' => true,
        'first_name' => true,
        'last_name' => true,
        'company_name' => true,
        'phone' => true,
        'role' => true
    ];
}
