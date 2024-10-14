<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccountType $accountType
 */  
?>
<div class="row accountTypes">
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Account Type
		<?php if($activeUser['role_id'] != ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $accountType->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $accountType->id)]) ?></span>
	    <?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($accountType) ?>
		<div class="form-group">
			<?php echo $this->Form->control('name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
