<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Region[]|\Cake\Collection\CollectionInterface $regions
 */
?>
<div class="row regions">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Region') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Regions', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th scope="col"><?= h('Id') ?></th>
			<th scope="col"><?= h('Name') ?></th>
			<th scope="col"><?= h('Client_id') ?></th>
			<th scope="col"><?= h('Created') ?></th>
			<th scope="col"><?= h('Modified') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($regions as $region): ?>
		<tr>
			<td><?= $this->Number->format($region->id) ?></td>
			<td><?= h($region->name) ?></td>
			<td><?= $region->has('client') ? $this->Html->link($region->client->company_name, ['controller' => 'Clients', 'action' => 'view', $region->client->id]) : '' ?></td>
			<td><?= h($region->created) ?></td>
			<td><?= h($region->modified) ?></td>
			<td class="actions">
			<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $region->id],['escape'=>false, 'title' => 'View']) ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $region->id],['escape'=>false, 'title' => 'Edit']) ?>
			<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $region->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $region->id)]) ?>
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
