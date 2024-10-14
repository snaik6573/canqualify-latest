<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PercentageDetail Entity
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $contractor_id
 * @property float|null $percentage
 * @property int|null $client_id
 * @property int|null $year
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\Client $client
 */
class PercentageDetail extends Entity
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
        'category_id' => true,
        'contractor_id' => true,
        'percentage' => true,
        'client_id' => true,
        'year' => true,
        'category' => true,
        'contractor' => true,
        'client' => true
    ];
}
