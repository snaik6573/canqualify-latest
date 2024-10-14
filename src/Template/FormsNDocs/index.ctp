<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormsNDoc[]|\Cake\Collection\CollectionInterface $formsNDocs
 */
?>
<div class="row formsNDocs">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Forms N Docs') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'FormsNDocs', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('name') ?></th>
		<th scope="col"><?= h('created') ?></th>
		<th scope="col"><?= h('modified') ?></th>
		<th scope="col"><?= h('created_by') ?></th>
		<th scope="col"><?= h('modified_by') ?></th>
		<th scope="col"><?= h('client_id') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($formsNDocs as $formsNDoc): ?>
	<tr>
		<td><?= h($formsNDoc->name) ?></td>
		<td><?= h($formsNDoc->created) ?></td>
		<td><?= h($formsNDoc->modified) ?></td>
		<td><?= $this->Number->format($formsNDoc->created_by) ?></td>
		<td><?= $this->Number->format($formsNDoc->modified_by) ?></td>
		<td><?= $formsNDoc->has('client') ? $this->Html->link($formsNDoc->client->id, ['controller' => 'Clients', 'action' => 'view', $formsNDoc->client->id]) : '' ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $formsNDoc->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $formsNDoc->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $formsNDoc->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $formsNDoc->id)]) ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
	<!--<div class="paginator">
		<ul class="pagination">
		<?= $this->Paginator->first('<< ' . __('first')) ?>
		<?= $this->Paginator->prev('< ' . __('previous')) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next(__('next') . ' >') ?>
		<?= $this->Paginator->last(__('last') . ' >>') ?>
		</ul>
		<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
	</div>-->
</div>
</div>
</div>
