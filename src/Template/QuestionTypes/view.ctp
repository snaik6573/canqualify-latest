<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QuestionType $questionType
 */
?>
<div class="row questionTypes">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($questionType->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($questionType->name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($questionType->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Html->link($questionType->created_by, ['controller' => 'Users', 'action' => 'view', $questionType->created_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Html->link($questionType->modified_by, ['controller' => 'Users', 'action' => 'view', $questionType->modified_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($questionType->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($questionType->modified) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Deleted On') ?></th>
			<td><?= h($questionType->deleted) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Deleted By') ?></th>
			<td><?= $this->Html->link($questionType->deleted_by, ['controller' => 'Users', 'action' => 'view', $questionType->deleted_by]) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
<?php /* ?>
<div class="row related">
<div class="col-lg-12">
<div class="related card">
	<div class="card-header">
		<?= __('Related Questions') ?>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($questionType->questions)): ?>
	<table class="table">
		<tr>
			<th scope="col"><?= __('Id') ?></th>
			<th scope="col"><?= __('Question') ?></th>
			<th scope="col"><?= __('Category Id') ?></th>
			<th scope="col"><?= __('Active') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		<?php foreach ($questionType->questions as $questions): ?>
		<tr>
			<td><?= h($questions->id) ?></td>
			<td><?= h($questions->question) ?></td>
			<td><?= $questions->has('category') ? h($questions->category->name) : h($questions->category_id) ?></td>
			<td><?= $questions->active ? __('Yes') : __('No'); ?></td>
			<td class="actions">
			<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'Questions', 'action' => 'view', $questions->id],['escape'=>false, 'title' => 'View']) ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'Questions', 'action' => 'edit', $questions->id],['escape'=>false, 'title' => 'Edit']) ?>
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'Questions', 'action' => 'delete', $questions->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $questions->id)]) ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
	</div>
</div>
</div>
</div>
<?php */ ?>
