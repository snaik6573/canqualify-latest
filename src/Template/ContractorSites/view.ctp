<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorSite $contractorSite
 */
?>
<div class="row contractorSites">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($contractorSite->client->company_name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($contractorSite->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Client') ?></th>
			<td><?= $contractorSite->has('client') ? $contractorSite->client->company_name : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Site') ?></th>
			<td><?= $contractorSite->has('site') ? $contractorSite->site->name : '' ?></td>
		</tr>		
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($contractorSite->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($contractorSite->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
