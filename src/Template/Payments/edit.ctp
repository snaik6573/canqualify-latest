<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
      <?php if($activeUser['role_id'] != ADMIN) { ?>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $payment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $payment->id)]
            )
        ?></li>
      <?php } ?>
        <li><?= $this->Html->link(__('List Payments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="payments form large-9 medium-8 columns content">
    <?= $this->Form->create($payment) ?>
    <fieldset>
        <legend><?= __('Edit Payment') ?></legend>
        <?php
            echo $this->Form->control('response');
            echo $this->Form->control('contractor_id', ['options' => $contractors, 'empty' => true]);
            echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true]);
            echo $this->Form->control('totalprice');
            echo $this->Form->control('secret_link');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
            echo $this->Form->control('p_ack');
            echo $this->Form->control('p_timestamp');
            echo $this->Form->control('p_correlationid');
            echo $this->Form->control('p_version');
            echo $this->Form->control('p_build');
            echo $this->Form->control('p_amt');
            echo $this->Form->control('p_currencycode');
            echo $this->Form->control('p_errorcode0');
            echo $this->Form->control('p_shortmessage0');
            echo $this->Form->control('p_longmessage0');
            echo $this->Form->control('p_serveritycode0');
            echo $this->Form->control('p_avscode');
            echo $this->Form->control('p_cvv2match');
            echo $this->Form->control('p_transactionid');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
