<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row users">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Change</strong> Password
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($user) ?>
	<div class="form-group row">
		<?= $this->Form->label('Current Password', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-5"><?= $this->Form->control('current_password', ['type'=>'password', 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('New Password', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-5"><?= $this->Form->control('password', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Confirm Password', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-5"><?= $this->Form->control('confirm_password', ['type'=>'password', 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-actions form-group">
		<?= $this->Form->control('username', ['type'=>'hidden', 'value'=>$user['username']]); ?>
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
