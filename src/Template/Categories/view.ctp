<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="row categories">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($category->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($category->name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Service') ?></th>
			<td><?= $category->has('service') ? $this->Html->link($category->service->name, ['controller' => 'Services', 'action' => 'view', $category->service->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($category->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Parent') ?></th>
			<td><?= $category->category_id !=0 ? $this->Html->link($category->category_id, ['action' => 'view', $category->category_id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Active') ?></th>
			<td><?= $category->active ? __('Yes') : __('No'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Html->link($category->created_by, ['controller' => 'Users', 'action' => 'view', $category->created_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Html->link($category->modified_by, ['controller' => 'Users', 'action' => 'view', $category->modified_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($category->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($category->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= __('Description') ?>
	</div>
	<div class="card-body card-block">
		<?= $this->Text->autoParagraph(h($category->description)); ?>
	</div>
</div>
</div>
</div>

<div class="row related">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Related Questions') ?>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($category->questions)): ?>
	<table class="bootstrap-data-table-export table table-striped table-bordered">
		<thead>
		<tr>
			<th scope="col"><?= __('Id') ?></th>
			<th scope="col"><?= __('Question') ?></th>
			<th scope="col"><?= __('Active') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($category->questions as $questions): ?>
		<tr>
			<td><?= h($questions->id) ?></td>
			<td><?= h($questions->question) ?></td>
			<td><?= $questions->active ? __('Yes') : __('No'); ?></td>
			<td class="actions">
			<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'Questions', 'action' => 'view', $questions->id],['escape'=>false, 'title' => 'View']) ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'Questions', 'action' => 'edit', $questions->id],['escape'=>false, 'title' => 'Edit']) ?>
			<?php if($activeUser['role_id'] == SUPER_ADMIN ) { ?>
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'Questions', 'action' => 'delete', $questions->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $questions->id)]) ?>
			<?php } ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	</div>
</div>
</div>
</div>
<div class="row related">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Sub Categories') ?>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($sub_cat)): ?>
	<table class="bootstrap-data-table-export table table-striped table-bordered">
		<thead>
		<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('name') ?></th>
		<th scope="col"><?= h('active') ?></th>
		<th scope="col"><?= h('service') ?></th>		
		<th scope="col"><?= h('Order') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
		</thead>
		<tbody>
		<?php foreach ($sub_cat as $category): ?>
		<tr>
		<td><?= $this->Number->format($category->id) ?></td>
		<td><?= h($category->name) ?></td>
		<td><?= $category->active ? __('Yes') : __('No'); ?></td>
		<td><?= $category->has('service') ? $this->Html->link($category->service->name, ['controller' => 'Services', 'action' => 'view', $category->service->id]) : '' ?></td>		
		<td><?= $category->category_order ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $category->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $category->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] != ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $category->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	</div>
</div>
</div>
</div>
