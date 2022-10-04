$(document).ready(function(){	
	
	$('.policy').on('show.bs.modal', function (event) {
	$.ajax({
		url: site_url+'settings/policy_read/',
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=policy&type=policy&p=1',
		success: function (response) {
			if(response) {
				$("#policy_modal").html(response);
			}
		}
		});
	});
	
	jQuery(".hrpremium_layout").change(function(){
		if($('#fixed_layout_hrpremium').is(':checked')){
			var fixed_layout_hrpremium = $("#fixed_layout_hrpremium").val();
			
		} else {
			var fixed_layout_hrpremium = '';
		}
		if($('#boxed_layout_hrpremium').is(':checked')){
			var boxed_layout_hrpremium = $("#boxed_layout_hrpremium").val();
		} else {
			var boxed_layout_hrpremium = '';
		}
		if($('#sidebar_layout_hrpremium').is(':checked')){
			var sidebar_layout_hrpremium = $("#sidebar_layout_hrpremium").val();
		} else {
			var sidebar_layout_hrpremium = '';
		}
	
		$.ajax({
			type: "GET",  url: site_url+"settings/layout_skin_info/?is_ajax=2&type=hrpremium_layout_info&form=2&fixed_layout_hrpremium="+fixed_layout_hrpremium+"&boxed_layout_hrpremium="+boxed_layout_hrpremium+"&sidebar_layout_hrpremium="+sidebar_layout_hrpremium+"&user_session_id="+user_session_id,
			//data: order,
			success: function(response) {
				if (response.error != '') {
					toastr.error(response.error);
				} else {
					toastr.success(response.result);	
				}
			}
		});
	});
	//
	jQuery("#fixed_layout_hrpremium").click(function(){
		if($('#fixed_layout_hrpremium').is(':checked')){
			//$('#boxed_layout_hrpremium').prop('checked', false);
		}
	});
	jQuery("#boxed_layout_hrpremium").click(function(){
		if($('#boxed_layout_hrpremium').is(':checked')){
			$('.hrpremium-layout').removeClass('fixed');
			$('#fixed_layout_hrpremium').prop('checked', false);
		}
	});
});