$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/pkwt_list/",
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
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	// jQuery("#aj_company").change(function(){
	// 	jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
	// 		jQuery('#employee_ajax').html(data);
	// 	});
	// });
		
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
	$('.add-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var invoice_id = button.data('invoice_id');
	var modal = $(this);
	$.ajax({
		url :  base_url+"/read_invoice_data/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_invoice_status&edit=status&invoice_id='+invoice_id,
		success: function (response) {
			if(response) {
				$("#add_ajax_modal").html(response);
			}
		}
		});
	});


/* Add data */ /*Form Submit*/
$("#xin-form").submit(function(e){
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	$.ajax({
		type: "POST",
		url: base_url+'/add_pkwt/',
		data: obj.serialize()+"&is_ajax=1&add_type=location&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
				Ladda.stopAll();
			} else {
				xin_table.api().ajax.reload(function(){ 
					toastr.success(JSON.result);
				}, true);
				$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('#xin-form')[0].reset(); // To reset form fields
				$('.add-form').removeClass('show');
				$('.select2-selection__rendered').html('--Select--');
				$('.save').prop('disabled', false);
				Ladda.stopAll();
			}
		}
	});
});

});
	
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete/'+$(this).data('record-id'));
});

 $( document ).on( "click", ".approve", function() {
	
	jQuery.get(base_url+"/update_pkwt_approve/"+jQuery(this).data('user-id'), function(data, status) {

		// var xin_table = $('#xin_table').dataTable({
		// 	"bDestroy": true,
		// 	"ajax": {
		// 		url : base_url+"/view_import_excel_employees/?upid="+$('#uploadid').val(),
		// 		type : 'GET'
		// 	},
		// dom: 'lBfrtip',
		// "buttons": ['csv', 'excel', 'pdf', 'print'],
		// 	"fnDrawCallback": function(settings){
		// 	$('[data-toggle="tooltip"]').tooltip();          
		// 	}
		// });
		// window.location.href = window.location.href;

		xin_table.api().ajax.reload(function(){

			toastr.success(data);
		}, true);
	});
});