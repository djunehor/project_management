<?php
include '../includes/config.php';
$page_name = 'Project Activities';
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
            <h4 class="card-body-title" style="background-color:brown;color:white; padding:2px;">Activities</h4>
            <table class="table table-white table-responsive mg-b-0 tx-12" style="border: 1px solid brown;margin:9px;">
                <thead>
                <tr>
                    <td>Description</td>
                    <td>Date</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
                    $q6 = mysqli_query($con, "SELECT * FROM $projectlog WHERE managerID='$managerID' order by logID desc limit 100");
                    while ($f = mysqli_fetch_assoc($q6)) {
                        ?>
                    <td><?php echo html_entity_decode(htmlspecialchars_decode($f['detail'])); ?></td>
                    <td><?php echo date('d-M-Y g:i a', $f['addDate']); ?></td>
                </tr>
                <?php
                    } ?>
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
