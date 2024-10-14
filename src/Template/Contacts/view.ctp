<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
?>
<div class="row users contacts">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($contact->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($contact->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Fname') ?></th>
			<td><?= h($contact->fname) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Lname') ?></th>
			<td><?= h($contact->lname) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Email') ?></th>
			<td><?= h($contact->email) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Phone No') ?></th>
			<td><?= h($contact->phone_no) ?></td>
		</tr>
	</table>
</div>
