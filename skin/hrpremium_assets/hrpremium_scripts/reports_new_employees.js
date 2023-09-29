$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"reports/request_list_hrd/",
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
		url : base_url+"/reports/read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=company&company_id='+company_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
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
});