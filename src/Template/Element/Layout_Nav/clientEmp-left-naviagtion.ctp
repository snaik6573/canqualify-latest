<?php
$users = array(SUPER_ADMIN,ADMIN,CONTRACTOR,CONTRACTOR_ADMIN,EMPLOYEE);

if($activeUser['role_id']!=EMPLOYEE) {
	echo !empty($employee) ? '<li class="sidebar-item">'.$this->Html->link(__($employee->pri_contact_fn.' '.$employee->pri_contact_ln), ['controller'=>'employees', 'action'=>'dashboard', $activeUser['employee_id']], ['class'=>'btn btn-outline-success sidebar-link']).'</li><hr>' : '' ;
}
else {
	echo '<li class="sidebar-item">'.$this->Html->link(__('<i class="bi bi-grid-fill"></i> <span>Dashboard</span>'), ['controller'=>'Employees', 'action'=>'dashboard'], ['escape'=>false, 'title'=>'dashboard','class'=>'sidebar-link']) .'</li><hr>';
}

$empContractors = $this->User->getEmpContractors($activeUser['employee_id']);
 if(!empty($empContractors)){
// get categories
echo $this->element('employee-categories-client');

// get trainings
echo $this->element('trainings-client');

// other links
?>
<h3 class="sidebar-title"></h3>
<?php
$empExpCount = $this->Training->getEmpExplanationsCount($activeUser['employee_id']);
if(in_array($activeUser['role_id'], $users)) { ?>
<li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Craft Certifications') ? 'active' :'' ?>">
<?= $this->Html->link(__('Add Craft Certifications and/or Safety Training Records (' . $empExpCount . ')'), ['controller'=>'EmployeeExplanations', 'action'=>'add'], ['escape'=>false, 'title'=>'Add Craft Certifications and/or Safety Training Records','class'=>'sidebar-link']) ?><?php echo '<a href="javascript:void();" data-toggle="popover" title="" data-content="If a license is required by law, upload license, i.e. plumbing, electrical, etc. If a license is not required by law, then upload OSHA 30 hr for supervisors and OSHA 10 hr for subordinates, or upload all relevant certificates and training documentation to validate competencies for the work being performed" style="margin-left: 15px;"><i class="fa fa-info-circle"></i></a>'; ?></li>
<?php } else { ?>
<li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Craft Certifications') ? 'active' :'' ?>">
<?= $this->Html->link(__('Add Craft Certifications and/or Safety Training Records (' . $empExpCount . ')'), ['controller'=>'EmployeeExplanations', 'action'=>'index'], ['escape'=>false, 'title'=>'Add Craft Certifications and/or Safety Training Records','class'=>'sidebar-link']) ?><?php echo '<a href="javascript:void();" data-toggle="popover" title="" data-content="If a license is required by law, upload license, i.e. plumbing, electrical, etc. If a license is not required by law, then upload OSHA 30 hr for supervisors and OSHA 10 hr for subordinates, or upload all relevant certificates and training documentation to validate competencies for the work being performed" style="margin-left: 15px;"><i class="fa fa-info-circle"></i></a>'; ?></li>
<?php }}
// get Basic Categories
echo $this->element('basic-emp-categories-client');

?>
