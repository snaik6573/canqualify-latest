<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CronQuestionUpdate[]|\Cake\Collection\CollectionInterface $cronQuestionUpdates
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Cron Question Update'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cronQuestionUpdates index large-9 medium-8 columns content">
    <h3><?= __('Cron Question Updates') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cronQuestionUpdates as $cronQuestionUpdate): ?>
            <tr>
                <td><?= $this->Number->format($cronQuestionUpdate->id) ?></td>
                <td><?= $cronQuestionUpdate->has('client') ? $this->Html->link($cronQuestionUpdate->client->id, ['controller' => 'Clients', 'action' => 'view', $cronQuestionUpdate->client->id]) : '' ?></td>
                <td><?= $cronQuestionUpdate->has('category') ? $this->Html->link($cronQuestionUpdate->category->name, ['controller' => 'Categories', 'action' => 'view', $cronQuestionUpdate->category->id]) : '' ?></td>
                <td><?= h($cronQuestionUpdate->created) ?></td>
                <td><?= h($cronQuestionUpdate->modified) ?></td>
                <td><?= $this->Number->format($cronQuestionUpdate->created_by) ?></td>
                <td><?= $this->Number->format($cronQuestionUpdate->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $cronQuestionUpdate->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cronQuestionUpdate->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cronQuestionUpdate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cronQuestionUpdate->id)]) ?>
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
