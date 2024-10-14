<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorClient $contractorClient
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contractor Client'), ['action' => 'edit', $contractorClient->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contractor Client'), ['action' => 'delete', $contractorClient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contractorClient->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contractor Clients'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractor Client'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contractorClients view large-9 medium-8 columns content">
    <h3><?= h($contractorClient->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $contractorClient->has('contractor') ? $this->Html->link($contractorClient->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $contractorClient->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $contractorClient->has('client') ? $this->Html->link($contractorClient->client->id, ['controller' => 'Clients', 'action' => 'view', $contractorClient->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contractorClient->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($contractorClient->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($contractorClient->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($contractorClient->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($contractorClient->modified) ?></td>
        </tr>
    </table>
</div>
