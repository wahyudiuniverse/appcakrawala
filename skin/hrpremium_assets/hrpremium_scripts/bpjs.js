$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/usermobile_list/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 

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
						$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					}, true);							
				}
			}
		});
	});


	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_comp_project/"+jQuery(this).val(), function(data, status){
			jQuery('#project_ajax').html(data);
		});
	});


	jQuery("#aj_project").change(function(){
		jQuery.get(base_url+"/get_subprojects/"+jQuery(this).val(), function(data, status){
			jQuery('#subproject_ajax').html(data);
		});
	});

	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var department_id = button.data('usermobile_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/read/",
		type: "GET",
		data: escapeHtmlSecure('jd=1&is_ajax=1&mode=modal&data=department&department_id='+ department_id),
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});

	/* projects report */
	$("#employee_mobile").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var company_id = $('#aj_company').val();
		var project_id = $('#aj_project').val();
		var subproject_id = $('#aj_subproject').val();

		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"usermobile/usermobile_list/"+company_id+"/"+project_id+"/"+subproject_id+"/",
				type : 'GET'
			},
			dom: 'lBfrtip',
			"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		toastr.success('Request Submit.');
		xin_table2.api().ajax.reload(function(){ Ladda.stopAll(); }, true);
	});
	

	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$('.icon-spinner3').show();
		$.ajax({
			type: "POST",
			url: base_url+'/add_usermobile/',
			data: obj.serialize()+"&is_ajax=1&add_type=usermobile&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
					$('.icon-spinner3').hide();
				} else {
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
						$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
					}, true);
					$('.icon-spinner3').hide();
					$('#xin-form')[0].reset(); // To reset form fields
					$('.select2-selection__rendered').html('--Select--');
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	var delUrl = base_url+'/delete/'+$(this).data('record-id');
	$('#delete_record').attr('action',escapeHtmlSecure(delUrl));
});
