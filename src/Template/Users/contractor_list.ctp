<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */ 
use Cake\Core\Configure;
$iconList = Configure::read('icons'); //, array('0'=>'Grey','1'=>'Red','2'=>'Yellow','3'=>'Green')
$dayList = array('8'=>'8 Days','15'=>'15 Days','30'=>'1 Month');
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
	<strong class="card-title"><?= __('Contractor List') ?></strong>				
	<div class="pull-right">
	<?= $this->Form->create($users, ['class'=>'form-inline']) ?>
		<div class="form-group">
           	<label for="client-id">Filter subscription date by </label>
		<?= $this->Form->select('sub_date', $dayList, ['class'=>"form-control ml-2", 'empty'=>'Select Days', 'default'=>$filterDate, 'onchange'=>'this.form.submit();']) ?>
		</div>
		<?= $this->Form->end() ?>
	</div>
	</div>

	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 5, &quot;asc&quot; ],[ 7, &quot;desc&quot; ]]">
	<thead>
	<tr>		
		<th scope="col"><?= h('Contractor name') ?></th>
		<th scope="col"><?= h('No. of Clients') ?></th>
		<th scope="col"><?= h('primary Contact') ?></th>
		<th scope="col"><?= h('Phone') ?></th>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Subscription Date') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Paid') ?></th>	    
		<th scope="col" class="noExport"><?= h('Actions') ?></th>
	</tr>
	</thead>
	<tbody>	
	<?php foreach ($contList as $c): 
    $getClients = $this->User->getClients($c['id']);
    $clients = [];
    foreach ($getClients as $cid) {
         $clients[] = $allClients[$cid];
    }     
	?>		
	<tr>		
		<td><?= $this->Html->link($c['company_name'], ['controller' => 'Contractors','action' => 'dashboard', $c['id']],['escape'=>false, 'title' => 'View']) ?></td>
		<td><a href="#" data-placement="top" title="<?= implode(',', $clients) ?>"><?= count($clients); ?></a></td>
		<td><?= h($c['pri_contact_fn'].' '.$c['pri_contact_ln']); ?></td>
		<td><?= h($c['pri_contact_pn']) ?></td>
		<td><?= h($c['username']); ?></td>
		<td><?= h($c['subscription_date']) ?></td>
		<td>
            <span style="display:none;"><?= $c['active'] ? '1' : '0' ?></span>
			<?= $this->Form->create($contractor,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?= $this->Form->control('user.active', ['required'=>false, 'label'=>false, 'class'=>'ajaxClick', 'checked'=>$c['active'] ? 'checked' : '']); ?>
			<?= $this->Form->control('user.username', ['type'=>'hidden', 'value'=>$c['username']]); ?>
			<?= $this->Form->control('id', ['type'=>'hidden', 'value'=>$c['id']]); ?>
			<?= $this->Form->end() ?>
		</td>
		<td><?= $c['payment_status'] ? __('Yes') : __('No'); ?></td>
		<td>	
		<?= $c['renew_subscription']  ? $this->Html->link(__('Generate Key'), ['controller' => 'Users','action'=>'generateKey', $c['id']], ['class'=>'ajaxmodal btn btn-sm btn-success mt-2 generate_key', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal2']) : '' ?>	
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>

<div class="modal fade" id="scrollmodal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Send Invoice Info.</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>
