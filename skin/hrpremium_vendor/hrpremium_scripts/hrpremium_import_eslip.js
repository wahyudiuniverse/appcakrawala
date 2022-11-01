
$(document).ready(function(){	

  var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/history_upload_eslip_list/",
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

});
