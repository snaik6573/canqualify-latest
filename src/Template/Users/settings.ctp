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
		<strong>Settings</strong>
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($user) ?>
	<div class="form-group row">
		<?= $this->Form->label('Email', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-5">
			<?= $this->Form->control('username', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
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
</div>
