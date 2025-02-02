/* piechart */
( function ( $ ) {
if(typeof pieChartData !== 'undefined') {
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
}

function drawChart() {
	var data = google.visualization.arrayToDataTable(pieChartData);

	var options = {
		title: 'Overall Compliance',
		pieHole: 0.4,
		sliceVisibilityThreshold :0,
		legend: { position: 'bottom'},
		chartArea: {width: '100%', height: 300},
		//pieSliceText: 'label',
		slices: {
		  0: {color: 'green'},
		  1: {color: '#ffc800'},
		  2: {color: '#dc3912'},
		  3: {color: 'gray'}
		},
		pieSliceTextStyle: {
		  color: '#ffffff'
		}
	};
	var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
	chart.draw(data, options);
}

if(typeof leadsChartData !== 'undefined') {
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChartLeads);
}

function drawChartLeads() {
	var data = google.visualization.arrayToDataTable(leadsChartData);

	var options = {
		title: 'Supplier Status',
		pieHole: 0.4,
		sliceVisibilityThreshold :0,
		legend: { position: 'bottom'},
		chartArea: {width: '100%', height: 300},
		//pieSliceText: 'label',
		slices: {
		  0: {color: '#E0E0E0'},
		  1: {color: '#9E9E9E'},
		  2: {color: '#F44336'},
		  3: {color: '#ffc800'},
		  4: {color: '#FF3D00'},
		  5: {color: '#00C853'},
		  6: {color: '#9C27B0'}
		  

		},
		pieSliceTextStyle: {
		  color: '#ffffff'
		}
	};
	var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
	chart.draw(data, options);
}

/* barChartStacked  */
if(typeof barChartStackedData !== 'undefined') {
	  google.charts.load('current', {'packages':['corechart', 'controls']});
	  google.charts.setOnLoadCallback(drawMultSeries);
}
function drawMultSeries() {
	var data = google.visualization.arrayToDataTable(barChartStackedData);

	// Create a dashboard.
	var dashboard = new google.visualization.Dashboard(
	document.getElementById('dashboard_div'));

	// Create a range slider, passing some options	
	
	
      if (jQuery(window).width() <= 768 ){
				var chartSearch = new google.visualization.ControlWrapper({
				  'controlType': 'CategoryFilter',
				  'containerId': 'filter_div',				  
				  'options': {					 
					'filterColumnLabel': 'Site',
						ui: {
						'allowMultiple' :false						
					} 
				  }
				});
       }
	   else{
		   var chartSearch = new google.visualization.ControlWrapper({
				  'controlType': 'StringFilter',
				  'containerId': 'filter_div',
				  'options': {
					'filterColumnLabel': 'Site'
				  }
				});
		   
	   }	
	

	// Create a pie chart, passing some options
	var barChart = new google.visualization.ChartWrapper({
	  'chartType': 'BarChart',
	  'containerId': 'chart_div',
	  'options': {
		title: 'Compliance by Location',
		colors: ['green', '#ffc800', '#dc3912', 'gray'],
		height: (data.getNumberOfRows() * 38) + 100,
		chartArea: {'bottom': 30, 'right': 20, 'width': '67%', 'height': (data.getNumberOfRows() * 38)},
		legend: { position: 'top',  maxLines: 4 },
		tooltip: { textStyle: { fontSize: 14 } },
		hAxis: {
		  minValue: 0,
		  ticks: [0, .2, .4, .6, .8, 1]
		},
		vAxis: {
		  textPosition: 'out',
		  textStyle : {
		    fontSize: 11
		  }
		},
		//bar: {groupWidth: '75%'},
		isStacked: 'percent',
	  }
	});
	   
	dashboard.bind(chartSearch, barChart);					
	dashboard.draw(data);

	google.visualization.events.addListener(chartSearch, 'statechange', statechangeFn);
	function statechangeFn() {
		var numOfRows =  barChart.getDataTable().getNumberOfRows();
		barChart.setOption('height', (numOfRows * 38) + 100);
		barChart.setOption('chartArea', {'bottom': 30, 'right': 20, 'width': '67%', 'height': (numOfRows * 38)});
		barChart.draw();
	}
			
	google.visualization.events.addListener(dashboard, 'ready', readyFn);
	function readyFn() {
		jQuery('#chart_div').css('cursor','pointer')
	}

	google.visualization.events.addListener(barChart, 'select', selectHandlerE);		

	function selectHandlerE() {
		Selection = barChart.getChart().getSelection();	
		
		
		if(Selection.length) {
			var row = Selection[0].row;

    	    var column = Selection[0].column;
			

			var ColumnValue = data.getValue(row, 1);	
            
			//location.href ='siteCompliance/'+row+'/'+ColumnValue;
			//var locationSiteCompliance = '/canqualify/canqualify-repo/clients/siteCompliance/'+row+'/'+ColumnValue;
			//var locationSiteCompliance = '/clients/siteCompliance/'+row+'/'+ColumnValue;
			//loadAjax(locationSiteCompliance, '#siteCompliance .modal-body');
			//jQuery('#siteCompliance').modal('show');

			location.href ='/clients/contractor-list/0/'+row+'/'+column;

			var column = Selection[0].column;
			var ColumnValue = data.getValue(row, 1);

			//location.href ='siteCompliance/'+row+'/'+ColumnValue;
			//var locationSiteCompliance = '/canqualify/canqualify-repo/clients/siteCompliance/'+row+'/'+ColumnValue;

			/*var locationSiteCompliance = '/clients/siteCompliance/'+row+'/'+ColumnValue;
			loadAjax(locationSiteCompliance, '#siteCompliance .modal-body');
			jQuery('#siteCompliance').modal('show');*/

			location.href ='/clients/contractor-list/0/0/'+row+'/'+column;

		}
	}
}


if(typeof linechart_material !== 'undefined') {
	google.charts.load('current', {'packages':['corechart', 'line']});
	google.charts.setOnLoadCallback(drawChart2);
}

function drawChart2() {
	var data = google.visualization.arrayToDataTable(lineChartData);
	var options = {
		chart: {
		title: 'Category List',
		  subtitle: 'Year wise description'
		},
		slices: {
		  0: {color: '#00ff00'},
		  1: {color: '#dc3912'},
		  2: {color: '#FFFF00'},
		},
		legend: { position: 'bottom'},
		height: 350

	};
	var chart = new google.visualization.LineChart(linechart_material);
	
	google.visualization.events.addListener(chart, 'ready', function () {		
		 var img = chart.getImageURI();
		
		jQuery('#chart_image').attr('src',img); 
	 });
	chart.draw(data, options);
	
}


jQuery('#siteCompliance').on('hidden.bs.modal', function (e) {
	 console.log("Modal hidden");
	 jQuery("#siteCompliance .modal-body").html("");
});
} )( jQuery );

jQuery(document).ready(function ($) {
			jQuery(document).on("click",".ExcelReport",function(e) {
		        e.preventDefault();
		        var selector = jQuery(this);
		        var currentForm = jQuery(this).parents('form'); 
								
		        jQuery.ajax({
		            type: "POST",
				headers: {'X-CSRF-TOKEN': csrfToken },
		        cache: false,
		        url: '/overallIcons/safety-statistics-report/1',
		        data: currentForm.serialize(),
				success: function( data ) {
	            //alert("file  save successfully.");
		        }
		        });
		        return false;
		    });
			
			jQuery(document).on("click",".PdfReport",function(e) {
		        e.preventDefault();
		        var selector = jQuery(this);
		        var currentForm = jQuery(this).parents('form');
				
		        jQuery.ajax({
		            type: "POST",
					headers: {'X-CSRF-TOKEN': csrfToken },
		            cache: false,
		            url: '/overallIcons/safety-statistics-report/2',
		            data: currentForm.serialize(),
		            success: function( data ) {
		            //alert("file  save successfully.");
		            }
		        });
		        return false;
		    });
			
			jQuery(document).on("click",".CsvReport",function(e) {
		        e.preventDefault();
		        var selector = jQuery(this);
		        var currentForm = jQuery(this).parents('form'); 					
		        jQuery.ajax({
		            type: 'POST',
					headers: {'X-CSRF-TOKEN': csrfToken },
		            cache: false,
		            url: '/overallIcons/safety-statistics-report/3',
		            data: currentForm.serialize(),					
		            success: function( data ) {
					// alert(data);
		            // alert("file  save successfully.");
		            },
					error: function (error) {
					console.log('error; ' + JSON.stringify(error));
					}
		        });
		        return false;
		    });

		  	/*setTimeout(function(){		  	
				var imgsrc =  $('#chart_image').attr('src');				
				jQuery.ajax({
                    url: '/overallIcons/saveimage',
                    data: {
                      imgBody: imgsrc
                    },
                    cache: false,
                    type: 'POST',
                    beforeSend: function (xhr) { // Add this line
						xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					},
                    success: function (results) {
                    },
                    error: function (results) {
                    }
                });
		  	},2000);*/
 });
