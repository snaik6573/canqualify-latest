<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
?>
<div class="row categories">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Categories') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Categories', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('Id') ?></th>
		<th scope="col"><?= h('Name') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Service') ?></th>
		<th scope="col"><?= h('Parent') ?></th>
		<th scope="col"><?= h('Order') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($categories as $category): ?>
	<tr>
		<td><?= $this->Number->format($category->id) ?></td>
		<td><?= h($category->name) ?></td>
		<td><?= $category->active ? __('Yes') : __('No'); ?></td>
		<td><?= $category->has('service') ? $this->Html->link($category->service->name, ['controller' => 'Services', 'action' => 'view', $category->service->id]) : '' ?></td>
		<td><?= $category->category_id !=0 ? $this->Html->link($category->category_id, ['action' => 'view', $category->category_id]) : '' ?></td>
		<td>
			<?= $this->Form->create($category,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('category_order', ['required'=>false, 'label'=>false, 'class'=>'form-control ajaxChangeOrder','value'=>$category->category_order]); ?>
			<?php echo $this->Form->control('id', ['required'=>false, 'label'=>false, 'type'=>'hidden','value'=>$category->id]); ?>
			<?= $this->Form->end() ?>
		</td>	
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $category->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $category->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN ) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $category->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?>
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
