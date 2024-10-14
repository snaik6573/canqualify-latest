<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentDiscount $paymentDiscount
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Payment Discounts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="paymentDiscounts form large-9 medium-8 columns content">
    <?= $this->Form->create($paymentDiscount) ?>
    <fieldset>
        <legend><?= __('Add Payment Discount') ?></legend>
        <?php
            echo $this->Form->control('contractor_id', ['options' => $contractors, 'empty' => true]);
            echo $this->Form->control('discount_price');
            echo $this->Form->control('valid_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
