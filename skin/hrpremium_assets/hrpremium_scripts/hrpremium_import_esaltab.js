
$(document).ready(function(){	
    $('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
	$('[data-plugin="xin_select"]').select2({ width:'100%' }); 

    // $('#sub_project_id').select2({
    //     width: '100%'
    // });

//    var saltab_table = $('#saltab_table').dataTable({
//         "bDestroy": true,
// 		"ajax": {
//             url : base_url+"/history_upload_esaltab_list/",
//             type : 'GET'
//         },
// 		dom: 'lBfrtip',
// 		"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
// 		"fnDrawCallback": function(settings){
// 		$('[data-toggle="tooltip"]').tooltip();          
// 		}
//     });


});

