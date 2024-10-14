<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */
?>
<div class="row roles">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Roles') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Roles', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('role_title') ?></th>
		<th scope="col"><?= h('active') ?></th>
		<th scope="col"><?= h('created') ?></th>
		<th scope="col"><?= h('modified') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($roles as $role): ?>
	<tr>
		<td><?= $this->Number->format($role->id) ?></td>
		<td><?= h($role->role_title) ?></td>
		<td><?= $role->active ? __('Yes') : __('No'); ?></td>
		<td><?= h($role->created) ?></td>
		<td><?= h($role->modified) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $role->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $role->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $role->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $role->id)]) ?>
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
