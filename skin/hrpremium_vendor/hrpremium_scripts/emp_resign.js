$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/resign_list/",
            type : 'GET'
        },
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
					Ladda.stopAll();
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);		
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					Ladda.stopAll();					
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
	$('#modals-slide').on('show.bs.modal', function (event) {
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


			//get project
	jQuery("#aj_project").change(function(){
		var p_id = jQuery(this).val();
		jQuery.get(base_url+"/get_project_employees/"+p_id, function(data, status){
			jQuery('#project_employees_ajax').html(data);			
		});
	});

			//get project
	jQuery("#aj_ktp").change(function(){
		var p_id = jQuery(this).val();
		jQuery.get(base_url+"/get_ktp/"+p_id, function(data, status){
			jQuery('#ktp_ajax').html(data);			
		});
	});
	
	// get departments
	jQuery("#aj_ktp").change(function(){
		jQuery.get(base_url+"/get_info/"+jQuery(this).val(), function(data, status){
			jQuery('#info_ajax').html(data);
		});
	});
				//get project
	jQuery("#aj_ktp").change(function(){
		var p_id = jQuery(this).val();
		jQuery.get(base_url+"/get_ket/"+p_id, function(data, status){
			jQuery('#ket_ajax').html(data);			
		});
	});
					//get project
	jQuery("#aj_ktp").change(function(){
		var p_id = jQuery(this).val();
		jQuery.get(base_url+"/get_rdate/"+p_id, function(data, status){
			jQuery('#rdate_ajax').html(data);			
		});
	});

	// get departments
	jQuery("#aj_dokumen").change(function(){
		var s_id = jQuery(this).val();
		var p_id = document.getElementById("aj_project").value;
		jQuery.get(base_url+"/get_dokumen_resign/"+s_id+"/"+p_id, function(data, status){
			jQuery('#dokumen_ajax').html(data);
		});
	});


	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e) {
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("add_type", 'company');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		
		$.ajax({
			url: base_url+'/request_employee_resign/',//e.target.action,
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
					Ladda.stopAll();
				} else {
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					}, true);
					$('#xin-form')[0].reset(); // To reset form fields
					$('.add-form').removeClass('show');
					$('.select2-selection__rendered').html('--Select--');
					$('.save').prop('disabled', false);
					Ladda.stopAll();
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
					Ladda.stopAll();
			} 	        
	   });
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