$(document).ready(function(){
	$('input[name="autopassword"]').click(function(){
		var boxes = $('input[name="autopassword"]:checked').val();
		if(boxes==1){
			$('input[name="password"]').removeAttr('required');
			$('.repass').css('color','#fff');
		}else{
			$('input[name="password"]').attr('required','required');
			$('.repass').css('color','#FF0000');
		}
	});
});