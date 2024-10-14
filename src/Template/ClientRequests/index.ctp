<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientRequest[]|\Cake\Collection\CollectionInterface $clientRequests
 */
$users = array(SUPER_ADMIN,CONTRACTOR,CONTRACTOR_ADMIN);
?>
<div class="row clientRequests">
<div class="col-lg-12">
<div class="card">
	<div class="card-header clearfix">
		<strong class="card-title"><?= __('Client Requests') ?></strong>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
         <div class="pull-right">      
            <?= $this->Html->link(__('Implementaion Registration Status'), ['controller'=>'Leads', 'action'=>'pendingLeads'], ['title'=>'Requests and Status']) ?> |
             <span>New Supplier Registration Status<span> 
          </div>
         <?php } ?>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('Subject') ?></th>
		<th scope="col"><?= h('Client Name') ?></th>
		<th scope="col"><?= h('Status') ?></th>
		<th scope="col"><?= h('Created') ?></th>
		<th scope="col" class="actions"><?= h('View') ?></th>
		<?php if($activeUser['role_id'] != SUPER_ADMIN) { ?>
		<th scope="col" class="actions"><?= h('Actions') ?></th>
	    <?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($clientRequests as $clientRequest): ?>
	<tr>
		<td><?= h($clientRequest->subject) ?></td>
		<td><?= $clientRequest->has('client') ? $clientRequest->client->company_name : '' ?></td>
		<td><?= $clientRequest->status==1 ? h('Pending') : h('Accepted') ?></td>
		<td><?= h($clientRequest->created) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $clientRequest->id],['escape'=>false, 'title' => 'View']) ?>
		</td>
		<?php if($activeUser['role_id'] != SUPER_ADMIN) { ?>
		<td class="actions">
		<?php if($clientRequest->status==2)
		{
			echo 'Accepted';
		}
		else { 
			/*echo $this->Html->link(__('Accept'), ['action'=>'accept', $clientRequest->id], ['escape'=>false, 'title' => 'Accept', 'class'=>'btn btn-sm btn-success']);*/

			echo $this->Html->link(__('Accept'), ['controller'=> 'ContractorClients', 'action'=>'add', $clientRequest->client_id], ['escape'=>false, 'title' => 'Accept', 'class'=>'btn btn-sm btn-success']);

			if(in_array($activeUser['role_id'], $users)) {
				echo $this->Form->postLink('Reject', ['action' => 'delete', $clientRequest->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to reject request from # {0}?', $clientRequest->client->company_name), 'class'=>'btn btn-sm btn-danger']);
			}
		}
		?>
		</td>
	<?php } ?>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
