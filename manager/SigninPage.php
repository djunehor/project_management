<?php
require '../includes/config.php';
require '../includes/functions.php';
if(isset($_SESSION['managerID']))
{
$detail = 'Last seen on <b>'.$_SERVER['HTTP_REFERER'].'</b>';
ActivityLog($con,$detail,$_SESSION['managerID']);
unset($_SESSION['managerID']);
}
elseif(isset($_COOKIE['managerID'])){
$detail = 'Last seen on <b>'.$_SERVER['HTTP_REFERER'].'</b>';
ActivityLog($con,$detail,$_COOKIE['managerID']);	
	setcookie("managerID", "", time() - 3600);
	}
$page_name = "SIGN IN | Manager";
include '../views/special_header.php';
?>

<form id="login_form" role="form">
        <div class="form-group">
          <input type="text" class="form-control" name="email" onblur="check_email(this.value)" id="email" placeholder="Enter your email" required >
        </div><!-- form-group -->
		<div class=" alert alert-danger em_error_show" style="display:none"></div>
        <div class="form-group">
          <input type="password" class="form-control" onblur="check_pw(this.value)" name="password" id="password" placeholder="Enter your password" required >
        </div><!-- form-group -->
        <div class=" alert alert-danger pw_error_show" style="display:none"></div>
        <input type="checkbox" name="remember" onchange="check_cookie(this.value)" value="1"> Remember me for 30 days
        <button id="btnSubmit" type="submit" class="btn btn-info btn-block">Sign In</button>
</form>
        <div class="mg-t-40 tx-center">Don't have an account? <a href="SignupPage" class="tx-info">Sign Up</a></div>
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
	$("#login_form").on('submit',(function(e) {
		e.preventDefault();
		$('.loading').show();
		$('.success').hide();
		$('.error').hide();
		$('#finish').attr('disabled','disabled');
		$.ajax({
			url: "<?php echo $website_url; ?>/ajax_form_process?value=login",
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
function check_cookie(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=cookie",{ucook:value},function(data){
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