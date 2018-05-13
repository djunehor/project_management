<?php
$page_name = "Update Profile";
include '../views/employee_header.php'; ?>
<link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/highlightjs/github.css" rel="stylesheet">
    <link href="../lib/jquery.steps/jquery.steps.css" rel="stylesheet">	

    <link href="../lib/summernote/summernote-bs4.css" rel="stylesheet">	
    <!-- Starlight CSS -->
    <link rel="stylesheet" href="../css/starlight.css">
    <!-- ########## START: MAIN PANEL ########## -->
  <div class="sl-mainpanel">
     <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index"><?php echo $option['website_name']; ?></a>
        <span class="breadcrumb-item active"><?php echo $page_name; ?></span>
      </nav>

      <div class="sl-pagebody">


        <div class="card pd-20 pd-sm-40 mg-t-50">
          <h6 class="card-body-title">Edit Your Profile</h6>
          <p class="mg-b-20 mg-sm-b-30">We suggest you complete your profile before proceeding</p>
<form id="update_profile" role="form" enctype="multipart/form-data">
          <div id="wizard1">
            <section>
         <!--     <p>Try the keyboard navigation by clicking arrow left or right!</p> -->
                <label class="form-control-label">FullName: <span class="tx-danger">*</span></label>
                <input class="form-control" name="fullname" placeholder="Enter full name" type="text">
            </section><br>
            <section>
          <!--    <p>Wonderful transition effects.</p>  -->
         
                <label class="form-control-label">Phone: <span class="tx-danger">*</span></label>
                <input onblur="check_number(this.value)" id="number" class="form-control" name="phone" type="number" />
          <div class=" alert alert-danger pnum_error_show" style="display:none"></div>
            </section><br>
			 <section>
                <label class="form-control-label">Photo: <span class="tx-danger">*</span></label>
                <input onblur="check_photo(this.value)" class="form-control" name="myphoto" type="file">
				  <div class=" alert alert-danger pphoto_error_show" style="display:none"></div>
            </section><br>
			<section>
                <label class="form-control-label">Website: <span class="tx-danger">*</span></label>
                <input onblur="check_url(this.value)" class="form-control" name="website" type="text">
				  <div class=" alert alert-danger purl_error_show" style="display:none"></div>
				  <br>
				  <label class="form-control-label">Skill Description: <span class="tx-danger">*</span></label>
                <textarea class="form-control" id="desc" name="jobdesc" type="text"></textarea>
            </section><br>
          </div>
		  <input type="hidden" value="<?php echo $_SESSION['employeeID']; ?>" name="employeeID">
		  <button id="btnSubmit" type="submit" class="btn btn-info btn-block">Update Profile</button></form>
		  <div style="display:none" class="alert alert-success success"></div>
													<div style="display:none" class="alert alert-info loading">Loading...</div>
													<div style="display:none" class="alert alert-danger error"></div>
	
        </div><!-- card -->
      </div><!-- sl-pagebody -->
     <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>	
    <script src="../lib/summernote/summernote-bs4.min.js"></script>
	<script>
	$(document).ready(function (e) {
	$("#update_profile").on('submit',(function(e) {
		e.preventDefault();
		$('.loading').show();
		$('.success').hide();
		$('.error').hide();
		$('#finish').attr('disabled','disabled');
		$.ajax({
			url: "<?php echo $website_url; ?>/ajax_form_process?value=eprofile",
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
function check_number(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=number",{unum:value},function(data){
		if(data.length != 0){
			$('.pnum_error_show').show();
			$('.pnum_error_show').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.pnum_error_show').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
function check_photo(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=photo",{uphoto:value},function(data){
		if(data.length != 0){
			$('.pphoto_error_show').show();
			$('.pphoto_error_show').html(data);
		//	$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.pphoto_error_show').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
function check_url(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=url",{uurl:value},function(data){
		if(data.length != 0){
			$('.purl_error_show').show();
			$('.purl_error_show').html(data);
		//	$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.purl_error_show').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
// Summernote editor
        $('#desc').summernote({
          height: 150,
          tooltip: false
        });
</script>
    <script src="../js/starlight.js"></script>	
	
    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>