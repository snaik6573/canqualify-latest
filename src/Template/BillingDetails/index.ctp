<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BillingDetail[]|\Cake\Collection\CollectionInterface $billingDetails
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Billing Detail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="billingDetails index large-9 medium-8 columns content">
    <h3><?= __('Billing Details') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('billing_address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('state_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('country_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('card_details') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deleted_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deleted_on') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($billingDetails as $billingDetail): ?>
            <tr>
                <td><?= $this->Number->format($billingDetail->id) ?></td>
                <td><?= h($billingDetail->first_name) ?></td>
                <td><?= h($billingDetail->last_name) ?></td>
                <td><?= h($billingDetail->email) ?></td>
                <td><?= h($billingDetail->billing_address) ?></td>
                <td><?= $billingDetail->has('state') ? $this->Html->link($billingDetail->state->name, ['controller' => 'States', 'action' => 'view', $billingDetail->state->id]) : '' ?></td>
                <td><?= $billingDetail->has('country') ? $this->Html->link($billingDetail->country->name, ['controller' => 'Countries', 'action' => 'view', $billingDetail->country->id]) : '' ?></td>
                <td><?= h($billingDetail->card_details) ?></td>
                <td><?= $this->Number->format($billingDetail->created_by) ?></td>
                <td><?= h($billingDetail->created_on) ?></td>
                <td><?= $this->Number->format($billingDetail->updated_by) ?></td>
                <td><?= h($billingDetail->updated_on) ?></td>
                <td><?= $this->Number->format($billingDetail->deleted_by) ?></td>
                <td><?= h($billingDetail->deleted_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $billingDetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $billingDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $billingDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $billingDetail->id)]) ?>
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
