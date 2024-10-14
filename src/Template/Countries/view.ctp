<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Country $country
 */
?>
<div class="row countries">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($country->name) ?>
	</div>

	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($country->name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($country->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($country->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($country->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>

<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('States') ?>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'States', 'action' => 'add', $country->id],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body">
	<?php if (!empty($country->states)): ?>
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('name') ?></th>
			<th scope="col"><?= $this->Paginator->sort('country_id') ?></th>
			<th scope="col"><?= $this->Paginator->sort('created') ?></th>
			<th scope="col"><?= $this->Paginator->sort('modified') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($country->states as $states): ?>
		<tr>
			<td><?= $this->Number->format($states->id) ?></td>
			<td><?= h($states->name) ?></td>
			<td><?= h($country->name) ?></td>
			<td><?= h($states->created) ?></td>
			<td><?= h($states->modified) ?></td>
			<td class="actions">
				<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'States', 'action' => 'view', $states->id],['escape'=>false, 'title' => 'View']) ?>
				<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'States', 'action' => 'edit', $states->id],['escape'=>false, 'title' => 'Edit']) ?>
				<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
				<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'States', 'action' => 'delete', $states->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $states->id)]) ?>
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
