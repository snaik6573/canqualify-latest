<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerrNote $customerrNote
 */
?>
<div class="row customerrNotes">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($customerrNote->subject) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Subject') ?></th>
		<td><?= h($customerrNote->subject) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Contractor') ?></th>
		<td><?= $customerrNote->has('contractor') ? $customerrNote->contractor->company_name : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('show_to_contractor') ?></th>
		<td><?= $customerrNote->show_to_contractor ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Follow Up') ?></th>
		<td><?= $customerrNote->follow_up ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Follow Up Date') ?></th>
		<td><?= h($customerrNote->feature_date) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Html->link($customerrNote->created_by, ['controller' => 'Users', 'action' => 'view', $customerrNote->created_by]) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($customerrNote->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($customerrNote->modified) ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= __('Notes') ?>
	</div>
	<div class="card-body card-block" style="padding:15px 15px 15px 25px;">
	<?= html_entity_decode($customerrNote->notes)?>		
	</div>
</div>
</div>
</div>
