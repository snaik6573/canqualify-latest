<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NaicCode[]|\Cake\Collection\CollectionInterface $naicCodes
 */
?>
<div class="row naicCodes">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong class="card-title"><?= __('NAIC Codes') ?></strong>
        <span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'NaicCodes', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
    </div>
    <div class="card-body table-responsive">
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th scope="col"><?= h('id') ?></th>
        <th scope="col"><?= h('naic_code') ?></th>
        <th scope="col"><?= h('title') ?></th>
        <th scope="col"><?= h('created') ?></th>
        <th scope="col"><?= h('modified') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($naicCodes as $naicCode): ?>
    <tr>
        <td><?= $this->Number->format($naicCode->id) ?></td>
        <td><?= $naicCode->naic_code ?></td>
        <td><?= h($naicCode->title) ?></td>
        <td><?= h($naicCode->created) ?></td>
        <td><?= h($naicCode->modified) ?></td>
        <td class="actions">
        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $naicCode->id],['escape'=>false, 'title' => 'View']) ?>
        <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $naicCode->id],['escape'=>false, 'title' => 'Edit']) ?>
        <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $naicCode->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $naicCode->id)]) ?>
        <?php } ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </div>
</div>
</div>
</div>
