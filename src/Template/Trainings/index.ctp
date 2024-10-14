<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training[]|\Cake\Collection\CollectionInterface $trainings
 */
$users = array(SUPER_ADMIN,CLIENT,CLIENT_ADMIN);
?>
<div class="row trainings">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Online Orientations') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Trainings', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('Id') ?></th>
		<th scope="col"><?= h('Name') ?></th>
		<th scope="col"><?= h('Company Name') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Parent') ?></th>
		<!--<th scope="col"><?= h('Is Training') ?></th>-->
		<th scope="col"><?= h('Order') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($trainings as $training): ?>
	<tr>
		<td><?= $this->Number->format($training->id) ?></td>
		<td><?= h($training->name) ?></td>
		<td><?= h($training->client->company_name) ?></td>
		<td><?= $training->active ? __('Yes') : __('No'); ?></td>
		<!--<td><?= $training->is_parent ? __('Yes') : __('No'); ?></td>-->
		<td><?= $training->category_id !=0 ? $this->Html->link($training->category_id, ['action' => 'view', $training->category_id]) : '' ?></td>
		<!--<td><?= $training->is_training ? __('Yes') : __('No'); ?></td>-->
		<td>
			<?= $this->Form->create($training,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('category_order', ['required'=>false, 'label'=>false, 'class'=>'form-control ajaxChange','value'=>$training->category_order]); ?>
			<?php echo $this->Form->control('id', ['required'=>false, 'label'=>false, 'type'=>'hidden','value'=>$training->id]); ?>
			<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $training->id],['escape'=>false, 'title' => 'View']) ?>
		<?php if(in_array($activeUser['role_id'], $users)) { ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $training->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $training->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $training->id)]) ?>
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
