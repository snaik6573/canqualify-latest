<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BenchmarkType[]|\Cake\Collection\CollectionInterface $benchmarkTypes
 */
?>
<div class="row benchmarkTypes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Benchmark Types') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'BenchmarkTypes', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th scope="col"><?= h('Id') ?></th>
			<th scope="col"><?= h('Name') ?></th>
			<th scope="col"><?= h('Created') ?></th>
			<th scope="col"><?= h('Modified') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	 <tbody>
            <?php foreach ($benchmarkTypes as $benchmarkType): ?>
            <tr>
                <td><?= $this->Number->format($benchmarkType->id) ?></td>
                <td><?= h($benchmarkType->name) ?></td>
                <td><?= h($benchmarkType->created) ?></td>
                <td><?= h($benchmarkType->modified) ?></td>
                <td class="actions">
					<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $benchmarkType->id],['escape'=>false, 'title' => 'View']) ?>
					<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $benchmarkType->id],['escape'=>false, 'title' => 'Edit']) ?>
					<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
					<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $benchmarkType->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $benchmarkType->id)]) ?>
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
