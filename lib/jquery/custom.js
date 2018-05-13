$(document).ready(function (e) {
	$("#login_form").on('submit',(function(e) {
		e.preventDefault();
		$('.loading').show();
		$('.success').hide();
		$('.error').hide();
		$('#btnSubmit').attr('disabled','disabled');
		$.ajax({
			url: "<?php echo $website_url."../"; ?>includes/login_process",
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data)
			{
				$('#btnSubmit').removeAttr('disabled');
				$('.loading').hide();
				if(data=="true"){
					$('.success').show();
					$('.error').hide();
					$('.success').html('Login Successful. Redirecting to Homepage in 5 seconds...');
					window.setTimeout(function(){ window.location = "<?php echo $website_url."ManagerPanel/"; ?>"; },5000);
				}else{
					$('.error').show();
					$('.success').hide();
					$('.error').html(data);
				}
			}
		});
	}));
});

function confirm_pw(value){
	var pw=$('#password').val();
	if(pw!=value){
		$('.pw_error_show').show();
		$('.pw_error_show').html('The same password should be entered in both fields. Please, re-enter the password correctly.');
		$('#btnSubmit').attr('disabled','disabled');
	}else{
		$('.pw_error_show').hide();
		$('#btnSubmit').removeAttr('disabled');
	}
}
function check_pw(value){
	$.post("<?php echo $website_url."../"; ?>includes/ajax_check_password.php",{pass:value},function(data){
		if(data.length != 0){
			$('.pw_error_show').show();
			$('.pw_error_show').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.pw_error_show').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
function check_email(value){
	$.post("<?php echo $website_url."../"; ?>includes/ajax_check_email.php",{mypass:value},function(data){
		if(data.length != 0){
			$('.em_error_show').show();
			$('.em_error_show').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.em_error_show').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}

$(document).ready(function (e) {
	$("#register_form").on('submit',(function(e) {
		e.preventDefault();
		$('.loading').show();
		$('.success').hide();
		$('.error').hide();
		$('#btnSubmit').attr('disabled','disabled');
		$.ajax({
			url: "<?php echo $website_url."../"; ?>includes/signup_process.php",
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data)
			{
				$('#btnSubmit').removeAttr('disabled');
				$('.loading').hide();
				if(data=="true"){
					$('.success').show();
					$('.error').hide();
					$('.success').html('Registration successful. Activation email has been sent');
				}else{
					$('.error').show();
					$('.success').hide();
					$('.error').html(data);
				}
			}
		});
	}));
});