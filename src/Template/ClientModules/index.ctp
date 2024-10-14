<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientModule[]|\Cake\Collection\CollectionInterface $clientModules
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Client Module'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientModules index large-9 medium-8 columns content">
    <h3><?= __('Client Modules') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('module_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientModules as $clientModule): ?>
            <tr>
                <td><?= $this->Number->format($clientModule->id) ?></td>
                <td><?= $clientModule->has('client') ? $this->Html->link($clientModule->client->id, ['controller' => 'Clients', 'action' => 'view', $clientModule->client->id]) : '' ?></td>
                <td><?= $clientModule->has('module') ? $this->Html->link($clientModule->module->name, ['controller' => 'Modules', 'action' => 'view', $clientModule->module->id]) : '' ?></td>
                <td><?= h($clientModule->created) ?></td>
                <td><?= h($clientModule->modified) ?></td>
                <td><?= $this->Number->format($clientModule->created_by) ?></td>
                <td><?= $this->Number->format($clientModule->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientModule->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientModule->id]) ?>
					<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
                    <?php } ?> 
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientModule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientModule->id)]) ?>
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
