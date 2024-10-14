<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */
?>
<div class="row roles">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Employees') ?></strong>
		
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('ISd') ?></th>
		<th scope="col" style="width: 30%;"><?= h('Contractor Company Name') ?></th>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Username') ?></th>
		<th scope="col"><?= h('Employee Name') ?></th>	
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($employees as $emp):
	$contractor_company_name = '';
	if(!empty($emp->employee_contractors)){ 
	$contractor_company_name = $emp->employee_contractors[0]->contractor->company_name;	
		
	} ?>
	<tr>
		<td><?= $this->Number->format($emp->id) ?></td>
		<td style="width: 30%;"><?= $contractor_company_name; ?></td>
		<?php if($emp->user_entered_email==true) { ?>
		<td><?= empty($emp->user->username) ? "" :$emp->user->username; ?></td>
		<?php } else{ ?>
			<td></td>
		<?php }?>
		<td><?= $emp->user->login_username; ?></td>
		<td><?= $emp->pri_contact_fn.' '.$emp->pri_contact_ln; ?></td>
		
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $emp->id],['escape'=>false, 'title' => 'View']) ?>		
		<!-- <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $emp->id],['escape'=>false, 'title' => 'Edit']) ?>	 -->
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $emp->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete Employee # {0}?', $emp->id)]) ?>
		<?= $this->Html->link('Update Orientation Completion', ['action' => 'updateOrientationCompletion', $emp->id], ['escape'=>false, 'title' => 'Update Orientation Completion']) ?>

	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>	
</div>
</div>
</div>