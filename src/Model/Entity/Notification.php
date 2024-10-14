<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Notification Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $notification_type_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $url
 * @property bool|null $state
 * @property bool|null $is_completed
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\NotificationType $notification_type
 */
class Notification extends Entity
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
        'user_id' => true,
        'notification_type_id' => true,
        'title' => true,
        'description' => true,
        'url' => true,
        'state' => true,
        'is_completed' => true,
        'created_by' => true,
        'modified_by' => true,
        'created' => true,
        'modified' => true,
		'from_user_id'=>true
        //'service_ids' => true
        //'notification_type' => true
    ];
}
