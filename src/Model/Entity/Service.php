<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Service Entity
 *
 * @property int $id
 * @property string|null $name
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $created_by
 * @property int|null $modified_by
 * @property int|null $service_order
 * @property string|null $description
 *
 * @property \App\Model\Entity\Category[] $categories
 * @property \App\Model\Entity\ClientService[] $client_services
 * @property \App\Model\Entity\Product[] $products
 */
class Service extends Entity
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
        'name' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'service_order' => true,
        'description' => true,
        'categories' => true,
        'client_services' => true,
        'products' => true
    ];
}
