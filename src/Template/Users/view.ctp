<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row users">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($user->username) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Username') ?></th>
			<td><?= h($user->username) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Role') ?></th>
			<td><?= $user->has('role_id') ? $user->role->role_title : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Active') ?></th>
			<td><?= $user->active ? __('Yes') : __('No'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Number->format($user->created_by) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Number->format($user->modified_by) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($user->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($user->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
