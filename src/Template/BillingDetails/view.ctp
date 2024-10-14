<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BillingDetail $billingDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Billing Detail'), ['action' => 'edit', $billingDetail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Billing Detail'), ['action' => 'delete', $billingDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $billingDetail->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Billing Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Billing Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="billingDetails view large-9 medium-8 columns content">
    <h3><?= h($billingDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($billingDetail->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($billingDetail->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($billingDetail->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Billing Address') ?></th>
            <td><?= h($billingDetail->billing_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $billingDetail->has('state') ? $this->Html->link($billingDetail->state->name, ['controller' => 'States', 'action' => 'view', $billingDetail->state->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Country') ?></th>
            <td><?= $billingDetail->has('country') ? $this->Html->link($billingDetail->country->name, ['controller' => 'Countries', 'action' => 'view', $billingDetail->country->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Card Details') ?></th>
            <td><?= h($billingDetail->card_details) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($billingDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($billingDetail->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated By') ?></th>
            <td><?= $this->Number->format($billingDetail->updated_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted By') ?></th>
            <td><?= $this->Number->format($billingDetail->deleted_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($billingDetail->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated On') ?></th>
            <td><?= h($billingDetail->updated_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted On') ?></th>
            <td><?= h($billingDetail->deleted_on) ?></td>
        </tr>
    </table>
</div>
