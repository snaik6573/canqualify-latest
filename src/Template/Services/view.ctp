<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Service $service
 */
?>
<div class="row services">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($service->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($service->name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($service->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Active') ?></th>
			<td><?= $service->active ? __('Yes') : __('No'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Html->link($service->created_by, ['controller' => 'Users', 'action' => 'view', $service->created_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Html->link($service->modified_by, ['controller' => 'Users', 'action' => 'view', $service->modified_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($service->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($service->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>

<div class="row related">
<div class="col-lg-12">
<div class="related card">
	<div class="card-header">
		<?= __('Related Categories') ?>
	</div>
	<div class="card-body card-block">
		<?php if (!empty($service->categories)): ?>
		<table class="bootstrap-data-table-export table table-striped table-bordered">
		<thead>
			<tr>
				<th scope="col"><?= __('Id') ?></th>
				<th scope="col"><?= __('Name') ?></th>
				<th scope="col"><?= __('Active') ?></th>
				<th scope="col"><?= __('Parent') ?></th>
				<th scope="col" class="actions"><?= __('Actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($service->categories as $categories): ?>
			<tr>
				<td><?= h($categories->id) ?></td>
				<td><?= $this->Html->link($categories->name, ['controller' => 'Categories','action' => 'view', $categories->id]) ?></td>
				<td><?= $categories->active ? __('Yes') : __('No'); ?></td>
				<td><?= $categories->category_id !=0 ? $this->Html->link($categories->category_id, ['controller' => 'Categories','action' => 'view', $categories->category_id]) : '' ?></td>
				<td class="actions">
				<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'Categories','action' => 'view', $categories->id],['escape'=>false, 'title' => 'View']) ?>
				<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'Categories','action' => 'edit', $categories->id],['escape'=>false, 'title' => 'Edit']) ?>
				<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
				<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'Categories','action' => 'delete', $categories->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $categories->id)]) ?>
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
<div class="related card">
	<div class="card-header">
		<?= __('Related Products') ?>
	</div>
	<div class="card-body card-block">
		<?php if (!empty($service->products)): ?>
		<table class="bootstrap-data-table-export table table-striped table-bordered">
		<thead>
			<tr>
				<th scope="col"><?= __('Id') ?></th>
				<th scope="col"><?= __('Name') ?></th>
				<th scope="col"><?= __('From') ?></th>
				<th scope="col"><?= __('To') ?></th>
				<th scope="col"><?= __('Pricing') ?></th>
				<th scope="col" class="actions"><?= __('Actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($service->products as $products): ?>
			<tr>
				<td><?= h($products->id) ?></td>
				<td><?= h($products->name) ?></td>
				<td><?= $this->Number->format($products->range_from) ?></td>
				<td><?= $this->Number->format($products->range_to) ?></td>
				<td><?= h($products->pricing) ?></td>
				<td class="actions">
				<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'Products','action' => 'view', $products->id],['escape'=>false, 'title' => 'View']) ?>
				<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'Products','action' => 'edit', $products->id],['escape'=>false, 'title' => 'Edit']) ?>
				<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
				<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'Products','action' => 'delete', $products->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $products->id)]) ?>
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
<div class="related card">
	<div class="card-header">
		<?= __('Related Client Services') ?>
	</div>
	<div class="card-body card-block">
		<?php if (!empty($service->client_services)): ?>
		<table class="bootstrap-data-table-export table table-striped table-bordered">
		<thead>
			<tr>
				<th scope="col"><?= __('Id') ?></th>
				<th scope="col"><?= __('Client') ?></th>
				<th scope="col"><?= __('Created') ?></th>
				<th scope="col"><?= __('Modified') ?></th>
				<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
				<th scope="col" class="actions"><?= __('Actions') ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($service->client_services as $clientServices): ?>
			<tr>
				<td><?= h($clientServices->id) ?></td>
				<td><?= $clientServices->has('client') ? $this->Html->link(__($clientServices->client->company_name), ['controller' => 'Clients', 'action' => 'view', $clientServices->client->id]) : '' ?></td>
				<td><?= h($clientServices->created) ?></td>
				<td><?= h($clientServices->modified) ?></td>
				<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
				<td class="actions">
				<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'ClientServices','action' => 'delete', $clientServices->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $clientServices->id)]) ?>
				</td>
				<?php } ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
		<?php endif; ?>
	</div>
</div>
</div>
</div>
