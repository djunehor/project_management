<?php
include_once '../includes/config.php';
//error_reporting(E_ALL);
$id = $_GET['id'];
$project = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $project_table INNER JOIN $status_table
ON $project_table.projectStatus=$status_table.statusID WHERE projectID='$id'"));
$page_name = $project['title'].' | Projects';
include '../views/manager_header.php'; ?>
<link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/highlightjs/github.css" rel="stylesheet">
    <link href="../lib/jquery.steps/jquery.steps.css" rel="stylesheet">

<script src="https://cdn.ckeditor.com/4.7.3/standard-all/ckeditor.js"></script>
    <!-- Starlight CSS -->
    <link rel="stylesheet" href="../css/starlight.css">
    <!-- ########## START: MAIN PANEL ########## -->
  <div class="sl-mainpanel">
     <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index"><?php echo $option['website_name']; ?></a>
        <span class="breadcrumb-item active"><?php echo '<a href="AllActivities">All Projects</a> / '.$project['title']; ?></span>
      </nav>

      <div class="sl-pagebody">
 <div class="card pd-20 pd-sm-40 mg-t-50">
<h2><?php echo $project['title']; ?></h2>
<div style="border: 1px solid green;padding:0.5%;"><?php echo html_entity_decode(htmlspecialchars_decode($project['detail'])); ?><hr>
               <p><span style="float:left;color:blue;">
            Duration: <?php echo date('D M Y', $project['startDate']); ?> - <?php echo date('D M Y', $project['endDate']); ?></span>
           <span style="padding-left:20%;color:green">Budget: <?php echo 'NGN '.number_format($project['budget']); ?></span>
<span style="float:right;color:red"><?php echo $project['sdetail']; ?></span></p><hr>
<span style="color:black;text-decoration:underline;">Milestones</span>
 <div style="margin:1%;padding:1%;border: 1px solid black">
<?php
$as = mysqli_query($con, "SELECT * FROM $milestone_table INNER JOIN $status_table
ON $milestone_table.status=$status_table.statusID WHERE projectID='".$project['projectID']."'");
while ($m1 = mysqli_fetch_assoc($as)) {
    ?>
            <p><?php echo '<b>'.$m1['milestoneID'].'. '.$m1['details'].'</b>'; ?>
           <span style="padding-left:20%;color:red;"> Duration: <?php echo date('D M Y', $m1['startDate']); ?> - <?php echo date('D M Y', $m1['endDate']); ?></span>
            <span style="float:right;color:green;">Status: <?php echo $m1['sdetail']; ?></span>	</p><hr>
			<span style="color:black;text-decoration:underline;">Tasks</span>
<div style="margin-left:2%;padding:1%;border: 1px solid green">
<?php
$ap = mysqli_query($con, "SELECT * FROM $task_table INNER JOIN $status_table
ON $task_table.status=$status_table.statusID WHERE milestoneID='".$m1['milestoneID']."'");
    while ($t1 = mysqli_fetch_assoc($ap)) {
        ?>
<span style="float:left;color:blue;">
            <?php echo '<b>'.$t1['taskID'].'. '.$t1['tdetail'].'</b>'; ?></span>
           <span style="padding-left:20%;color:red;"> Duration: <?php echo date('D M Y', $t1['startDate']); ?> - <?php echo date('D M Y', $t1['endDate']); ?></span>
            <span style="float:right;color:green;">Status: <?php echo $t1['sdetail']; ?></span><br>
<br><span style="color:black;text-decoration:underline;">Contractors</span>			
			<div style="margin-left:3%;padding:1%;border: 1px solid red">
<?php
$ao = mysqli_query($con, "SELECT * FROM assigned INNER JOIN $employee_table
ON assigned.employeeID=$employee_table.employeeID WHERE assigned.taskID='".$t1['taskID']."'");
        while ($c1 = mysqli_fetch_assoc($ao)) {
            ?>
<span style="float:left;color:black;">
            <?php echo '<b>'.$c1['employeeID'].'. '.$c1['fullname'].'</b>'; ?></span><br>
           <span style="color:red;">Skills: <?php echo $c1['skills']; ?></span><br>
           <span style="color:blue;">Job description: <?php echo $c1['jobDesc']; ?></span>
            <br><span style="color:green;">Contact:<br>
			Email: <?php echo $c1['email']; ?><br>	 
			Phone: <?php echo $c1['phone']; ?><br>	 
			Website: <?php echo $c1['website']; ?></span><hr>	
	 <?php
        }
        if (mysqli_num_rows($ao) < 1) {
            echo 'No contractor assigned yet. <a href="AssignContractor?id='.$t1['taskID'].'">Assign Task</a>';
        } ?></div> <hr>	
	 <?php
    }
    if (mysqli_num_rows($ap) < 1) {
        echo 'No task created yet. <a href="NewTask?id='.$m1['milestoneID'].'">Create New Task</a>';
    } ?>	</div>	
	 <?php
}
if (mysqli_num_rows($as) < 1) {
    echo 'No milestone created yet. <a href="NewMilstone?id='.$project['projectID'].'">Create New Task</a>';
}
     ?></div>
</div>
      <!-- sl-pagebody -->
     <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
    <script src="../js/starlight.js"></script>
    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>