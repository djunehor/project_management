<?php
$page_name = 'View Task';
include '../views/employee_header.php';
$tid = $_GET['id'];
$omo = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $assigned_table INNER JOIN $task_table
ON $assigned_table.taskID=$task_table.taskID WHERE employeeEmail='".$employee['email']."' AND $assigned_table.taskID='$tid'"));
 ?>
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
	  <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title" style="background-color:green;color:white; padding:2px;"><?php echo $omo['ttitle']; ?></h6>
          <?php echo html_entity_decode(htmlspecialchars_decode($omo['tdetail'])); ?>
		   <div class=" alert alert-danger pname_error_show" style="display:none"></div>
		  <table class="table table-white table-responsive mg-b-0 tx-12" style="border: 1px solid red;">
		  <thead>
		  <tr>
		  <td>Assign Date</td>
		  <td>Duration</td>
		  <td>Deadline</td>
		  <td>Status</td>
		  <td>Additional Comments</td>
		  <td></td>
		  </tr>
		  </thead>
		  <tbody>
		  <tr>
		  <td><?php echo date('d-M-Y', $omo['startDate']); ?></td>
		  <td><?php echo $omo['duration'].' hours'; ?></td>
		  <td><?php echo date('d-M-Y', ($omo['startDate'] + ($omo['duration'] * 3600))); ?></td>
		  <td><?php $s = mysqli_fetch_assoc(mysqli_query($con, "SELECT sdetail FROM $status_table WHERE statusID='".$omo['status']."'")); echo $s['sdetail']; ?></td>
		  <td><?php echo html_entity_decode(htmlspecialchars_decode($omo['comment'])); ?></td>
		  <?php if ($omo['astatus'] == 0) { ?>
                  <td><button onclick="start_task(this.value)" id="btnStart" type="submit" value="<?php echo $omo['id']; ?>" class="btn btn-success">Mark As started</button></td> <?php } ?>
                
		  </tr>
		  </tbody>
		  </table>
<hr><h3>Fill the Form below if you've completed task</h3>
 <form id="task_com" role="form" enctype="multipart/form-data" style="border: 1px solid green;padding:5px;">
 <section>
  <label class="form-control-label">Comments: <span class="tx-danger">*</span></label>
                <textarea id="comment" class="form-control" name="tcomment"></textarea>
          <div class=" alert alert-danger pdesc_error_show" style="display:none"></div>
		  <br><label class="form-control-label">Total Cost: <span class="tx-danger">*</span></label>
                <input onblur="check_number(this.value)" id="number" class="form-control" name="tcost" type="number" />
          <div class=" alert alert-danger pnum_error_show" style="display:none"></div>
            </section><br>
			 <section>
                <label class="form-control-label">Photo: <span class="tx-danger">*</span></label>
                <input onblur="check_doc(this.value)" class="form-control" name="upload[]" type="file">
                <input onblur="check_doc(this.value)" class="form-control" name="upload[]" type="file">
                <input onblur="check_doc(this.value)" class="form-control" name="upload[]" type="file">
				  <div class=" alert alert-danger pphoto_error_show" style="display:none"></div>
            </section>  
<br>
		  <input type="hidden" value="<?php echo $employee['email']; ?>" name="employeeid">
		  <input type="hidden" value="<?php echo $omo['managerID']; ?>" name="managerid">
		  <input type="hidden" value="<?php echo $omo['projectID']; ?>" name="projectid">
		  <input type="hidden" value="<?php echo $omo['milestoneID']; ?>" name="milestoneid">
		  <input type="hidden" value="<?php echo $omo['taskID']; ?>" name="taskid">
		  <button id="btnSubmit" type="submit" class="btn btn-info btn-block">Task Completed</button>			
 </form>
 <div style="display:none" class="alert alert-success success"></div>
													<div style="display:none" class="alert alert-info loading">Loading...</div>
													<div style="display:none" class="alert alert-danger error"></div>
        </div><!-- card -->
		
     <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>	
	
    <script src="../lib/summernote/summernote-bs4.min.js"></script>
<script>
	$(document).ready(function (e) {
	$("#task_com").on('submit',(function(e) {
		e.preventDefault();
		$('.loading').show();
		$('.success').hide();
		$('.error').hide();
		$('#finish').attr('disabled','disabled');
		$.ajax({
			url: "<?php echo $website_url; ?>/ajax_form_process?value=task_com",
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
function check_doc(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=doc",{udoc:value},function(data){
		if(data.length != 0){
			$('.pphoto_error_show').show();
			$('.pphoto_error_show').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.pphoto_error_show').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
function start_task(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=start_task",{utask:value},function(data){
		if(data.length != 0){
			$('.pname_error_show').show();
			$('.pname_error_show').html(data);
		//	$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.pname_error_show').hide();
			$('#btnStart').removeAttr('disabled');
		}
	});
}
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
// Summernote editor
        $('#comment').summernote({
          height: 150,
          tooltip: false
        });
</script>	
    <script src="../js/starlight.js"></script>
</div>

    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>