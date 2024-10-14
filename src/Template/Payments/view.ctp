<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Payment'), ['action' => 'edit', $payment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payment'), ['action' => 'delete', $payment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->id)]) ?> </li>
   		<li><?= $this->Html->link(__('List Payments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="payments view large-9 medium-8 columns content">
    <h3><?= h($payment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $payment->has('contractor') ? $this->Html->link($payment->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $payment->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $payment->has('client') ? $this->Html->link($payment->client->id, ['controller' => 'Clients', 'action' => 'view', $payment->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Secret Link') ?></th>
            <td><?= h($payment->secret_link) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Ack') ?></th>
            <td><?= h($payment->p_ack) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Correlationid') ?></th>
            <td><?= h($payment->p_correlationid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Currencycode') ?></th>
            <td><?= h($payment->p_currencycode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Shortmessage0') ?></th>
            <td><?= h($payment->p_shortmessage0) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Longmessage0') ?></th>
            <td><?= h($payment->p_longmessage0) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Serveritycode0') ?></th>
            <td><?= h($payment->p_serveritycode0) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Avscode') ?></th>
            <td><?= h($payment->p_avscode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Cvv2match') ?></th>
            <td><?= h($payment->p_cvv2match) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Transactionid') ?></th>
            <td><?= h($payment->p_transactionid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($payment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Totalprice') ?></th>
            <td><?= $this->Number->format($payment->totalprice) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($payment->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($payment->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Version') ?></th>
            <td><?= $this->Number->format($payment->p_version) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Build') ?></th>
            <td><?= $this->Number->format($payment->p_build) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Amt') ?></th>
            <td><?= $this->Number->format($payment->p_amt) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Errorcode0') ?></th>
            <td><?= $this->Number->format($payment->p_errorcode0) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($payment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($payment->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('P Timestamp') ?></th>
            <td><?= h($payment->p_timestamp) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Response') ?></h4>
        <?= $this->Text->autoParagraph(h($payment->response)); ?>
    </div>
</div>-->

<div class="row payment">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Transaction Failure Error Message') ?>
	</div>
	<div class="card-body card-block">
		<?= $this->Text->autoParagraph($payment->p_longmessage0); ?>
	</div>
</div>
</div>
</div>
