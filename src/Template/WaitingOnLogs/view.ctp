<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WaitingOnLog $waitingOnLog
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Waiting On Log'), ['action' => 'edit', $waitingOnLog->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Waiting On Log'), ['action' => 'delete', $waitingOnLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $waitingOnLog->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Waiting On Logs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Waiting On Log'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="waitingOnLogs view large-9 medium-8 columns content">
    <h3><?= h($waitingOnLog->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $waitingOnLog->has('contractor') ? $this->Html->link($waitingOnLog->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $waitingOnLog->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('From Status') ?></th>
            <td><?= h($waitingOnLog->from_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('To Status') ?></th>
            <td><?= h($waitingOnLog->to_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($waitingOnLog->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($waitingOnLog->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($waitingOnLog->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($waitingOnLog->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($waitingOnLog->modified) ?></td>
        </tr>
    </table>
</div>
