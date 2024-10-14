<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccountType $accountType
 */  
?>
<div class="row accountTypes">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($accountType->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($accountType->name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($accountType->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Html->link($accountType->created_by, ['controller' => 'Users', 'action' => 'view', $accountType->created_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Html->link($accountType->modified_by, ['controller' => 'Users', 'action' => 'view', $accountType->modified_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($accountType->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($accountType->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
