<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Note $note
 */
?>
<div class="row notes">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($note->subject) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Subject') ?></th>
		<td><?= h($note->subject) ?></td>
	</tr>
	<tr>
	<th scope="row"><?= __('Contractor') ?></th>
		<td><?= $note->has('contractor') ? $note->contractor->company_name : '' ?></td>
	</tr>
    <!--<tr>
		<th scope="row"><?= __('show_to_contractor') ?></th>
		<td><?= $note->show_to_contractor ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('is_read') ?></th>
		<td><?= $note->is_read ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('follow_up') ?></th>
		<td><?= $note->follow_up ? __('True') : __('False'); ?></td>
	</tr> -->
	<?php if($note->follow_up) { ?>
    <tr>
		<th scope="row"><?= __('Follow Up Date') ?></th>
		<td><?= $note->feature_date ?></td>
	</tr>
	<?php } ?>
    <!--  <tr>
		<th scope="row"><?= __('show_to_client') ?></th>
		<td><?= $note->is_read ? __('Yes') : __('No'); ?></td>
	</tr> 
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $note->has('user') ? $this->User->getCreatedBy($note->user, $activeUser) : '' ?></td>		
	</tr>
	<<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Number->format($note->modified_by) ?></td>
	</tr> -->
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($note->created) ?></td>
	</tr>
    <!-- <tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($note->modified) ?></td>
	</tr> -->
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
	<?= html_entity_decode($note->notes)?>		
	</div>
</div>
</div>
</div>
