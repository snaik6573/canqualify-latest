<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientUser $clientUser
 */
?>

<div class="row clientUsers">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($clientUser->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('First Name ') ?></th>
		<td><?= h($clientUser->pri_contact_fn) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Last Name') ?></th>
		<td><?= h($clientUser->pri_contact_ln) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Phone Number') ?></th>
		<td><?= h($clientUser->pri_contact_pn) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Email') ?></th>
		<td><?= h($clientUser->user->username) ?></td>
	</tr>
	<!-- <tr>
		<th scope="row"><?= __('Client') ?></th>
		<td><?= $clientUser->has('client') ? $this->Html->link($clientUser->client->id, ['controller' => 'Clients', 'action' => 'view', $clientUser->client->id]) : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Id') ?></th>
		<td><?= $this->Number->format($clientUser->id) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($clientUser->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($clientUser->modified) ?></td>
	</tr> -->
	</table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= __('Sites') ?>
	</div>
	<div class="card-body card-block">
		<?php foreach($sitesAssigned as $site) {
			echo $this->Text->autoParagraph(h($site));
		} ?>
	</div>
</div>
</div>
</div>
