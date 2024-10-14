<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document[]|\Cake\Collection\CollectionInterface $documents
 */
?>
<div class="row documents">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Documents') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Documents', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('name') ?></th>
		<th scope="col"><?= h('document') ?></th>		
		<th scope="col"><?= h('doc_version') ?></th>
		<th scope="col"><?= h('Parent document') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($documents as $document): ?>
            <tr>
                <td><?= $this->Number->format($document->id) ?></td>
                <td><?= h($document->name) ?></td>
				<td><?= h($document->document) ?></td>                
                <td><?= $this->Number->format($document->doc_version) ?></td>
                <td><?= $this->Number->format($document->document_id) ?></td>
				<td class="actions">
				<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $document->id],['escape'=>false, 'title' => 'View']) ?>
				<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $document->id],['escape'=>false, 'title' => 'Edit']) ?>
				<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
				<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $document->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?>
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
