<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Benchmark $benchmark
 */
?>
<div class="row benchmarks">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($benchmark->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
        <tr>
            <th scope="row"><?= __('Benchmark Type') ?></th>
            <td><?= $benchmark->has('benchmark_type') ? $this->Html->link($benchmark->benchmark_type->name, ['controller' => 'BenchmarkTypes', 'action' => 'view', $benchmark->benchmark_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Benchmark Category') ?></th>
            <td><?= $benchmark->has('benchmark_category') ? $this->Html->link($benchmark->benchmark_category->name, ['controller' => 'BenchmarkCategories', 'action' => 'view', $benchmark->benchmark_category->id]) : '' ?></td>
        </tr>
	<tr>
		<th scope="row"><?= __('Client') ?></th>
		<td><?= $benchmark->has('client') ? $this->Html->link($benchmark->client->company_name, ['controller' => 'Clients', 'action' => 'view', $benchmark->client->id]) : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Icon') ?></th>
		<td><?= h($benchmark->icon) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Id') ?></th>
		<td><?= $this->Number->format($benchmark->id) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Range From') ?></th>
		<td><?= $this->Number->format($benchmark->range_from) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Range To') ?></th>
		<td><?= $this->Number->format($benchmark->range_to) ?></td>
	</tr>
        <tr>
		<th scope="row"><?= __('Is Percentage') ?></th>
		<td><?= $benchmark->is_percentage ? __('Yes') : __('No'); ?></td>
        </tr>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Html->link($benchmark->created_by, ['controller' => 'Users', 'action' => 'view', $benchmark->created_by]) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Html->link($benchmark->modified_by, ['controller' => 'Users', 'action' => 'view', $benchmark->modified_by]) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($benchmark->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($benchmark->modified) ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= __('Conclusion') ?>
	</div>
	<div class="card-body card-block">
		<?= $this->Text->autoParagraph(h($benchmark->conclusion)); ?>
	</div>
</div>
</div>
</div>
