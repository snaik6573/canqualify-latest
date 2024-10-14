<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * FormsNDoc Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $document
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property int|null $client_id
 *
 * @property \App\Model\Entity\Client $client
 */
class FormsNDoc extends Entity
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
        'document' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'client_id' => true,
		'show_to_contractor' => true,
        'show_to_employees' => true,
        'client' => true,
        'contractor_id' => true,
        'document_type' => true,
        'document_type_other' => true
    ];
}
