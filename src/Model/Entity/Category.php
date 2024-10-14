<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $active
 * @property int|null $service_id
 * @property int|null $category_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Service $service
 * @property \App\Model\Entity\Category[] $categories
 * @property \App\Model\Entity\Question[] $questions
 */
class Category extends Entity
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
        'description' => true,
        'active' => true,
        'service_id' => true,
        'category_id' => true,
        'created' => true,
        'modified' => true,
        'service' => true,
        'categories' => true,
        'questions' => true,
        'category_order' => true,
        'year_based' => true,
        'is_parent' => true,
        'created_by' => true,
        'modified_by' => true,
        'from_year'=>true,
        'to_year'=>true,
    ];
}
