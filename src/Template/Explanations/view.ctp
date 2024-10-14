<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormsNDoc $explanation
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row formsNDocs">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= h($explanation->name) ?></strong>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Name') ?></th>
		<td><?= h($explanation->name) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Client') ?></th>
		<td><?= $explanation->has('client') ? $this->Html->link($explanation->client->id, ['controller' => 'Clients', 'action' => 'view', $explanation->client->id]) : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Id') ?></th>
		<td><?= $this->Number->format($explanation->id) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Number->format($explanation->created_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Number->format($explanation->modified_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($explanation->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($explanation->modified) ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Document') ?></strong>
	</div>
	<div class="card-body card-block">
		<?= $this->Text->autoParagraph(h($explanation->document)); ?>
	</div>
</div>
</div>
</div>