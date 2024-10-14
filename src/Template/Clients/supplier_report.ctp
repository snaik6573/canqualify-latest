<?php
require_once(ROOT . DS . 'vendor' . DS . "fusion-charts" . DS . "fusioncharts.php");
?>

<h5>Reports: Suppliers</h5>
<hr/>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">Suppliers: Waiting On Status</div>
            <div class="card-body">
                <div id="chart-supplierWaitingOnChart"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">Suppliers: Registration Status</div>
            <div class="card-body">
                <div id="chart-supplier-registration"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">Suppliers: Subscription Status by Location</div>
            <div class="card-body">
                <div id="chart-site-subscription"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">Suppliers: Overall Subscription Status</div>
            <div class="card-body">
                <div id="chart-overall-subscription"></div>
            </div>
        </div>
    </div>
</div>
<?php
$supplierWaitingOnChart = new FusionCharts("column2d", "supplierWaitingOn", "100%", 300, "chart-supplierWaitingOnChart", "json", $supplierWaitingOn);
$supplierWaitingOnChart->render();

/*supplier registration*/
$donutSupplierRegistration = new FusionCharts("doughnut2d", "supplier-registration", "100%", 300, "chart-supplier-registration", "json", $supplierRegistration );
$donutSupplierRegistration->render();

/*supplier registration*/
if(!empty($siteSubscriptionChart)){
    $siteSubscription = new FusionCharts("scrollstackedcolumn2d", "site-subscription", "100%", 350, "chart-site-subscription", "json", json_encode($siteSubscriptionChart));
    $siteSubscription->render();
}


if(!empty($overallSubscription) && count($overallSubscription) > 0){
    $chartOverallSubscription = new FusionCharts("multilevelpie", "overall-subscription", "100%", 400, "chart-overall-subscription", "json", json_encode($overallSubscription));
    $chartOverallSubscription->render();
}
?>

