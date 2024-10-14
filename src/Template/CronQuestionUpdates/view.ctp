<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CronQuestionUpdate $cronQuestionUpdate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cron Question Update'), ['action' => 'edit', $cronQuestionUpdate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cron Question Update'), ['action' => 'delete', $cronQuestionUpdate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cronQuestionUpdate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cron Question Updates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cron Question Update'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cronQuestionUpdates view large-9 medium-8 columns content">
    <h3><?= h($cronQuestionUpdate->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $cronQuestionUpdate->has('client') ? $this->Html->link($cronQuestionUpdate->client->id, ['controller' => 'Clients', 'action' => 'view', $cronQuestionUpdate->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $cronQuestionUpdate->has('category') ? $this->Html->link($cronQuestionUpdate->category->name, ['controller' => 'Categories', 'action' => 'view', $cronQuestionUpdate->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cronQuestionUpdate->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($cronQuestionUpdate->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($cronQuestionUpdate->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($cronQuestionUpdate->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($cronQuestionUpdate->modified) ?></td>
        </tr>
    </table>
</div>
