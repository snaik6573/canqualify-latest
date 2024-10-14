<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Explanation[]|\Cake\Collection\CollectionInterface $explanations
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row explanations">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Supplier Explanations') ?></strong>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('name') ?></th>
		<th scope="col"><?= h('document') ?></th>
		<th scope="col"><?= h('created') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($explanations as $explanation): ?>
		<tr>
		<td><?= h($explanation->name) ?></td>
		<td><a href="<?php echo $uploaded_path.$explanation->document;?>" target="_Blank"><?= $explanation->document ?></a></td>
		<td><?= h($explanation->created) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
