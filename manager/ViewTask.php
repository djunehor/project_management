<?php
include '../includes/config.php';
$tid = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM $task_table WHERE taskID='$tid'"))!=1) { header('HTTP/1.0 404 Forbidden');
          exit;}
$page_name = "View Task";
include '../views/manager_header.php';
$omo = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM $task_table LEFT JOIN $assigned_table ON $task_table.taskID=$assigned_table.taskID LEFT JOIN $employee_table ON $assigned_table.employeeEmail=$employee_table.email LEFT JOIN $status_table ON $task_table.status=$status_table.statusID WHERE $task_table.taskID='$tid'"));
 ?>
<link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/highlightjs/github.css" rel="stylesheet">
    <link href="../lib/jquery.steps/jquery.steps.css" rel="stylesheet">	

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
          <h4 class="card-body-title" style="background-color:green;color:white; padding:2px;"><?php echo $omo['ttitle']; ?></h4>
          <?php echo html_entity_decode(htmlspecialchars_decode($omo['tdetail'])); ?>
		  <div class=" alert alert-danger ptask_error_show" style="display:none"></div>
		  <table class="table table-white table-responsive mg-b-0 tx-12" style="border: 1px solid red;">
		  <thead>
		  <tr>
		  <td>Assign Date</td>
		  <td>Employee Email</td>
		  <td>Phone</td>
		  <td>Website</td>
		  <td>Status</td>
		  <td>Duration</td>
		  <td>Action</td>
		  </tr>
		  </thead>
		  <tbody>
		  <tr>
		  <td><?php echo $omo['startDate']?date('d-M-Y',$omo['startDate']):'-'; ?></td>
		  <td><a href="ViewContractor?id=<?php echo $omo['employeeID']; ?>"><?php echo $omo['email']; ?></a></td>
		  <td><?php echo $omo['phone']; ?></td>
		  <td><a href="<?php echo $omo['website']; ?>"><?php echo $omo['website']; ?></a></td>
		  <td><?php echo $omo['sdetail']; ?></td>
		  <td><?php echo $omo['duration']." hours"; ?></td>
		  <td><button onclick="del_con(this.value)" id="btnDelete" type="submit" value="<?php echo $omo['employeeEmail']; ?>" class="btn btn-info">Delete</button></td>
                
		  </tr>
		  </tbody>
		  </table>
				     <script src="../lib/jquery/jquery.js"></script>
        </div><!-- card -->
		

    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>	
<script>	function del_task(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=del_con",{pid:value},function(data){
		if(data.length != 0){
			$('.ptask_error_show').show();
			$('.ptask_error_show').html(data);
		$('.ptask_error_show').show();
		}else{
			$('.ptask_error_show').hide();
			$('#btnDelete').removeAttr('disabled');
		}
	});
}	
    </script>
	<script src="../js/starlight.js"></script>
</div>

    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>