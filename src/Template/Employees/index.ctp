<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee[]|\Cake\Collection\CollectionInterface $employees
 */
$users = array(SUPER_ADMIN,ADMIN,CONTRACTOR,CONTRACTOR_ADMIN,CLIENT);
?>
<div class="row employees">
<div class="col-lg-12">
<div class="card">
	<div class="card-header clearfix">
		<strong class="card-title pull-left"><?= __('Employees') ?></strong>
		<span class="pull-right">
			<?php $empCount = 0;
			if(!empty($employees)){ $empCount = count($employees); }

			$available = ($employeesSlot - $empCount);  ?>
			<b>Available : </b> <?= $available ?>
            <?php // if($available <= 0){
            if(in_array($activeUser['role_id'], $users)) { ?>
			<?= $this->Html->link(__('Purchase Additional Employees'), ['controller'=>'ContractorSites', 'action'=>'addSlot'],['class'=>'btn btn-info btn-sm']) ?>
            <?php }
//} ?>
		</span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
		<?php if($available > 0 && in_array($activeUser['role_id'], $users)) { ?>
		<?= $this->Html->link(__('Add New Employee'), ['controller'=>'Employees', 'action'=>'add',$service_id],['class'=>'btn btn-success btn-sm']) ?>
		<?php } ?>
	<thead>
	<tr>
		<!-- <th scope="col"><?= h('Contractor') ?></th>-->
		<th scope="col"><?= h('Employee Name') ?></th>
		<th scope="col"><?= h('Position') ?></th>
        <th scope="col"><?= h('Username') ?></th>
		<th scope="col"><?= h('Phone') ?></th>
		<?php if($activeUser['role_id'] == SUPER_ADMIN || $this->User->isContractor()) { ?>
		<th scope="col"><?= h('Location') ?></th>
		<?php } ?>
		<!--<th scope="col"><?= h('ID') ?></th>-->
		<th scope="col"><?= h('Status') ?></th>
		<th scope="col"><?= h('Completion Date') ?></th>
		<!-- <th scope="col"><?= h('Hire Date') ?></th> -->
		<!--<th scope="col"><?= h('Waiting On') ?></th>-->
		<!-- <th scope="col"><?= h('Client Location') ?></th> -->
		<!--<th scope="col"><?= h('Orientation') ?></th>-->
		<th scope="col" class="noExport actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$waitingOn='';
	$status = '';
	if(!empty($employees)){
	foreach ($employees as $employee):
	//if(!empty($employee->employee_sites)) {

	$catNext = '';
	$status = '';
	$trainings = $this->Training->getTrainings($activeUser, $employee->id);
	$categories = $this->EmployeeCategory->getCategories(null,$employee->id);

	if(!empty($trainings) || !empty($categories)) { $status = 'Complete'; }

	if(!empty($trainings)) {
		foreach ($trainings as $training) {
            /*if(isset($training['id']) && $training['id'] == 22){
                continue;
            }*/
			$perc = $training['getPerc'];
			if($perc != '100%') {
				$status = 'Incomplete';
				break;
			}
		}
		$catNext = $this->Training->getNextcat($trainings,null,4);
	}
	if(!empty($categories) && $status != 'Incomplete') {
		foreach ($categories as $category) {
			$perc = $category['getPerc'];
			if($perc != '100%') {
				$status = 'Incomplete';
				break;
			}
		}
	}
	$completionDate = '';
	if($status == 'Complete'){
        $completionDate = $this->Training->getTrainingDate($employee->id);
        if(!empty($completionDate)){
            $completionDate = date('m-d-Y', strtotime($completionDate));
        }
    }
	//if($employee->registration_status == 0 ) { $waitingOn = 'Request Send';} else {$waitingOn = 'Associated';}
	?>
	<tr>
	<!--<td><?= $employee->has('contractor') ? $employee->contractor->company_name : '' ?></td>-->
	<td>
	<?= $catNext!= '' ? $this->Html->link(h($employee->pri_contact_fn. ' '.$employee->pri_contact_ln), ['controller'=>'Employees', 'action' => 'dashboard/'.$employee->id],['escape'=>false, 'title' => '']) : $this->Html->link(h($employee->pri_contact_fn. ' '.$employee->pri_contact_ln), ['controller'=>'Employees', 'action' => 'dashboard', $employee->id],['escape'=>false, 'title' => '']) ?></td>
	<td><?= $employee->emp_position ?></td>
	<td>
        <?=  ($employee['user_entered_email'] == true) ? $employee->user['username'] : ""?>
        <?=  ($employee['user_entered_email'] == false) ? $employee->user['login_username'] : ""?>
    </td>
	<td><?= $employee->pri_contact_pn ?></td>
	<?php if($activeUser['role_id'] == SUPER_ADMIN || $this->User->isContractor()) { ?>
	<td><?= $this->Html->link(__('Add Location'), ['controller'=>'EmployeeSites', 'action'=>'add/'.$employee->id],['class'=>'btn btn-success btn-sm']) ?></td>
	<?php } ?>
	<!--<td><?= $this->Html->link(__('Print'),['class'=>'btn btn-success btn-sm']) ?></td>-->
	<td><?= $status ?></td>
	<td><?= $completionDate ?></td>
	<!-- <td><?= $employee->created  ?></td> -->
	<!--<td><?= $waitingOn; ?></td>-->
	<!--<td>Visitor/Vendor</td>-->
	<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $employee->id],['escape'=>false, 'title' => 'View']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN || $this->User->isContractor() || $activeUser['role_id'] == CLIENT || $activeUser['role_id'] == ADMIN) { ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $employee->id,$service_id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php } ?>
		<?php if(in_array($activeUser['role_id'], $users) && $employee->user->active &&  $employee->user_entered_email){ ?>
		<?= $this->Html->link('<i class="ti-email"></i>', ['action' => 'resend_emails', $employee->id,$service_id],['escape'=>false, 'title' => 'Resend Email for Employee Regisrtation']) ?>
		<?php } ?>
		<?php /*if($activeUser['role_id'] == SUPER_ADMIN ) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $employee->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $employee->id)]) ?>
		<?php }*/ ?>
       <!--<?= $this->Form->button('Issue ID', ['class'=>'btn btn-success btn-sm']) ?>-->
	</td>
	</tr>
	<?php
	//}
	endforeach; } ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
