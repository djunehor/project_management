<?php require '../includes/config.php';
$page_name = 'SIGN UP | Employee';
include '../views/special_header.php';
?>

<form id="register_form" role="form">
        <div class="form-group">
          <input type="email" class="form-control" name="email" onblur="check_email(this.value)" id="email" placeholder="Enter your email" required >
        </div><!-- form-group -->
		<div class=" alert alert-danger em_error_show" style="display:none"></div>
        <div class="form-group">
          <input type="password" class="form-control" onblur="check_pw(this.value)" name="password" id="password" placeholder="Enter your password" required >
        </div><!-- form-group -->
        <div class="form-group">
        <input type="password" class="form-control" onblur="confirm_pw(this.value)"  name="confpass" id="confirm_pass" placeholder="Renter your password" required >
        </div><!-- form-group -->
        <div class=" alert alert-danger pw_error_show" style="display:none"></div>
        <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our <a href="../privacy-policy">privacy policy</a> and <a href="../terms-and-conditions">terms of use</a> of our website.</div>
		<input type="hidden" name="mytype" value="1">
        <button id="btnSubmit" type="submit" class="btn btn-info btn-block">Sign Up</button>
</form>
        <div class="mg-t-40 tx-center">Already have an account? <a href="SigninPage" class="tx-info">Sign In</a></div>
													<div style="display:none" class="alert alert-success success"></div>
													<div style="display:none" class="alert alert-info loading">Loading...</div>
													<div style="display:none" class="alert alert-danger error"></div>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->
    <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
	<script>
	$(document).ready(function (e) {
	$("#register_form").on('submit',(function(e) {
		e.preventDefault();
		$('.loading').show();
		$('.success').hide();
		$('.error').hide();
		$('#finish').attr('disabled','disabled');
		$.ajax({
			url: "<?php echo $website_url; ?>/ajax_form_process?value=eregister",
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data)
			{
				$('#finish').removeAttr('disabled');
				$('.loading').hide();
				
				if(data.search("Error")!=-1){
					$('.error').show();
					$('.success').hide();
					$('.error').html(data);
				}
				else{
					$('.success').show();
					$('.error').hide();
					$('.success').html(data);
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
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=password",{upass:value},function(data){
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
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=email",{uemail:value},function(data){
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
</script>

  </body>
</html>
