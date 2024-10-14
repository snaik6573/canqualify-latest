<?php
require_once(ROOT . DS . 'vendor' . DS . "fusion-charts" . DS . "fusioncharts.php");
?>
<h5>Reports: Compliance</h5>
<hr/>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div id="chart-forced-icon"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div id="chart-severityRate"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div id="chart-groupEmr"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div id="chart-groupDart"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div id="chart-groupTrir"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div id="chart-groupLwcr"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div id="chart-fatalities"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div id="chart-citation"></div>
            </div>
        </div>
    </div>
</div>

<?php
//debug($forcedIcon);
/*forced icon*/
if(!empty($forcedIcon)) {
    $chartForcedIcon = new FusionCharts("multilevelpie", "forced-icon", "100%", 400, "chart-forced-icon", "json", json_encode($forcedIcon));
    $chartForcedIcon->render();
}

/*EMR*/
if(!empty($groupData['EMR'])) {
    $groupEmrChart = new FusionCharts("mscolumn2d", "groupEmr", "100%", 400, "chart-groupEmr", "json", json_encode($groupData['EMR']));
    $groupEmrChart->render();
}

/*DART*/
if(!empty($groupData['DART'])) {
    $groupDartChart = new FusionCharts("mscolumn2d", "groupDart", "100%", 400, "chart-groupDart", "json", json_encode($groupData['DART']));
    $groupDartChart->render();
}

/*TRIR*/
if(!empty($groupData['TRIR'])) {
    $groupTrirChart = new FusionCharts("mscolumn2d", "groupTrir", "100%", 400, "chart-groupTrir", "json", json_encode($groupData['TRIR']));
    $groupTrirChart->render();
}

/*LWCR*/
if(!empty($groupData['LWCR'])) {
    $groupLwcrChart = new FusionCharts("mscolumn2d", "groupLwcr", "100%", 400, "chart-groupLwcr", "json", json_encode($groupData['LWCR']));
    $groupLwcrChart->render();
}

/*Fatalities*/
if(!empty($lineData['fatalities'])) {
    $fatalitiesChart = new FusionCharts("line", "fatalities", "100%", 300, "chart-fatalities", "json", json_encode($lineData['fatalities']));
    $fatalitiesChart->render();
}

/*Citation*/
if(!empty($lineData['citation'])) {
    $citationChart = new FusionCharts("line", "citation", "100%", 300, "chart-citation", "json", json_encode($lineData['citation']));
    $citationChart->render();
}
/* Severity Rate (SR) */
if(!empty($lineDataSR['SR'])) {
    $SRChart = new FusionCharts("line", "SR", "100%", 300, "chart-severityRate", "json", json_encode($lineDataSR['SR']));
    $SRChart->render();
}

?>

