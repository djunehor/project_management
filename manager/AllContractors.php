<?php
$page_name = 'All Contractors';
include '../views/manager_header.php'; ?>
 <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/highlightjs/github.css" rel="stylesheet">
    <link href="../lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="../lib/select2/css/select2.min.css" rel="stylesheet">

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
          <h6 class="card-body-title">All Contractors</h6>
         <p class="mg-b-20 mg-sm-b-30">List of all contractors working with you.</p>

          <div class="table-wrapper">
		   <div class=" alert alert-danger pname_error_show" style="display:none"></div>
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-20p">Task Title</th>
                  <th class="wd-10p">Duration</th>
                  <th class="wd-10p">Status</th>
                  <th class="wd-10p">FullName</th>
                  <th class="wd-10p">Email</th>
                  <th class="wd-10p">Website</th>
                  <th class="wd-10p">Phone</th>
                  <th class="wd-15p"></th>
                </tr>
              </thead>
			  <tbody>
			  <?php
              $q8 = mysqli_query($con, "select * from $project_table inner join $task_table on $project_table.projectID=$task_table.projectID inner join $assigned_table on $task_table.taskID=$assigned_table.taskID inner join $employee_table on $assigned_table.employeeEmail=$employee_table.email where $project_table.managerID='$managerID'") or die(mysqli_error($con));
               while ($v = mysqli_fetch_assoc($q8)) {
                   ?>
                <tr class="<?php echo $v['id']; ?>">
                  <td><a href="ViewTask?id=<?php echo $v['taskID']; ?>"><?php echo $v['ttitle']; ?></a></td>
                  <td><?php echo $v['duration'].' hours'; ?></td>
                  <td><?php $e = mysqli_fetch_assoc(mysqli_query($con, "SELECT sdetail FROM $status_table WHERE statusID='".$v['astatus']."'"));
                   echo $e['sdetail']; ?></td>
                  <td><?php echo $v['fullname']; ?></td>
                  <td><a href="ViewContractor?id=<?php echo $v['employeeID']; ?>"><?php echo $v['email']; ?></a></td>
                  <td><a href="<?php echo $v['website']; ?>"><?php echo $v['website']; ?></a></td>
                  <td><a href="tel:<?php echo $v['phone']; ?>"><?php echo $v['phone']; ?></a></td>
				  <td><button onclick="del_con(this.value)" id="btnDelete" type="submit" value="<?php echo $v['employeeEmail']; ?>" class="btn btn-info">Delete</button></td>
                </tr>
 <?php
               } ?>
				 </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
		<script>
		function del_con(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=del_con",{pid:value},function(data){
		if(data.length != 0){
			$('.pname_error_show').show();
			$('.pname_error_show').html(data);
		$('.pname_error_show').show();
		}else{
			$('.pname_error_show').hide();
			$('#btnDelete').removeAttr('disabled');
		}
	});
}
		$('#datatable1').DataTable({
responsive: true,
language: {
  searchPlaceholder: 'Search...',
  sSearch: '',
  lengthMenu: '_MENU_ items/page',
}
});</script>
 <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
    <script src="../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="../lib/highlightjs/highlight.pack.js"></script>
    <script src="../lib/datatables/jquery.dataTables.js"></script>
    <script src="../lib/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../lib/select2/js/select2.min.js"></script>

    <script src="../js/starlight.js"></script>
    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script> 
</div>

    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>