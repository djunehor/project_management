<?php
include '../includes/config.php';
$tid = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM $employee_table WHERE employeeID='$tid'")) != 1) {
    header('HTTP/1.0 404 Forbidden');
    exit;
}
$page_name = 'View Contractor';
include '../views/manager_header.php';
$omo = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $employee_table WHERE employeeID='$tid'"));
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
          <h4 class="card-body-title" style="background-color:green;color:white; padding:2px;"><?php echo $omo['fullname']; ?></h4>
          <?php echo html_entity_decode(htmlspecialchars_decode($omo['jobDesc'])); ?>
		  <div class=" alert alert-danger ptask_error_show" style="display:none"></div>
		  <table class="table table-white table-responsive mg-b-0 tx-12" style="border: 1px solid red;">
		  <thead>
		  <tr>
		  <td>Email</td>
		  <td>Phone</td>
		  <td>Website</td>
		  <td>Photo</td>
		  </tr>
		  </thead>
		  <tbody>
		  <tr>
		  <td><?php echo $omo['email']; ?></td>
		  <td><?php echo $omo['phone']; ?></td>
		  <td><a href="<?php echo $omo['website']; ?>"><?php echo $omo['website']; ?></a></td> 
		  <td><a target="_blank" href="<?php echo $omo['photo']; ?>"><img width="50px" height="50px" src="<?php echo $omo['photo']; ?>" /></a></td> 
		  </tr>
		  </tbody>
		  </table>
				     <script src="../lib/jquery/jquery.js"></script>
        </div><!-- card -->
		

    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>	
	<script src="../js/starlight.js"></script>
</div>

    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>