<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client $client
 */
?>
<div class="row clients">
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Client
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $client->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $client->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($client) ?>
		<div class="form-group">
			<?php echo $this->Form->control('company_name', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('account_type_id', ['options' => $accountTypes, 'empty' => false, 'class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('addressline_1', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('addressline_2', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('city', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('state_id', ['options' => $states, 'empty' => false, 'class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('country_id', ['options' => $countries, 'empty' => false, 'class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('zip', ['class'=>'form-control', 'type'=>'text']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_fn', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_ln', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_pn', ['class'=>'form-control','id'=>'txtPhone']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('membership_startdate', ['type'=>'text', 'class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('membership_enddate', ['type'=>'text', 'class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('registration_status', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('user_id', ['options' => $users, 'empty' => false, 'class'=>'form-control']); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
