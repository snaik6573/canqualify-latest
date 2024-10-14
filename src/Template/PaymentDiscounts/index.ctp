<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentDiscount[]|\Cake\Collection\CollectionInterface $paymentDiscounts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Payment Discount'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="paymentDiscounts index large-9 medium-8 columns content">
    <h3><?= __('Payment Discounts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contractor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valid_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentDiscounts as $paymentDiscount): ?>
            <tr>
                <td><?= $this->Number->format($paymentDiscount->id) ?></td>
                <td><?= $paymentDiscount->has('contractor') ? $this->Html->link($paymentDiscount->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $paymentDiscount->contractor->id]) : '' ?></td>
                <td><?= $this->Number->format($paymentDiscount->discount_price) ?></td>
                <td><?= h($paymentDiscount->valid_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $paymentDiscount->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $paymentDiscount->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $paymentDiscount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentDiscount->id)]) ?>
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
