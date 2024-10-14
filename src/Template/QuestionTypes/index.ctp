<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QuestionType[]|\Cake\Collection\CollectionInterface $questionTypes
 */
?>
<div class="row questionTypes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Question Types') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'questionTypes', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('name') ?></th>
		<th scope="col"><?= h('created_by') ?></th>
		<th scope="col"><?= h('deleted on') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($questionTypes as $questionType): ?>
	<tr>
		<td><?= $this->Number->format($questionType->id) ?></td>
		<td><?= h($questionType->name) ?></td>
		<td><?= $this->Html->link($questionType->created_by, ['controller' => 'Users', 'action' => 'view', $questionType->created_by]) ?></td>
		<td><?= h($questionType->deleted) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $questionType->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $questionType->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $questionType->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $questionType->id)]) ?>
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
