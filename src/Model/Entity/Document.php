<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Document Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $document
 * @property int|null $client_id
 * @property int|null $contractor_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 * @property int|null $doc_version
 * @property int|null $document_id
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\DocumentVersion[] $document_versions
 */
class Document extends Entity
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
        'client_id' => true,
        'contractor_id' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'doc_version' => true,
        'document_id' => true,
        'client' => true,
        'contractor' => true,
		'doc_ver' => true,
		'document_id' => true,
        'document_versions' => true
    ];
}
