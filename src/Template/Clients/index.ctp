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
		<strong class="card-title"><?= __('Clients') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Clients', 'action' => 'add/1'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>		
		<th scope="col"><?= h('Client Name') ?></th>
		<th scope="col"><?= h('Industry Type') ?></th>		
		<th scope="col"><?= h('No. of Contractors') ?></th>
		<th scope="col"><?= h('Under Configuration Flag') ?></th>			
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php $addr = array(); ?>
	<?php foreach ($clients as $client): ?>
	<tr>		
		<td><?= $this->Html->link($client->company_name, ['controller' => 'Clients', 'action' => 'dashboard', $client->id]); ?></td>
		<td><?= $client->has('account_type') ? $client->account_type->name : '' ?></td>
		<td class="text-center"><?php echo count($this->User->getContractors($client->id));?></td><td>
			 <span style="display:none;"><?= $client->user->under_configuration ? '1' : '0' ?></span>
			<?= $this->Form->create($client,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('user.under_configuration', ['required'=>false, 'label'=>false, 'class'=>'ajaxClick']); ?>
			<?php echo $this->Form->control('user.username', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('user.id', ['type'=>'hidden']); ?>
			<?= $this->Form->end() ?>
			
		</td>
		<td><?= $client->user->active ? __('Yes') : __('No'); ?></td>
		<td class="actions">		
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'add/1/'.$client->id],['escape'=>false, 'title' => 'Edit']) ?>
		</td>
	</tr>
	<?php
		foreach ($client->sites as $client_site): 
		if(isset($client_site->state->name) && isset($client_site->country->name)){
			$addrInfo[0] = $client_site->addressline_1.' '.$client_site->addressline_2.' '.$client_site->city.' '.$client_site->state->name.' '.$client_site->country->name;
			$addrInfo[1] = $client_site->latitude;
			$addrInfo[2] = $client_site->longitude;
			$addrInfo[3] = $client_site->name.', '.$client_site->state->name;
			array_push($addr, $addrInfo);
		}
		endforeach; 
	endforeach;
	?>
	</tbody>
	</table>
	</div>
</div>
</div>
<?php $show_map = Configure::read('show_map'); 
if($show_map == true) { 
?>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Clients Location') ?></strong>
	</div>
	<div class="card-body">
		<script>
			var client_markers = <?php echo json_encode($addr) ?>;
		</script>
		<div class="map" id="map" style="width: 100%;"></div>
	</div>
</div>
</div>
<?php } ?>
</div>