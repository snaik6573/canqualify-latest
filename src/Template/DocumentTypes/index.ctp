<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentType[]|\Cake\Collection\CollectionInterface $documentTypes
 */
?>
<!--  <nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Document Type'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documentTypes index large-9 medium-8 columns content">
    <h3><?= __('Document Types') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documentTypes as $documentType): ?>
            <tr>
                <td><?= $this->Number->format($documentType->id) ?></td>
                <td><?= h($documentType->name) ?></td>
                <td><?= h($documentType->created) ?></td>
                <td><?= h($documentType->modified) ?></td>
                <td><?= $this->Number->format($documentType->created_by) ?></td>
                <td><?= $this->Number->format($documentType->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $documentType->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $documentType->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $documentType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentType->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>  -->

<div class="row documentTypes">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong class="card-title"><?= __('Document Types') ?></strong>
        <span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'documentTypes', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
    </div>
    <div class="card-body table-responsive">
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th scope="col"><?= h('id') ?></th>
        <th scope="col"><?= h('name') ?></th>
        <th scope="col"><?= h('Created') ?></th>
        <th scope="col"><?= h('Modified') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($documentTypes as $documentType): ?>
    <tr>
        <td><?= $this->Number->format($documentType->id) ?></td>
        <td><?= h($documentType->name) ?></td>
        <td><?= h($documentType->created) ?></td>
        <td><?= h($documentType->modified) ?></td>
        <td class="actions">
        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $documentType->id],['escape'=>false, 'title' => 'View']) ?>
        <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $documentType->id],['escape'=>false, 'title' => 'Edit']) ?>
        <?php if($activeUser['role_id'] != ADMIN) { ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $documentType->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $documentType->id)]) ?>
        <?php } ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
</div>
</div>
</div>
