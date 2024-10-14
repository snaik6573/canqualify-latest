<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 */
 //pr($question);
?>
<div class="row questions">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
	<?= h($question->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
	    <th scope="row"><?= __('Question Type') ?></th>
	    <td><?= $question->has('question_type') ? $this->Html->link($question->question_type->name, ['controller' => 'QuestionTypes', 'action' => 'view', $question->question_type->id]) : '' ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Category') ?></th>
	    <td><?= $question->has('category') ? $this->Html->link($question->category->name, ['controller' => 'Categories', 'action' => 'view', $question->category->id]) : '' ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Client') ?></th>
	    <td><?= $question->has('client') ? $this->Html->link(__($question->client->pri_contact_fn.' '.$question->client->pri_contact_ln), ['controller' => 'Clients', 'action' => 'view', $question->client->id]) : '' ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Id') ?></th>
	    <td><?= $this->Number->format($question->id) ?></td>
	</tr>
	<?php if(!empty($question->document)){ ?>
	<tr>
	    <th scope="row"><?= __('Document') ?></th>	    
		<td><?= h($question->document) ?></td>
	</tr>
	<?php } ?>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Html->link($question->created_by, ['controller' => 'Users', 'action' => 'view', $question->created_by]) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Html->link($question->modified_by, ['controller' => 'Users', 'action' => 'view', $question->modified_by]) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Created') ?></th>
	    <td><?= h($question->created) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Modified') ?></th>
	    <td><?= h($question->modified) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Active') ?></th>
	    <td><?= $question->active ? __('Yes') : __('No'); ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
	<?= __('Question') ?>
	</div>
	<div class="card-body card-block">
	<?= htmlspecialchars_decode(h($question->question)); ?>
	</div>

	<div class="card-header">
	<?= __('Question Options') ?>
	</div>
	<div class="card-body card-block">
	<?= htmlspecialchars_decode(h($question->question_options)); ?>
	</div>

	<div class="card-header">
	<?= __('Help') ?>
	</div>
	<div class="card-body card-block">
	<?= htmlspecialchars_decode(h($question->help)); ?>
	</div>
</div>
</div>
</div>

<div class="row related">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Sub Questions') ?>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($subQuestions)): ?>
	<table class="bootstrap-data-table-export table table-striped table-bordered">
	<thead>
	<tr>
    	<th scope="col"><?= h('Id') ?></th>
		<th scope="col"><?= h('Question') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Order') ?></th>
		<th scope="col"><?= h('Show On Option') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($subQuestions as $question): ?>
	<tr>
		<td><?= $this->Number->format($question->id) ?></td>
		<td><?= htmlspecialchars_decode(h($question->question)) ?></td>
		<td><?= $question->active ? __('Yes') : __('No'); ?></td>
		<td>
			<span style="display:none;"><?= $this->Number->format($question->ques_order) ?></span>
		    <?= $this->Form->create($question,['action'=>'index', 'class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>			
			    <?php echo $this->Form->control('ques_order', ['required'=>false, 'label'=>false, 'class'=>'form-control ajaxChange', 'value'=>$question->ques_order]); ?>
			    <?php echo $this->Form->control('id', ['required'=>false, 'label'=>false, 'type'=>'hidden','value'=>$question->id]); ?>
		    <?= $this->Form->end() ?>
		</td>
		<td><?= h($question->parent_option) ?></td>
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
	<?php endif; ?>
	</div>
</div>
</div>
</div>
