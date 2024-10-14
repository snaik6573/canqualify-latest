<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentDetail $paymentDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Payment Detail'), ['action' => 'edit', $paymentDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payment Detail'), ['action' => 'delete', $paymentDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payment Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Services'), ['controller' => 'Services', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Service'), ['controller' => 'Services', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="paymentDetails view large-9 medium-8 columns content">
    <h3><?= h($paymentDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Payment') ?></th>
            <td><?= $paymentDetail->has('payment') ? $this->Html->link($paymentDetail->payment->id, ['controller' => 'Payments', 'action' => 'view', $paymentDetail->payment->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Service') ?></th>
            <td><?= $paymentDetail->has('service') ? $this->Html->link($paymentDetail->service->name, ['controller' => 'Services', 'action' => 'view', $paymentDetail->service->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client Ids') ?></th>
            <td><?= h($paymentDetail->client_ids) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($paymentDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($paymentDetail->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($paymentDetail->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($paymentDetail->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($paymentDetail->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($paymentDetail->modified) ?></td>
        </tr>
    </table>
</div>
