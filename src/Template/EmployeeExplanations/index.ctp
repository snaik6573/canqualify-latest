<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeExplanation[]|\Cake\Collection\CollectionInterface $employeeExplanations
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row explanations">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Employee Training Certificates') ?></strong>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered" data-order="[[ 4, &quot;desc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('name') ?></th>
		<th scope="col"><?= h('document') ?></th>
		<th scope="col"><?= h('Training Date') ?></th>
		<th scope="col"><?= h('Expiration Date') ?></th>
		<th scope="col"><?= h('created') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($employeeExplanations as $employeeExplanation): ?>
		<tr>
		<?php if(empty($employeeExplanation->name)) { ?>
			<td><?= $documentTypes[$employeeExplanation->document_type_id]; ?></td>
		<?php }else{ ?>
			<td><?= h($employeeExplanation->name) ?></td>
		<?php } ?>
		<!-- <td><?= h($employeeExplanation->name) ?></td> -->
		<td><a href="<?php echo $uploaded_path.$employeeExplanation->document;?>" target="_Blank"><?= $employeeExplanation->document ?></a></td>
		<td><?= h($employeeExplanation->training_date) ?></td>
		<td><?= h($employeeExplanation->expiration_date) ?></td>
		<td><?= h($employeeExplanation->created) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
