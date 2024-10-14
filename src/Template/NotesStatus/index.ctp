<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NotesStatus[]|\Cake\Collection\CollectionInterface $notesStatus
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Notes Status'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Leads'), ['controller' => 'Leads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lead'), ['controller' => 'Leads', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="notesStatus index large-9 medium-8 columns content">
    <h3><?= __('Notes Status') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contractor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('old_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('new_status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lead_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notesStatus as $notesStatus): ?>
            <tr>
                <td><?= $this->Number->format($notesStatus->id) ?></td>
                <td><?= $notesStatus->has('contractor') ? $this->Html->link($notesStatus->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $notesStatus->contractor->id]) : '' ?></td>
                <td><?= $notesStatus->has('user') ? $this->Html->link($notesStatus->user->id, ['controller' => 'Users', 'action' => 'view', $notesStatus->user->id]) : '' ?></td>
                <td><?= h($notesStatus->old_status) ?></td>
                <td><?= h($notesStatus->new_status) ?></td>
                <td><?= h($notesStatus->created) ?></td>
                <td><?= h($notesStatus->modified) ?></td>
                <td><?= $this->Number->format($notesStatus->created_by) ?></td>
                <td><?= $this->Number->format($notesStatus->modified_by) ?></td>
                <td><?= $notesStatus->has('lead') ? $this->Html->link($notesStatus->lead->id, ['controller' => 'Leads', 'action' => 'view', $notesStatus->lead->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $notesStatus->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $notesStatus->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $notesStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notesStatus->id)]) ?>
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
