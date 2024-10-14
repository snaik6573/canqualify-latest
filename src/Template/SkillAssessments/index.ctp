<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SkillAssessment[]|\Cake\Collection\CollectionInterface $skillAssessments
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
 $users = array(SUPER_ADMIN,ADMIN,CONTRACTOR,CONTRACTOR_ADMIN);
?>
<div class="row skillAssessments">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong class="card-title"><?= __('Skill Assessments Document') ?></strong>
        <?php if(in_array($activeUser['role_id'], $users)) { ?>
        <?= $this->Html->link(__('Add New'), ['controller'=>'SkillAssessments', 'action'=>'add'],['class'=>'btn btn-success btn-sm pull-right']) ?>  
    <?php } ?>
    </div>
    <div class="card-body table-responsive">
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered" data-order="[[ 4, &quot;desc&quot; ]]">
    <thead>
    <tr>
        <th scope="col"><?= h('name') ?></th>
        <th scope="col"><?= h('document') ?></th>
        <th scope="col"><?= h('Training Date') ?></th>
        <th scope="col"><?= h('Expiration Date') ?></th>
        <th scope="col"><?= h('created') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($skillAssessments as $skillAssessment): ?>
        <tr>
        <td><?= h($skillAssessment->name) ?></td>
        <td><a href="<?php echo $uploaded_path.'skill_assessments/'.$skillAssessment->document;?>" target="_Blank"><?= $skillAssessment->document ?></a></td>
        <td><?= h($skillAssessment->training_date) ?></td>
        <td><?= h($skillAssessment->expiration_date) ?></td>
        <td><?= h($skillAssessment->created) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
</div>
</div>
</div>
