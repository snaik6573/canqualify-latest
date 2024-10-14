<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SiteVisit Entity
 *
 * @property int $id
 * @property int|null $contractor_id
 * @property int|null $site_id
 * @property \Cake\I18n\FrozenTime|null $start_time
 * @property \Cake\I18n\FrozenTime|null $end_time
 * @property string|null $description
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\Site $site
 */
class SiteVisit extends Entity
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
        'start_time' => true,
        'end_time' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'contractor' => true,
        'site' => true,
        'client_id'=>true
    ];
}
