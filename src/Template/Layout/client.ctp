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


$cakeDescription = 'CanQualify';
?>
<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<?php

/* Include the `../src/fusioncharts.php` file that contains functions to embed the charts.*/
//include("assets/vendors/fusion-charts/fusioncharts.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <?= $this->Html->css('clear-blue/bootstrap.css') ?>
    <?= $this->Html->css('/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>
    <?= $this->Html->css('/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>
    <?= $this->Html->css('/vendors/font-awesome/css/font-awesome.min.css') ?>
    <?= $this->Html->css('/vendors/jquery-ui-1.12.1/jquery-ui.min.css') ?>
    <?= $this->Html->css('/assets/videojs/dist/video-js.min.css') ?>
    <?= $this->Html->css('/assets/videojs/dist/videojs-resume.min.css') ?>
    <?= $this->Html->css('/assets/quill/css/quill.bubble.css') ?>
    <?= $this->Html->css('/assets/quill/css/quill.snow.css') ?>
    <?= $this->Html->css('/assets/css/summernote-bs4.css') ?>
    <?= $this->Html->css('dataTables.checkboxes.css') ?>
    <?= $this->Html->css('tagsinput.css') ?>
    <?= $this->Html->css('multi-select.css') ?>
    <?= $this->Html->css('jquery.multiselect.css') ?>
    <?= $this->Html->css('jquery.multiselect.filter.css') ?>
    <?= $this->Html->css('select2.min.css') ?>
    <?= $this->Html->css('/vendors/bootstrap/dist/css/bootstrap-toggle.min.css') ?>
    

    <?= $this->Html->css('clear-blue/iconly/bold.css') ?>
    <?= $this->Html->css('clear-blue/perfect-scrollbar/perfect-scrollbar.css') ?>
    <?= $this->Html->css('clear-blue/bootstrap-icons/bootstrap-icons.css') ?>

    <?= $this->Html->css('clear-blue/app.css') ?>
    <?= $this->Html->css('clear-blue/clear-blue.css') ?>
    <?= $this->Html->css('clear-blue/datatable-style.css') ?>
    <?= $this->Html->css('custom.css?v='.css_version) ?>
    <?= $this->Html->meta('icon', '/img/icon.png', ['type'=>'image/png']) ?>

     <?= $this->Html->script('/vendors/jquery/dist/jquery.min.js') ?>

    <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <?= $this->Html->script('/js/fusion-charts/key.js') ?>

</head>

<body>
<div id="app">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="logo">
                        <?php
                        if(isset($activeUser['company_logo']) && $activeUser['company_logo']!=='') {
                            echo $this->Html->image($uploaded_path.$activeUser['company_logo'], ['class'=>'']);
                        }elseif(isset($activeUser['company_name']) && $activeUser['company_name']!==''){ ?>
                            <h5 title="<?= $activeUser['company_name'];?> "><?=$activeUser['company_name'] ?></h5><h3 class="menu-title"></h3>
                        <?php }?>
                        <?php
                        if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ) {
                            ?>
                            <h6 class="environment_name"><?= $_SERVER['ENVIRONMENT'] == 'development' ? 'Demo' : $_SERVER['ENVIRONMENT'] ?> site</h6>
                        <?php } ?>
                    </div>
                    <div class="toggler">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                <?php
                if(isset($contractorNav) && $contractorNav==true && isset($activeUser['contractor_id'])) {
                    ?>
                    <?php if(isset($activeUser['contractor_id'])){ 
                         echo $this->element('Layout_Nav/client-left-navigation');
                  }else{ ?>
                           <li><?= $this->Html->link(__('<i class="menu-icon fa fa-dashboard"></i> Client Dashboard'), ['controller'=>'Clients', 'action'=>'dashboard'], ['escape'=>false, 'title'=>'dashboard']) ?></li>
                     <?php
                    echo $this->element('Layout_Nav/contractor_left_nav');
                    } 
                 
                   
                }
                else {
                    echo $this->element('client-elements/left-navigation');
                }
                ?>
                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
    <div id="main">
       <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
        </header>       
        <?= $this->element('client-elements/header');?>
        <?php echo $this->element('Layout_Nav/contractor_center_nav'); // contractor_nav ?>
        <div class="row">
            <div class="col-sm-12 alert-wrap">
                <?= $this->Flash->render() ?>
            </div>
        </div>
        <div class="animated">
            <?= $this->fetch('content') ?>
        </div>

        <?= $this->element('footer')?>

    </div>
</div>
<?= $this->Html->script('/vendors/popper.js/dist/umd/popper.min.js') ?>
<?= $this->Html->script('/assets/js/summernote-bs4.js') ?>
<?= $this->Html->script('/vendors/jquery-ui-1.12.1/jquery-ui.min.js') ?>
<?= $this->Html->script('/vendors/bootstrap/dist/js/bootstrap.min.js') ?>
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
<script>var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;</script>
<?= $this->Html->script('/assets/videojs/dist/video.min.js') ?>
<?= $this->Html->script('/assets/videojs/dist/store.min.js') ?>
<?= $this->Html->script('/assets/videojs/dist/videojs-resume.min.js') ?>
<?= $this->Html->script('/assets/quill/js/quill.core.js') ?>
<?= $this->Html->script('/assets/quill/js/quill.js') ?>
<?= $this->Html->script('/assets/quill/js/placeholder-module.js') ?>
<?= $this->Html->script('dataTables.checkboxes.min.js') ?>

<?= $this->Html->script('jquery.multiselect.js') ?>
<?= $this->Html->script('jquery.multiselect.filter.js') ?>
<?= $this->Html->script('select2.min.js') ?>
<?= $this->Html->script('/vendors/bootstrap/dist/js/bootstrap-toggle.min.js') ?>

<?= $this->Html->script('clear-blue/perfect-scrollbar/perfect-scrollbar.min.js') ?>
<?= $this->Html->script('clear-blue/bootstrap.bundle.min.js') ?>
<?= $this->Html->script('clear-blue/main.js') ?>
<?= $this->Html->script('clear-blue/client-custom.js') ?>
<?= $this->Html->script('custom.js?v='.js_version) ?>
</body>

</html>
