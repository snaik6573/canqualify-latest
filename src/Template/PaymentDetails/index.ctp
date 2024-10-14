<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentDetail[]|\Cake\Collection\CollectionInterface $paymentDetails
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Payment Detail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Services'), ['controller' => 'Services', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Service'), ['controller' => 'Services', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="paymentDetails index large-9 medium-8 columns content">
    <h3><?= __('Payment Details') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('service_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_ids') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentDetails as $paymentDetail): ?>
            <tr>
                <td><?= $this->Number->format($paymentDetail->id) ?></td>
                <td><?= $paymentDetail->has('payment') ? $this->Html->link($paymentDetail->payment->id, ['controller' => 'Payments', 'action' => 'view', $paymentDetail->payment->id]) : '' ?></td>
                <td><?= $paymentDetail->has('service') ? $this->Html->link($paymentDetail->service->name, ['controller' => 'Services', 'action' => 'view', $paymentDetail->service->id]) : '' ?></td>
                <td><?= h($paymentDetail->client_ids) ?></td>
                <td><?= $this->Number->format($paymentDetail->price) ?></td>
                <td><?= $this->Number->format($paymentDetail->created_by) ?></td>
                <td><?= $this->Number->format($paymentDetail->modified_by) ?></td>
                <td><?= h($paymentDetail->created) ?></td>
                <td><?= h($paymentDetail->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $paymentDetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $paymentDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $paymentDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentDetail->id)]) ?>
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
