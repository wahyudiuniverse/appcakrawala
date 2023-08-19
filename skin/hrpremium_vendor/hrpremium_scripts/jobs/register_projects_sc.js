$(document).ready(function() {
		
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		var ktp = document.getElementById("nomor_ktp").value ;
		fd.append("is_ajax", 1);
		fd.append("add_type", 'employer');
		fd.append("form", action);
		e.preventDefault();
		$('.save').prop('disabled', true);
		
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
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('.add-form').removeClass('show');
					$('#xin-form')[0].reset(); // To reset form fields
					$('.save').prop('disabled', false);
					window.location = base_url+'/success/' + ktp;
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('.save').prop('disabled', false);
			} 	        
	   });
	});



	jQuery("#aj_project").change(function(){
		jQuery.get(base_url+"/get_project_sub_project/"+jQuery(this).val(), function(data, status){
			jQuery('#projectsubproject').html(data);
		});
	});


	jQuery("#aj_project").change(function(){
		jQuery.get(base_url+"/get_project_posisi/"+jQuery(this).val(), function(data, status){
			jQuery('#project_position').html(data);
		});

	});

});
	
	