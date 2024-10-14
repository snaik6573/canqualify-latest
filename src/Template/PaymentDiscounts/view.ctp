<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentDiscount $paymentDiscount
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Payment Discount'), ['action' => 'edit', $paymentDiscount->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payment Discount'), ['action' => 'delete', $paymentDiscount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentDiscount->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payment Discounts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment Discount'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="paymentDiscounts view large-9 medium-8 columns content">
    <h3><?= h($paymentDiscount->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $paymentDiscount->has('contractor') ? $this->Html->link($paymentDiscount->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $paymentDiscount->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($paymentDiscount->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount Price') ?></th>
            <td><?= $this->Number->format($paymentDiscount->discount_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Valid Date') ?></th>
            <td><?= h($paymentDiscount->valid_date) ?></td>
        </tr>
    </table>
</div>
