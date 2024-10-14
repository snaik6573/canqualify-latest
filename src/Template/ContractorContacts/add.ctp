<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorContact $contractorContact
 */
?>
<div class="row contractorContacts">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add Contractor Contact</strong>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($contractorContact) ?>
		<div class="form-group">
			<?php echo $this->Form->control('fname', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('lname', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('email', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('phone_no', ['id'=>'txtPhone', 'class'=>'form-control', 'placeholder'=>'(123)-456-7890']); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
