<?php
include '../includes/config.php';
$tid = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM $project_table WHERE projectID='$tid'")) != 1) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}
$omo = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $project_table WHERE projectID='$tid'"));
$page_name = $omo['title'].' | Projects';
include '../views/manager_header.php';
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
          <h4 class="card-body-title" style="background-color:green;color:white; padding:2px;"><?php echo $omo['title']; ?></h4>
          <?php echo html_entity_decode(htmlspecialchars_decode($omo['detail'])); ?>
		  <div class=" alert alert-danger pname_error_show" style="display:none"></div>
		  <table class="table table-white table-responsive mg-b-0 tx-12" style="border: 1px solid red;">
		  <thead>
		  <tr>
		  <td>Start Date</td>
		  <td>End Date</td>
		  <td>Budget</td>
		  <td>Status</td>
		  <td>Action</td>
		  </tr>
		  </thead>
		  <tbody>
		  <tr>
		  <td><?php echo date('d-M-Y', $omo['startDate']); ?></td>
		  <td><?php echo date('d-M-Y', $omo['endDate']); ?></td>
		  <td><?php echo '&#x20A6;'.number_format($omo['budget']); ?></td>
		  <td><?php $s = mysqli_fetch_assoc(mysqli_query($con, "SELECT sdetail FROM $status_table WHERE statusID='".$omo['status']."'")); echo $s['sdetail']; ?></td>
		  <?php if ($omo['projectStatus'] == 0) { ?>
                  <td><button onclick="start_project(this.value)" id="btnStart" type="submit" value="<?php echo $omo['projectID']; ?>" class="btn btn-success">Mark As started</button></td> <?php } ?>
                  
		  </tr>
		  </tbody>
		  </table><br><hr>
		   <h4 class="card-body-title" style="background-color:blue;color:white; padding:2px;">Milestones</h4>
		   <div class=" alert alert-danger pmile_error_show" style="display:none"></div>
				<table class="table table-white table-responsive mg-b-0 tx-12" style="border: 1px solid yellow;margin:5px;">
		  <thead>
		  <tr>
		  <td>ID</td>
		  <td>Title</td>
		  <td>Description</td>
		  <td>Date</td>
		  <td>Tag</td>
		  <td>Action</td>
		  <td></td>
		  </tr>
		  </thead>
		  <tbody>
<?php
$g = mysqli_query($con, "SELECT * FROM $milestone_table WHERE projectID='".$omo['projectID']."'");
while ($om = mysqli_fetch_assoc($g)) {
    ?>	
<tr class="<?php echo $om['milestoneID']; ?>">
		  <td><?php echo $om['milestoneID']; ?></td>
		  <td><a href="ViewMilestone?id=<?php echo $om['milestoneID']; ?>"><?php echo $om['mtitle']; ?></a></td>
		  <td><?php echo substr(html_entity_decode(htmlspecialchars_decode($om['mdetail'])), 0, 100); ?></td>
		  <td><?php echo date('d-M-Y', $om['startDate']); ?></td>
		  <td><?php $s = mysqli_fetch_assoc(mysqli_query($con, "SELECT detail FROM $tag_table WHERE tagID='".$om['tagID']."'"));
    echo $s['detail']; ?></td>
<td><form action="EditMilestone?id=<?php echo $om['milestoneID']; ?>"><button id="btnEdit" type="submit" class="btn btn-info">Edit</button></form></td>
                  <td><button onclick="del_mile(this.value)" id="btnDelete" type="submit" value="<?php echo $om['milestoneID']; ?>" class="btn btn-danger">Delete</button></td>
               		 
		 </tr>
<?php
} ?>
		  </tbody><tfoot><tr><a style="text-align:right;" href="NewMilestone">Add New Milestone</a></tr></tfoot>
				</table>
				<br><hr>
		   <h4 class="card-body-title" style="background-color:red;color:white; padding:2px;">Tasks</h4>
		   <div class=" alert alert-danger ptask_error_show" style="display:none"></div>
				<table class="table table-white table-responsive mg-b-0 tx-12" style="border: 1px solid yellow;margin:7px;">
		  <thead>
		  <tr>
		  <td>ID</td>
		  <td>Title</td>
		  <td>Description</td>
		  <td>Duration</td>
		  <td>Status</td>
		  
		  <td>Assign Date</td>
		  <td>Employee</td>
		  <td>Action</td>
		  <td></td>
		  </tr>
		  </thead>
		  <tbody>
<?php
$g = mysqli_query($con, "SELECT * FROM $task_table WHERE projectID='".$omo['projectID']."'");
while ($o = mysqli_fetch_assoc($g)) {
    ?>	
<tr class="<?php echo $o['taskID']; ?>">
		  <td><?php echo $o['taskID']; ?></td>
		  <td><a href="ViewTask?id=<?php echo $omo['taskID']; ?>"><?php echo $o['ttitle']; ?></a></td>
		  <td><?php echo substr(html_entity_decode(htmlspecialchars_decode($o['tdetail'])), 0, 50); ?></td>
		  <td><?php echo $o['duration'].' hours'; ?></td>
		  <td><?php $s = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $assigned_table LEFT JOIN $status_table ON $assigned_table.astatus=$status_table.statusID WHERE taskID='".$o['taskID']."'"));
    echo $s['sdetail'] ? $s['sdetail'] : 'Not Assigned'; ?></td>
		  
		  <td><?php echo $s['startDate'] ? date('d-M-Y', $s['startDate']) : 'Not Assigned'; ?></td>
		  <td><?php echo $s['employeeEmail'] ? $s['employeeEmail'] : 'Not Assigned'; ?></td>
		  <td><form action="EditTask?id=<?php echo $o['taskID']; ?>"><button id="btnEdit" type="submit" class="btn btn-info">Edit</button></form></td>
                  <td><button onclick="del_task(this.value)" id="btnDelete" type="submit" value="<?php echo $o['taskID']; ?>" class="btn btn-danger">Delete</button></td>
                
		  </tr>
<?php
} ?>
		  </tbody><tfoot><tr><a style="text-align:right;" href="NewTask">Add New Task</a></tr></tfoot>
				</table>
				<br><hr>
		   <h4 class="card-body-title" style="background-color:brown;color:white; padding:2px;">Activities</h4>
				<table class="table table-white table-responsive mg-b-0 tx-12" style="border: 1px solid brown;margin:9px;">
		  <thead>
		  <tr>
		  <td>Description</td>
		  <td>Date</td>
		  </tr>
		  </thead>
		  <tbody>
<?php
$l = mysqli_query($con, "SELECT * FROM $projectlog WHERE projectID='".$omo['projectID']."'");
while ($f = mysqli_fetch_assoc($l)) {
    ?>		  <tr>
		  <td><?php echo html_entity_decode(htmlspecialchars_decode($f['detail'])); ?></td>
		  <td><?php echo date('d-M-Y g:i a', $f['addDate']); ?></td>
		  </tr>
<?php
} ?>
		  </tbody>
				</table>
				     <script src="../lib/jquery/jquery.js"></script>
				<?php include_once '../includes/functions.php'; ?>
 <link href="../css/calendar-style.css" rel="stylesheet">	
<div id="calendar_div" style="border: 1px solid blue;">
	<?php echo getCalender(); ?>
</div>
        </div><!-- card -->
		

    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>	
<script>	function del_task(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=del_task",{pid:value},function(data){
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
function del_mile(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=del_mile",{pid:value},function(data){
		if(data.length != 0){
			$('.pmile_error_show').show();
			$('.pmile_error_show').html(data);
		$('.pmile_error_show').show();
		}else{
			$('.pmile_error_show').hide();
			$('#btnDelete').removeAttr('disabled');
		}
	});
}
function start_project(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=start_project",{pid:value},function(data){
		if(data.length != 0){
			$('.pname_error_show').show();
			$('.pname_error_show').html(data);
		}else{
			$('.pname_error_show').hide();
			$('#btnStart').removeAttr('disabled');
		}
	});
}
    </script>
	<script src="../js/starlight.js"></script>
</div>

    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>