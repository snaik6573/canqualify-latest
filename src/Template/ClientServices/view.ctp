<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientService $clientService
 */
?>
<div class="row clientServices">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($clientService->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Client') ?></th>
			<td><?= $clientService->has('client') ? $this->Html->link($clientService->client->id, ['controller' => 'Clients', 'action' => 'view', $clientService->client->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Service') ?></th>
			<td><?= $clientService->has('service') ? $clientService->service->name : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($clientService->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Discount') ?></th>
			<td><?= $this->Number->format($clientService->discount) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Html->link($clientService->created_by, ['controller' => 'Users', 'action' => 'view', $clientService->created_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Html->link($clientService->modified_by, ['controller' => 'Users', 'action' => 'view', $clientService->modified_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($clientService->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($clientService->modified) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Is Percentage') ?></th>
			<td><?= $clientService->is_percentage ? __('Yes') : __('No'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Is Safety Sensitive') ?></th>
			<td><?= $clientService->is_safety_sensitive ? __('Yes') : __('No'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Is Safety Nonsensitive') ?></th>
			<td><?= $clientService->is_safety_nonsensitive ? __('Yes') : __('No'); ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
