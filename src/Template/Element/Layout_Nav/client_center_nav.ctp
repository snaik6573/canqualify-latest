<?php 
if(!isset($clientCenterNav)){
	$clientCenterNav = false;
}
if(isset($clientNav) && $clientNav == true && isset($activeUser['client_id'] ) || $clientCenterNav == true) { ?>
	<div class="clientNav navbar-wraper mb-3">
	<nav class="navbar navbar-expand-lg navbar-light bg-white">
	  <?= $this->Html->link(__($activeUser['client_company_name'].' Dashboard'), ['controller'=>'Clients', 'action'=>'dashboard', $activeUser['client_id']], ['class'=>'btn btn-secondary']) ?>
	</nav>
	</div>
<?php } ?>