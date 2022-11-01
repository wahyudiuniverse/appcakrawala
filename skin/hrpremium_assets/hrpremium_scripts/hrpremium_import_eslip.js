
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


});

