<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<div class="row roles">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($role->role_title) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Role Title') ?></th>
			<td><?= h($role->role_title) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($role->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Active') ?></th>
			<td><?= $role->active ? __('Yes') : __('No'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Description') ?></th>
			<td><?= h($role->description); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Html->link($role->created_by, ['controller' => 'Users', 'action' => 'view', $role->created_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Html->link($role->modified_by, ['controller' => 'Users', 'action' => 'view', $role->modified_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($role->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($role->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
