<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerRepresentative $customerRepresentative
 */
?>
<div class="row customerRepresentative">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($customerRepresentative->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Id') ?></th>
		<td><?= $this->Number->format($customerRepresentative->id) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Username') ?></th>
		<td><?= $customerRepresentative->has('user') ? $customerRepresentative->user->username : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('First Name') ?></th>
		<td><?= h($customerRepresentative->pri_contact_fn) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Last Name') ?></th>
		<td><?= h($customerRepresentative->pri_contact_ln) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Phone No.') ?></th>
		<td><?= h($customerRepresentative->pri_contact_pn) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Html->link($customerRepresentative->user->created_by, ['controller' => 'Users', 'action' => 'view', $customerRepresentative->user->created_by]) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Html->link($customerRepresentative->user->modified_by, ['controller' => 'Users', 'action' => 'view', $customerRepresentative->user->modified_by]) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($customerRepresentative->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($customerRepresentative->modified) ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
</div>
