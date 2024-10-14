<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row employees">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Login </strong> Details
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($customerrepresentative) ?>
	<div class="form-group row">
		<?= $this->Form->label('Email', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?php echo $this->Form->control('user.username', ['class'=>'form-control', 'label'=>false, 'required'=>false ]); ?></div>
	</div>
	<div class="form-actions form-group row">
		<div class="offset-sm-3 col-sm-9">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Html->link(__('<em><i class="fa fa-dot-circle-o"></i></em> Change Password'), ['controller' => 'Users','action' => 'changePassword'], ['escape' => false, 'class'=>'btn btn-success btn-sm']) ?>
		</div>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Profile</strong>
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($customerrepresentative) ?>
	<?= $this->element('profile_upload', ["user" => $customerrepresentative->user, "fieldname" => 'user.profile_photo']) ?>
   	<div class="form-actions form-group">
		<?= $this->Form->control('user.username', ['type'=>'hidden']); ?>
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Primary Contact</strong> Details
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($customerrepresentative) ?>
	<div class="form-group row">
		<?= $this->Form->label('First Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_fn', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Last Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_ln', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Phone No', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_pn', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Extension', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-6"><?= $this->Form->control('extension', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>	
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
