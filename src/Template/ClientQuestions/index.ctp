<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientQuestion[]|\Cake\Collection\CollectionInterface $clientQuestions
 */
?>
<div class="row clientQuestions">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Client Questions') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controllerQuestions' => 'Client', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('category') ?></th>
		<th scope="col"><?= h('question') ?></th>
		<th scope="col"><?= h('is_safety_sensitive') ?></th>
		<th scope="col"><?= h('is_safety_nonsensitive') ?></th>
		<th scope="col"><?= h('is_compulsory') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($clientQuestions as $clientQuestion): ?>
	<tr>
		<td><?= $this->Number->format($clientQuestion->id) ?></td>
		<td><?= $clientQuestion->question->has('category') ? $this->Html->link($clientQuestion->question->category->name, ['controller' => 'Categories', 'action' => 'view', $clientQuestion->question->category->id]) : '' ?></td>
		<td><?= $clientQuestion->has('question') ? $this->Html->link($clientQuestion->question->question, ['controller' => 'Questions', 'action' => 'view', $clientQuestion->question->id]) : '' ?></td>
		<td><?= h($clientQuestion->is_safety_sensitive) ?></td>
		<td><?= h($clientQuestion->is_safety_nonsensitive) ?></td>
		<td><?= h($clientQuestion->is_compulsory) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $clientQuestion->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $clientQuestion->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $clientQuestion->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $clientQuestion->id)]) ?>
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
