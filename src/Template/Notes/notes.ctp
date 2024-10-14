<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Note[]|\Cake\Collection\CollectionInterface $notes
 */
?>
<div class="row notes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Notes') ?></strong>		
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Notes', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>		
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered" data-sort="2">
	<thead>
	<tr>
		<th scope="col"><?= h('subject') ?></th>
		<?php if($activeUser['role_id'] != 4) { ?> <th scope="col"><?= h('User') ?></th><?php } ?>
		<th scope="col"><?= h('Created') ?></th>
		<th scope="col" class="actions"><?= h('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($notes as $note): ?>
	<tr>
		<td><?= h($note->subject) ?></td>
		<?php if($activeUser['role_id'] != 4) { ?><td><?php if($note->has('user')) {
			if($note->user->role->id == 1) { echo 'CanQualify'; }
			elseif(!empty($note->user->client)) { echo $note->user->client->company_name; }		
		} ?>
		</td><?php } ?>
		</td>
		<td><?= h($note->created) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $note->id],['escape'=>false, 'title' => 'View']) ?>
		<?php 
		if($note->created_by == $activeUser['id']) {?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $note->id],['escape'=>false, 'title' => 'Edit']) ?>
			<?php if($activeUser['role_id'] != ADMIN) { ?>
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $note->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $note->id)]) ?>
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
