<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientRequest $clientRequest
 */
?>

<div class="row clientRequests">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h('Client Request') ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Client') ?></th>
		<td><?= $clientRequest->has('client') ? $clientRequest->client->company_name : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Status') ?></th>
		<td><?= $this->Number->format($clientRequest->status) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Number->format($clientRequest->created_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Number->format($clientRequest->modified_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($clientRequest->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($clientRequest->modified) ?></td>
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
		<?= h($clientRequest->subject) ?>
	</div>

	<div class="card-header">
		<?= __('Message') ?>
	</div>
	<div class="card-body card-block">
		<?= h($clientRequest->message) ?>
	</div>
</div>
</div>

</div>
