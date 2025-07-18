$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/request_list_hrd/",
            type : 'GET'
        },
		dom: 'lBfrtip',
		"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
	$('[data-plugin="xin_select"]').select2({ width:'100%' }); 
	
		
	/* Delete data */
	$("#delete_record").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);		
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);					
				}
			}
		});
	});
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var company_id = button.data('company_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=company&company_id='+company_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	
	// view
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var company_id = button.data('company_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_company&company_id='+company_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
	

	jQuery("#aj_project").change(function(){
		jQuery.get(base_url+"/get_project_sub_project/"+jQuery(this).val(), function(data, status){
			jQuery('#project_sub_project').html(data);
		});
		// jQuery.get(base_url+"/get_company_office_shifts/"+jQuery(this).val(), function(data, status){
		// 	jQuery('#ajax_office_shift').html(data);
		// });
	});
	
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'company');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		
		$.ajax({
			url: base_url+'/request_add_employee/',//e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,

			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					$('#xin-form')[0].reset(); // To reset form fields
					$('.add-form').removeClass('in');
					$('.select2-selection__rendered').html('--Select--');
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} 	        
	   });
	});


	/* attendance datewise report */
	$("#emp_pkwt_request").submit(function(e){
		/*Form Submit*/
		e.preventDefault();

		// var company_id = document.getElementById("aj_company").value;
		var project_id = document.getElementById("aj_project").value;
		
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				
				url : site_url+"Employee_request_hrd/request_list_hrd/"+project_id+"/",
				// url : site_url+"reports/empdtwise_attendance_list/"+project_id+"/"+subproject_id+"/"+area_emp+"/"+start_date+"/"+end_date+"/",
				// url : site_url+"reports/empdtwise_attendance_list/"+company_id+"/"+project_id+"/"+subproject_id+"/"+start_date+"/"+end_date+"/",
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
	//open the lateral panel
	$( document ).on( "click", ".cd-btn", function() {
		event.preventDefault();
		var company_id = $(this).data('company_id');
		$.ajax({
		url : site_url+"company/read_info/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_company&company_id='+company_id,
		success: function (response) {
			if(response) {
				//alert(response);
				$('.cd-panel').addClass('is-visible');
				$("#cd-panel").html(response);
			}
		}
		});
		
	});
	//clode the lateral panel
	$( document ).on( "click", ".cd-panel", function() {
		if( $(event.target).is('.cd-panel') || $(event.target).is('.cd-panel-close') ) { 
			$('.cd-panel').removeClass('is-visible');
			event.preventDefault();
		}
	});
	
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});