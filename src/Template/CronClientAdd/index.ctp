<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CronClientAdd[]|\Cake\Collection\CollectionInterface $cronClientAdd
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Cron Client Add'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cronClientAdd index large-9 medium-8 columns content">
    <h3><?= __('Cron Client Add') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contractor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cronClientAdd as $cronClientAdd): ?>
            <tr>
                <td><?= $this->Number->format($cronClientAdd->id) ?></td>
                <td><?= $cronClientAdd->has('contractor') ? $this->Html->link($cronClientAdd->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $cronClientAdd->contractor->id]) : '' ?></td>
                <td><?= $cronClientAdd->has('client') ? $this->Html->link($cronClientAdd->client->id, ['controller' => 'Clients', 'action' => 'view', $cronClientAdd->client->id]) : '' ?></td>
                <td><?= h($cronClientAdd->created) ?></td>
                <td><?= h($cronClientAdd->modified) ?></td>
                <td><?= $this->Number->format($cronClientAdd->created_by) ?></td>
                <td><?= $this->Number->format($cronClientAdd->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $cronClientAdd->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cronClientAdd->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cronClientAdd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cronClientAdd->id)]) ?>
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
</div>
