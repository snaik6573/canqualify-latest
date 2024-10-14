<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientUser[]|\Cake\Collection\CollectionInterface $clientUsers
 */
 $users = array(SUPER_ADMIN,CLIENT,CLIENT_BASIC);
?>
<div class="row clientUsers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Client Users') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'ClientUsers', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Role') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<!-- <?php if(!empty($client)): ?>
		<tr>		
		<td><?= $client->has('user') ? $client->user->username : '' ?></td>
		<td><?= $client->has('user') ? $client->user->role->role_title : '' ?></td>
		<td><?= $client->has('user') ? $client->user->active ? __('Yes') : __('No') : '' ?></td>
		<td class="actions"></td>
		</tr>
		<?php endif; ?> -->

		<?php foreach ($clientUsers as $clientUser):// pr($clientUser);?>
		<tr>
		<td><?= $clientUser->has('user') ? $clientUser->user->username : '' ?></td>
		<td><?= $clientUser->has('user') ? $clientUser->user->role->role_title : '' ?></td>
		<td><?= $clientUser->has('user') ? $clientUser->user->active ? __('Yes') : __('No') : '' ?></td>
		<?php if($clientUser->user->role_id == CLIENT){ ?>
		<td class="actions"></td>
		<?php }else { ?>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $clientUser->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $clientUser->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if(in_array($activeUser['role_id'], $users)) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $clientUser->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $clientUser->id)]) ?>
		<?php } ?>
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
