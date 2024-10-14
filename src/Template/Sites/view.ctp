<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Site $site
 */
?>
<div class="row sites">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($site->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($site->name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Client') ?></th>
			<td><?= $site->has('client') ? $this->Html->link($site->client->company_name, ['controller' => 'Clients', 'action' => 'view', $site->client->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Region') ?></th>
			<td><?= $site->has('region') ? $this->Html->link($site->region->name, ['controller' => 'Regions', 'action' => 'view', $site->region->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($site->id) ?></td>
		</tr>
		<tr>
		    <th scope="row"><?= __('Addressline 1') ?></th>
		    <td><?= h($site->addressline_1) ?></td>
		</tr>
		<tr>
		    <th scope="row"><?= __('Addressline 2') ?></th>
		    <td><?= h($site->addressline_2) ?></td>
		</tr>
		<tr>
		    <th scope="row"><?= __('City') ?></th>
		    <td><?= h($site->city) ?></td>
		</tr>
		<tr>
		    <th scope="row"><?= __('State') ?></th>
		    <td><?= $site->has('state') ? $site->state->name : '' ?></td>
		</tr>
		<tr>
		    <th scope="row"><?= __('Country') ?></th>
		    <td><?= $site->has('country') ? $site->country->name : '' ?></td>
		</tr>
		<tr>
		    <th scope="row"><?= __('Zip') ?></th>
		    <td><?= $this->Number->format($site->zip) ?></td>
		</tr>
		<tr>
		    <th scope="row"><?= __('Latitude') ?></th>
		    <td><?= $this->Number->format($site->latitude) ?></td>
		</tr>
		<tr>
		    <th scope="row"><?= __('Longitude') ?></th>
		    <td><?= $this->Number->format($site->longitude) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Html->link($site->created_by, ['controller' => 'Users', 'action' => 'view', $site->created_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Html->link($site->modified_by, ['controller' => 'Users', 'action' => 'view', $site->modified_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($site->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($site->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
