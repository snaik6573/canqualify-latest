<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContractorDoc Entity
 *
 * @property int $id
 * @property string|null $document
 * @property int|null $fndocs_id
 * @property int|null $client_id
 * @property int|null $contractor_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\FormsNDoc $forms_n_doc
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Contractor $contractor
 */
class ContractorDoc extends Entity
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
        'document' => true,
        'fndocs_id' => true,
        'client_id' => true,
        'contractor_id' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'forms_n_doc' => true,
        'client' => true,
        'contractor' => true
    ];
}
