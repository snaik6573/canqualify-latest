<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerrNote $customerrNote
 */
?>
<div class="row customerrNotes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Note
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($customerrNote,['type'=>'file', 'class'=>"saveAjax reloadpage", 'data-responce'=>'.modal-body']) ?>
		<div class="form-group">
			<?php echo $this->Form->control('subject', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('notes', ['class'=>'form-control', 'id'=>'notes']); ?>
		</div>		
		<div class="form-group">
			<?php echo $this->Form->control('show_to_contractor'); ?>
		</div>		
		<div class="form-group">
			<?php echo $this->Form->control('follow_up'); ?>
		</div>		
		<div class="form-group">
			<?= $this->Form->label('Follow up date', null, ['class'=>'col-form-label']); ?>
			<?= $this->Form->control('feature_date', ['type'=>'text', 'class'=>'form-control col-sm-4 datepicker','label'=>false]) ?>
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
