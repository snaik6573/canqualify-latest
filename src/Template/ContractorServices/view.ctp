<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorService $contractorService
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contractor Service'), ['action' => 'edit', $contractorService->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contractor Service'), ['action' => 'delete', $contractorService->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contractorService->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contractor Services'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractor Service'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Services'), ['controller' => 'Services', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Service'), ['controller' => 'Services', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contractorServices view large-9 medium-8 columns content">
    <h3><?= h($contractorService->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $contractorService->has('contractor') ? $this->Html->link($contractorService->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $contractorService->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Service') ?></th>
            <td><?= $contractorService->has('service') ? $this->Html->link($contractorService->service->name, ['controller' => 'Services', 'action' => 'view', $contractorService->service->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client Ids') ?></th>
            <td><?= h($contractorService->client_ids) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contractorService->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($contractorService->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($contractorService->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($contractorService->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($contractorService->modified) ?></td>
        </tr>
    </table>
</div>
