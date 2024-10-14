<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="row products">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($product->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($product->name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($product->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Pricing') ?></th>
			<td><?= h($product->pricing) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Service') ?></th>
			<td><?= $product->has('service') ? $this->Html->link($product->service->name, ['controller' => 'Services', 'action' => 'view', $product->service->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('From') ?></th>
			<td><?= $this->Number->format($product->range_from) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('To') ?></th>
			<td><?= $this->Number->format($product->range_to) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($product->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($product->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
