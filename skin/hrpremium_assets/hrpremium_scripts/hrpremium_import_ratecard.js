$(document).ready(function(){	

	/* Add data */ /*Form Submit*/
	$("#import_newemp_temp").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 3);
		fd.append("type", 'imp_employees');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		//$('#hrload-img').show();
		//toastr.info(processing_request);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.success(JSON.result);
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					$('#import_users_temp')[0].reset(); // To reset form fields
					
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				//toastr.clear();
				//$('#hrload-img').hide();
				toastr.error(JSON.error);
				$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} 	        
	   });
	});


   var xin_table = $('#xin_table_temp').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/import_list_newemp/",
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
   
	/* Add data */ /*Form Submit*/
	$("#import_users").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 3);
		fd.append("type", 'imp_employees');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		//$('#hrload-img').show();
		//toastr.info(processing_request);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.success(JSON.result);
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					$('#import_users')[0].reset(); // To reset form fields
					
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				//toastr.clear();
				//$('#hrload-img').hide();
				toastr.error(JSON.error);
				$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} 	        
	   });
	});

	/* Add data */ /*Form Submit*/


	/* Add data */ /*Form Submit*/
	$("#import_newemp_temp").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 3);
		fd.append("type", 'imp_employees');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		//$('#hrload-img').show();
		//toastr.info(processing_request);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.error(JSON.error);
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					//toastr.clear();
					//$('#hrload-img').hide();
					toastr.success(JSON.result);
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					$('#import_pkwt_temp')[0].reset(); // To reset form fields
					
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				//toastr.clear();
				//$('#hrload-img').hide();
				toastr.error(JSON.error);
				$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			} 	        
	   });
	});


	$(".nav-tabs-link").click(function(){
		var import_id = $(this).data('hrpremium-import');
		var hrpremium_import_block = $(this).data('hrpremium-import-block');
		$('.list-group-item').removeClass('active');
		$('.current-tab').hide();
		$('#hrpremium_import_'+import_id).addClass('active');
		$('#'+hrpremium_import_block).show();
	});	
});
