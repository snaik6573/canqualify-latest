<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CanqualifyUser Entity
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\User $user
 */
class CanqualifyUser extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'phone' => true,
        'user_id' => true,
        'user' => true
    ];
}
