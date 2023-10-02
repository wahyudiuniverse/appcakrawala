$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"reports/report_manage_employees_list/0/0/0/0/0/",
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
	
	// get departments
	// jQuery("#aj_company").change(function(){
	// 	var c_id = jQuery(this).val();
	// 	jQuery.get(base_url+"/get_departments/"+c_id, function(data, status){
	// 		jQuery('#department_ajax').html(data);			
	// 	});

	jQuery("#aj_company").change(function(){
		jQuery.get(base_url+"/get_comp_project/"+jQuery(this).val(), function(data, status){
			jQuery('#project_ajax').html(data);
		});
	});
		
		//get project
	jQuery("#aj_project").change(function(){
		var p_id = jQuery(this).val();
		jQuery.get(base_url+"/get_subprojects/"+p_id, function(data, status){
			jQuery('#subproject_ajax').html(data);			
		});
	});
	/* projects report */
	$("#employee_reports").submit(function(e){
		/*Form Submit*/
		e.preventDefault();
		var company_id = $('#aj_company').val();
		var department_id = $('#aj_department').val();
		var project_id = $('#aj_project').val();
		var subproject_id = $('#aj_subproject').val();
		var status_resign = $('#aj_status').val();
		var xin_table2 = $('#xin_table').dataTable({
			"bDestroy": true,
			"ajax": {
				url : site_url+"reports/report_manage_employees_list/"+company_id+"/"+department_id+"/"+project_id+"/"+subproject_id+"/"+status_resign+"/",
				type : 'GET'
			},
			dom: 'lBfrtip',
			// "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
		});
		toastr.success('Request Submit.');
		// xin_table2.api().ajax.reload(function(){ }, true);
		
		xin_table2.api().ajax.reload(function(){ Ladda.stopAll(); }, true);
	});
});