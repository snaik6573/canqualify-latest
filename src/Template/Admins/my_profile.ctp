<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row admins">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>My</strong> Profile
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($user) ?>
		<div class="form-group">
			<?php echo $this->Form->control('username', ['class'=>'form-control','oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
