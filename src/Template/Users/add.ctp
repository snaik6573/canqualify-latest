<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row users">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> User
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($user) ?>
		<div class="form-group">
			<?php echo $this->Form->control('username', ['class'=>'form-control', 'required' => false,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('password', ['class'=>'form-control', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('confirm_password', ['type'=>'password', 'class'=>'form-control', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('role_id', ['options' => $roles, 'empty' => false, 'class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('active', ['checked'=>'checked']); ?>
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
