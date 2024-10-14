<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Benchmark Entity
 *
 * @property int $id
 * @property int|null $benchmark_category_id
 * @property float|null $range_from
 * @property float|null $range_to
 * @property string|null $icon
 * @property int|null $client_id
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $conclusion
 * @property int|null $benchmark_type_id
 * @property bool|null $is_percentage
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\BenchmarkType $benchmark_type
 */
class Benchmark extends Entity
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
        'benchmark_category_id' => true,
        'range_from' => true,
        'range_to' => true,
        'icon' => true,
        'client_id' => true,
        'created_by' => true,
        'modified_by' => true,
        'created' => true,
        'modified' => true,
        'conclusion' => true,
        'benchmark_type_id' => true,
        'is_percentage' => true,
        'category' => true,
        'client' => true,
        'benchmark_type' => true
    ];
}
