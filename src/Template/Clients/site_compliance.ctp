<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Site</strong> : <?= $siteName ?>
	</div>

	<div class="card-body card-block">
		<?php 
		$pieChartData[] = array('Type', 'Number');
		$pieChartData[] = array('Compliant ['.$pieChart[0].']', $pieChart[0]);	//green
		$pieChartData[] = array('Conditional ['.$pieChart[1].']', $pieChart[1]); //yellow
		$pieChartData[] = array('Non-Compliant ['.$pieChart[2].']', $pieChart[2]); //red
		$pieChartData[] = array('Waiting on Contractor ['.$pieChart[3].']', $pieChart[3]);
		?>
		<script>
			var pieChartBySiteData = <?php echo json_encode($pieChartData) ?>;
		</script>
		<div id="pieChartBySite"></div>
	</div>
</div>
</div>
</div>

<script type="text/javascript">
//google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {

    var data = google.visualization.arrayToDataTable(pieChartBySiteData);

    var options = {
        title: 'Compliance By Site',
		pieHole: 0.4,		
		chartArea: {width: 600, height: 400},
		legend: { position: 'right'},
		sliceVisibilityThreshold :0,
        slices: {
	  0: {color: 'green'},
	  1: {color: '#ffc800'},
	  2: {color: '#dc3912'},
	  3: {color: 'gray'},
        },
        pieSliceTextStyle: {
          color: '#ffffff'
        }
    };

    var chart = new google.visualization.PieChart(document.getElementById('pieChartBySite'));
    chart.draw(data, options);
}
</script>
