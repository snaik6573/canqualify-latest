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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

	<?= $this->Html->css('/assets/css/style.css') ?>
	<?= $this->Html->css('/assets/css/summernote-bs4.css') ?>
	<?= $this->Html->css('custom.css?v='.css_version) ?>
	<?= $this->Html->css('tagsinput.css') ?>
	<?= $this->Html->css('multi-select.css') ?>
	<?= $this->Html->css('select2.min.css') ?>

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
<aside id="left-panel" class="left-panel">
<nav class="navbar navbar-expand-sm navbar-default">
	<div class="navbar-header">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fa fa-bars"></i>
		</button>
		<?= $this->Html->image('logo.png', ['url'=>['controller'=>'Users', 'action'=>'dashboard'], 'class'=>'navbar-brand', 'alt'=>'CanQualify', 'width'=>'200px'])?>
		<?= $this->Html->image('icon.png', ['url'=>['controller'=>'Users', 'action'=>'dashboard'], 'class'=>'navbar-brand hidden', 'alt'=>'CanQualify'])?>
		<?php if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){?>
			<h5 class="environment_name"><?= $_SERVER['ENVIRONMENT'] == 'development' ? 'Demo' : $_SERVER['ENVIRONMENT'] ?> site</h5><hr />
		<?php } ?>
	</div>

	<div id="main-menu" class="main-menu collapse navbar-collapse">
	<ul class="nav navbar-nav">
		<li><?= $this->Html->link(__('<i class="menu-icon fa fa-dashboard"></i> Admin Dashboard'), ['controller'=>'users', 'action'=>'dashboard'], ['escape'=>false, 'title'=>'dashboard']) ?></li>

	<?php if(isset($clientNav) && $clientNav==true && isset($activeUser['client_id'])) { // Client links ?>
	<h3 class="menu-title"></h3>

		<li><?= $this->Html->link(__('<i class="menu-icon fa fa-building-o"></i>Locations'), ['controller'=>'Sites', 'action'=>'clientSites'], ['escape'=>false, 'title'=>'dashboard']) ?></li>
		<li class="menu-item-has-children dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i> Contractors</a>
		<ul class="sub-menu children dropdown-menu">
			<li><?= $this->Html->link(__('Contractor List'), ['controller'=>'clients', 'action'=>'contractorList'], ['title'=>'Contractor List']) ?></li>
			<li><?= $this->Html->link(__('Search New Contractor'), ['controller'=>'clients', 'action'=>'searchContractor'], ['title'=>'Search New Contractor']) ?></li>			
		</ul>
		</li>
		<li><?= $this->Html->link(__('<i class="menu-icon fa fa-file-o"></i> Forms & docs'), ['controller'=>'forms-n-docs', 'action'=>'add'], ['escape'=>false, 'title'=>'Forms & docs']) ?></li>
		<li><?= $this->Html->link(__('<i class="menu-icon fa fa-user"></i> Users'), ['controller'=>'ClientUsers', 'action'=>'index'], ['escape'=>false, 'title'=>'Users']) ?></li>
		<li class="menu-item-has-children dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-list-alt"></i> Reports</a>
		<ul class="sub-menu children dropdown-menu">
			<li><?= $this->Html->link(__('Safety Statistics'), ['controller'=>'OverallIcons', 'action'=>'safety_statistics_report'], ['title'=>'Safety Statistics']) ?></li>				
			<li><?= $this->Html->link(__('EMR,Citation,Fataliies'), ['controller'=>'OverallIcons', 'action'=>'emr_citation_fataliies_report'], ['title'=>'EMR,Citation,Fataliies']) ?></li>				
			<li><?= $this->Html->link(__('Icon Changes'), ['controller'=>'OverallIcons', 'action'=>'iconchange-report'], ['title'=>'Icon Changes']) ?></li>				
		</ul>
		</li>
				
	<?php
	}
	elseif(isset($contractorNav) && $contractorNav==true && isset($activeUser['contractor_id'])) { // Contractor links
	?>

	<h3 class="menu-title"></h3>
		<li><?= $this->Html->link(__('<i class="menu-icon fa fa-building-o"></i> Manage Locations'), ['controller'=>'ContractorSites', 'action'=>'manageSites'], ['escape'=>false, 'title'=>'Manage Locations']) ?></li>
		<li><?= $this->Html->link(__('<i class="menu-icon fa fa-exchange"></i> Client Requests'), ['controller'=>'ClientRequests', 'action'=>'index'], ['escape'=>false, 'title'=>'Client Requests']) ?></li>


	<?php
	if(isset($service_id) && $service_id!=null) {
		if(!isset($year)) {$year=null;}
  		$categories = $this->Category->getCategories($activeUser['contractor_id'], $service_id, false, $category_id, $year);
	?>
	<h3 class="menu-title">Supplier</h3>

	<?php if($category_id==6 || $year!=null) { ?>
	<li><?= $this->Html->link(__('OSHA Safety Rates'), ['controller'=>'ContractorAnswers', 'action'=>'safety_report', $service_id, 6], ['escape'=>false, 'title'=>'OSHA Safety Rates', 'class'=>'highlight']) ?></li>
	<?php
	}

	//$final_submit = true;
	foreach($categories as $cat) {
	if(!empty($cat['childrens'])) { ?>
	<li>
		<a href="#"><?= $cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>' ?></a>
		<ul>
			<?php foreach ($cat['childrens'] as $key=>$value) { ?>			
			<li class="menu-item-has-children dropdown <?= $key ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $key . ' <b>(' . $value['getPerc'] . ')</b>' ?></a>
				<ul class="sub-menu children dropdown-menu">
				<?php foreach ($value['cat'] as $childcats) { ?>
					<li><?= $this->Html->link(__($childcats['name'] . ' <b>(' . $childcats['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories']) ?></li>
				<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>
	</li>
	<?php
	} else {
	if(!empty($cat['child'])) { ?>
	<li class="menu-item-has-children dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>' ?></a>
		<ul class="sub-menu children dropdown-menu">
			<?php foreach ($cat['child'] as $key=>$value) { ?>
			<li><?= $this->Html->link(__($value['name'] . ' <b>(' . $value['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $value['id']], ['escape'=>false, 'title'=>'categories']) ?></li>
			</li>
			<?php } ?>
		</ul>
	</li>
	<?php }
	else {
		//if ($cat['getPerc'] != '100%') { $final_submit = false; } 
	?>
	<li><?= $this->Html->link(__($cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $cat['id']], ['escape'=>false, 'title'=>'categories']) ?></li>
	<?php 
	}
	}
	} // foreach $categories

	/*if($final_submit) { ?>
	<li><?= $this->Html->link(__('Final Submit'), ['controller'=>'contractor-answers', 'action'=>'final-submit', $service_id], ['escape'=>false, 'title'=>'Final submit']) ?></li>
	<?php }*/
	?>

	<h3 class="menu-title">Others</h3>
	<?php 
	if($category_id==6 || $year!=null) {
	$expCount = $this->Category->getExplanationsCount($activeUser['contractor_id']); ?>
	<li><?= $this->Html->link(__('Supplier Explanations (' . $expCount . ')'), ['controller'=>'Explanations', 'action'=>'add', $service_id,6], ['escape'=>false, 'title'=>'explanations']) ?></li> 

	  <?php $contractor = $this->User->getContractor($activeUser['contractor_id']);
	  if ($contractor->waiting_on == 'CanQualify') {
		if (isset($activeUser['client_id'])) {
		  echo '<li>' . $this->Html->link(__($contractor->waiting_on . ' Review'), ['controller'=>'OverallIcons', 'action'=>'forceChange', $activeUser['client_id'], $activeUser['contractor_id'], 1], ['title'=>'Force Icon', 'class'=>'ajaxmodal forceicon', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal2']) . '</li>';
		} else {
		  echo '<li>' . $this->Html->link(__($contractor->waiting_on . ' Review'), ['controller'=>'OverallIcons', 'action'=>'forceChangeAdmin', 0, $activeUser['contractor_id'], 1], []) . '</li>';
		}
	  }
	?>
	<li>
	<?php
	if (isset($activeUser['client_id'])) {
		echo $this->Html->link(__('Force Icon'), ['controller'=>'OverallIcons', 'action'=>'forceChange', $activeUser['client_id'], $activeUser['contractor_id']], ['title'=>'Force Icon', 'class'=>'ajaxmodal forceicon', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal2']);
	} else {
		echo $this->Html->link(__('Force Icon'), ['controller'=>'OverallIcons', 'action'=>'forceChangeAdmin', 0, $activeUser['contractor_id']], ['title'=>'Force Icon']);
	}
	?>
	</li>
	<?php
	}

	} // if service_id
	}
	else { // admin links
	?>
	<h3 class="menu-title">Clients</h3>

	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-users"></i> Clients'), ['controller'=>'Clients', 'action'=>'index'], ['title'=>'Clients','escape'=>false]) ?></li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-building-o"></i> Locations'), ['controller'=>'Sites', 'action'=>'index'], ['title'=>'Locations','escape'=>false]) ?> </li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-map-marker"></i> Regions'), ['controller'=>'Regions', 'action'=>'index'], ['title'=>'Regions','escape'=>false]) ?> </li>

	<h3 class="menu-title"></h3>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-check"></i> Benchmarks'), ['controller'=>'Benchmarks', 'action'=>'index'], ['title'=>__('Benchmarks'),'escape'=>false, 'class'=>'nav-link']) ?></li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-users"></i> Contractors'), ['controller'=>'Contractors', 'action'=>'index'], ['escape'=>false, 'title'=>'Contractors']) ?> </li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-users"></i> Customer REP'), ['controller'=>'CustomerRepresentative', 'action'=>'index'], ['escape'=>false, 'title'=>'Customer REP']) ?></li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-users"></i> Users'), ['controller'=>'Users', 'action'=>'index'], ['escape'=>false, 'title'=>'Users']) ?> </li>

	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-list-ul"></i> Categories'), ['controller'=>'Categories', 'action'=>'index'], ['escape'=>false, 'title'=>'Categories']) ?></li>
	<li><?= $this->Html->link(__('<i class="menu-icon fa fa-question"></i> Questions'), ['controller'=>'Questions', 'action'=>'index'], ['escape'=>false, 'title'=>'Questions']) ?></li>
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
		<li><?= $this->Html->link(__('NAISC Codes'), ['controller'=>'NaiscCodes', 'action'=>'index'], ['title'=>'NAISC Codes']) ?></li>
		<li><?= $this->Html->link(__('Diagnostics'), ['controller'=>'Users', 'action'=>'diagnostics'], ['title'=>'diagnostics']) ?></li>
	</ul>
	</li>
	<?php } ?>
	</ul>
	</div><!-- /.navbar-collapse -->
</nav>
</aside><!-- /#left-panel -->
<!-- Left Panel -->

<div id="right-panel" class="right-panel">
	<!-- Header-->
	<header id="header" class="header">
	<div class="col-sm-9 header-left">
		<a id="menuToggle" class="menutoggle pull-left"><i class="fa fa-chevron-left"></i></a>
		<span class="welMsg">Welcome <?= $activeUser['username'] ?> (Logged in as Admin)</span>
		<?= $this->Html->link('Login As', ['controller'=>'Users','action'=>'loginAs'], ['escape'=>false, 'title'=>__('Login As'), 'class'=>'btn btn-secondary pull-right loginbtn']) ?>		
	</div>
	<div class="col-sm-3 header-right text-right">
		<div class="dropdown for-notification">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa fa-bell"></i>
			<span class="count bg-danger">0</span>
			</button>
		</div>
		<!--<div class="dropdown for-message">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="ti-email"></i>
			<span class="count bg-primary">0</span>
			</button>
		</div>-->
		<div class="user-area dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<?= $this->Html->image('user-icon.jpeg', ['alt'=>'User Avatar','class'=>'user-avatar rounded-circle'])?>
		</a>
		<div class="user-menu dropdown-menu">
		<?= $this->Html->link('<i class="fa fa-user"></i> My Profile', ['controller'=>'Users','action'=>'myProfile'], ['escape'=>false, 'title'=>__('My Profile'), 'class'=>'nav-link']) ?>
		<?= $this->Html->link('<i class="fa fa-cog"></i> Settings', ['controller'=>'Users','action'=>'settings'], ['escape'=>false, 'title'=>__('Settings'), 'class'=>'nav-link']) ?>
		<?= $this->Html->link('<i class="fa fa-sign-out"></i> Logout', ['controller'=>'Users','action'=>'logout'], ['escape'=>false, 'title'=>__('Logout'), 'class'=>'nav-link']) ?>		
		</div>
	</div>
	</div>
	</header><!-- /header -->
	<!-- Header-->
	
	<!-- Client navigation -->	
	<?php if(isset($clientNav) && $clientNav == true && isset($activeUser['client_id'])) { 
	?>
	<div class="clientNav navbar-wraper mb-3">
	<nav class="navbar navbar-expand-lg navbar-light bg-white">
	  <?= $this->Html->link(__($activeUser['client_company_name'].' Dashboard'), ['controller'=>'Clients', 'action'=>'dashboard', $activeUser['client_id']], ['class'=>'btn btn-secondary']) ?>
	</nav>
	</div>
	<?php } ?>

	<?php if(isset($contractorNav) && $contractorNav == true && isset($activeUser['contractor_id'])) { ?>
	<div class="contractorNav navbar-wraper mb-3 clearfix">
	<nav class="navbar navbar-expand-lg navbar-light bg-white">
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#clientNav" aria-controls="clientNav" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	  </button>
	  <ul class="navbar-nav cat-nav">
		<li class="nav-item">
		  <?= $this->Html->link(__($activeUser['contractor_company_name'].' Dashboard'), ['controller'=>'Contractors', 'action'=>'dashboard', $activeUser['contractor_id']], ['class'=>'nav-link btn btn-secondary']) ?>
		</li>		
		<?php
		$client_services = $this->Category->getServices($activeUser['contractor_id']);
		foreach ($client_services as $client_service) {
		if(!empty($client_service['service']['categories'])) {
			$firstCatId = $client_service['service']['categories'][0]['id'];
		?>
			<li class="nav-item"><?= $this->Html->link(__($client_service['service']['name']), ['controller'=>'ContractorAnswers', 'action'=>'addAnswers', $client_service['service']['id'], $firstCatId], ['class'=>'nav-link btn btn-success']) ?></li>
		<?php
			if($client_service['service']['name'] == 'DocuQUAL') { 
			$serviceSubcat = $this->Category->getServiceSubcat($client_service['service']['id']);
			foreach ($serviceSubcat as $subcat) {
		?>
			<li class="nav-item"><?= $this->Html->link(__($subcat['name']), ['controller'=>'ContractorAnswers', 'action'=>'addAnswers', $client_service['service']['id'], $subcat['id']], ['class'=>'nav-link btn btn-success']) ?></li>
		<?php
			}
			}
		}
		}
		?>
	  </ul>
	  <ul class="text-right">
	  <li class="nav-item"><?= $this->Html->link(__('Notes'), ['controller'=>'Notes', 'action'=>'index'], ['class'=>'nav-link btn']) ?></li>
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
	<?= $this->Html->script('/assets/js/init-scripts/data-table/datatables-init.js') ?>
	<?= $this->Html->script('/assets/js/init-scripts/charts/chart-init.js') ?>
	<?= $this->Html->script('/assets/js/summernote-bs4.js') ?>

	<?= $this->Html->script('/vendors/jquery-ui-1.12.1/jquery-ui.min.js') ?>
	<?= $this->Html->script('multiselect.js') ?>
	<?= $this->Html->script('select2.min.js') ?>
	<?= $this->Html->script('tagsinput.js') ?>

	<script>var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;</script>
	<?= $this->Html->script('form_wizard.js?v='.js_version) ?>
	<?= $this->Html->script('custom.js?v='.js_version) ?>
	<?= $this->Html->script('google_map.js') ?>
	
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
