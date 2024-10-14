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
	<?= $this->Html->css('jquery-ui.css') ?>

	<?= $this->Html->css('/assets/css/style.css') ?>	
	<?= $this->Html->css('custom.css?v='.css_version) ?>
	

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

	<?= $this->Html->script('/vendors/jquery/dist/jquery.min.js') ?>	
	
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>
<body>
<div id="right-panel" class="right-panel">
	<div class="content mt-3">
	<div class="row">
	<div class="col-sm-12 alert-wrap">
	
	<div class="navbar-header">		
		<?= $this->Html->image('logo.png', ['url'=>['controller'=>'Users', 'action'=>'dashboard'], 'class'=>'navbar-brand', 'alt'=>'CanQualify', 'width'=>'200px'])?>		
		<br>
		<br>
		<br>
	</div>
	
	
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
	<?= $this->Html->script('custom.js?v='.js_version) ?>
</footer>
</body>
</html>
