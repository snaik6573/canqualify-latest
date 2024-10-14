<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OverallIcon[]|\Cake\Collection\CollectionInterface $overallIcons
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Overall Icon'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="overallIcons index large-9 medium-8 columns content">
    <h3><?= __('Overall Icons') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= h('id') ?></th>
                <th scope="col"><?= h('client_id') ?></th>
                <th scope="col"><?= h('contractor_id') ?></th>
                <th scope="col"><?= h('bench_type') ?></th>
                <th scope="col"><?= h('icon') ?></th>
                <th scope="col"><?= h('category') ?></th>
                <th scope="col"><?= h('created_by') ?></th>
                <th scope="col"><?= h('modified_by') ?></th>
                <th scope="col"><?= h('created') ?></th>
                <th scope="col"><?= h('modified') ?></th>
                <th scope="col"><?= h('is_forced') ?></th>
                <th scope="col"><?= h('show_to_contractor') ?></th>
                <th scope="col"><?= h('show_to_clients') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($overallIcons as $overallIcon): ?>
            <tr>
                <td><?= $this->Number->format($overallIcon->id) ?></td>
                <td><?= $overallIcon->has('client') ? $this->Html->link($overallIcon->client->id, ['controller' => 'Clients', 'action' => 'view', $overallIcon->client->id]) : '' ?></td>
                <td><?= $overallIcon->has('contractor') ? $this->Html->link($overallIcon->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $overallIcon->contractor->id]) : '' ?></td>
                <td><?= h($overallIcon->bench_type) ?></td>
                <td><?= h($overallIcon->icon) ?></td>
                <td><?= h($overallIcon->category) ?></td>
                <td><?= $this->Number->format($overallIcon->created_by) ?></td>
                <td><?= $this->Number->format($overallIcon->modified_by) ?></td>
                <td><?= h($overallIcon->created) ?></td>
                <td><?= h($overallIcon->modified) ?></td>
                <td><?= h($overallIcon->is_forced) ?></td>
                <td><?= h($overallIcon->show_to_contractor) ?></td>
                <td><?= h($overallIcon->show_to_clients) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $overallIcon->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $overallIcon->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $overallIcon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $overallIcon->id)]) ?>
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
