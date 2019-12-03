<?php
$page_name = 'All Tasks';
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
          <h6 class="card-body-title">All Tasks</h6>
         <p class="mg-b-20 mg-sm-b-30">List of all tasks created by you.</p>

          <div class="table-wrapper">
		   <div class=" alert alert-danger pname_error_show" style="display:none"></div>
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-20p">Task Title</th>
                  <th class="wd-15p">Detail</th>
                  <th class="wd-10p">Duration</th>
                  <th class="wd-10p">Contractor</th>
                  <th class="wd-10p">Action</th>
                  <th class="wd-15p"></th>
                </tr>
              </thead>
			  <tbody>
			  <?php
              $q8 = mysqli_query($con, "SELECT *,$task_table.taskID as tid FROM $task_table LEFT JOIN $assigned_table ON $task_table.taskID=$assigned_table.taskID WHERE $task_table.managerID='$managerID'");
               while ($v = mysqli_fetch_assoc($q8)) {
                   ?>
                <tr class="<?php echo $v['taskID']; ?>">
                  <td><a href="ViewTask?id=<?php echo $v['tid']; ?>"><?php echo $v['ttitle']; ?></a></td>
                  <td><?php echo substr(html_entity_decode(htmlspecialchars_decode($v['tdetail'])), 0, 100); ?>...</td>
                  <td><?php echo $v['duration'].' hours'; ?></td>
                  <td><?php echo $v['employeeEmail'] ? $v['employeeEmail'] : 'Not Assigned'; ?></td>
                  <td><form action="EditTask?id=<?php echo $v['tid']; ?>"><button id="btnEdit" type="submit" class="btn btn-info">Edit</button></form></td>
                  <td><button onclick="del_task(this.value)" id="btnDelete" type="submit" value="<?php echo $v['tid']; ?>" class="btn btn-danger">Delete</button></td>
                </tr>
 <?php
               } ?>
				 </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
		<script>
		function del_task(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=del_task",{pid:value},function(data){
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