<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorAnswer $contractorAnswer
 */
?>
<div class="row contractorAnswers">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add </strong> Answer
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($contractorAnswer) ?>
		<div class="form-group">
			<?php echo $this->Form->control('contractor_id', ['options' => $contractors, 'empty' => true]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('question_id', ['options' => $questions, 'empty' => true]); ?>
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
