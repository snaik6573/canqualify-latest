<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorAnswer[]|\Cake\Collection\CollectionInterface $contractorAnswers
 */
$users = array(SUPER_ADMIN,CONTRACTOR);
?>
<div class="row contractorAnswers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Answers') ?></strong>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th scope="col"><?= h('id') ?></th>
			<th scope="col"><?= h('question') ?></th>
			<th scope="col"><?= h('year') ?></th>
			<th scope="col"><?= h('created') ?></th>
			<th scope="col"><?= h('modified') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($contractorAnswers as $contractorAnswer): ?>
		<tr>
			<td><?= $this->Number->format($contractorAnswer->id) ?></td>
			<td><?= $contractorAnswer->has('question') ? $contractorAnswer->question->question : '' ?></td>
			<td><?= h($contractorAnswer->year) ?></td>
			<td><?= h($contractorAnswer->created) ?></td>
			<td><?= h($contractorAnswer->modified) ?></td>
			<td class="actions">
				<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $contractorAnswer->id],['escape'=>false, 'title' => 'View']) ?>
			<?php if (in_array($activeUser['role_id'], $users)) { ?>
				<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $contractorAnswer->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $contractorAnswer->id)]) ?>
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
