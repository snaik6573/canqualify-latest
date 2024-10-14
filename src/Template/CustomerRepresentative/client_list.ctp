<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */ 
use Cake\Core\Configure;
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
	<strong class="card-title"><?= __('Client List') ?></strong>				
	<div class="pull-right">
	</div>
	</div>

	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 1, &quot;asc&quot; ]]">
	<thead>
	<tr>		
		<th scope="col"><?= h('Client name') ?></th>
		<th scope="col"><?= h('Phone') ?></th>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Industry Type') ?></th>
		<th scope="col"><?= h('No. of Contractors') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col" class="noExport"><?= h('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($clientList as $client): ?>
	<tr>		
		<td><?= h($client->company_name) ?></td>
		<td><?= h($client->pri_contact_pn) ?></td>
		<td><?= h($client->user->username); ?></td>
		<td><?= $client->has('account_type') ? $client->account_type->name : '' ?></td>
		<td class="text-center"><?php echo count($this->User->getContractors($client->id));?></td>
		<td><?= $client->user->active ? __('Yes') : __('No'); ?></td>
		<td></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
