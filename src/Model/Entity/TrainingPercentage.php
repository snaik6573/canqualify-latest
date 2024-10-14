<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TrainingPercentage Entity
 *
 * @property int $id
 * @property int|null $training_id
 * @property int|null $employee_id
 * @property float|null $percentage
 * @property int|null $contractor_id
 * @property int|null $client_id
 *
 * @property \App\Model\Entity\Training $training
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\Contractor $contractor
 * @property \App\Model\Entity\Client $client
 */
class TrainingPercentage extends Entity
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
        'training_id' => true,
        'employee_id' => true,
        'percentage' => true,
        'contractor_id' => true,
        'client_id' => true,
        'work_locations' => true,
        'completion_date' => true,
        'expiration_date' => true
    ];
}
