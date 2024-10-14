(function ($) {
    //    "use strict";


    /*  Data Table
    -------------*/

    /*var dtorder =[ 0, "asc" ];
    if($('#bootstrap-data-table-export').attr('data-sort') !== undefined) {
	dtsort = $('#bootstrap-data-table-export').attr('data-sort');		
	dtorder =[ dtsort, "desc" ];
    }*/

	if(typeof dtAjaxUrl !== 'undefined') {
	var table = $('.data-table-ajax').DataTable({
		lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
	    "processing": true,
	    "serverSide": true,
		"ajax": {
			"url" : dtAjaxUrl
		},
		"pagingType": "full_numbers",
		"fnDrawCallback": function(){
		},
		"preDrawCallback": function(settings){
		}
	});
	}
	
   $('#bootstrap-data-table, .bootstrap-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
		"drawCallback": function( settings ) {
			var api = this.api();
			var current_page_record =  api.rows( {page:'current'} ).data().length;
			var total_record = api.rows().data().length;
			var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
			if(current_page_record >= total_record) { $(pagination).hide(); }
			else { $(pagination).show();}
		},
		"fnDrawCallback": function(){
		
		// hightlight updated leads
		jQuery('.hightlight_lead').each(function() {
			var foundCell = 0;
			var selectedTR = jQuery(this);
			var classes = selectedTR.attr('class').split(' ');
			classes.pop(); // removes even / odd class from array
			classes.pop(); // removes hightlight_lead class from array
			
			$.each( classes, function( key, value ) {			
			if(selectedTR.find('td.'+value).length) {
				selectedTR.find('td.'+value).addClass('bg-flat-color-6');
				foundCell = 1;
			}
			});
			
			if(foundCell == 0) {
				selectedTR.find('td.status').addClass('bg-flat-color-6');
			}
		});
		}
        //responsive:true
    });

    $('#bootstrap-data-table-export, .bootstrap-data-table-export').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
	dom: 'Blfrtip',
	buttons: {
	  dom: {
	      button: {
		tag: 'button',
		className: ''
	     }   
	  },
          buttons: [
	     { extend: 'csv', text: 'Export to Csv',
		     exportOptions: { columns: "thead th:not(.noExport)",
		     format   : {
			body: function(data, row, col, node) {
				if ($(node).find('a').length) 
					return $(node).find('a').text();
				else if ($(node).find('select').length) 
					return $(node).find(':selected').text();

				return data;
			}
		     }
		     }
		},
		{ extend: 'excel', text: 'Export to Excel',
		     exportOptions: { columns: "thead th:not(.noExport)",
		     format   : {
			body: function(data, row, col, node) {
				if ($(node).find('a').length) 
					return $(node).find('a').text();
				else if ($(node).find('select').length) 
					return $(node).find(':selected').text();

				return data;
			}
		     }
		     }
		}
	  ]
	},
	"drawCallback": function( settings ) {
		var api = this.api();
		var current_page_record =  api.rows( {page:'current'} ).data().length;
		var total_record = api.rows().data().length;
		var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
		if(current_page_record >= total_record) { $(pagination).hide(); }
		else { $(pagination).show();}
	}
        // responsive:true
    });

/*    $('#bootstrap-data-table-export-1, .bootstrap-data-table-export-1').DataTable({
    
        "processing": true,
        "serverSide": true,
        "ajax": "/leads/index.php"
   
    });*/

    /*$('#bootstrap-data-table-export-2, .bootstrap-data-table-export').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
	//order: [dtorder]
    });*/
	

    $('#row-select, .row-select').DataTable( {
        initComplete: function () {
		this.api().columns().every( function () {
			var column = this;
			var select = $('<select class="form-control"><option value=""></option></select>')
			.appendTo( $(column.footer()).empty() )
			.on( 'change', function () {
				var val = $.fn.dataTable.util.escapeRegex(
				$(this).val()
			);
			column
				.search( val ? '^'+val+'$' : '', true, false )
				.draw();
			});

			column.data().unique().sort().each( function ( d, j ) {
				select.append( '<option value="'+d+'">'+d+'</option>' )
			} );
		});
	}
    });
})(jQuery);
