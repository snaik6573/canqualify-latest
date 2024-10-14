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
    <?= $this->Html->css('/vendors/font-awesome/css/font-awesome.min.css') ?>
    <?= $this->Html->css('/vendors/themify-icons/css/themify-icons.css') ?>
    <?= $this->Html->css('/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>
    <?= $this->Html->css('/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>
    <?= $this->Html->css('/vendors/jquery-ui-1.12.1/jquery-ui.min.css') ?>
    <?= $this->Html->css('/assets/css/style.css?v='.css_version) ?>
    <?= $this->Html->css('/assets/css/summernote-bs4.css') ?>
    <?= $this->Html->css('/assets/videojs/dist/video-js.min.css') ?>
    <?= $this->Html->css('/assets/videojs/dist/videojs-resume.min.css') ?>
    <?= $this->Html->css('/assets/quill/css/quill.bubble.css') ?>
    <?= $this->Html->css('/assets/quill/css/quill.snow.css') ?>
    <?= $this->Html->css('dataTables.checkboxes.css') ?>
    <?= $this->Html->css('/vendors/bootstrap/dist/css/bootstrap-toggle.min.css') ?>
    <?= $this->Html->css('custom.css?v='.css_version) ?>
    <?= $this->Html->css('tagsinput.css') ?>
    <?= $this->Html->css('multi-select.css') ?>
    <?= $this->Html->css('jquery.multiselect.css') ?>
    <?= $this->Html->css('jquery.multiselect.filter.css') ?>
    <?= $this->Html->css('prettify.css') ?>
    <?= $this->Html->css('select2.min.css') ?>
    <?= $this->Html->css('review.css') ?>
    <?= $this->Html->css('jquery-ui-timepicker-addon.css') ?>
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
                <?= $this->Html->image('logo.png', ['url'=>['controller'=>'CustomerRepresentative', 'action'=>'dashboard'], 'class'=>'navbar-brand', 'alt'=>'CanQualify', 'width'=>'200px'])?>
                <?= $this->Html->image('icon.png', ['url'=>['controller'=>'CustomerRepresentative', 'action'=>'dashboard'], 'class'=>'navbar-brand hidden', 'alt'=>'CanQualify'])?>
                <?php if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){?>
                <h5 style="margin-top:10px; display: inline-block;">
                    <?= $_SERVER['ENVIRONMENT'] == 'development' ? 'Demo' : $_SERVER['ENVIRONMENT'] ?> site</h5>
                <hr />
                <?php } ?>
            </div>
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <?= $this->Html->link(__('<i class="menu-icon fa fa-dashboard"></i> CR Dashboard'), ['controller'=>'CustomerRepresentative', 'action'=>'dashboard'], ['escape'=>false, 'title'=>'dashboard']) ?>
                    </li>
                    <?php if(isset($contractorNav) && $contractorNav==true && isset($activeUser['contractor_id'])) { 
		echo $this->element('Layout_Nav/contractor_left_nav');	
	} // if contractorNav
	else { ?>
                    <li>
                        <?= $this->Html->link(__('<i class="menu-icon fa fa-dashboard"></i>All Contractors'), ['controller'=>'Contractors', 'action'=>'index'], ['escape'=>false, 'title'=>'contractorList']) ?>
                    </li>
                    <li>
                        <?= $this->Html->link(__('<i class="menu-icon fa fa-dashboard"></i> Contractor List'), ['controller'=>'CustomerRepresentative', 'action'=>'contractorList'], ['escape'=>false, 'title'=>'contractorList']) ?>
                    </li>
                    <!--<li>
                        <?= $this->Html->link(__('<i class="menu-icon fa fa-pencil"></i> Notes'), ['controller'=>'Notes', 'action'=>'index'], ['escape'=>false, 'title'=>'Notes']) ?>
                    </li>
                    <li>
                        <?= $this->Html->link(__('<i class="menu-icon fa fa-pencil"></i> Completed Follow Ups'), ['controller'=>'Notes', 'action'=>'index',0,1], ['escape'=>false, 'title'=>'Completed Follow Ups']) ?>
                    </li> -->
                    <li>
                        <?= $this->Html->link(__('<i class="menu-icon fa fa-upload"></i> Leads'), ['controller'=>'Leads', 'action'=>'index'], ['escape'=>false, 'title'=>'Leads']) ?>
                    </li>
                    <li>
                        <?= $this->Html->link(__('<i class="menu-icon fa fa-dollar"></i> Payments'),['controller'=>'Payments', 'action'=>'index'], ['escape'=>false,'title'=>'Payments']) ?>
                    </li>
                    <!--<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-envelope"></i> Email Wizard</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li>
                                <?= $this->Html->link(__('Email Campaign'), ['controller'=>'EmailWizards', 'action'=>'index'], ['title'=>'Email Campaign']) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('Campaign Contact List'), ['controller'=>'campaignContactLists', 'action'=>'index'], ['title'=>'Campaign Contact List']) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('Email Template'), ['controller'=>'EmailWizards', 'action'=>'emailTemplateList'], ['title'=>'Email Template']) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('Email Signature'), ['controller'=>'EmailSignatures', 'action'=>'index'], ['title'=>'Email Signature']) ?>
                            </li>
                        </ul>
                    </li> -->
                    <?php } ?>
                    <li>
                        <?php if(isset($contractorNav) && $activeUser['role_id'] == CR && isset($activeUser['contractor_id']) ){ ?>
                        <?= $this->Html->link('<i class="menu-icon fa fa-sign-in"></i>  Login As', ['controller'=>'CustomerRepresentative','action'=>'loginAs'], ['escape'=>false, 'title'=>__('Login As')]) ?>
                        <?php } ?>
                    </li>

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
                    <li><?= $this->Html->link(__('Redundant Users'), ['controller'=>'Users', 'action'=>'redundantUsers'], ['title'=>'Account Types']) ?></li>
                </ul>
            </div><!-- #main-menu -->
        </nav>
    </aside>
    <!-- Left Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header no-print">
            <!--<div style="width:100%;background: #C2C2C2;line-height: 25px;text-align: center;margin-bottom: 25px"><i class="fa fa-wrench"></i>  We are under maintenance. Thank you for your patience.</div> -->
            <div class="col-sm-8 header-left">
                <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa-chevron-left"></i></a>
                Welcome
                <?= $activeUser['username'] ?> (Logged in as Customer Representative).
            </div>
            <div class="col-sm-4 header-right text-right pull-right">
                <?php 		
		if(isset($activeUser['lastlogin'])){?>
                <?= $this->Html->link('Back to Admin', ['controller'=>'Users','action'=>'backtoAdmin'], ['escape'=>false, 'title'=>__('Back to Admin'), 'class'=>'btn btn-secondary btn-sm']) ?>
                <?php } ?>
                <?= $this->Html->link('Login As', ['controller'=>'Users','action'=>'loginAs'], ['escape'=>false, 'title'=>__('Login As'), 'class'=>'btn btn-secondary btn-sm btn-login-as']) ?>

                <!-- 	<div class="dropdown for-notification">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                <span class="count bg-danger">0<?php //echo $this->Category->unreadNotes($contractor_id);?></span>
            </button>
	</div> -->
                <div class="user-area dropdown float-right">
                    <?php $profile_photo = $activeUser['profile_photo'] != null ? $uploaded_path.$activeUser['profile_photo'] : 'user-icon.jpeg'; ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $this->Html->image($profile_photo, ['alt'=>'User Avatar','class'=>'user-avatar rounded-circle'])?>
                    </a>
                    <div class="user-menu dropdown-menu">
                        <?= $this->Html->link('<i class="fa fa-user"></i> My Profile', ['controller'=>'CustomerRepresentative','action'=>'myProfile'], ['escape'=>false, 'title'=>__('My Profile'), 'class'=>'nav-link']) ?>
                        <?= $this->Html->link('<i class="fa fa-sign-out"></i> Logout', ['controller'=>'Users','action'=>'logout'], ['escape'=>false, 'title'=>__('Logout'), 'class'=>'nav-link']) ?>
                    </div>
                </div>
            </div>
        </header><!-- /header -->
        <?php echo $this->element('Layout_Nav/contractor_center_nav');?>
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
        <?= $this->Html->script('/vendors/datatables.net/js/dataTables.select.min.js') ?>
        <?= $this->Html->script('/assets/js/init-scripts/data-table/datatables-init.js?v='.js_version) ?>
        <?= $this->Html->script('/assets/js/init-scripts/charts/chart-init.js?v='.js_version) ?>
        <?= $this->Html->script('/assets/js/summernote-bs4.js') ?>
        <?= $this->Html->script('/vendors/jquery-ui-1.12.1/jquery-ui.min.js') ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js">
        </script>
        <?= $this->Html->script('widget.min.js') ?>
        <?= $this->Html->script('prettify.js') ?>
        <?= $this->Html->script('select2.min.js') ?>
        <?= $this->Html->script('tagsinput.js') ?>
        <?= $this->Html->script('jquery.validate.js') ?>
        <script>
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;

        </script>
        <?= $this->Html->script('form_wizard.js?v='.js_version) ?>
        <?= $this->Html->script('/assets/videojs/dist/video.min.js') ?>
        <?= $this->Html->script('/assets/videojs/dist/store.min.js') ?>
        <?= $this->Html->script('/assets/videojs/dist/videojs-resume.min.js') ?>
        <?= $this->Html->script('/assets/quill/js/placeholder-module.js') ?>
        <?= $this->Html->script('/assets/quill/js/quill.js') ?>
        <?= $this->Html->script('dataTables.checkboxes.min.js') ?>
        <?= $this->Html->script('/vendors/bootstrap/dist/js/bootstrap-toggle.min.js') ?>
        <?= $this->Html->script('custom.js?v='.js_version) ?>
        <?= $this->Html->script('google_map.js') ?>
        <?= $this->Html->script('jquery.creditCardValidator.js') ?>
        <?= $this->Html->script('review.js') ?>
    </footer>
</body>

</html>
