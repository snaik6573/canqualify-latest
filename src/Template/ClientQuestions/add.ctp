<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientQuestion $clientQuestion
 */
?>
<div class="row clientQuestions">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add Client</strong> Question
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($clientQuestion) ?>
		<div class="form-group">
			<?php echo $this->Form->control('question_id', ['options' => $questions, 'class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('is_safety_sensitive', ['class'=>'']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('is_safety_nonsensitive', ['class'=>'']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('is_compulsory', ['class'=>'']); ?>
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
