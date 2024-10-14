<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerRepresentative[]|\Cake\Collection\CollectionInterface $customerRepresentative
 */
?>
<!--<div class="row customerRepresentative">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Default Customer Representative') ?></strong>	
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create(null) ?>	
	<div class="row form-group">
		<label class="col-sm-3">Select Default CR : </label>
		<div class="col-sm-4"><?= $this->Form->control('id', ['options'=>$cr,'empty'=>false,'class'=>'form-control', 'label'=>false, 'required'=>true, 'value'=>$defaultCr]) ?></div>
		<div class="col-sm-3"><?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?></div>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>-->

<div class="row customerRepresentative">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Customer Representative') ?></strong>
		<span class="pull-right">
        <!--<?= $this->Html->link(__('Assign'), ['controller' => 'CustomerRepresentative', 'action' => 'select_rep'],['class'=>'btn btn-success btn-sm']) ?>-->
        <?= $this->Html->link(__('Add New'), ['controller' => 'CustomerRepresentative', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Pri_contact_fn') ?></th>
		<th scope="col"><?= h('Pri_contact_ln') ?></th>
		<th scope="col"><?= h('Created') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($customerRepresentative as $customerRepresentative): ?>
	<tr>
		<td><?= $customerRepresentative->has('user') ? h($customerRepresentative->user->username) : '' ?></td>
		<td><?= $customerRepresentative->user->active ? __('Yes') : __('No'); ?></td>
		<td><?= h($customerRepresentative->pri_contact_fn) ?></td>
		<td><?= h($customerRepresentative->pri_contact_ln) ?></td>
		<td><?= h($customerRepresentative->created) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $customerRepresentative->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $customerRepresentative->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $customerRepresentative->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $customerRepresentative->id)]) ?>
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
