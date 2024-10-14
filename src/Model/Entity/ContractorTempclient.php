<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContractorTempclient Entity
 *
 * @property int $id
 * @property int $contractor_id
 * @property int $site_id
 * @property int|null $client_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\Site $site
 * @property \App\Model\Entity\Client $client
 */
class ContractorTempclient extends Entity
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
        'site_id' => true,
        'client_id' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'contractor' => true,
        'site' => true,
        'client' => true
    ];
}
