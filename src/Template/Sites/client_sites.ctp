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
		<strong class="card-title"><?= __('Locations') ?></strong>
		<?php if(($activeUser['role_id'] == SUPER_ADMIN) || ($activeUser['role_id'] == ADMIN)) { ?>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Sites', 'action' => 'addsites'],['class'=>'btn btn-success btn-sm']) ?> </span>
		<?php } ?>
	</div>
	<div class="card-body table-responsive">	
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered" <?php if($clm !=0){ echo "data-sort=".$clm;}?>>
	<thead>
	<tr>
		<th scope="col"><?= $this->Paginator->sort('Id') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Name') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Client') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Region_Id') ?></th>
		<th scope="col"><?= $this->Paginator->sort('City') ?></th>
		<th scope="col"><?= $this->Paginator->sort('State') ?></th>
	</tr>
	</thead>	
	<tbody>
	<?php 
	if(!empty($sites)){	
	foreach ($sites as $site): ?>
	<tr>
		<td><?= $this->Number->format($site->id) ?></td>
		<td><?= h($site->name) ?></td>
		<td><?= $site->has('client') ? $site->client->company_name : '' ?></td>
		<td><?= $site->has('region') ? $site->region->name : '' ?></td>
		<td><?= h($site->city) ?></td>
		<td><?= $site->has('state') ? $site->state->name : $site->state_id ?></td>
	</tr>
	<?php endforeach; } ?>
	</tbody>
	</table>	
	</div>
</div>
</div>
</div>
