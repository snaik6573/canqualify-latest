<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FinalOverallIcon Entity
 *
 * @property int|null $id
 * @property int|null $client_id
 * @property int|null $contractor_id
 * @property string|null $bench_type
 * @property string|null $icon
 * @property int|null $category
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool|null $is_forced
 * @property string|null $documents
 * @property string|null $notes
 * @property bool|null $show_to_contractor
 * @property bool|null $show_to_clients
 * @property int|null $icon_from
 * @property bool|null $review
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Contractor $contractor
 */
class FinalOverallIcon extends Entity
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
        'id' => true,
        'client_id' => true,
        'contractor_id' => true,
        'bench_type' => true,
        'icon' => true,
        'category' => true,
        'created_by' => true,
        'modified_by' => true,
        'created' => true,
        'modified' => true,
        'is_forced' => true,
        'documents' => true,
        'notes' => true,
        'show_to_contractor' => true,
        'show_to_clients' => true,
        'icon_from' => true,
        'review' => true,
        'client' => true,
        'contractor' => true
    ];
}
