<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorAnswer $contractorAnswer
 */
?>
<div class="row contractorAnswers">
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Answer
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right">
		<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contractorAnswer->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $contractorAnswer->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($contractorAnswer) ?>
		<div class="form-group">
			<?php echo $this->Form->control('contractor_id', ['class'=>'form-control', 'options' => $contractors, 'empty' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('question_id', ['class'=>'form-control', 'options' => $questions, 'empty' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('answer', ['class'=>'form-control']); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
