<?php
$users = array(SUPER_ADMIN,ADMIN,CONTRACTOR,CONTRACTOR_ADMIN,EMPLOYEE);

if($activeUser['role_id']!=EMPLOYEE) {
	echo !empty($employee) ? '<li>'.$this->Html->link(__($employee->pri_contact_fn.' '.$employee->pri_contact_ln), ['controller'=>'employees', 'action'=>'dashboard', $activeUser['employee_id']], ['class'=>'btn btn-success']).'</li>' : '' ;
}
else {
	echo '<li>'.$this->Html->link(__('<i class="menu-icon fa fa-dashboard"></i> Dashboard'), ['controller'=>'Employees', 'action'=>'dashboard'], ['escape'=>false, 'title'=>'dashboard']) .'</li>';
}

// get categories
echo $this->element('employee_categories');

// get trainings
echo $this->element('trainings');

// other links
?>
<h3 class="menu-title"></h3>
<?php
$empExpCount = $this->Training->getEmpExplanationsCount($activeUser['employee_id']);
if(in_array($activeUser['role_id'], $users)) { ?>
<li><?= $this->Html->link(__('Craft Certifications and/or Safety Training Records(' . $empExpCount . ')'), ['controller'=>'EmployeeExplanations', 'action'=>'add'], ['escape'=>false, 'title'=>'Craft Certifications']) ?>
    <?php echo '<a href="javascript:void();" data-toggle="popover" title="" data-content="If a license is required by law, upload license, i.e. plumbing, electrical, etc. If a license is not required by law, then upload OSHA 30 hr for supervisors and OSHA 10 hr for subordinates, or upload all relevant certificates and training documentation to validate competencies for the work being performed" style="margin-left: 15px;"><i class="fa fa-info-circle"></i></a>'; ?>
</li>
<?php } else { ?>
<li><?= $this->Html->link(__('Craft Certifications and/or Safety Training Records(' . $empExpCount . ')'), ['controller'=>'EmployeeExplanations', 'action'=>'index'], ['escape'=>false, 'title'=>'Craft Certifications']) ?>
    <?php echo '<a href="javascript:void();" data-toggle="popover" title="" data-content="If a license is required by law, upload license, i.e. plumbing, electrical, etc. If a license is not required by law, then upload OSHA 30 hr for supervisors and OSHA 10 hr for subordinates, or upload all relevant certificates and training documentation to validate competencies for the work being performed" style="margin-left: 15px;"><i class="fa fa-info-circle"></i></a>'; ?>
</li>
<?php }?>
