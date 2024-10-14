<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BillingDetail $billingDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Billing Details'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="billingDetails form large-9 medium-8 columns content">
    <?= $this->Form->create($billingDetail) ?>
    <fieldset>
        <legend><?= __('Add Billing Detail') ?></legend>
        <?php
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('email');
            echo $this->Form->control('billing_address');
            echo $this->Form->control('state_id', ['options' => $states]);
            echo $this->Form->control('country_id', ['options' => $countries]);
            echo $this->Form->control('card_details');
            echo $this->Form->control('created_by');
            echo $this->Form->control('created_on');
            echo $this->Form->control('updated_by');
            echo $this->Form->control('updated_on');
            echo $this->Form->control('deleted_by');
            echo $this->Form->control('deleted_on');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
