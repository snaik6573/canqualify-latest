<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QuestionType $questionType
 */
?>
<div class="row questionTypes">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Question Type
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($questionType) ?>
		<div class="form-group">
			<?= $this->Form->control('name', ['class'=>'form-control']) ?>
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
