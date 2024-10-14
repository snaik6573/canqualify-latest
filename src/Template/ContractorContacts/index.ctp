<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorContact[]|\Cake\Collection\CollectionInterface $contractorContacts
 */
$users = array(SUPER_ADMIN, CONTRACTOR,CONTRACTOR_ADMIN);
?>
<div class="row contractorContacts">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Contractor Contacts') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'ContractorContacts', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('fname') ?></th>
		<th scope="col"><?= h('lname') ?></th>
		<th scope="col"><?= h('email') ?></th>
		<th scope="col"><?= h('phone_no') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($contractorContacts as $contractorContact): ?>
	<tr>
		<td><?= $this->Number->format($contractorContact->id) ?></td>
		<td><?= h($contractorContact->fname) ?></td>
		<td><?= h($contractorContact->lname) ?></td>
		<td><?= h($contractorContact->email) ?></td>
		<td><?= h($contractorContact->phone_no) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $contractorContact->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $contractorContact->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if (in_array($activeUser['role_id'], $users)) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $contractorContact->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $contractorContact->id)]) ?>
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
