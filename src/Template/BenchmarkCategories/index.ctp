<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BenchmarkCategory[]|\Cake\Collection\CollectionInterface $benchmarkCategories
 */
?>
<div class="row benchmarkCategories">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Benchmark Categories') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'BenchmarkCategories', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th scope="col"><?= h('Id') ?></th>
			<th scope="col"><?= h('Name') ?></th>
			<th scope="col"><?= h('Client id') ?></th>
			<th scope="col"><?= h('Created') ?></th>
			<th scope="col"><?= h('Modified') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	 <tbody>
            <?php foreach ($benchmarkCategories as $benchmarkCategory): ?>
            <tr>
                <td><?= $this->Number->format($benchmarkCategory->id) ?></td>
                <td><?= h($benchmarkCategory->name) ?></td>
                <td><?= $benchmarkCategory->has('client') ? $this->Html->link($benchmarkCategory->client->id, ['controller' => 'Clients', 'action' => 'view', $benchmarkCategory->client->id]) : '' ?></td>
                <td><?= h($benchmarkCategory->created) ?></td>
                <td><?= h($benchmarkCategory->modified) ?></td>
   				<td class="actions">
					<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $benchmarkCategory->id],['escape'=>false, 'title' => 'View']) ?>
					<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $benchmarkCategory->id],['escape'=>false, 'title' => 'Edit']) ?>
					<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
					<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $benchmarkCategory->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $benchmarkCategory->id)]) ?>
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




