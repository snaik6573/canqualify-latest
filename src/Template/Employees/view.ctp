<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<div class="row employees">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($employee->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('First Name') ?></th>
			<td><?= h($employee->pri_contact_fn) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Last Name') ?></th>
			<td><?= h($employee->pri_contact_ln) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Phone No.') ?></th>
			<td><?= h($employee->pri_contact_pn) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Position') ?></th>
		    <td><?= h($employee->emp_position) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Address Same As Company') ?></th>
			<td><?= $employee->addr_sameas_company ? __('Yes') : __('No'); ?></td>
		</tr>
		<?php if(!$employee['addr_sameas_company']) { ?>
	    <tr>
			<th scope="row"><?= __('Addressline 1') ?></th>
			<td><?= h($employee->addressline_1) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Addressline 2') ?></th>
			<td><?= h($employee->addressline_2) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('City') ?></th>
			<td><?= h($employee->city) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('State') ?></th>
			<td><?= $employee->has('state') ? $employee->state->name : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Country') ?></th>
			<td><?= $employee->has('country') ? $employee->country->name : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Zip') ?></th>
			<td><?= h($employee->zip) ?></td>
		</tr>
		<?php }  ?>
		<tr>
			<th scope="row"><?= __('Is Login Enable') ?></th>
			<td><?= ($employee->is_login_enable) ? 'Yes' : 'No' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Emergency Contact Name') ?></th>
			<td><?= h($employee->emergency_contact_name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Emergency Contact Number') ?></th>
			<td><?= h($employee->emergency_contact_number) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Contractor') ?></th>
			<td><?php
                if(!empty($contractor)) {
                    echo $this->Html->link($contractor['company_name'], ['controller' => 'Contractors', 'action' => 'view', $contractor['id']]);
                    echo '<br />'.$this->Form->postLink(__('Delete Association'), ['controller' => 'EmployeeContractors','action' => 'delete', $employeeContractorId], ['confirm' => __('Are you sure you want to delete this association?'), 'class' => 'btn btn-danger']);
                }else{
                    if($activeUser['role_id'] == SUPER_ADMIN) {
                        echo $this->Form->create(null, ['url' => ['controller' => 'EmployeeContractors', 'action' => 'associateContractor']]);
                        echo $this->Form->select('contractor_id', $assignCon, ['class' => 'form-control', 'empty' => 'Select Contractor']);
                        echo $this->Form->control('employee_id', ['type' => 'hidden', 'value' => $employee->id]);
                        echo '<br />';
                        echo $this->Form->submit('Associate Contractor', array('class' => 'btn btn-success'));
                        echo $this->Form->end();
                    }
                }
                ?>
            </td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($employee->created) ?></td>
		</tr>
		<!--
		<tr>
			<th scope="row"><?= __('User') ?></th>
			<td><?= $employee->has('user') ? $this->Html->link($employee->user->id, ['controller' => 'Users', 'action' => 'view', $employee->user->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($employee->id) ?></td>
		</tr>
        <tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($employee->modified) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Number->format($employee->created_by) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Number->format($employee->modified_by) ?></td>
		</tr>-->
	</table>
	</div>
</div>
</div>

<div class="col-lg-6 ">
<div class="card trainings">	
	<div class="card-header">
		<?= __('Orientations') ?>
	</div>
	<div class="card-body card-block">
		<?php
        if(!empty($empTrainings)){
            foreach($empTrainings as $key => $site) {
                if(isset($site['trainings'])) {
                    echo $this->Text->autoParagraph(h($site['name']));
                    echo '<ul>';
                    foreach($site['trainings'] as $k => $training) {
                        echo '<li>'.$this->Text->autoParagraph(h($training)).'</li>';
                    }
                    echo '</ul>';
                }
            }
        }else{
            echo 'No trainings associated.';
        }
        ?>
	</div>
</div>

<div class="card sites">	
	<div class="card-header">
		<?= __('Locations') ?>
	</div>
	<div class="card-body card-block">
		<?php
        if(!empty($employee->employee_sites)){
            foreach($employee->employee_sites as $key => $site) {
                if($site->has('site')) {
                    echo $this->Text->autoParagraph(h($site->site->name));
                }
            }
        }else{
            echo 'No locations associated';
        }
        ?>
	</div>
</div>
</div>

</div>
