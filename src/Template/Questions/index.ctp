<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question[]|\Cake\Collection\CollectionInterface $questions
 */
?>
<div class="row questions">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Questions') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Questions', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('Id') ?></th>
		<th scope="col"><?= h('Question') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Is Parent') ?></th>
		<th scope="col"><?= h('Service') ?></th>
		<th scope="col"><?= h('Category') ?></th>
		<th scope="col"><?= h('Client') ?></th>
		<th scope="col"><?= h('Order') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($questions as $question): ?>
	<tr>
		<td><?= $this->Number->format($question->id) ?></td>
		<td><?= htmlspecialchars_decode(h($question->question)) ?></td>
		<td><?= $question->active ? __('Yes') : __('No'); ?></td>
		<td><?= $question->is_parent ? __('Yes') : __('No'); ?></td>
		<td><?= $question->has('category') ? $this->Html->link($question->category->service->name, ['controller' => 'Services', 'action' => 'view', $question->category->service->id]) : '' ?></td>
		<td><?= $question->has('category') ? $this->Html->link($question->category->name, ['controller' => 'Categories', 'action' => 'view', $question->category->id]) : '' ?></td>
		<td><?= $question->has('client') ? $this->Html->link(__($question->client->company_name), ['controller' => 'Clients', 'action' => 'view', $question->client->id]) : '' ?></td>
		<td>
			<span style="display:none;"><?= $this->Number->format($question->ques_order) ?></span>
		<?= $this->Form->create($question, ['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>			
			<?php echo $this->Form->control('ques_order', ['required'=>false, 'label'=>false, 'class'=>'form-control ajaxChangeOrder', 'value'=>$question->ques_order]); ?>
			<?php echo $this->Form->control('id', ['required'=>false, 'label'=>false, 'type'=>'hidden','value'=>$question->id]); ?>
		<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $question->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $question->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $question->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $question->id)]) ?>
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
