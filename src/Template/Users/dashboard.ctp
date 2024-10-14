<?php
use Cake\Core\Configure;
$this->assign('title', 'Dashboard');
$this->Breadcrumbs->add([
    ['title' => 'Admins', 'url' => ['controller' => 'users', 'action' => 'index']],
    ['title' => 'Dashboard']
]);
?>
<div class="row">
<div class="col-lg-3 col-6">
<div class="card text-white bg-flat-color-1">
    <div class="card-body pb-0">
	<h4 class="mb-0">
		<span class="count"><?php echo $this->User->getClientsount();?></span>
	</h4>
	<p class="text-light">Clients</p>
    </div>
</div>
</div>
<div class="col-lg-3 col-6">
<div class="card text-white bg-flat-color-2">
    <div class="card-body pb-0">
	<h4 class="mb-0">
		<span class="count"><?php echo $this->User->getContractorcount();?></span>
	</h4>
	<p class="text-light">Contractor</p>
    </div>
</div>
</div>
<div class="col-lg-3 col-6">
<div class="card text-white bg-flat-color-3">
    <div class="card-body pb-0">
	<h4 class="mb-0">
		<span class="count"><?php echo $this->User->getCRFount();?></span>
	</h4>
	<p class="text-light">Customer REP</p>
    </div>
</div>
</div>
<div class="col-lg-3 col-6">
<div class="card text-white bg-flat-color-4">
    <div class="card-body pb-0">
	<h4 class="mb-0">
	<span class="count">
		<?php $userCnt = $this->User->getWaitingonCnt();?>
		<?= $this->Html->link($userCnt, ['controller'=>'Contractors', 'action' => 'pendingContractorList',1],['escape'=>false, 'title' => 'View']) ?>
	</span>
	</h4>
	<p class="text-light">Pending Reviews</p>
    </div>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-3 col-6">
<div class="social-box facebook">
    <i class="fa fa-facebook"></i>
    <ul>
	<li>
	<span class="count">40</span> k
	<span>friends</span>
	</li>
	<li>
	<span class="count">450</span>
	<span>feeds</span>
	</li>
    </ul>
</div>
</div>
<div class="col-lg-3 col-6">
<div class="social-box twitter">
    <i class="fa fa-twitter"></i>
    <ul>
	<li>
	<span class="count">30</span> k
	<span>friends</span>
	</li>
	<li>
	<span class="count">450</span>
	<span>tweets</span>
	</li>
    </ul>
</div>
</div>
<div class="col-lg-3 col-6">
<div class="social-box linkedin">
    <i class="fa fa-linkedin"></i>
    <ul>
	<li>
	<span class="count">40</span> +
	<span>contacts</span>
	</li>
	<li>
	<span class="count">250</span>
	<span>feeds</span>
	</li>
    </ul>
</div>
</div>
<div class="col-lg-3 col-6">
<div class="social-box google-plus">
    <i class="fa fa-google-plus"></i>
    <ul>
	<li>
	<span class="count">94</span> k
	<span>followers</span>
	</li>
	<li>
	<span class="count">92</span>
	<span>circles</span>
	</li>
    </ul>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
	<strong>Overall Compliance</strong>
    </div>
    <div class="card-body pieChartBlock">
	<?php 
	$pieChartData[] = array('Type', 'Number');
	$pieChartData[] = array('Compliant', $pieChart[0]); // green
	$pieChartData[] = array('Conditional', $pieChart[1]); // yellow
	$pieChartData[] = array('Non-Compliant', $pieChart[2]); // red
	$pieChartData[] = array('Waiting on Contractor', $pieChart[3]);
	?>
	<script>
		var pieChartData = <?php echo json_encode($pieChartData) ?>;
	</script>
	<div id="pieChart" style="height: 450px;"></div>
	<div id="pieChartLabelOverlay">
	    <div>Overall</div><div>Compliance</div><div>Status</div>
	</div>
    </div>
</div>
</div>

<!--<div class="col-lg-3 col-md-6">
<section class="card">
    <div class="twt-feed blue-bg">
	<div class="corner-ribon black-ribon">
	<i class="fa fa-twitter"></i>
	</div>
	<div class="fa fa-twitter wtt-mark"></div>

	<div class="media">
	<a href="#">
	<img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px;" alt="" src="images/admin.jpg">
	</a>
	<div class="media-body">
	<h2 class="text-white display-6">Jim Doe</h2>
	<p class="text-light">Project Manager</p>
	</div>
	</div>
    </div>
    <div class="weather-category twt-category">
	<ul>
	<li class="active">
	<h5>750</h5>
	Tweets
	</li>
	<li>
	<h5>865</h5>
	Following
	</li>
	<li>
	<h5>3645</h5>
	Followers
	</li>
	</ul>
    </div>
    <div class="twt-write col-sm-12">
	<textarea placeholder="Write your Tweet and Enter" rows="1" class="form-control t-text-area"></textarea>
    </div>
    <footer class="twt-footer">
	<a href="#"><i class="fa fa-camera"></i></a>
	<a href="#"><i class="fa fa-map-marker"></i></a>
	New Castle, UK
	<span class="pull-right">
	32
	</span>
    </footer>
</section>
</div>

<div class="col-lg-3 col-md-6">
<div class="card">
    <div class="card-body">
	<div class="stat-widget-one">
	<div class="stat-icon dib"><i class="ti-money text-success border-success"></i></div>
	<div class="stat-content dib">
	<div class="stat-text">Total Profit</div>
	<div class="stat-digit">1,012</div>
	</div>
	</div>
    </div>
</div>

<div class="card">
    <div class="card-body">
	<div class="stat-widget-one">
	<div class="stat-icon dib"><i class="ti-user text-primary border-primary"></i></div>
	<div class="stat-content dib">
	<div class="stat-text">New Customer</div>
	<div class="stat-digit">961</div>
	</div>
	</div>
    </div>
</div>

<div class="card">
    <div class="card-body">
	<div class="stat-widget-one">
	<div class="stat-icon dib"><i class="ti-layout-grid2 text-warning border-warning"></i></div>
	<div class="stat-content dib">
	<div class="stat-text">Active Projects</div>
	<div class="stat-digit">770</div>
	</div>
	</div>
    </div>
</div>
</div> -->
<?php $show_map = Configure::read('show_map'); 
if($show_map == true) { 
?>
<div class="col-lg-6">
<div class="card">
	<?php 
	$contractorsArr =array();
	foreach ($contractors as $contractor):
	if(isset($contractor->state->name) && isset($contractor->country->name)) {
		$addrInfo[0] = $contractor->addressline_1.' '.$contractor->addressline_2.' '.$contractor->city.' '.$contractor->state->name.' '.$contractor->country->name;

		$addrInfo[1] = $contractor->latitude;
		$addrInfo[2] = $contractor->longitude;
		$addrInfo[3] = $contractor->company_name;
		array_push($contractorsArr, $addrInfo);
	}
	endforeach; 

	$clientsArr = array();
	foreach ($clients as $client): 
	foreach ($client->sites as $site):
	if(isset($site->state->name) && isset($site->country->name)) {
		$addrInfo[0] = $site->addressline_1.' '.$site->addressline_2.' '.$site->city.' '.$site->state->name.' '.$site->country->name;
		$addrInfo[1] = $site->latitude;
		$addrInfo[2] = $site->longitude;
		$addrInfo[3] = $site->name.' '.$site->state->name;
		array_push($clientsArr, $addrInfo);
	}
	endforeach;
	endforeach;
	?>
	<script>
		var contractor_markers = <?php echo json_encode($contractorsArr) ?>;
		var client_markers = <?php echo json_encode($clientsArr) ?>;
	</script>
	<div class="card-header">
		<strong class="pull-left">Locations</strong>
		<div class="pull-right">
			<span>Contractors <span class="badge badge-success"><?= count($contractorsArr)?></span></span> &nbsp;
			<span>Client Sites <span class="badge badge-primary"><?= count($clientsArr)?></span></span> &nbsp;
		</div>
	</div>
	<div class="Vector-map-js">
		<div class="map" id="map" style="width: 100%;"></div>
	</div>
</div>     
</div>
<?php } ?>
</div>
