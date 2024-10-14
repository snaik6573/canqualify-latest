<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State $state
 */
?>
<div class="row states">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($state->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($state->name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Country') ?></th>
			<td><?= $state->has('country') ? $this->Html->link($state->country->name, ['controller' => 'Countries', 'action' => 'view', $state->country->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($state->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($state->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($state->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
