<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContractorSiteList Entity
 *
 * @property int|null $contractor_id
 * @property string|null $sites
 *
 * @property \App\Model\Entity\Contractor $contractor
 */
class ContractorSiteList extends Entity
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
        'contractor_id' => true,
        'sites' => true,
        'contractor' => true
    ];
}
