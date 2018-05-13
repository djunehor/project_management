<?php
$page_name = "Assign Contractor";
include '../views/manager_header.php'; ?>
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
          <h6 class="card-body-title">Assign Task</h6>
          <p class="mg-b-20 mg-sm-b-30">Assign a Task to an Employee</p>
<form id="assign_task" role="form">
          <div id="wizard1">
            <section><label class="form-control-label">Project: <span class="tx-danger">*</span></label>
                <select onblur="check_task(this.value)" id="project" class="form-control" name="projectid">
       <?php
	  $oop  = mysqli_query($con,"SELECT * FROM $project_table WHERE managerID='$managerID'");
	  while($ool = mysqli_fetch_assoc($oop))
	  {
	 echo '<option value="'.$ool['projectID'].'">'.$ool['title'].'</option>';
	  }
	  ?>
			 </select><div class="milestonep" style="display:none"></div><div class="taskp" style="display:none"></div>
            </section><br>
            <section>
          <!--    <p>Wonderful transition effects.</p>  -->
         
                <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                <input onblur="check_email(this.value)" id="email" class="form-control" name="email" placeholder="Enter email" type="email" required />
          <div class=" alert alert-danger em_error_show" style="display:none"></div>
		   <br><label class="form-control-label">Additional Comments: <span class="tx-danger">*</span></label>
                <textarea id="mile_desc" class="form-control" name="comment" placeholder="comments here" type="text"></textarea>
          <div class=" alert alert-danger pdesc_error_show" style="display:none"></div>
            </section><br>
          </div>
		  <input name="managername" type="hidden" value="<?php echo $manager['fullname']; ?>" />
		  <input name="managerid" type="hidden" value="<?php echo $manager['managerID']; ?>" />
		  <button id="btnSubmit" type="submit" class="btn btn-info btn-block">Send Invitation</button></form>
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
	$("#assign_task").on('submit',(function(e) {
		e.preventDefault();
		$('.loading').show();
		$('.success').hide();
		$('.error').hide();
		$('#finish').attr('disabled','disabled');
		$.ajax({
			url: "<?php echo $website_url; ?>ajax_form_process?value=assign_task",
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
function check_task(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=ctask",{utask:value},function(data){
		if(data.length != 0){
			$('.milestonep').show();
			$('.milestonep').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.milestonep').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
function check_mile(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=cmil",{umil:value},function(data){
		if(data.length != 0){
			$('.taskp').show();
			$('.taskp').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.taskp').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
// Summernote editor
        $('#mile_desc').summernote({
          height: 150,
          tooltip: false
        });
</script>
    <script src="../js/starlight.js"></script>	
	
    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>