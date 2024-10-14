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
         <div class="pull-right">      
            <?= $this->Html->link(__('Implementaion Registration Status'), ['controller'=>'Leads', 'action'=>'pendingLeads'], ['title'=>'Requests and Status']) ?> |
             <span>New Supplier Registration Status<span> 
          </div>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('Subject') ?></th>
		<th scope="col"><?= h('Company Name') ?></th>
		<th scope="col"><?= h('Status') ?></th>
		<th scope="col"><?= h('Created') ?></th>
		<th scope="col" class="actions"><?= h('View') ?></th>
		<!-- <th scope="col" class="actions"><?= h('Actions') ?></th> -->
	</tr>
	</thead>
	<tbody>
	<?php foreach ($ClientRequest as $clientRequest): ?>
	<tr>
		<td><?= h($clientRequest->subject) ?></td>
		<td><?= $clientRequest->has('contractor') ? $clientRequest->contractor->company_name : '' ?></td>
		<td><?= $clientRequest->status==1 ? h('Pending') : h('Accepted') ?></td>
		<td><?= h($clientRequest->created) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $clientRequest->id],['escape'=>false, 'title' => 'View']) ?>
		</td>
	<!-- 	<td class="actions">
		<?php if($clientRequest->status==2)
		{
			echo 'Accepted';
		}
		else{ ?>
		<?= $this->Html->link(__('Accept'), ['action'=>'accept', $clientRequest->id], ['escape'=>false, 'title' => 'Accept', 'class'=>'btn btn-sm btn-success']) ?>
		<?php if(in_array($activeUser['role_id'], $users)) { ?>
		<?= $this->Form->postLink('Reject', ['action' => 'delete', $clientRequest->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to reject request from # {0}?', $clientRequest->client->company_name), 'class'=>'btn btn-sm btn-danger']) ?>
		<?php } ?>
		<?php  } ?>
		</td> -->
	</tr>
	<?php endforeach; ?>
    <?php foreach ($ClientRequestLead as $clientRequestLead): ?>
	<tr>
		<td><?= h($clientRequestLead->subject) ?></td>
		<td><?= $clientRequestLead->has('contractor') ? $clientRequestLead->contractor->company_name : '' ?></td>
		<td><?= $clientRequestLead->status==1 ? h('Pending') : h('Accepted') ?></td>
		<td><?= h($clientRequestLead->created) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller'=>'ClientRequestsLeads','action' => 'view', $clientRequestLead->id],['escape'=>false, 'title' => 'View']) ?>
		</td>	
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
