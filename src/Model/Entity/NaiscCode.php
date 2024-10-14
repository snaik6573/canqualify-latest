<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * NaiscCode Entity
 *
 * @property int $id
 * @property int|null $naisc_code
 * @property string|null $title
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class NaiscCode extends Entity
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
        'naisc_code' => true,
        'title' => true,
        'created' => true,
        'modified' => true,
		'created_by' => true,
        'modified_by' => true
    ];
}
