<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link	  https://cakephp.org CakePHP(tm) Project
 * @since	 0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CanQualify, a solution for managing supply chain';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
	<?= $cakeDescription ?>:
	<?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon', ROOT.'/img/icon.png', ['type'=>'image/png']) ?>

    <!--<?= $this->Html->css('base.css') ?>-->

	<?= $this->Html->css('/vendors/bootstrap/dist/css/bootstrap.min.css') ?>
	<?= $this->Html->css('/vendors/font-awesome/css/font-awesome.min.css') ?>
	<?= $this->Html->css('/vendors/themify-icons/css/themify-icons.css') ?>
	<?= $this->Html->css('/vendors/flag-icon-css/css/flag-icon.min.css') ?>
	<?= $this->Html->css('/vendors/selectFX/css/cs-skin-elastic.css') ?>

	<?= $this->Html->css('/assets/css/style.css') ?>
	<?= $this->Html->css('custom.css?v='.css_version) ?>

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>

<body class="bg-dark">
<div class="sufee-login d-flex align-content-center flex-wrap">
<div class="container">
	<div class="login-content">
		<div class="row">
		    <div class="col-sm-12">
			<?= $this->Flash->render() ?>
		    </div>
		</div>

		<div class="login-form">
			<div class="login-logo">
			<?= $this->Html->image('logo.png', ['url' => 'https://canqualify.com/', 'class'=>'navbar-brand', 'alt' => 'CanQualify', 'width' => '250px'])?>
			</div>
			<?= $this->fetch('content') ?>
			<p class="text-center">Back to <a href="https://canqualify.com/">canqualify.com</a></p>
		</div>
	</div>
</div>
</div>

<footer>
	<?= $this->Html->script('/vendors/jquery/dist/jquery.min.js') ?>
	<?= $this->Html->script('/vendors/bootstrap/dist/js/bootstrap.min.js') ?>
	<?= $this->Html->script('/assets/js/main.js') ?>
	<?= $this->Html->script('https://www.google.com/recaptcha/api.js') ?>
	<?= $this->Html->script('form_wizard.js') ?>
	<?= $this->Html->script('custom.js?v='.js_version) ?>
</footer>
</body>
</html>
