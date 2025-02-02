<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NotificationType[]|\Cake\Collection\CollectionInterface $notificationTypes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Notification Type'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notifications'), ['controller' => 'Notifications', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Notification'), ['controller' => 'Notifications', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="notificationTypes index large-9 medium-8 columns content">
    <h3><?= __('Notification Types') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notificationTypes as $notificationType): ?>
            <tr>
                <td><?= $this->Number->format($notificationType->id) ?></td>
                <td><?= h($notificationType->name) ?></td>
                <td><?= $this->Number->format($notificationType->created_by) ?></td>
                <td><?= $this->Number->format($notificationType->modified_by) ?></td>
                <td><?= h($notificationType->created) ?></td>
                <td><?= h($notificationType->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $notificationType->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $notificationType->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $notificationType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notificationType->id)]) ?>
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
