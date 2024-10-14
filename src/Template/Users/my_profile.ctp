<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row users">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Login</strong> Details
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($user) ?>
	<div class="form-group row">
		<?= $this->Form->label('Email', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-5">
			<?= $this->Form->control('username', ['class'=>'form-control', 'label'=>false, 'required'=>false,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>
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
	<?= $this->Form->create($user) ?>
	<?= $this->element('profile_upload', ["user" => $user, "fieldname" => 'profile_photo']) ?>
   	<div class="form-actions form-group">
		<?= $this->Form->control('username', ['type'=>'hidden']); ?>
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>

</div>
</div>
