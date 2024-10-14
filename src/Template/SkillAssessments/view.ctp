<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SkillAssessment $skillAssessment
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row formsNDocs">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <strong class="card-title"><?= h($skillAssessment->name) ?></strong>
    </div>
    <div class="card-body card-block">
    <table class="table">
    <tr>
        <th scope="row"><?= __('Name') ?></th>
        <td><?= h($skillAssessment->name) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Training Date') ?></th>
        <td><?= h($skillAssessment->training_date) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Expiration Date') ?></th>
        <td><?= h($skillAssessment->expiration_date) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Contractor') ?></th>
        <td><?= $skillAssessment->has('employee') ? $this->Html->link($skillAssessment->contractor->id, ['controller' => 'Employees', 'action' => 'view', $skillAssessment->contractor->id]) : '' ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Id') ?></th>
        <td><?= $this->Number->format($skillAssessment->id) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Created By') ?></th>
        <td><?= $this->Number->format($skillAssessment->created_by) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Modified By') ?></th>
        <td><?= $this->Number->format($skillAssessment->modified_by) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Created') ?></th>
        <td><?= h($skillAssessment->created) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Modified') ?></th>
        <td><?= h($skillAssessment->modified) ?></td>
    </tr>
    </table>
    </div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <strong class="card-title"><?= __('Document') ?></strong>
    </div>
    <div class="card-body card-block">
        <?= $this->Text->autoParagraph(h($skillAssessment->document)); ?>
    </div>
</div>
</div>
</div>
