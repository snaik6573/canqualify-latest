<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentType $documentType
 */
?>
<!-- <nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Document Type'), ['action' => 'edit', $documentType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Document Type'), ['action' => 'delete', $documentType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Document Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document Type'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="documentTypes view large-9 medium-8 columns content">
    <h3><?= h($documentType->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($documentType->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($documentType->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($documentType->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($documentType->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($documentType->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($documentType->modified) ?></td>
        </tr>
    </table>
</div> -->

<div class="row documentTypes">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <?= h($documentType->name) ?>
    </div>
    <div class="card-body card-block">
    <table class="table">
       <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($documentType->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($documentType->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($documentType->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($documentType->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($documentType->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($documentType->modified) ?></td>
        </tr>
    </table>
    </div>
</div>
</div>
</div>
