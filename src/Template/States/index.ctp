<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State[]|\Cake\Collection\CollectionInterface $states
 */
?>
<div class="row states">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('States') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'States', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th scope="col"><?= h('id') ?></th>
			<th scope="col"><?= h('name') ?></th>
			<th scope="col"><?= h('country_id') ?></th>
			<th scope="col"><?= h('created') ?></th>
			<th scope="col"><?= h('modified') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($states as $state): ?>
		<tr>
			<td><?= $this->Number->format($state->id) ?></td>
			<td><?= h($state->name) ?></td>
			<td><?= $state->has('country') ? $this->Html->link($state->country->name, ['controller' => 'Countries', 'action' => 'view', $state->country->id]) : '' ?></td>
			<td><?= h($state->created) ?></td>
			<td><?= h($state->modified) ?></td>
			<td class="actions">
			<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $state->id],['escape'=>false, 'title' => 'View']) ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $state->id],['escape'=>false, 'title' => 'Edit']) ?>
			<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $state->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $state->id)]) ?>
			<?php } ?>
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
