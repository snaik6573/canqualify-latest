<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingQuestion $trainingQuestion
 */
?>
<div class="row trainingQuestions">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Training Question
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($trainingQuestion) ?>
		<div class="form-group">
			<?= $this->Form->control('question', ['class'=>'form-control', 'required' => false]) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('question_options', ['class'=>'form-control']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('correct_answer', ['class'=>'form-control']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('question_type_id', ['class'=>'form-control', 'options' => $questionTypes, 'empty' => false]) ?>
		</div>		
		<div class="form-group">
			<?= $this->Form->control('help', ['class'=>'form-control', 'class'=>'note']) ?>
		</div>		
		<div class="form-group">
			<?= $this->Form->control('training_id', ['type'=>'hidden', 'value' => $training_id]) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('active', ['class'=>'', 'checked'=>'checked']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('ques_order', ['class'=>'']) ?>
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
