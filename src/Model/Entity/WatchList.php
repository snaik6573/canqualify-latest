<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WatchList Entity
 *
 * @property int|null $contractor_id
 * @property int|null $client_id
 * @property string|null $company_name
 * @property string|null $company_logo
 * @property string|null $waiting_on
 * @property bool|null $active
 *
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\Client $client
 */
class WatchList extends Entity
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
        'client_id' => true,
        'company_name' => true,
        'company_logo' => true,
        'waiting_on' => true,
        'active' => true,
        'contractor' => true,
        'client' => true
    ];
}
