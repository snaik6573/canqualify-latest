<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientService[]|\Cake\Collection\CollectionInterface $clientServices
 */
?>
<div class="row clientServices">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Services') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'ClientServices', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('service') ?></th>
		<th scope="col"><?= h('discount') ?></th>
		<th scope="col"><?= h('is_percentage') ?></th>
		<th scope="col"><?= h('is_safety_sensitive') ?></th>
		<th scope="col"><?= h('is_safety_nonsensitive') ?></th>
		<th scope="col"><?= h('created') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($clientServices as $clientService): ?>
		<tr>
		<td><?= $this->Number->format($clientService->id) ?></td>
		<td><?= $clientService->has('service') ? $this->Html->link($clientService->service->name, ['controller' => 'Services', 'action' => 'view', $clientService->service->id]) : '' ?></td>
		<td><?= $this->Number->format($clientService->discount) ?></td>
		<td><?= $clientService->is_percentage ? __('Yes') : __('No'); ?></td>
		<td><?= $clientService->is_safety_sensitive ? __('Yes') : __('No'); ?></td>
		<td><?= $clientService->is_safety_nonsensitive ? __('Yes') : __('No'); ?></td>
		<td><?= h($clientService->created) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $clientService->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $clientService->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $clientService->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $clientService->id)]) ?>
		<?php } ?>
		</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
