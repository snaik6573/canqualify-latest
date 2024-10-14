<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerrNote $customerrNote
 */
 $users = array(SUPER_ADMIN,CR);
?>
<div class="row customerrNotes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Note
		<?php if (in_array($activeUser['role_id'], $users)) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $customerrNote->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $customerrNote->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($customerrNote) ?>
		<div class="form-group">
			<?php echo $this->Form->control('subject', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('notes', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('show_to_contractor'); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->control('follow_up'); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->label('Follow up date', null, ['class'=>'col-form-label']); ?>
			<?= $this->Form->control('feature_date', ['type'=>'text', 'class'=>'form-control col-sm-3 datepicker','label'=>false]) ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>	
	</div>
</div>
</div>
</div>
