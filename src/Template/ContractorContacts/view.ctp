<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorContact $contractorContact
 */
?>
<div class="row contractorContacts">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($contractorContact->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Fname') ?></th>
		<td><?= h($contractorContact->fname) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Lname') ?></th>
		<td><?= h($contractorContact->lname) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Email') ?></th>
		<td><?= h($contractorContact->email) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Phone No') ?></th>
		<td><?= h($contractorContact->phone_no) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Contractor') ?></th>
		<td><?= $contractorContact->has('contractor') ? $this->Html->link($contractorContact->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $contractorContact->contractor->id]) : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Id') ?></th>
		<td><?= $this->Number->format($contractorContact->id) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Number->format($contractorContact->created_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Number->format($contractorContact->modified_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($contractorContact->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($contractorContact->modified) ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
</div>
