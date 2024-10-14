<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */
use Cake\Core\Configure;
?>
<div class="row notes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Notes') ?></strong>		
	</div>
	<div class="card-body">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>		
		<th scope="col"><?= $this->Paginator->sort('Subject') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Uploaded Document') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Notes') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Created') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Modified by') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$uploaded_path = Configure::read('uploaded_path');
	foreach ($notes as $note): ?>
	<tr>
		<td></td>
		<td><a href="<?php echo $uploaded_path.$note->documents;?>" target="_Blank"><?= $note->documents ?></a></td>
		<td><?= $note->notes;?></td>
		<td><?= $note->created;?></td>
		<td><?= $note->modified_by;?></td>
	</tr>
	<?php endforeach;?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
