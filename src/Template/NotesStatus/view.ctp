<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NotesStatus $notesStatus
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Notes Status'), ['action' => 'edit', $notesStatus->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Notes Status'), ['action' => 'delete', $notesStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notesStatus->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Notes Status'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notes Status'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Leads'), ['controller' => 'Leads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lead'), ['controller' => 'Leads', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="notesStatus view large-9 medium-8 columns content">
    <h3><?= h($notesStatus->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $notesStatus->has('contractor') ? $this->Html->link($notesStatus->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $notesStatus->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $notesStatus->has('user') ? $this->Html->link($notesStatus->user->id, ['controller' => 'Users', 'action' => 'view', $notesStatus->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Old Status') ?></th>
            <td><?= h($notesStatus->old_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('New Status') ?></th>
            <td><?= h($notesStatus->new_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lead') ?></th>
            <td><?= $notesStatus->has('lead') ? $this->Html->link($notesStatus->lead->id, ['controller' => 'Leads', 'action' => 'view', $notesStatus->lead->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($notesStatus->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($notesStatus->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($notesStatus->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($notesStatus->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($notesStatus->modified) ?></td>
        </tr>
    </table>
</div>
