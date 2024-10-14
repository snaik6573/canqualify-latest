<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Region $region
 */
?>
<div class="row states">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($region->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Name') ?></th>
		<td><?= h($region->name) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Client') ?></th>
		<td><?= $region->has('client') ? $this->Html->link($region->client->company_name, ['controller'=>'Clients', 'action'=>'view', $region->client->id]) : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Id') ?></th>
		<td><?= $this->Number->format($region->id) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($region->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($region->modified) ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
</div>

<div class="row related">
<div class="col-lg-12">
<div class="related card">
	<div class="card-header">
		<?= __('Related Sites') ?>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($region->sites)): ?>
	<table class="bootstrap-data-table-export table table-striped table-bordered">
		<thead>
		<tr>
			<th scope="col"><?= __('Id') ?></th>
			<th scope="col"><?= __('Name') ?></th>
			<th scope="col"><?= __('City') ?></th>
			<th scope="col"><?= __('State') ?></th>
			<th scope="col"><?= __('Created') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($region->sites as $sites): ?>
		<tr>
			<td><?= h($sites->id) ?></td>
			<td><?= h($sites->name) ?></td>
			<td><?= h($sites->city) ?></td>
			<td><?= $sites->has('state') ? $sites->state->name : '' ?></td>
			<td><?= h($sites->created) ?></td>
			<td class="actions">
			<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller'=>'Sites', 'action'=>'view', $sites->id],['escape'=>false, 'title'=>'View']) ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller'=>'Sites', 'action'=>'edit', $sites->id],['escape'=>false, 'title'=>'Edit']) ?>
			<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller'=>'Sites', 'action'=>'delete', $sites->id], ['escape'=>false, 'title'=>'Delete', 'confirm'=>__('Are you sure you want to delete # {0}?', $sites->id)]) ?>
			<?php } ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
	<?php endif; ?>
	</div>
</div>
</div>
</div>
