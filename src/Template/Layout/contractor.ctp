<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	 Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link		  https://cakephp.org CakePHP(tm) Project
 * @since		 0.10.0
 * @license	   https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');

$cakeDescription = 'CanQualify, a solution for managing supply chain';
//$this->assign('title', $title);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>	  <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>		 <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>		 <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
	<?= $this->Html->charset() ?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?= $cakeDescription ?>:
		<?= $this->fetch('title') ?>
	</title>
	<?= $this->Html->meta('icon', '/img/icon.png', ['type'=>'image/png']) ?>

	<?= $this->Html->css('/vendors/bootstrap/dist/css/bootstrap.min.css') ?>
	<?= $this->Html->css('/vendors/bootstrap/dist/css/bootstrap-toggle.min.css') ?>
	<?= $this->Html->css('/vendors/font-awesome/css/font-awesome.min.css') ?>
	<?= $this->Html->css('/vendors/themify-icons/css/themify-icons.css') ?>
	<?= $this->Html->css('/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>
	<?= $this->Html->css('/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>
	<?= $this->Html->css('/vendors/jquery-ui-1.12.1/jquery-ui.min.css') ?>

	<?= $this->Html->css('/assets/css/style.css?v='.css_version) ?>
	<?= $this->Html->css('/assets/css/summernote-bs4.css') ?>
	<?= $this->Html->css('/assets/videojs/dist/video-js.min.css') ?>
    <?= $this->Html->css('/assets/videojs/dist/videojs-resume.min.css') ?>
	<?= $this->Html->css('custom.css?v='.css_version) ?>
	<?= $this->Html->css('tagsinput.css') ?>
	<?= $this->Html->css('jquery.multiselect.css') ?>
	<?= $this->Html->css('jquery.multiselect.filter.css') ?>
	<?= $this->Html->css('prettify.css') ?>
	<?= $this->Html->css('select2.min.css') ?>
	<?= $this->Html->css('jquery-ui-timepicker-addon.css') ?>

	<!--<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
		<?= $this->Html->script('https://maps.google.com/maps/api/js?key=AIzaSyDHlu1gUt6dbjHthfZpnE6YxynlrPwN2EY&sensor=true&libraries=places'); ?>
	-->

	<?= $this->Html->script('/vendors/jquery/dist/jquery.min.js') ?>
	<?= $this->Html->script('/vendors/charts/loader.js') ?>


	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>
<body>
<!-- Left Panel -->
<aside id="left-panel" class="left-panel no-print">
<nav class="navbar navbar-expand-sm navbar-default">
	<div class="navbar-header">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fa fa-bars"></i>
		</button>
		<?= $this->Html->image('logo.png', ['url'=>['controller'=>'Contractors', 'action'=>'dashboard'], 'class'=>'navbar-brand', 'alt'=>'CanQualify', 'width'=>'200px'])?>
		<?= $this->Html->image('icon.png', ['url'=>['controller'=>'Contractors', 'action'=>'dashboard'], 'class'=>'navbar-brand hidden', 'alt'=>'CanQualify'])?>
		<?php
		if(isset($activeUser['company_logo']) && $activeUser['company_logo']!=='') {
		    echo '<div class="company_logo">'.$this->Html->image($uploaded_path.$activeUser['company_logo'], ['class'=>'']).'</div>';
		}elseif(isset($activeUser['company_name']) && $activeUser['company_name']!==''){?>
			<h5 class="company_name" title="<?= $activeUser['company_name'];?> "><?=$activeUser['company_name'] ?></h5><h3 class="menu-title"></h3>
		<?php }
		if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ) {
		?>
		<h5 class="environment_name"><?= $_SERVER['ENVIRONMENT'] == 'development' ? 'Demo' : $_SERVER['ENVIRONMENT'] ?> site</h5><hr />
		<?php } ?>
	</div>

	<?php
	if(isset($activeUser['registration_status']) && in_array($activeUser['registration_status'],array(2,3)) && $activeUser['active']==true) { ?>
	<div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li><?= $this->Html->link(__('<i class="menu-icon fa fa-dashboard"></i> Dashboard'), ['controller'=>'Contractors', 'action'=>'dashboard'], ['escape'=>false, 'title'=>'dashboard']) ?></li>
            <!--<li><?= $this->Html->link(__('<i class="menu-icon fa fa-file"></i> Skill Assessment Documents'), ['controller'=>'SkillAssessments', 'action'=>'add'], ['escape'=>false, 'title'=>'Skill Assessment Documents ']) ?></li>-->
              <?php $clients = $this->User->getClients($activeUser['contractor_id']);
                  $visited_client = $this->Category->SiteVisit($clients);
                  $visit =false;
                 foreach ($clients as $key => $value) {
                   if(in_array($value, $visited_client)){$visit = true; }}
      		if($visit){ ?>
            <li><?= $this->Html->link(__('<i class="menu-icon fa fa-exchange
"></i> Add Visits'), ['controller'=>'SiteVisits', 'action'=>'index'], ['escape'=>false, 'title'=>'Add Visits']) ?></li>
	<?php }
	echo $this->element('Layout_Nav/contractor_left_nav');	

	/*if (isset($service_id) && $service_id != null) {
	if($service_id==6) { ?>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-file-text-o"></i> OSHA Safety Rates'), ['controller'=>'ContractorAnswers', 'action'=>'safety_report', $service_id], ['escape'=>false, 'title'=>'OSHA Safety Rates', 'class'=>'highlight']) ?></li>
	<?php
	}
	
	if($service_id == 4) { ?>
	<h3 class="menu-title">EmployeeQUAL</h3>

	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-user"></i> Employees'), ['controller'=>'Employees', 'action'=>'index', $service_id], ['escape'=>false, 'title'=>'Employee']) ?></li>
	</li>
	<?php
	} // if $service_id==4
	else {
		echo $this->element('categories');
		echo $this->element('archived_categories');
	}
    } // if service_id

    if(isset($employeeNav) && $employeeNav==true && isset($activeUser['employee_id'])) { ?>	
	
	<?php echo !empty($employee) ? '<li>'.$this->Html->link(__($employee->pri_contact_fn.' '.$employee->pri_contact_ln), ['controller'=>'employees', 'action'=>'dashboard', $activeUser['employee_id']], ['class'=>'btn btn-success']).'</li>' : '' ; ?>
	<?php $empExpCount = $this->Training->getEmpExplanationsCount($activeUser['employee_id']); ?>
	<li><?= $this->Html->link(__('Documents and Uploads (' . $empExpCount . ')'), ['controller'=>'EmployeeExplanations', 'action'=>'add'], ['escape'=>false, 'title'=>'Documents and Uploads']) ?></li> 
	<?php
	echo $this->element('trainings');	
	} // if employeeNav
	*/
	?>
	</ul>
	</div><!-- #main-menu -->
	<?php } ?>
</nav>
</aside><!-- /#left-panel -->
<!-- Left Panel -->

<div id="right-panel" class="right-panel">
	<!-- Header-->
	<header id="header" class="header no-print">
        <?php
        if(isset($_SERVER['MAINTENANCE']) && $_SERVER['MAINTENANCE'] == 1){
            ?>
            <div style="width:100%;background: #C2C2C2;line-height: 25px;text-align: center;margin-bottom: 25px"><i class="fa fa-wrench"></i>  We are under maintenance. Thank you for your patience.</div>
            <?php
        }
        ?>
	<div class="header-menu">
	<div class="col-sm-8 header-left">
		<a id="menuToggle" class="menutoggle pull-left"><i class="fa fa-chevron-left"></i></a>
		Welcome <?= $activeUser['username'] ?> (Logged in as Contractor)
	</div>
	<div class="col-sm-4 header-right text-right pull-right">
	    <?php 		   
		if(isset($activeUser['lastlogin'])){?>	
        <?php if($activeUser['lastlogin']['role_id'] == CR){ ?> 	
		<?= $this->Html->link('Back to CR', ['controller'=>'Users','action'=>'backtoAdmin'], ['escape'=>false, 'title'=>__('Back to Admin'), 'class'=>'btn btn-secondary']) ?>
		<?php } else{ ?>        			
		<?= $this->Html->link('Back to Admin', ['controller'=>'Users','action'=>'backtoAdmin'], ['escape'=>false, 'title'=>__('Back to Admin'), 'class'=>'btn btn-secondary']) ?>
		<?php }} ?>
		<?php 
		if($activeUser['role_id'] == CONTRACTOR && $activeUser['active'] ==true){ 
		echo $this->element('notification'); }  ?>
		
		<!--<div class="dropdown for-message">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="ti-email"></i><span class="count bg-primary">0</span></button>
		</div>-->
	<div class="user-area dropdown float-right">
		<?php $profile_photo = $activeUser['profile_photo'] != null ? $uploaded_path.$activeUser['profile_photo'] : 'user-icon.jpeg'; ?>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<?= $this->Html->image($profile_photo, ['alt'=>'User Profile','class'=>'user-avatar rounded-circle'])?>
		</a>
		<div class="user-menu dropdown-menu">
			<?php if($activeUser['role_id']==CONTRACTOR && $activeUser['active']==false && !isset($activeUser['lastlogin'])){ ?>
			<?= $this->Html->link('<i class="fa fa-user"></i> Payment History', ['controller'=>'Payments','action'=>'paymentHistory'], ['escape'=>false, 'title'=>__('Payment History'), 'class'=>'nav-link']) ?>
			<?= $this->Html->link('<i class="fa fa-sign-out"></i> Logout', ['controller'=>'Users','action'=>'logout'], ['escape'=>false, 'title'=>__('Logout'), 'class'=>'nav-link']) ?>
			<?php } else { ?>
			<?php if($activeUser['role_id'] == CONTRACTOR_ADMIN ){ ?>
			<?= $this->Html->link('<i class="fa fa-user"></i> My Profile', ['controller'=>'ContractorUsers','action'=>'myProfile'], ['escape'=>false, 'title'=>__('My Profile'), 'class'=>'nav-link']) ?>
			<?php }else { ?>
			<?= $this->Html->link('<i class="fa fa-user"></i> My Profile', ['controller'=>'Contractors','action'=>'myProfile'], ['escape'=>false, 'title'=>__('My Profile'), 'class'=>'nav-link']) ?>
			<?php } ?>
			<?= $this->Html->link('<i class="fa fa-user"></i> Company Profile', ['controller'=>'Contractors','action'=>'profile'], ['escape'=>false, 'title'=>__('Company Profile'), 'class'=>'nav-link']) ?>
			<?= $this->Html->link('<i class="fa fa-user"></i> Users/Contacts', ['controller'=>'ContractorUsers','action'=>'index'], ['escape'=>false, 'title'=>__('Users'), 'class'=>'nav-link']) ?>
			<!--<?= $this->Html->link('<i class="fa fa-envelope"></i>  Contacts', ['controller'=>'ContractorContacts', 'action'=>'index'], ['escape'=>false, 'title'=>'Contacts', 'class'=>'nav-link']) ?>-->
			<?= $this->Html->link('<i class="fa fa-user"></i> Payment History', ['controller'=>'Payments','action'=>'paymentHistory'], ['escape'=>false, 'title'=>__('Payment History'), 'class'=>'nav-link']) ?>
            <!--<?= $this->Html->link('<i class="fa fa-user"></i> My Subscription', ['controller'=>'ContractorServices','action'=>'subscription'], ['escape'=>false, 'title'=>__('My Subscription'), 'class'=>'nav-link']) ?>-->
			<!--<?= $this->Html->link('<i class="fa fa-credit-card"></i> Manage Cards', ['controller'=>'billingDetails','action'=>'manageCards'], ['escape'=>false, 'title'=>__('Manage Cards'), 'class'=>'nav-link']) ?>-->
			<?= $this->Html->link(__('<i class="menu-icon fa fa-user-o"></i>  Manage Clients'), ['controller'=>'ContractorClients', 'action'=>'manageClients'], ['escape'=>false, 'title'=>'Manage Clients', 'class'=>'nav-link']) ?>
			<?= $this->Html->link(__('<i class="menu-icon fa fa-building-o"></i> Manage Locations'), ['controller'=>'ContractorSites', 'action'=>'manageSites'], ['escape'=>false, 'title'=>'Manage Locations', 'class'=>'nav-link']) ?>
			<?= $this->Html->link(__('<i class="menu-icon fa fa-exchange"></i> Client Requests'), ['controller'=>'ClientRequests', 'action'=>'index'], ['escape'=>false, 'title'=>'Client Requests', 'class'=>'nav-link']) ?>
            <?= $this->Html->link(__('<i class="menu-icon fa fa-pencil-square-o"></i> Explanations'), ['controller'=>'Explanations', 'action'=>'add', null], ['escape'=>false, 'title'=>'explanations', 'class'=>'nav-link']) ?> 
            <?= $this->Html->link(__('<i class="menu-icon fa fa-pencil-square-o"></i> Craft Certificates'), ['controller'=>'EmployeeExplanations', 'action'=>'exp_list', null], ['escape'=>false, 'title'=>'Craft Certificates', 'class'=>'nav-link']) ?>
            <?php if($activeUser['emp_req'] == true ){ ?>
            <?= $this->Html->link(__('<i class="menu-icon fa fa-search"></i> Search For Employees'), ['controller'=>'Contractors', 'action'=>'searchEmployee'], ['escape'=>false, 'title'=>'Search For Employees', 'class'=>'nav-link']) ?>
        	<?php }?>
			<?= $this->Html->link('<i class="fa fa-sign-out"></i> Logout', ['controller'=>'Users','action'=>'logout'], ['escape'=>false, 'title'=>__('Logout'), 'class'=>'nav-link']) ?>
			<?php } ?>
		</div>
	</div>
	</div>
	</header><!-- /header -->

	<?php if(isset($activeUser['registration_status']) && in_array($activeUser['registration_status'], array(2,3)) && $activeUser['active']==true ) { ?>
	<div class="contractorNav navbar-wraper mb-3 clearfix">
	<nav class="navbar navbar-expand-lg navbar-light bg-white">	 
	  <ul class="navbar-nav cat-nav">
		<?php		
		$services = $this->Category->getServices($activeUser['contractor_id']);
		$sites = $this->User->getContractorSites($activeUser['contractor_id']);
		$client = $this->User->getClients($activeUser['contractor_id']);

		foreach ($services as $service_id => $service_name) {
		$catNext = $service_id;

        $categories = $this->Category->getServiceCategories($activeUser, $service_id);
		if(!empty($categories)){	
			    $catNext = $this->Category->getNextcat($categories, 0, $service_id);
	    }
	   if(!empty($service_id) && $service_id == 4) {
			/*if(count($client) == 1 && in_array(3, $client)) { // if only associates to BAE
				if((count($sites) == 0) || (!in_array(7, $sites)) ){
					continue; // do not show employeeQual service
				}
			}*/
		?>
		    <li class="nav-item"><?= $this->Html->link(__($service_name), ['controller'=>'employees', 'action'=>'index/'.$service_id], ['class'=>'nav-link btn btn-secondary']) ?></li>
		<?php
		}
		else {
		?>
		    <li class="nav-item"><?= $this->Html->link(__($service_name), ['controller'=>'ContractorAnswers', 'action'=>'addAnswers/'.$catNext], ['class'=>'nav-link btn btn-secondary']) ?></li>
		<?php
		}
		}
		?>
	  </ul>
	  <ul class="text-right">
	  	<li class="nav-item"><?= $this->Html->link(__('Notes'), ['controller'=>'Notes', 'action'=>'contractorNotes'], ['class'=>'nav-link btn']) ?></li>
	  </ul>
	</nav>
	</div>
	<?php } ?>

	<div class="content mt-3">
        <div class="row">
            <div class="col-sm-12 alert-wrap">
                <?= $this->Flash->render() ?>
            </div>
        </div>
        <div class="animated">
            <?= $this->fetch('content') ?>
        </div>

    </div> <!-- .content -->

</div><!-- /#right-panel -->
<!-- Right Panel -->

<footer>
	<?= $this->Html->script('/vendors/popper.js/dist/umd/popper.min.js') ?>
	<?= $this->Html->script('/vendors/bootstrap/dist/js/bootstrap.min.js') ?>
	<?= $this->Html->script('/vendors/bootstrap/dist/js/bootstrap-toggle.min.js') ?>
	<?= $this->Html->script('/assets/js/main.js') ?>

	<?= $this->Html->script('/vendors/datatables.net/js/jquery.dataTables.min.js') ?>
	<?= $this->Html->script('/vendors/datatables.net/js/average().js') ?>

	<?= $this->Html->script('/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>
	<?= $this->Html->script('/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') ?>
	<?= $this->Html->script('/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') ?>
	<?= $this->Html->script('/vendors/datatables.net-buttons/js/buttons.html5.min.js') ?>
	<?= $this->Html->script('/vendors/datatables.net-buttons/js/buttons.print.min.js') ?>
	<?= $this->Html->script('/vendors/datatables.net-buttons/js/buttons.colVis.min.js') ?>
	<?= $this->Html->script('/vendors/datatables.net/js/jszip.min.js') ?>
	<?= $this->Html->script('/assets/js/init-scripts/data-table/datatables-init.js?v='.js_version) ?>
	<?= $this->Html->script('/assets/js/init-scripts/charts/chart-init.js?v='.js_version) ?>
	<?= $this->Html->script('/assets/js/summernote-bs4.js') ?>

	<?= $this->Html->script('/vendors/jquery-ui-1.12.1/jquery-ui.min.js') ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js">	
    <?= $this->Html->script('/js/jquery.multiselect.js') ?>
	<?= $this->Html->script('/js/select2.min.js') ?>
	<?= $this->Html->script('/js/tagsinput.js') ?>
	<?= $this->Html->script('/js/widget.min.js') ?>
    <?= $this->Html->script('/js/prettify.js') ?>
	<?= $this->Html->script('jquery.validate.js') ?>

	<script>var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;</script>
	<?= $this->Html->script('form_wizard.js?v='.js_version) ?>
	<?= $this->Html->script('/assets/videojs/dist/video.min.js') ?>
    <?= $this->Html->script('/assets/videojs/dist/store.min.js') ?>
    <?= $this->Html->script('/assets/videojs/dist/videojs-resume.min.js') ?>
	<?= $this->Html->script('custom.js?v='.js_version) ?>
	<?= $this->Html->script('google_map.js') ?>
</footer>
</body>
</html>