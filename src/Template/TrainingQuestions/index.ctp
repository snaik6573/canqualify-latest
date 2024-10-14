<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingQuestion[]|\Cake\Collection\CollectionInterface $trainingQuestions
 */
$users = array(SUPER_ADMIN,CLIENT,CLIENT_ADMIN);
?>
<div class="row trainingQuestions">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Training Questions') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'TrainingQuestions', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('Id') ?></th>
		<th scope="col"><?= h('Question') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Training Name') ?></th>
		<th scope="col"><?= h('Order') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($trainingQuestions as $trainingQuestion): ?>
	<tr>
		<td><?= $this->Number->format($trainingQuestion->id) ?></td>
		<td><?= h($trainingQuestion->question) ?></td>
		<td><?= $trainingQuestion->active ? __('Yes') : __('No'); ?></td>
		<td><?= $trainingQuestion->has('training') ? $this->Html->link($trainingQuestion->training->name, ['controller' => 'Trainings', 'action' => 'view', $trainingQuestion->training->id]) : '' ?></td>
		<td>
		<span style="display:none;"><?= $this->Number->format($trainingQuestion->ques_order) ?></span>
		<?= $this->Form->create($trainingQuestion,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>			
			<?php echo $this->Form->control('ques_order', ['required'=>false, 'label'=>false, 'class'=>'form-control ajaxChange', 'value'=>$trainingQuestion->ques_order]); ?>
			<?php echo $this->Form->control('id', ['required'=>false, 'label'=>false, 'type'=>'hidden','value'=>$trainingQuestion->id]); ?>
		<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $trainingQuestion->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $trainingQuestion->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if (in_array($activeUser['role_id'], $users)) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $trainingQuestion->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $trainingQuestion->id)]) ?>
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
