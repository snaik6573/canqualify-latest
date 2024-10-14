<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractor $contractor
 */
$users = array(SUPER_ADMIN, ADMIN);

?>
<div class="row employees">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Associated</strong>  Contractors
		<!-- <span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller'=>'EmployeeContractors', 'action'=>'add'],['class'=>'btn btn-success btn-sm']) ?> </span> -->
	</div>

	<div class="card-body card-block">
	<?php //if (!empty($contractor)): ?>
	<table id="bootstrap-data-table" class="table table-striped table-bordered">
	<thead>
	<tr>
		<!-- <th scope="col"><?= __('Contractor Name') ?></th> -->
		<th scope="col"><?= __('Contractor Company Name') ?></th>
	</tr>
	</thead>
	<tbody>
		<?php foreach ($employee['employee_contractors'] as $key => $value) { ?>
		<tr>
		<!-- <td><?= h($contractor->company_name) ?></td> -->
		<td><?= h($value->contractor['company_name']) ?></td>		
		<?php } ?>
	</tr>
	</tbody>
	</table>
	
	</div> 
</div>
</div>
</div>
