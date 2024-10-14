<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Benchmark[]|\Cake\Collection\CollectionInterface $benchmarks
 */
$users = array(SUPER_ADMIN,ADMIN);
?>
<div class="row benchmarks">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Benchmarks') ?></strong>
	</div>
<?php if(in_array($activeUser['role_id'], $users)) {?>
	<div class="card-body card-block">
	<?= $this->Form->create($benchmarks) ?>
	<?php $selectedClient = !empty($client) ? $client->id : reset($clients); ?>
	<div class="row form-group">
		<label class="col-sm-3">Select Client</label>
		<div class="col-sm-3"><?= $this->Form->control('current_client_id', ['options'=>$clients, 'default'=>$selectedClient, 'required'=>true, 'label'=>false, 'class'=>'form-control']); ?></div>
		<div class="col-sm-3"><?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']) ?></div>
	</div>
	<?= $this->Form->end() ?>
	</div>
<?php } ?>
<?php if(!empty($client)) : ?>
    <?php if(in_array($activeUser['role_id'], $users)) {?>
	<div class="card-header">
		<strong>CanQualify Client: <?= $client->has('company_name') ? $client->company_name : ''; ?></strong>
		<?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Benchmarks', 'action' => 'add', $client->id],['class'=>'btn btn-success btn-sm']) ?> </span>
		<?php } ?>
	</div>
		<?php } ?>
	<div class="card-body table-responsive">
	<?php /*if($activeUser['role'] == 'Admin') { ?>
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('category') ?></th>
		<th scope="col"><?= h('client_id') ?></th>
		<th scope="col"><?= h('emr_from') ?></th>
		<th scope="col"><?= h('emr_to') ?></th>
		<th scope="col"><?= h('dart_from') ?></th>
		<th scope="col"><?= h('dart_to') ?></th>
		<th scope="col"><?= h('icon') ?></th>
		<th scope="col"><?= h('created') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($benchmarks as $benchmark): ?>
	<tr>
		<td><?= $this->Number->format($benchmark->id) ?></td>
		<td><?= h($benchmark->category) ?></td>
		<td><?= $benchmark->has('client') ? $this->Html->link($benchmark->client->company_name, ['controller' => 'Clients', 'action' => 'view', $benchmark->client->id]) : '' ?></td>
		<td><?= $this->Number->format($benchmark->emr_from) ?></td>
		<td><?= $this->Number->format($benchmark->emr_to) ?></td>
		<td><?= $this->Number->format($benchmark->dart_from) ?></td>
		<td><?= $this->Number->format($benchmark->dart_to) ?></td>
		<td><?= h($benchmark->icon) ?></td>
		<td><?= h($benchmark->created) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $benchmark->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $benchmark->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $benchmark->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $benchmark->id)]) ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>


	<?php
	}
	else 
	{*/
    $dtOrder = '[[ 2, &quot;desc&quot; ], [ 0, &quot;asc&quot; ]]';
    if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) {
        $dtOrder = '[[ 3, &quot;asc&quot; ], [ 2, &quot;desc&quot; ], [ 0, &quot;asc&quot; ]]';
    } ?>

	<table id="bootstrap-data-table-export" class="table table-striped table-bordered" data-order="<?= $dtOrder ?>">
	<thead>
	<tr>
		<th scope="col"><?= h('Icon') ?></th>
        <th scope="col"><?= h('Category') ?></th>
		<th scope="col"><?= h('Bench Type') ?></th>
		<?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?><th scope="col"><?= h('client_id') ?></th><?php } ?>
		<th scope="col"><?= h('Range* (Any Year)') ?></th>		
		<th scope="col"><?= h('Conclusion') ?></th>
		<?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
		<th scope="col"><?= h('created') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
		<?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($benchmarks as $benchmark): ?>
	<tr>
		<td class="text-center"><?= '<span style="display:none;">'.$benchmark->icon.'</span><i class="fa fa-circle color-'.$benchmark->icon.'"></i></td>' ?>
		<td><?= $benchmark->has('benchmark_category') ? $this->Html->link($benchmark->benchmark_category->name, ['controller' => 'BenchmarkCategories', 'action' => 'view', $benchmark->benchmark_category->id]) : '' ?></td>
		<td><?= $benchmark->has('benchmark_type') ? $this->Html->link($benchmark->benchmark_type->name, ['controller' => 'BenchmarkTypes', 'action' => 'view', $benchmark->benchmark_type->id]) : '' ?></td>
		<?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
		<td><?= $benchmark->has('client') ? $this->Html->link($benchmark->client->company_name, ['controller' => 'Clients', 'action' => 'view', $benchmark->client->id]) : '' ?></td>
		<?php } ?>
		<td class="text-center"><?= $benchmark->range_to==0 ? $benchmark->range_from .' +' : $benchmark->range_from .' < '. $benchmark->range_to ?></td>
		<td><?= h($benchmark->conclusion) ?></td>
		<?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
		<td><?= h($benchmark->created) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $benchmark->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $benchmark->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN ) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $benchmark->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $benchmark->id)]) ?>
		<?php } ?>
		</td>
		<?php } ?>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php
	//}
	?>
	</div>
<?php endif; ?>
</div>
</div>
</div>
