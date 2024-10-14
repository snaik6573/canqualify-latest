<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientQuestion $clientQuestion
 */
?>
<div class="row clientQuestions">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= h($clientQuestion->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Question') ?></th>
		<td><?= $clientQuestion->has('question') ? $clientQuestion->question->question : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Id') ?></th>
		<td><?= $this->Number->format($clientQuestion->id) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Is Safety Sensitive') ?></th>
		<td><?= $clientQuestion->is_safety_sensitive ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Is Safety Nonsensitive') ?></th>
		<td><?= $clientQuestion->is_safety_nonsensitive ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Is Compulsory') ?></th>
		<td><?= $clientQuestion->is_compulsory ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Number->format($clientQuestion->created_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Number->format($clientQuestion->modified_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($clientQuestion->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($clientQuestion->modified) ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
</div>
