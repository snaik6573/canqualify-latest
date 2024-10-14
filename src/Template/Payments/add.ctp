<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<div class="row payments">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Payment</strong>  Add
		<span><?= $this->Html->link(__('List Payments'), ['action' => 'index']) ?></span>        
	</div>
	<div class="card-body card-block">	
    <?= $this->Form->create($payment) ?>
    <fieldset>
        <legend><?= __('Add Payment') ?></legend>
		<div class="form-group">
		<?= $this->Form->control('response', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('contractor_id', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('client_id', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('totalprice', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('secret_link', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('created_by', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('modified_by', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_ack', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_timestamp', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">		
		<?= $this->Form->control('p_correlationid', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_version', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_build', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_amt', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_currencycode', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_errorcode0', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_shortmessage0', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_longmessage0', ['class'=>'form-control']); ?>        
		</div>
			<div class="form-group">
		<?= $this->Form->control('p_serveritycode0', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_avscode', ['class'=>'form-control']); ?>        
		</div>
        <div class="form-group">
		<?= $this->Form->control('p_cvv2match', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-group">
		<?= $this->Form->control('p_transactionid', ['class'=>'form-control']); ?>        
		</div>
		<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-success nextBtn']); ?>				
		<?= $this->Form->end() ?>
		</div>		        
</div>
</div>
</div>
</div>
