<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NaiscCode $naiscCode
 */
?>
<div class="row naiscCodes">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($naiscCode->title) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Title') ?></th>
			<td><?= h($naiscCode->title) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($naiscCode->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Naisc Code') ?></th>
			<td><?= $this->Number->format($naiscCode->naisc_code) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($naiscCode->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($naiscCode->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
