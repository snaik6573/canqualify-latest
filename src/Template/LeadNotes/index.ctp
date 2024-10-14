<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeadNote[]|\Cake\Collection\CollectionInterface $leadNotes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Lead Note'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Leads'), ['controller' => 'Leads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lead'), ['controller' => 'Leads', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customer Representative'), ['controller' => 'CustomerRepresentative', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer Representative'), ['controller' => 'CustomerRepresentative', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="leadNotes index large-9 medium-8 columns content">
    <h3><?= __('Lead Notes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subject') ?></th>
                <th scope="col"><?= $this->Paginator->sort('notes') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lead_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_representative_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('follow_up') ?></th>
                <th scope="col"><?= $this->Paginator->sort('feature_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_completed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('show_to_client') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leadNotes as $leadNote): ?>
            <tr>
                <td><?= $this->Number->format($leadNote->id) ?></td>
                <td><?= h($leadNote->subject) ?></td>
                <td><?= h($leadNote->notes) ?></td>
                <td><?= $leadNote->has('lead') ? $this->Html->link($leadNote->lead->id, ['controller' => 'Leads', 'action' => 'view', $leadNote->lead->id]) : '' ?></td>
                <td><?= $leadNote->has('customer_representative') ? $this->Html->link($leadNote->customer_representative->id, ['controller' => 'CustomerRepresentative', 'action' => 'view', $leadNote->customer_representative->id]) : '' ?></td>
                <td><?= h($leadNote->follow_up) ?></td>
                <td><?= h($leadNote->feature_date) ?></td>
                <td><?= h($leadNote->is_completed) ?></td>
                <td><?= h($leadNote->show_to_client) ?></td>
                <td><?= h($leadNote->created) ?></td>
                <td><?= h($leadNote->modified) ?></td>
                <td><?= $this->Number->format($leadNote->created_by) ?></td>
                <td><?= $this->Number->format($leadNote->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $leadNote->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $leadNote->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $leadNote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leadNote->id)]) ?>
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
