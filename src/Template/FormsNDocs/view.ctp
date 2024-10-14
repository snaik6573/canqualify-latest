<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormsNDoc $formsNDoc
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row formsNDocs">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= h($formsNDoc->name) ?></strong>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Name') ?></th>
		<td><?= h($formsNDoc->name) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Client') ?></th>
		<td><?= $formsNDoc->has('client') ? $this->Html->link($formsNDoc->client->id, ['controller' => 'Clients', 'action' => 'view', $formsNDoc->client->id]) : '' ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Id') ?></th>
		<td><?= $this->Number->format($formsNDoc->id) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created By') ?></th>
		<td><?= $this->Number->format($formsNDoc->created_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified By') ?></th>
		<td><?= $this->Number->format($formsNDoc->modified_by) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($formsNDoc->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($formsNDoc->modified) ?></td>
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
		<?= $this->Text->autoParagraph(h($formsNDoc->document)); ?>
	</div>
</div>
</div>
</div>


<div class="row related">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Related Contractor Docs') ?></strong>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($formsNDoc->contractor_docs)): ?>
	<table class="bootstrap-data-table-export table table-striped table-bordered">
		<thead>
		<tr>
			<th scope="col"><?= __('Id') ?></th>
			<th scope="col"><?= __('Document') ?></th>
			<th scope="col"><?= __('Contractor') ?></th>
			<th scope="row"><?= __('Download') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($formsNDoc->contractor_docs as $doc): ?>
		<tr>
			<td><?= h($doc->id) ?></td>
			<td><a href="<?= $uploaded_path.$doc->document;?>" target="_Blank"><?= $doc->document ?></a></td>
			<td><?= $doc->has('contractor') ? $this->Html->link($doc->contractor->company_name, ['controller' => 'Contractors','action' => 'dashboard', $doc->contractor->id],['escape'=>false, 'title' => 'View']) : '' ?></td>
			<td class="text-center"><a href="<?= $uploaded_path.$doc->document ?>" target="_Blank"><i class="fa fa-download"></i></a></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	</div>
</div>
</div>
</div>
