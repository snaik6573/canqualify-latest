<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IndustryAverage Entity
 *
 * @property int $id
 * @property int|null $naisc_code_id
 * @property float|null $total_recordable_cases
 * @property float|null $total
 * @property float|null $cases_with_days_away_from_work
 * @property float|null $cases_with_days_of_job_transfer_or_restriction
 * @property float|null $other_recordable_cases
 * @property float|null $industry_average
 * @property int|null $year
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $created_by
 * @property int|null $modified_by
 *
 * @property \App\Model\Entity\NaiscCode $naisc_code
 */
class IndustryAverage extends Entity
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
        'naisc_code_id' => true,
        'total_recordable_cases' => true,
        'total' => true,
        'cases_with_days_away_from_work' => true,
        'cases_with_job_transfer_or_restriction' => true,
        'other_recordable_cases' => true,
        'industry_average' => true,
        'year' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'naisc_code' => true
    ];
}
