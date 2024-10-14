<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorSite[]|\Cake\Collection\CollectionInterface $contractorSites
 */
$users = array(SUPER_ADMIN, CONTRACTOR,CONTRACTOR_ADMIN);
?>
<div class="row contractorSites">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Contractor Sites') ?></strong>
		<!--<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'ContractorSites', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>-->
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('contractor_id') ?></th>
		<th scope="col"><?= h('site_id') ?></th>
		<!--<th scope="col"><?= h('created') ?></th>
		<th scope="col"><?= h('modified') ?></th>
		<th scope="col"><?= h('created_by') ?></th>
		<th scope="col"><?= h('modified_by') ?></th>-->
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($contractorSites as $contractorSite): ?>
	<tr>
		<td><?= $this->Number->format($contractorSite->id) ?></td>
		<td><?= $contractorSite->has('contractor') ? $this->Html->link($contractorSite->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $contractorSite->contractor->id]) : '' ?></td>
		<td><?= $contractorSite->has('site') ? $this->Html->link($contractorSite->site->name, ['controller' => 'Sites', 'action' => 'view', $contractorSite->site->id]) : '' ?></td>
		<!--<td><?= h($contractorSite->created) ?></td>
		<td><?= h($contractorSite->modified) ?></td>
		<td><?= $this->Number->format($contractorSite->created_by) ?></td>
		<td><?= $this->Number->format($contractorSite->modified_by) ?></td>-->
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $contractorSite->id],['escape'=>false, 'title' => 'View']) ?>
		<!--<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $contractorSite->id],['escape'=>false, 'title' => 'Edit']) ?>-->
		<?php if (in_array($activeUser['role_id'], $users)) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $contractorSite->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $contractorSite->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
	<!--<div class="paginator">
	<ul class="pagination">
	<?= $this->Paginator->first('<< ' . __('first')) ?>
	<?= $this->Paginator->prev('< ' . __('previous')) ?>
	<?= $this->Paginator->numbers() ?>
	<?= $this->Paginator->next(__('next') . ' >') ?>
	<?= $this->Paginator->last(__('last') . ' >>') ?>
	</ul>
	<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
	</div>-->
</div>
</div>
</div>
