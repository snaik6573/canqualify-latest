<?php
$users = array(SUPER_ADMIN,ADMIN,CLIENT,CLIENT_ADMIN);
?>
<li class="sidebar-title">Menu</li>
<li class="sidebar-item <?= (!empty($currentPage) && $currentPage == 'Dashboard') ? 'active' :'' ?> ">
    <?= $this->Html->link(__('<i class="bi bi-grid-fill"></i><span>Dashboard</span>'), ['controller'=>'Clients', 'action'=>'dashboard'], ['escape'=>false, 'title'=>'Forms & docs', 'class'=>'sidebar-link']) ?>
</li>
<li class="sidebar-item  has-sub <?= (!empty($parentPage) && $parentPage == 'Suppliers') ? 'active' :'' ?>">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-people-fill"></i>
        <span>Suppliers</span>
    </a>
    <ul class="submenu <?= (!empty($parentPage) && $parentPage == 'Suppliers') ? 'active' :'' ?>">
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'My Suppliers') ? 'active' :'' ?>">
            <?= $this->Html->link(__('My Suppliers'), ['controller'=>'contractors', 'action'=>'contractorList'], ['title'=>'My Suppliers']) ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Search For Supplier') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Search For Supplier'), ['controller'=>'clients', 'action'=>'searchContractor'], ['title'=>'Search For Supplier']) ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Request New Supplier') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Request New Supplier'), ['controller'=>'Leads', 'action'=>'manuallyAdd'], ['title'=>'Request New Supplier']) ?>
        </li>
        <!--<li><?= $this->Html->link(__('Request New Supplier Registration Status'), ['controller'=>'ClientRequests', 'action'=>'display'], ['title'=>'Requests and Status']) ?></li>-->
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Supplier Registration Status') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Supplier Registration Status'), ['controller'=>'Leads', 'action'=>'pendingLeads'], ['escape'=>false,'title'=>'Pending Contractors']) ?>
        </li>
    </ul>
</li>
<li class="sidebar-item has-sub <?= (!empty($parentPage) && $parentPage == 'Reports') ? 'active' :'' ?>">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-bar-chart-fill"></i><span>Reports</span>
    </a>
    <ul class="submenu <?= (!empty($parentPage) && $parentPage == 'Reports') ? 'active' :'' ?>">
        <?php
        //if($activeUser['role_id'] != CLIENT_VIEW){
            ?>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Compliance') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Compliance'), ['controller'=>'clients', 'action'=>'complianceReport'], ['title'=>'Compliance']) ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Suppliers') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Suppliers'), ['controller'=>'clients', 'action'=>'supplierReport'], ['title'=>'Suppliers']) ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Icon Changes') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Icon Changes'), ['controller'=>'OverallIcons', 'action'=>'iconchange-report'], ['title'=>'Icon Changes']) ?></li> 
         <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Policy Expiration Report') ? 'active' :'' ?>">
            <?php $services = $this->User->getClientServices();
            if(in_array('InsureQual', $services)){ ?>
           <?= $this->Html->link(__('Policy Expiration Report'), ['controller'=>'ContractorAnswers', 'action'=>'getPolicyExpDate'], ['title'=>'Policy Expiration Report']) ?>
        <?php } ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Subscription Expired Suppliers') ? 'active' :'' ?>">
        <?= $this->Html->link(__('Subscription Expired Suppliers'), ['controller'=>'Contractors', 'action'=>'subscriptionsEndReport'], ['title'=>'Subscription Expired Suppliers']) ?>
        </li>
        <?php
        //}
        ?>
        <?php if($activeUser['client_id']==3) { ?>  
        <!-- <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Contractor Orientation Status') ? 'active' :'' ?>"><?= $this->Html->link(__('Contractor Orientation Status'), ['controller'=>'Clients', 'action'=>'employee_list'], ['title'=>'Contractor Orientation Status']) ?></li>-->
            <?php if($activeUser['id'] == 3) { $isEmail = true;?>
            <!-- <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Contractor Orientation Status') ? 'active' :'' ?>"><?= $this->Html->link(__('Send Email'), ['controller'=>'Clients', 'action'=>'employee_list/excel/'.$isEmail], ['title'=>'Contractor Orientation Status']) ?></li>-->
            <?php }?>
        <?php } ?>
        <?php if($activeUser['client_id']==3) { ?>
            <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Contractor Orientation Status') ? 'active' :'' ?>"><?= $this->Html->link(__('Contractor Orientation Status'), ['controller'=>'Clients', 'action'=>'aggregateOrientationReport'], ['title'=>'Contractor Orientation Status']) ?></li>
        <?php } ?>
        <?php
        if($activeUser['role_id'] != CLIENT_VIEW) {
            ?>
            <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Safety Rates') ? 'active' : '' ?>">
                <?= $this->Html->link(__('Safety Rates'), ['controller' => 'reports', 'action' => 'safetyRates'], ['title' => 'Suppliers']) ?>
            </li>
            <?php
        }
        ?>

        <?php
        /* fetch client reports */
        $reports = array();
        if(!empty($activeUser['client_id'])){
            $reports = $this->User->getClientReports($activeUser['client_id']);
            if(!empty($reports)){
                foreach ($reports as $report){
                    $report_title = (isset($report->report->title)) ? $report->report->title : '';
                    $report_controller = (isset($report->report->controller)) ? $report->report->controller : '';
                    $report_action = (isset($report->report->action)) ? $report->report->action : '';
                    $report_client_id = (isset($report->client_id)) ? $report->client_id : '';
                    ?>
                    <li class="submenu-item <?= (!empty($currentPage) && $currentPage == $report_title) ? 'active' : '' ?>">
                        <?= $this->Html->link(__($report_title), ['controller' => $report_controller, 'action' => $report_action, $report_client_id], ['title' => $report_title]) ?>
                    </li>
                    <?php
                }
            }
        }
        ?>
    </ul>
</li>
<?php
if($activeUser['role_id'] != CLIENT_VIEW) {
    ?>
    <li class="sidebar-item <?= (!empty($currentPage) && $currentPage == 'Documents') ? 'active' : '' ?>">
        <?= $this->Html->link(__('<i class="bi bi-cloud-arrow-up-fill"></i><span>Documents</span>'), ['controller' => 'forms-n-docs', 'action' => 'add'], ['escape' => false, 'title' => 'Forms & docs', 'class' => 'sidebar-link']) ?>
    </li>
    <?php
}
?>
<?php if(in_array($activeUser['role_id'], $users)) {
    $empEnable = $this->User->getEmpQualWithAdmin();
    if($empEnable['empqual_with_admin'] == true){ ?>
<li class="sidebar-item has-sub <?= (!empty($parentPage) && $parentPage == 'Employees') ? 'active' :'' ?>">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-person-plus-fill"></i>
        <span>Employees</span>
    </a>
    <ul class="submenu <?= (!empty($parentPage) && $parentPage == 'Employees') ? 'active' :'' ?>">
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Employee Trainings') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Online Orientations'), ['controller'=>'trainings', 'action'=>'index'], ['title'=>'Employee Trainings']) ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Employee Categories') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Categories'), ['controller'=>'employeeCategories', 'action'=>'index'], ['title'=>'Employee Categories']) ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Employee Category Questions') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Category Questions'), ['controller'=>'employeeQuestions', 'action'=>'index'], ['title'=>'Employee Category Questions']) ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Manage Client Questions') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Manage Client Questions'), ['controller'=>'ClientEmployeeQuestions', 'action'=>'add'], ['title'=>'Manage Client Questions']) ?>
        </li>
    </ul>
</li>
<?php } }?>
<?php $visited_client = $this->Category->SiteVisit($activeUser['client_id']);
if(!empty($activeUser['client_id']) && in_array($activeUser['client_id'], $visited_client)){ ?>
<?php  $client_id = $activeUser['client_id'];
    if(in_array($activeUser['role_id'], $users)) { ?>
<li class="sidebar-item ">
    <?= $this->Html->link(__('<i class="bi bi-calendar-event-fill"></i><span>Contractor Visits</span>'), ['controller'=>'SiteVisits', 'action'=>'sitevisit',$client_id], ['escape'=>false, 'title'=>'Contractor Visits','class'=>'sidebar-link']) ?>
</li>
<?php } } ?>
<!-- Navigation for List of Employess -->
<?php if(isset($employeeNav) && $employeeNav==true && isset($activeUser['employee_id'])) {
    echo $this->element('Layout_Nav/employee_left_nav');
} ?>
<!--<li class="menu-item-has-children dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-list-alt"></i> Reports</a>
    <ul class="sub-menu children dropdown-menu">
        <li><?= $this->Html->link(__('Safety Statistics'), ['controller'=>'OverallIcons', 'action'=>'safety_statistics_report'], ['title'=>'Safety Statistics']) ?></li>                
        <li><?= $this->Html->link(__('EMR,Citation,Fataliies'), ['controller'=>'OverallIcons', 'action'=>'emr_citation_fataliies_report'], ['title'=>'EMR,Citation,Fataliies']) ?></li>             
        <li><?= $this->Html->link(__('Icon Changes'), ['controller'=>'OverallIcons', 'action'=>'iconchange-report'], ['title'=>'Icon Changes']) ?></li> 
        <?php $services = $this->User->getClientServices();
            if(in_array('InsurQual', $services)){ ?>
        <li><?= $this->Html->link(__('Policy Expiration Report'), ['controller'=>'ContractorAnswers', 'action'=>'getPolicyExpDate'], ['title'=>'Policy Expiration Report']) ?></li>
        <?php } ?>
        <li><?= $this->Html->link(__('Subscription Expired Suppliers'), ['controller'=>'Contractors', 'action'=>'subscriptionsEndReport'], ['title'=>'Subscription Expired Suppliers']) ?></li> 
        <?php if($activeUser['client_id']==3) { ?>  
        <li><?= $this->Html->link(__('Contractor Orientation Status'), ['controller'=>'Clients', 'action'=>'employee_list'], ['title'=>'Contractor Orientation Status']) ?></li>    <?php if($activeUser['id'] == 3) { $isEmail = true;?>
             <li><?= $this->Html->link(__('Send Email'), ['controller'=>'Clients', 'action'=>'employee_list/excel/'.$isEmail], ['title'=>'Contractor Orientation Status']) ?></li>
            <?php }?>
        <?php } ?>                  
    </ul>
</li>-->
<!--<?php if(($activeUser['role_id'] == SUPER_ADMIN) || ($activeUser['role_id'] == ADMIN)) { ?>
<li><?= $this->Html->link(__('<i class="menu-icon fa fa-map-marker"></i> Add Location'), ['controller'=>'Clients', 'action'=>'add_location'], ['escape'=>false, 'title'=>'Add Location']) ?></li>
<?php } ?>-->
<!--<li><?= $this->Html->link(__('<i class="menu-icon fa fa-upload"></i> Upload Contractor List'), ['controller'=>'Leads', 'action'=>'add'], ['escape'=>false, 'title'=>'Upload Contractor']) ?></li>-->
<?php
if($activeUser['role_id'] != CLIENT_VIEW){
?>
    <li class="sidebar-item  has-sub <?= (!empty($parentPage) && $parentPage == 'Email Wizard') ? 'active' :'' ?>">
    <a href="#" class='sidebar-link'>
        <i class="fa fa-envelope"></i>
        <span>Email Wizard</span>
    </a>
    <ul class="submenu <?= (!empty($parentPage) && $parentPage == 'Email Wizard') ? 'active' :'' ?>">
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Email Campaign') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Email Campaign'), ['controller'=>'EmailWizards', 'action'=>'index'], ['title'=>'Email Campaign']) ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Campaign Contact List') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Campaign Contact List'), ['controller'=>'campaignContactLists', 'action'=>'index'], ['title'=>'Campaign Contact List']) ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Email Template') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Email Template'), ['controller'=>'EmailWizards', 'action'=>'emailTemplateList'], ['title'=>'Email Template']) ?>
        </li>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'Email Signature') ? 'active' :'' ?>">
            <?= $this->Html->link(__('Email Signature'), ['controller'=>'EmailSignatures', 'action'=>'index'], ['title'=>'Email Signature']) ?>
        </li>
    </ul>
</li>
<?php
}
?>
<li class="sidebar-item">
    <?php if(isset($activeUser['lastlogin'])){?>
    <?= $this->Html->link('<i class="bi bi-box-arrow-up-left"></i><span>Back to Admin</span>', ['controller'=>'Users','action'=>'backtoAdmin'], ['escape'=>false, 'title'=>__('Back to Admin'), 'class'=>'sidebar-link']) ?>
    <?php } ?>
</li>
