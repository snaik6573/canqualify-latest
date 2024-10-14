<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NaiscCode[]|\Cake\Collection\CollectionInterface $naiscCodes
 */
?>
<div class="row naiscCodes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('NAISC Codes') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'NaiscCodes', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('naisc_code') ?></th>
		<th scope="col"><?= h('title') ?></th>
		<th scope="col"><?= h('created') ?></th>
		<th scope="col"><?= h('modified') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($naiscCodes as $naiscCode): ?>
	<tr>
		<td><?= $this->Number->format($naiscCode->id) ?></td>
		<td><?= $this->Number->format($naiscCode->naisc_code) ?></td>
		<td><?= h($naiscCode->title) ?></td>
		<td><?= h($naiscCode->created) ?></td>
		<td><?= h($naiscCode->modified) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $naiscCode->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $naiscCode->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $naiscCode->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $naiscCode->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</div>
</div>
</div>
</div>
