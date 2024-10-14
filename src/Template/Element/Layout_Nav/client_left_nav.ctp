<?php
$users = array(SUPER_ADMIN,ADMIN,CLIENT,CLIENT_ADMIN);
?>
<li class="menu-item-has-children dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i> Suppliers</a>
	<ul class="sub-menu children dropdown-menu">
		<li><?= $this->Html->link(__('My Suppliers'), ['controller'=>'Contractors', 'action'=>'contractorList'], ['title'=>'My Suppliers']) ?></li>
		<li><?= $this->Html->link(__('Search For Supplier'), ['controller'=>'clients', 'action'=>'searchContractor'], ['title'=>'Search For Supplier']) ?></li>
		<li><?= $this->Html->link(__('Request New Supplier'), ['controller'=>'Leads', 'action'=>'manuallyAdd'], ['title'=>'Request New Supplier']) ?></li>
		<!--<li><?= $this->Html->link(__('Request New Supplier Registration Status'), ['controller'=>'ClientRequests', 'action'=>'display'], ['title'=>'Requests and Status']) ?></li>-->
        <li><?= $this->Html->link(__('<span style="color:red; font-size: 80%;">Beta</span> Supplier Registration Status'), ['controller'=>'Leads', 'action'=>'pendingLeads'], ['escape'=>false,'title'=>'Pending Contractors']) ?></li>
	</ul>
</li>
<li><?= $this->Html->link(__('<i class="menu-icon fa fa-file-o"></i> Forms & docs'), ['controller'=>'forms-n-docs', 'action'=>'add'], ['escape'=>false, 'title'=>'Forms & docs']) ?></li>
<li class="menu-item-has-children dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-list-alt"></i> Reports</a>
	<ul class="sub-menu children dropdown-menu">
		<li><?= $this->Html->link(__('Safety Statistics'), ['controller'=>'OverallIcons', 'action'=>'safety_statistics_report'], ['title'=>'Safety Statistics']) ?></li>				
		<li><?= $this->Html->link(__('EMR,Citation,Fataliies'), ['controller'=>'OverallIcons', 'action'=>'emr_citation_fataliies_report'], ['title'=>'EMR,Citation,Fataliies']) ?></li>				
		<li><?= $this->Html->link(__('Icon Changes'), ['controller'=>'OverallIcons', 'action'=>'iconchange-report'], ['title'=>'Icon Changes']) ?></li>	
		<?php $clientServices = $this->User->getClientServices();
		foreach ($clientServices as $service) { 
		    if($service == 'InsureQual'){ ?>
		<li><?= $this->Html->link(__('Policy Expiration Report'), ['controller'=>'ContractorAnswers', 'action'=>'getPolicyExpDate'], ['title'=>'Policy Expiration Report']) ?></li>
		<?php } } ?>
		<li><?= $this->Html->link(__('Subscription Expired Suppliers'), ['controller'=>'Contractors', 'action'=>'subscriptionsEndReport'], ['title'=>'Subscription Expired Suppliers']) ?></li>	
		<?php if($activeUser['client_id']==3) { ?>	
		<li><?= $this->Html->link(__('Employees Orientation Status'), ['controller'=>'Clients', 'action'=>'employee_list'], ['title'=>'Employees Orientation Status']) ?></li>	  <?php if($activeUser['id'] == 3) { $isEmail = true;?>
			 <li><?= $this->Html->link(__('Send Email'), ['controller'=>'Clients', 'action'=>'employee_list/excel/'.$isEmail], ['title'=>'Employees Orientation Status']) ?></li>
			<?php }?>
		<?php } ?>					
	</ul>
</li>
<?php if(in_array($activeUser['role_id'], $users)) { 
	$empEnable = $this->User->getEmpQualWithAdmin();
	if($empEnable['empqual_with_admin'] == true){ ?>
	<li class="menu-item-has-children dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-graduation-cap"></i> Employees</a>
		<ul class="sub-menu children dropdown-menu">
			<li><?= $this->Html->link(__('Online Orientations'), ['controller'=>'trainings', 'action'=>'index'], ['title'=>'Employee Trainings']) ?></li>
			<li><?= $this->Html->link(__('Categories'), ['controller'=>'employeeCategories', 'action'=>'index'], ['title'=>'Employee Categories']) ?></li>
			<li><?= $this->Html->link(__('Category Questions'), ['controller'=>'employeeQuestions', 'action'=>'index'], ['title'=>'Employee Category Questions']) ?></li>
			<li><?= $this->Html->link(__('Manage Client Questions'), ['controller'=>'ClientEmployeeQuestions', 'action'=>'add'], ['title'=>'Manage Client Questions']) ?></li>			
		</ul>
	</li>
<?php } }?>
<?php $visited_client = $this->Category->SiteVisit($activeUser['client_id']);
if(!empty($activeUser['client_id']) && in_array($activeUser['client_id'], $visited_client)){ ?>
<?php $clients = [6,10]; $client_id = $activeUser['client_id'];
if(in_array($activeUser['role_id'], $users) || in_array($activeUser['role_id'], $clients )) { ?>
<li><?= $this->Html->link(__('<i class="menu-icon fa fa-exchange		
"></i> Contractor Visits'), ['controller'=>'SiteVisits', 'action'=>'sitevisit',$client_id], ['escape'=>false, 'title'=>'Contractor Visits']) ?></li>
<?php } } ?>
<!-- Navigation for List of Employess -->
<?php if(isset($employeeNav) && $employeeNav==true && isset($activeUser['employee_id'])) { 
		echo $this->element('Layout_Nav/employee_left_nav');
	} ?>
<!--<?php if(($activeUser['role_id'] == SUPER_ADMIN) || ($activeUser['role_id'] == ADMIN)) { ?>
<li><?= $this->Html->link(__('<i class="menu-icon fa fa-map-marker"></i> Add Location'), ['controller'=>'Clients', 'action'=>'add_location'], ['escape'=>false, 'title'=>'Add Location']) ?></li>
<?php } ?>-->
<!--<li><?= $this->Html->link(__('<i class="menu-icon fa fa-upload"></i> Upload Contractor List'), ['controller'=>'Leads', 'action'=>'add'], ['escape'=>false, 'title'=>'Upload Contractor']) ?></li>-->
