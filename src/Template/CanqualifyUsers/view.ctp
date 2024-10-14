<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CanqualifyUser $canqualifyUser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Canqualify User'), ['action' => 'edit', $canqualifyUser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Canqualify User'), ['action' => 'delete', $canqualifyUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $canqualifyUser->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Canqualify Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Canqualify User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="canqualifyUsers view large-9 medium-8 columns content">
    <h3><?= h($canqualifyUser->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($canqualifyUser->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($canqualifyUser->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($canqualifyUser->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $canqualifyUser->has('user') ? $this->Html->link($canqualifyUser->user->id, ['controller' => 'Users', 'action' => 'view', $canqualifyUser->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($canqualifyUser->id) ?></td>
        </tr>
    </table>
</div>
