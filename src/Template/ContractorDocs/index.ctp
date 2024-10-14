<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorDoc[]|\Cake\Collection\CollectionInterface $contractorDocs
 */
?>
<div class="row contractorDocs">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Contractor Docs') ?></strong>		
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('fndocs_id') ?></th>
		<th scope="col"><?= h('client_id') ?></th>
		<th scope="col"><?= h('contractor_id') ?></th>
		<th scope="col"><?= h('created') ?></th>
		<th scope="col"><?= h('modified') ?></th>
		<th scope="col"><?= h('created_by') ?></th>
		<th scope="col"><?= h('modified_by') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($contractorDocs as $contractorDoc): ?>
	<tr>
		<td><?= $this->Number->format($contractorDoc->id) ?></td>
		<td><?= $contractorDoc->has('forms_n_doc') ? $this->Html->link($contractorDoc->forms_n_doc->name, ['controller' => 'FormsNDocs', 'action' => 'view', $contractorDoc->forms_n_doc->id]) : '' ?></td>
		<td><?= $contractorDoc->has('client') ? $this->Html->link($contractorDoc->client->id, ['controller' => 'Clients', 'action' => 'view', $contractorDoc->client->id]) : '' ?></td>
		<td><?= $contractorDoc->has('contractor') ? $this->Html->link($contractorDoc->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $contractorDoc->contractor->id]) : '' ?></td>
		<td><?= h($contractorDoc->created) ?></td>
		<td><?= h($contractorDoc->modified) ?></td>
		<td><?= $this->Number->format($contractorDoc->created_by) ?></td>
		<td><?= $this->Number->format($contractorDoc->modified_by) ?></td>
		<td class="actions">
		    <?= $this->Html->link(__('View'), ['action' => 'view', $contractorDoc->id]) ?>
		    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contractorDoc->id]) ?>
			<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contractorDoc->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contractorDoc->id)]) ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
