<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Site[]|\Cake\Collection\CollectionInterface $sites
 */
 $clm =0;
 if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] == 'production' ){
	 $clm =1;	 
 }
 ?>
<div class="row sites">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Sites') ?></strong>		
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Sites', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>		
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered" <?php if($clm !=0){ echo "data-sort=".$clm;}?>>
	<thead>
	<tr>
		<th scope="col"><?= h('Id') ?></th>
		<th scope="col"><?= h('Name') ?></th>
		<th scope="col"><?= h('Client') ?></th>
		<th scope="col"><?= h('Region_id') ?></th>
		<th scope="col"><?= h('City') ?></th>
		<th scope="col"><?= h('State') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php 	
	foreach ($sites as $site): ?>
	<tr>
		<td><?= $this->Number->format($site->id) ?></td>
		<td><?= h($site->name) ?></td>
		<td><?= $site->has('client') ? $this->Html->link($site->client->company_name, ['controller' => 'Clients', 'action' => 'view', $site->client->id]) : '' ?></td>
		<td><?= $site->has('region') ? $this->Html->link($site->region->name, ['controller' => 'Regions', 'action' => 'view', $site->region->id]) : '' ?></td>
		<td><?= h($site->city) ?></td>
		<td><?= $site->has('state') ? $site->state->name : $site->state_id ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $site->id],['escape'=>false, 'title' => 'View']) ?>
		<?php if(!isset($client_id)) {?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $site->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php $site->longitude==null && $site->latitude==null ? $locCls='noLocation' : $locCls='updateLocation'; ?>
		<?= $this->Html->link('<i class="fa fa-location-arrow"></i>', ['action' => 'update-location', $site->id],['escape'=>false, 'title' => 'Update Location', 'class'=>$locCls]) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $site->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $site->id)]) ?>
		<?php } ?>
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
