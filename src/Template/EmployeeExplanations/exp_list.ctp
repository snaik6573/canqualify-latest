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
		<th scope="col"><?= h('Employee Name') ?></th>
		<th scope="col"><?= h('Document Name') ?></th>
		<th scope="col"><?= h('Document') ?></th>
		<th scope="col"><?= h('Training Date') ?></th>
		<th scope="col"><?= h('Expiration Date') ?></th>
		<?php if($review ==null) { ?>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
		<?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($employeesContractors as $employeesContractor):		
		$employee = $employeesContractor['employee'];
		
		if(!empty($employee['employee_explanations'])) {
		foreach ($employee['employee_explanations'] as $employeeExplanation){
		?>
		<tr>
		<td><?= h($employee->pri_contact_fn .' '.$employee->pri_contact_ln) ?></td>	
		<?php if(empty($employeeExplanation->name)) { ?>
			<td><?= $documentTypes[$employeeExplanation->document_type_id]; ?></td>
		<?php }else{ ?>
			<td><?= h($employeeExplanation->name) ?></td>
		<?php } ?>	
		<!-- <td><?= h($employeeExplanation->name) ?></td> -->
		<td><a href="<?php echo $uploaded_path.$employeeExplanation->document;?>" target="_Blank"><?= $employeeExplanation->document ?></a></td>
		<td><?= h($employeeExplanation->training_date) ?></td>
		<td><?= h($employeeExplanation->expiration_date) ?></td>
		<?php if($review ==null) { ?>
		<td>
		<?= $this->Html->link(__('Add'), ['controller'=>'EmployeeExplanations','action' => 'add',$employee->id], ['class'=>'btn btn-success btn-sm']) ?></td>
		<?php } ?>
		</tr>
	<?php } }else{ ?>
		<tr>
		<td><?= h($employee->pri_contact_fn .' '.$employee->pri_contact_ln) ?></td>	
		<td> </td>
		<td></td>
		<td></td>
		<td></td>
		<?php if($review ==null) { ?>
		<td>
		<?= $this->Html->link(__('Add'), ['controller'=>'EmployeeExplanations','action' => 'add',$employee->id], ['class'=>'btn btn-success btn-sm']) ?></td>
		<?php } ?>
		</tr>
	<?php }	endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
