<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientRequest $clientRequest
 */
?>

<div class="row contractorRequests">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h('Contractor Request') ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Contractor') ?></th>
		<td><?= $contractorRequest->has('contractor') ? $contractorRequest->contractor->company_name : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Status') ?></th>
		<td><?= $this->Number->format($contractorRequest->status) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Number->format($contractorRequest->created_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Number->format($contractorRequest->modified_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($contractorRequest->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($contractorRequest->modified) ?></td>
	</tr>
	</table>
	</div>
</div>
</div>

<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= __('Subject') ?>
	</div>
	<div class="card-body card-block">
		<?= h($contractorRequest->subject) ?>
	</div>

	<div class="card-header">
		<?= __('Message') ?>
	</div>
	<div class="card-body card-block">
		<?= h($contractorRequest->message) ?>
	</div>
</div>
</div>

</div>
