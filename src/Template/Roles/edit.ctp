<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<div class="row roles">
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Role
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $role->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $role->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($role) ?>
		<div class="form-group">
			<?php echo $this->Form->control('role_title', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('description', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('active'); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>	
	</div>
</div>
</div>
</div>
