<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row products">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Products') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Products', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('name') ?></th>
		<th scope="col"><?= h('range_from') ?></th>
		<th scope="col"><?= h('range_to') ?></th>
		<th scope="col"><?= h('pricing') ?></th>
		<th scope="col"><?= h('service') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($products as $product): ?>
	<tr>
		<td><?= $this->Number->format($product->id) ?></td>
		<td><?= h($product->name) ?></td>
		<td><?= $this->Number->format($product->range_from) ?></td>
		<td><?= $this->Number->format($product->range_to) ?></td>
		<td><?= h($product->pricing) ?></td>
		<td><?= $product->has('service') ? $this->Html->link($product->service->name, ['controller' => 'Services', 'action' => 'view', $product->service->id]) : '' ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $product->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $product->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $product->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?>
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
