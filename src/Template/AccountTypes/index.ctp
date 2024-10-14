<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccountType[]|\Cake\Collection\CollectionInterface $accountTypes
 */  
?>
<div class="row accountTypes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Account Types') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'accountTypes', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('name') ?></th>
		<th scope="col"><?= h('Created') ?></th>
		<th scope="col"><?= h('Modified') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($accountTypes as $accountType): ?>
	<tr>
		<td><?= $this->Number->format($accountType->id) ?></td>
		<td><?= h($accountType->name) ?></td>
		<td><?= h($accountType->created) ?></td>
		<td><?= h($accountType->modified) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $accountType->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $accountType->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] != ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $accountType->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $accountType->id)]) ?>
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
