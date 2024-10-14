<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Training Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $active
 * @property int|null $category_id
 * @property int|null $client_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int $created_by
 * @property int|null $modified_by
 * @property int|null $category_order
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\TrainingQuestion[] $training_questions
 */
class Training extends Entity
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
        'category_id' => true,
        'client_id' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'category_order' => true,
        'category' => true,
        'client' => true,
        'training_questions' => true,
		'traning_video' => true,
		'site_ids' => true,
		//'is_training' => true,
		'is_parent' => true	,
        'traning_video_link'=> true	
    ];
}
