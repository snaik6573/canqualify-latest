<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerRepresentative $customerRepresentative
 */
?>
<div class="row customerRepresentative">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Edit</strong> Customer Representative
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $customerRepresentative->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $customerRepresentative->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($customerRepresentative) ?>
		<div class="form-group">
			<?php echo $this->Form->control('user.username', ['class'=>'form-control','label' => 'Email','required' => false,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_fn', ['class'=>'form-control', 'label'=>'First Name', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_ln', ['class'=>'form-control', 'label'=>'Last Name', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_pn', ['id'=>'txtPhone', 'class'=>'form-control', 'placeholder'=>'(123)-456-7890', 'label'=>'Phone No.', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('extension', ['class'=>'form-control', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('user.active', ['required'=>false]); ?>
		</div>
		<div class="form-actions form-group">
			<?php echo $this->Form->control('user.role_id', ['type'=>'hidden', 'value'=>'4']); ?>
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
<?php /* ?>
<div class="col-lg-6">
        <div class="card">
	<div class="card-header">
		<strong>Assign Contractors</strong>
	</div>
	<div class="card-body card-block">
		<?= $this->Form->create() ?>
		<div class="form-group">
		<?= $this->Form->select('contractor_name', ['Select Contractor' => $contractorList], ['value' => $asignedContractors, 'multiple' => true, 'class'=>'form-control selectwithcheckbox'] ); ?>
		</div>
		<div class="form-group">
		<?= $this->Form->button(__('Assign Contractor'), ['class'=>'btn btn-success btn-flat m-b-30 m-t-30']) ?>
		</div>
		<?= $this->Form->end() ?>
	</div>
	</div>

        <div class="card">
	<div class="card-header">
		<strong>Assign Clients</strong>
	</div>
	<div class="card-body card-block">
		<?= $this->Form->create() ?>
		<div class="form-group">
		<?= $this->Form->select('client_name', ['Select Client' => $clientList], ['value' => $asignedClients, 'multiple' => true, 'class'=>'form-control selectwithcheckbox'] ); ?>
		</div>
		<div class="form-group">
		<?= $this->Form->button(__('Assign Clients'), ['class'=>'btn btn-success btn-flat m-b-30 m-t-30']) ?>
		</div>
		<?= $this->Form->end() ?>
	</div>
	</div>
</div>
<?php */ ?>
</div>
