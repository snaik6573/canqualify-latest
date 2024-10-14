<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientService Entity
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $service_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Service $service
 */
class ClientService extends Entity
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
        'client_id' => true,
        'service_id' => true,
        'discount' => true,
        'is_percentage' => true,
        'is_safety_sensitive' => true,
        'is_safety_nonsensitive' => true,
        'created' => true,
        'modified' => true,
        'client' => true,
        'service' => true,
        'created_by' => true,
        'modified_by' => true,
		'empqual_with_admin' =>true
    ];
}
