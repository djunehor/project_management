<?php
$page_name = 'All Chats';
include '../views/employee_header.php'; ?>
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
          <h6 class="card-body-title">All Chats</h6>
         <p class="mg-b-20 mg-sm-b-30">List of your chat history.</p>

          <div class="table-wrapper">
		   <div class=" alert alert-danger pname_error_show" style="display:none"></div>
<table class="table table-bordered table-striped">
<tr>
<th>Email</th>
<th>Message</th>
<th>Date</th>
<th>Action</th>
</tr>
<?php
$tabla = mysqli_query($con, "SELECT * FROM $chat_table where senderID='".$employee['email']."' OR recipientID='".$employee['email']."' GROUP BY chatID DESC limit 50");
while ($registro = mysqli_fetch_array($tabla)) {
    echo '
<tr class="even">
<td>'.$registro['senderID'].'</td>
<td>'.html_entity_decode(htmlspecialchars_decode($registro['message'])).'</td>
<td>'.date('M j Y, g:i a', $registro['sendDate']).'</td>
<td><a href="ViewChat?id='.$registro['chatID'].'">View Chat</a></td>
</tr>';
}
?>
</table>

          </div><!-- table-wrapper -->
        </div><!-- card -->
		<script>
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