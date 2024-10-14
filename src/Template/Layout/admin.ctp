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

$cakeDescription = 'CanQualify, a solution for managing supply chain';
//$this->assign('title', $title);
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
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
	<?= $this->Html->css('clear-blue/iconly/bold.css') ?>
	<?= $this->Html->meta('icon', '/img/icon.png', ['type'=>'image/png']) ?>

    <?= $this->Html->css('clear-blue/perfect-scrollbar/perfect-scrollbar.css') ?>
    <?= $this->Html->css('clear-blue/bootstrap-icons/bootstrap-icons.css') ?>
	<?= $this->Html->css('/vendors/bootstrap/dist/css/bootstrap.min.css') ?>
	<?= $this->Html->css('/vendors/font-awesome/css/font-awesome.min.css') ?>
	<?= $this->Html->css('/vendors/themify-icons/css/themify-icons.css') ?>
	<?= $this->Html->css('/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>
	<?= $this->Html->css('/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>
	<?= $this->Html->css('/vendors/jquery-ui-1.12.1/jquery-ui.min.css') ?>
	<?= $this->Html->css('/assets/css/summernote-bs4.css') ?>
	<?= $this->Html->css('tagsinput.css') ?>
	<?= $this->Html->css('multi-select.css') ?>
	<?= $this->Html->css('jquery.multiselect.css') ?>
	<?= $this->Html->css('jquery.multiselect.filter.css') ?>
	<?= $this->Html->css('prettify.css') ?>
	<?= $this->Html->css('select2.min.css') ?>
	<?= $this->Html->css('review.css') ?>
	<?= $this->Html->css('jquery-ui-timepicker-addon.css') ?>
	<?= $this->Html->css('/assets/css/style.css?v='.css_version) ?>
	<?= $this->Html->css('/assets/videojs/dist/video-js.min.css') ?>
    <?= $this->Html->css('/assets/videojs/dist/videojs-resume.min.css') ?>
    <?= $this->Html->css('/assets/quill/css/quill.bubble.css') ?>
    <?= $this->Html->css('/assets/quill/css/quill.snow.css') ?>
  
    <?= $this->Html->css('/vendors/bootstrap/dist/css/bootstrap-toggle.min.css') ?>
	<?= $this->Html->css('custom.css?v='.css_version) ?>
	
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

	<?= $this->Html->script('/vendors/jquery/dist/jquery.min.js') ?>
	<?= $this->Html->script('/vendors/charts/loader.js') ?>
	<?= $this->Html->script('https://maps.google.com/maps/api/js?key=AIzaSyDHlu1gUt6dbjHthfZpnE6YxynlrPwN2EY&sensor=true&libraries=places'); ?>

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
		<?= $this->Html->image('logo.png', ['url'=>['controller'=>'Users', 'action'=>'dashboard'], 'class'=>'navbar-brand', 'alt'=>'CanQualify', 'width'=>'200px'])?>
		<?= $this->Html->image('icon.png', ['url'=>['controller'=>'Users', 'action'=>'dashboard'], 'class'=>'navbar-brand hidden', 'alt'=>'CanQualify'])?>
		<?php if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ) { ?>
		<h5 class="environment_name"><?= $_SERVER['ENVIRONMENT'] == 'development' ? 'Demo' : $_SERVER['ENVIRONMENT'] ?> site</h5><hr />
		<?php } ?>
	</div>

	<div id="main-menu" class="main-menu collapse navbar-collapse">
	<ul class="nav navbar-nav">
		<li><?= $this->Html->link(__('<i class="menu-icon fa fa-dashboard"></i> Admin Dashboard'), ['controller'=>'users', 'action'=>'dashboard'], ['escape'=>false, 'title'=>'dashboard']) ?></li>
	<?php 
	if(isset($clientNav) && $clientNav==true && isset($activeUser['client_id'])) { // Client links 
    ?>
	<h3 class="menu-title"></h3>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-location-arrow"></i>Locations'), ['controller'=>'Sites', 'action'=>'clientSites'], ['escape'=>false, 'title'=>'dashboard']) ?></li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-user"></i> Users'), ['controller'=>'ClientUsers', 'action'=>'index'], ['escape'=>false, 'title'=>'Users']) ?></li>
    <?php
		echo $this->element('Layout_Nav/client_left_nav');
	 }// if clientNav
	elseif(isset($contractorNav) && $contractorNav==true && isset($activeUser['contractor_id'])) { // Contractor links 
		echo $this->element('Layout_Nav/contractor_left_nav');	
		
		if(!empty($service_id) && !empty($contractor) && $contractor->data_submit) {
			echo '<h3 class="menu-title"></h3>';
		    echo $this->Form->create(null, ['url'=>['controller'=>'Contractors','action'=>'setRead',$contractor->id],'class'=>'saveAjax','data-responce'=>".alert-wrap"]);
		    if($contractor->data_read){
 			     echo '<li>'.$this->Form->control('data_read',['type'=>'checkbox','class'=>'ajaxClick ','lable'=>false,'title'=>'Data Read','checked']);
		    }else{
		    	 echo '<li>'.$this->Form->control('data_read',['type'=>'checkbox','class'=>'ajaxClick ','lable'=>false,'title'=>'Data Read']);
		    }
			echo $this->Form->end();
			echo '<li>'.$this->Html->link('Final Submit', ['controller' => 'OverallIcons', 'action' => 'setIcons',true], ['class'=>'btn btn-success btn-sm']).'</li>';
		}
	} // if contractorNav
	else { // admin links	
	?>
	<h3 class="menu-title">Clients</h3>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-users"></i> Clients'), ['controller'=>'ClientUsers', 'action'=>'clientList'], ['title'=>'ClientUsers','escape'=>false]) ?></li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-server"></i> Manage Client Services'), ['controller'=>'ClientServices', 'action'=>'add'], ['title'=>'Manage Client Services','escape'=>false]) ?> </li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-server"></i> Manage GC-Client'), ['controller'=>'Clients', 'action'=>'addClientsToGc'], ['title'=>'Manage GC-Client Association','escape'=>false]) ?> </li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-location-arrow"></i> Locations'), ['controller'=>'Sites', 'action'=>'index'], ['title'=>'Locations','escape'=>false]) ?> </li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-map-marker"></i> Regions'), ['controller'=>'Regions', 'action'=>'index'], ['title'=>'Regions','escape'=>false]) ?> </li>
    <li><?= $this->Html->link(__('<i class="menu-icon fa fa-external-link"></i> Landing Page Links'), ['controller'=>'ClientUsers', 'action'=>'landingpageLinks'], ['title'=>'Landing Page Links','escape'=>false]) ?></li>

	<h3 class="menu-title"></h3>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-check"></i> Benchmarks'), ['controller'=>'Benchmarks', 'action'=>'index'], ['title'=>__('Benchmarks'),'escape'=>false, 'class'=>'nav-link']) ?></li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-users"></i> Contractors'), ['controller'=>'Contractors', 'action'=>'index'], ['escape'=>false, 'title'=>'Contractors']) ?> </li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-address-book-o"></i> Contractors Contact List'), ['controller'=>'Contractors', 'action'=>'supplierList'], ['escape'=>false, 'title'=>'Contractors Contact List']) ?> </li>
	<li><?= $this->Html->link(__('<i class="menu-icon ti-user"></i> Customer REP'), ['controller'=>'CustomerRepresentative', 'action'=>'index'], ['escape'=>false, 'title'=>'Customer REP']) ?></li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-users"></i> Users'), ['controller'=>'Users', 'action'=>'index'], ['escape'=>false, 'title'=>'Users']) ?> </li>
	<li><?= $this->Html->link('<i class="menu-icon fa fa-unlock "></i> Reset Password', ['controller'=>'Users','action'=>'reset-password-users'], ['escape'=>false, 'title'=>__('Reset Password'), 'class'=>'nav-link']) ?></li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-list-ul"></i> Categories'), ['controller'=>'Categories', 'action'=>'index'], ['escape'=>false, 'title'=>'Categories']) ?></li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-question"></i> Questions'), ['controller'=>'Questions', 'action'=>'index'], ['escape'=>false, 'title'=>'Questions']) ?></li>
	<li>
		<?= $this->Html->link(__('<i class="menu-icon fa fa-upload"></i> Leads'), ['controller'=>'Leads', 'action'=>'index'], ['escape'=>false, 'title'=>'Leads']) ?>
	</li>
	<!--<li><?= $this->Html->link(__(' <i class="menu-icon fa fa-graduation-cap"></i> Trainings'), ['controller'=>'trainings', 'action'=>'index'], ['escape'=>false, 'title'=>'Employee Trainings']) ?></li>-->
	<li class="menu-item-has-children dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-graduation-cap"></i> Employees</a>
	<ul class="sub-menu children dropdown-menu">
        <li><?= $this->Html->link(__('Online Orientations'), ['controller'=>'trainings', 'action'=>'index'], ['title'=>'Employee Trainings']) ?></li>
		<li><?= $this->Html->link(__('Categories'), ['controller'=>'employeeCategories', 'action'=>'index'], ['title'=>'Employee Categories']) ?></li>
		<li><?= $this->Html->link(__('Category Questions'), ['controller'=>'employeeQuestions', 'action'=>'index'], ['title'=>'Employee Category Questions']) ?></li>
		<li><?= $this->Html->link(__('Manage Client Questions'), ['controller'=>'ClientEmployeeQuestions', 'action'=>'add'], ['title'=>'Manage Client Questions']) ?></li>				
	</ul>
	</li>	
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-pencil"></i> Completed Follow Ups'), ['controller'=>'Notes', 'action'=>'index',0,1], ['escape'=>false, 'title'=>'Completed Follow Ups']) ?></li>	
	<li class="menu-item-has-children dropdown">    
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-file-text"></i> Reports</a>
	<ul class="sub-menu children dropdown-menu">
		<li><?= $this->Html->link(__('Subscription Expired Suppliers'), ['controller'=>'Reports', 'action'=>'subscriptionsEndReport'], ['title'=>'Subscription Expired Suppliers']) ?></li>
		<li><?= $this->Html->link(__('Policy Expiration Report'), ['controller'=>'ContractorAnswers', 'action'=>'getPolicyExpDate'], ['title'=>'Policy Expiration Report']) ?></li>
		<li><?= $this->Html->link(__('Client Users With No Location/s'), ['controller'=>'Reports', 'action'=>'noLocationClientUsers'], ['title'=>'Users With No Location/s']) ?></li>
		<li><?= $this->Html->link(__('No TIN or Incorrect TIN'), ['controller'=>'Reports', 'action'=>'noTin'], ['title'=>'Suppliers With No TIN']) ?></li>
		<li><?= $this->Html->link(__('Final Submit Pending'), ['controller'=>'Reports', 'action'=>'finalSubmitPending', 10,0], ['title'=>'Suppliers With No TIN']) ?></li>
	</ul>
	</li>
    <li><?= $this->Html->link(__('<i class="menu-icon fa fa-dollar"></i> Payments'),['controller'=>'Payments', 'action'=>'index'], ['escape'=>false,'title'=>'Payments']) ?></li>
    <li><?= $this->Html->link(__('<i class="menu-icon fa fa-star"></i> Contractor Feedbacks/Reviews'),['controller'=>'ContractorFeedbacks', 'action'=>'index'], ['escape'=>false,'title'=>'Contractor Feedbacks']) ?></li> 
    <li><?= $this->Html->link(__('<i class="menu-icon fa fa-users"></i> All Employees '),['controller'=>'Employees', 'action'=>'employeeList'], ['escape'=>false,'title'=>'All Employees List']) ?></li> 
    <li class="menu-item-has-children dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-envelope"></i> Email Wizard</a>
	<ul class="sub-menu children dropdown-menu">
        <li><?= $this->Html->link(__('Email Campaign'), ['controller'=>'EmailWizards', 'action'=>'index'], ['title'=>'Email Campaign']) ?></li>
		<li><?= $this->Html->link(__('Campaign Contact List'), ['controller'=>'campaignContactLists', 'action'=>'index'], ['title'=>'Campaign Contact List']) ?></li>
		<li><?= $this->Html->link(__('Email Template'), ['controller'=>'EmailWizards', 'action'=>'emailTemplateList'], ['title'=>'Email Template']) ?></li>
		<li><?= $this->Html->link(__('Email Signature'), ['controller'=>'EmailSignatures', 'action'=>'index'], ['title'=>'Email Signature']) ?></li>				
	</ul>
	</li>

        <!-- manage users -->
        <li class="menu-item-has-children dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-envelope"></i> Manage Users</a>
            <ul class="sub-menu children dropdown-menu">
                <li><?= $this->Html->link(__('Redundant Users'), ['controller'=>'Users', 'action'=>'redundantUsers'], ['title'=>'Account Types']) ?></li>
            </ul>
        </li>
        <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
	<li class="menu-item-has-children dropdown">    
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-gears"></i> Masters</a>
	<ul class="sub-menu children dropdown-menu">
		<li><?= $this->Html->link(__('Account Types'), ['controller'=>'AccountTypes', 'action'=>'index'], ['title'=>'Account Types']) ?></li>
		<li><?= $this->Html->link(__('Roles'), ['controller'=>'Roles', 'action'=>'index'], ['title'=>'Account Types']) ?></li>
		<li><?= $this->Html->link(__('Services'), ['controller'=>'Services', 'action'=>'index'], ['title'=>'Services']) ?> </li>
		<li><?= $this->Html->link(__('Products'), ['controller'=>'Products', 'action'=>'index'], ['title'=>'Products']) ?> </li>
		<li><?= $this->Html->link(__('Question Types'), ['controller'=>'QuestionTypes', 'action'=>'index'], ['title'=>'Question Types']) ?></li>
		<li><?= $this->Html->link(__('Countries'), ['controller'=>'Countries', 'action'=>'index'], ['title'=>'Countries']) ?></li>
		<li><?= $this->Html->link(__('Years'), ['controller'=>'CanqYears', 'action'=>'index'], ['title'=>'Years']) ?></li>
		<li><?= $this->Html->link(__('NAICS Codes'), ['controller'=>'NaiscCodes', 'action'=>'index'], ['title'=>'NAICS Codes']) ?></li>
		<li><?= $this->Html->link(__('NAIC Codes'), ['controller'=>'NaicCodes', 'action'=>'index'], ['title'=>'NAIC Codes']) ?></li>
		<li><?= $this->Html->link(__('Diagnostics'), ['controller'=>'Users', 'action'=>'diagnostics'], ['title'=>'diagnostics']) ?></li>
        <li><?= $this->Html->link(__('Industry Averages'), ['controller'=>'IndustryAverages', 'action'=>'index'], ['title'=>'Industry Averages']) ?></li>
        <li><?= $this->Html->link(__('Document Types'), ['controller'=>'DocumentTypes', 'action'=>'index'], ['title'=>'Document Types']) ?></li>
        <!--<li><?= $this->Html->link(__('Payments'), ['controller'=>'Payments', 'action'=>'index'], ['title'=>'Payments']) ?></li>-->

	</ul>
	</li>
	<?php }} ?>
	</ul>
	</div><!-- /.navbar-collapse -->
</nav>
</aside>
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
		<?php if($activeUser['role_id'] == ADMIN) { ?>
		Welcome <?= $activeUser['username'] ?> (Logged in as Admin).		
		<?php } ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		Welcome <?= $activeUser['username'] ?> (Logged in as Super Admin).		
		<?php } ?>
	</div>
	<div class="col-sm-4 header-right text-right pull-right">
        <?php if($activeUser['role_id'] == ADMIN) { 
        if(isset($activeUser['lastlogin'])){?>
		<?= $this->Html->link('Back to Super Admin', ['controller'=>'Users','action'=>'backtoAdmin'], ['escape'=>false, 'title'=>__('Back to Super Admin'), 'class'=>'btn btn-secondary btn-sm']) ?>
		<?php } }?>
		<?= $this->Html->link('Login As', ['controller'=>'Users','action'=>'loginAs'], ['escape'=>false, 'title'=>__('Login As'), 'class'=>'btn btn-secondary btn-sm btn-login-as']) ?>		
	
		<?php echo $this->element('notification');  ?>
			
		<div class="user-area dropdown">
		<?php $profile_photo = $activeUser['profile_photo'] != null ? $uploaded_path.$activeUser['profile_photo'] : 'user-icon.jpeg'; ?>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">			
			<?= $this->Html->image($profile_photo, ['alt'=>'User Profile','class'=>'user-avatar rounded-circle'])?>
		</a>
		<div class="user-menu dropdown-menu">
		<?= $this->Html->link('<i class="fa fa-user"></i> My Profile', ['controller'=>'Users','action'=>'myProfile'], ['escape'=>false, 'title'=>__('My Profile'), 'class'=>'nav-link']) ?>
		<?= $this->Html->link('<i class="fa fa-cog"></i> Settings', ['controller'=>'Users','action'=>'settings'], ['escape'=>false, 'title'=>__('Settings'), 'class'=>'nav-link']) ?>
		
		<?= $this->Html->link('<i class="fa fa-sign-out"></i> Logout', ['controller'=>'Users','action'=>'logout'], ['escape'=>false, 'title'=>__('Logout'), 'class'=>'nav-link']) ?>		
		</div>
		</div>
	</div>
	</div>
	</header><!-- /header -->
	<!-- Header-->
	
	<!-- Client & contractor navigation -->	
	<?php
		echo $this->element('Layout_Nav/client_center_nav');
		echo $this->element('Layout_Nav/contractor_center_nav');
	?>

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

</div>
<!-- Right Panel -->
<footer>
	<?= $this->Html->script('/vendors/popper.js/dist/umd/popper.min.js') ?>
	<?= $this->Html->script('/assets/js/summernote-bs4.js') ?>
	<?= $this->Html->script('/vendors/jquery-ui-1.12.1/jquery-ui.min.js') ?>
	<?= $this->Html->script('/vendors/bootstrap/dist/js/bootstrap.min.js') ?>
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
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js">
	</script>
    <?= $this->Html->script('widget.min.js') ?>
    <?= $this->Html->script('prettify.js') ?>
	<?= $this->Html->script('select2.min.js') ?>
	<?= $this->Html->script('tagsinput.js') ?>
	<?= $this->Html->script('jquery.validate.js') ?>	
	<script>var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;</script>
	<?= $this->Html->script('form_wizard.js?v='.js_version) ?>
	<?= $this->Html->script('/assets/videojs/dist/video.min.js') ?>
    <?= $this->Html->script('/assets/videojs/dist/store.min.js') ?>
    <?= $this->Html->script('/assets/videojs/dist/videojs-resume.min.js') ?>
    <?= $this->Html->script('/assets/quill/js/placeholder-module.js') ?>
    <?= $this->Html->script('/assets/quill/js/quill.js') ?>
    
    <?= $this->Html->script('/vendors/bootstrap/dist/js/bootstrap-toggle.min.js') ?>
	<?= $this->Html->script('custom.js?v='.js_version) ?>
	<?= $this->Html->script('google_map.js') ?>
	<?= $this->Html->script('jquery.creditCardValidator.js') ?>
    <?= $this->Html->script('review.js') ?>

	<div class="modal fade" id="scrollmodal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Force Change Icon Status</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
		</div>
	</div>
	</div>
	</div>
</footer>
</body>
</html>


