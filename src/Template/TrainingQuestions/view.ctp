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
		<?= h($trainingQuestion->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Question Type') ?></th>
		<td><?= $trainingQuestion->has('question_type') ? $this->Html->link($trainingQuestion->question_type->name, ['controller' => 'QuestionTypes', 'action' => 'view', $trainingQuestion->question_type->id]) : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Training') ?></th>
		<td><?= $trainingQuestion->has('training') ? $this->Html->link($trainingQuestion->training->name, ['controller' => 'Trainings', 'action' => 'view', $trainingQuestion->training->id]) : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Client') ?></th>
		<td><?= $trainingQuestion->has('client') ? $this->Html->link($trainingQuestion->client->id, ['controller' => 'Clients', 'action' => 'view', $trainingQuestion->client->id]) : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Safety Type') ?></th>
		<td><?= h($trainingQuestion->safety_type) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Id') ?></th>
		<td><?= $this->Number->format($trainingQuestion->id) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Number->format($trainingQuestion->created_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Number->format($trainingQuestion->modified_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Ques Order') ?></th>
		<td><?= $this->Number->format($trainingQuestion->ques_order) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($trainingQuestion->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($trainingQuestion->modified) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Allow Multiselect') ?></th>
		<td><?= $trainingQuestion->allow_multiselect ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Active') ?></th>
		<td><?= $trainingQuestion->active ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Allow Multiple Answers') ?></th>
		<td><?= $trainingQuestion->allow_multiple_answers ? __('Yes') : __('No'); ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
	<?= __('Question') ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Text->autoParagraph(h($trainingQuestion->question)); ?>
	</div>

	<div class="card-header">
	<?= __('Question Options') ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Text->autoParagraph(h($trainingQuestion->question_options)); ?>
	</div>

	<div class="card-header">
	<?= __('Help') ?>
	</div>
	<div class="card-body card-block">
	<?= html_entity_decode($trainingQuestion->help)?>	
	</div>
</div>
</div>
</div>
