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
 * @link	  https://cakephp.org CakePHP(tm) Project
 * @since	 0.10.0
 * @license	   https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CanQualify, a solution for managing supply chain';
?>
<!DOCTYPE html>
<!--[if lt IE 7]>	  <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>		 <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>		 <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js h-100" lang="en">
<!--<![endif]-->

<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?= $cakeDescription ?>:
		<?= $this->fetch('title') ?>
	</title>
	<?= $this->Html->meta('icon', '/img/icon.png', ['type'=>'image/png']) ?>

	<!--<?= $this->Html->css('base.css') ?>-->
	<?= $this->Html->css('/vendors/bootstrap/dist/css/bootstrap.min.css') ?>
	<?= $this->Html->css('/vendors/font-awesome/css/font-awesome.min.css') ?>
	<?= $this->Html->css('/vendors/themify-icons/css/themify-icons.css') ?>
	<?= $this->Html->css('/vendors/flag-icon-css/css/flag-icon.min.css') ?>
	<?= $this->Html->css('select2.min.css') ?>

	<?= $this->Html->css('custom.css?v='.time()) ?>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,600" rel="stylesheet">

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>
<body class="ly-default d-flex flex-column h-100">
<!-- Header-->
<header id="header" class="header no-print">

<nav class="navbar navbar-expand-lg navbar-light bg-white">
<div class="container">
	  <?= $this->Html->link(
	      $this->Html->image('logo.png', ['alt' => 'CanQualify', 'width' =>'234px', 'height' => '58px']),
	      'https://canqualify.com/',
	      ['escapeTitle' => false, 'class' => 'navbar-brand', 'title' => 'CanQualify']
	  ); ?>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
	    <ul class="navbar-nav">
		<li class="nav-item current_page"><?= $this->Html->link(__('Home'), 'https://canqualify.com/', ['class'=>'nav-link']) ?> </li>
		<li class="nav-item"><?= $this->Html->link(__('Services'), 'https://canqualify.com/services/', ['class'=>'nav-link']) ?> </li>
		<li class="nav-item"><?= $this->Html->link(__('Clients'), 'https://canqualify.com/client/', ['class'=>'nav-link']) ?> </li>
		<li class="nav-item"><?= $this->Html->link(__('Suppliers'), 'https://canqualify.com/contractor/', ['class'=>'nav-link']) ?> </li>
		<li class="nav-item"><?= $this->Html->link(__('About Us'), 'https://canqualify.com/blog/articles/', ['class'=>'nav-link']) ?> </li>
		<li class="nav-item"><?= $this->Html->link(__('Articles'), 'https://canqualify.com/blog/articles/', ['class'=>'nav-link']) ?> </li>		
		<li class="nav-item fusion_menu">		
		<a href="/users/empRegister" class="fusion-background-highlight nav-link">
		<span class="menu-text fusion-button button-default button-medium redbtn">Register</span>
		</a>
		</li>
		<li class="nav-item fusion_menu">
		<a href="/users/login" class="fusion-background-highlight nav-link">
		<span class="menu-text fusion-button button-default button-medium greenBtn">
		<span class="button-icon-divider-left"><i class="fa fa-lock"></i></span>
		<span class="fusion-button-text-left">Log In</span>
		</span></a></li>
	    </ul>
	  </div>
</div>
</nav>
</header><!-- /header -->

<main role="main" class="flex-shrink-0" style="margin-top:100px;">
<?php if($this->fetch('title')=='register') { ?>
<div class="container">
	<div class="row">
		<div class="col-md-12 text-center mt-5 mb-5">
			<h1>Employee Registration</h1>
		</div>
	</div>
	</div>
	</div>
<?php } ?>

<div class="container">
	<div class="row">
	<div class="col-sm-12">
		<?= $this->Flash->render() ?>
	</div>
	</div>

	<div class="content">
		<?= $this->fetch('content') ?>
	</div>
</div>
</main><!-- /main -->

<footer id="footer" role="contentinfo" class="footer mt-5">
<section class="section subfooter">
    <div class="container">
        <div class="row footer-columns-2">
	<div class="col-sm-12">
		<div class="mt-3 mb-3 copyright">COPYRIGHT 2019 CanQualify   |   ALL RIGHTS RESERVED! </div>
	</div>
        </div>
    </div>
</section>
</footer>

<?= $this->Html->script('/vendors/jquery/dist/jquery.min.js') ?>
<?= $this->Html->script('/vendors/popper.js/dist/umd/popper.min.js') ?>
<?= $this->Html->script('/vendors/bootstrap/dist/js/bootstrap.min.js') ?>
<?= $this->Html->script('https://www.google.com/recaptcha/api.js') ?>
<?= $this->Html->script('/vendors/jquery-ui-1.12.1/jquery-ui.min.js') ?>
<?= $this->Html->script('select2.min.js') ?>

<script>var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;</script>
<?= $this->Html->script('custom.js?v='.time()) ?>
<script>
/*jQuery(function(){
	var navbar = jQuery('.navbar');
	jQuery(window).scroll(function(){
		if(jQuery(window).scrollTop() <= 50){
			navbar.removeClass('fixed-top');
		} else {
			navbar.addClass('fixed-top');
		}
	});
});*/
document.getElementById('txtPhone').addEventListener('input', function (e) {
       var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
          e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
});
document.getElementById('txtTIN').addEventListener('input', function (e) {
       var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,7})/);
          e.target.value = !x[2] ? x[1] : '' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
});
</script>
</body>
</html>
