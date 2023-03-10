$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({ 
        "bDestroy": true,
		"ajax": {
            url : site_url+"reports/empdtwise_order/0/0/0/0/",
            type : 'GET'
        },
		dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_company_project/"+jQuery(this).val(), function(data, status){
			jQuery('#project_ajax').html(data);
		});
	});

	// Month & Year
	$('.attendance_date').datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: '0',
		dateFormat:'yy-mm-dd',
		altField: "#date_format",
		altFormat: js_date_format,
		yearRange: '1970:' + new Date().getFullYear(),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
	});
	$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var ipaddress = button.data('ipaddress');
	var modal = $(this);
	$.ajax({
		url :  site_url+"/timesheet/read_map_info/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_map&type=view_map&ipaddress='+ipaddress,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
		
	/* attendance datewise report */
	$("#attendance_datewise_report").submit(function(e){
		/*Form Submit*/
		e.preventDefault();

		var company_id = document.getElementById("aj_company").value;
		var project_id = document.getElementById("aj_project").value;
		var subproject_id = document.getElementById("aj_subproject").value;
		var start_date = document.getElementById("start_date").value;
		var end_date = document.getElementById("end_date").value;
		
		// var company_id = $('#aj_company').val();
		// var project_id = $('#aj_project').val();
		// var subproject_id = $('#aj_subproject').val();
		// var start_date = $('#start_date').val();
		// var end_date = $('#end_date').val();
		// var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"reports/empdtwise_order/"+company_id+"/"+project_id+"/"+subproject_id+"/"+start_date+"/"+end_date+"/",
				type : 'GET'
			},
			dom: 'lBfrtip',
			"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		toastr.success('Request Submit.');
		// xin_table2.api().ajax.reload(function(){ }, true);
		xin_table2.api().ajax.reload(function(){ Ladda.stopAll(); }, true);
	});

});