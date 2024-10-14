<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorService[]|\Cake\Collection\CollectionInterface $contractorServices
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Contractor Service'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Services'), ['controller' => 'Services', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Service'), ['controller' => 'Services', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contractorServices index large-9 medium-8 columns content">
    <h3><?= __('Contractor Services') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contractor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('service_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_ids') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contractorServices as $contractorService): ?>
            <tr>
                <td><?= $this->Number->format($contractorService->id) ?></td>
                <td><?= $contractorService->has('contractor') ? $this->Html->link($contractorService->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $contractorService->contractor->id]) : '' ?></td>
                <td><?= $contractorService->has('service') ? $this->Html->link($contractorService->service->name, ['controller' => 'Services', 'action' => 'view', $contractorService->service->id]) : '' ?></td>
                <td><?= h($contractorService->client_ids) ?></td>
                <td><?= $this->Number->format($contractorService->created_by) ?></td>
                <td><?= $this->Number->format($contractorService->modified_by) ?></td>
                <td><?= h($contractorService->created) ?></td>
                <td><?= h($contractorService->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $contractorService->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contractorService->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contractorService->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contractorService->id)]) ?>
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
