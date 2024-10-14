<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $from
 * @property int|null $to
 * @property string|null $pricing
 * @property int|null $service_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Service $service
 */
class Product extends Entity
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
        'range_from' => true,
        'range_to' => true,
        'pricing' => true,
        'service_id' => true,
        'created' => true,
        'modified' => true,
        'service' => true,
        'created_by' => true,
        'modified_by' => true
    ];
}
