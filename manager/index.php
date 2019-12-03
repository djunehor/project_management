<?php
$page_name = 'Dashboard';
include '../views/manager_header.php'; ?>
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/rickshaw/rickshaw.min.css" rel="stylesheet">

    <!-- Starlight CSS -->
    <link rel="stylesheet" href="../css/starlight.css">
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index"><?php echo $option['website_name']; ?></a>
        <span class="breadcrumb-item active"><?php echo $page_name; ?></span>
    </nav>

    <div class="sl-pagebody" id="molue">

        <div class="row row-sm">
            <div class="col-sm-6 col-xl-3">
                <div class="card pd-20 bg-primary">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Total Projects</h6>
                        <a class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="mg-b-0 tx-white tx-lato tx-bold"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM $project_table WHERE managerID='$managerID'")); ?></h3>
                    </div><!-- card-body -->

                </div><!-- card -->
            </div><!-- col-3 -->
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                <div class="card pd-20 bg-info">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Total Budget</h6>
                        <a class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">

                        <h3 class="mg-b-0 tx-white tx-lato tx-bold">
                            &#x20A6;<?php $tb = mysqli_fetch_assoc(mysqli_query($con, "SELECT sum(budget) as tbudget FROM $project_table WHERE managerID='$managerID'"));
                            echo number_format($tb['tbudget']); ?></h3>
                    </div><!-- card-body -->

                </div><!-- card -->
            </div><!-- col-3 -->
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="card pd-20 bg-purple">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Milestones</h6>
                        <a class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">

                        <h3 class="mg-b-0 tx-white tx-lato tx-bold"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM $milestone_table WHERE managerID='$managerID'")); ?></h3>
                    </div><!-- card-body -->

                </div><!-- card -->
            </div><!-- col-3 -->
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="card pd-20 bg-sl-primary">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Tasks</h6>
                        <a class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">

                        <h3 class="mg-b-0 tx-white tx-lato tx-bold"><?php echo mysqli_num_rows(mysqli_query($con, "select * from $task_table where managerID='$managerID'")); ?></h3>
                    </div><!-- card-body -->

                </div><!-- card -->
            </div><!-- col-3 -->
        </div><!-- row -->

        <div class="row row-sm mg-t-20">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-transparent pd-20 bd-b bd-gray-200">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">My Projects</h6>
                    </div><!-- card-header -->
                    <table class="table table-white table-responsive mg-b-0 tx-12">
                        <thead>
                        <th class="pd-y-5">Title</th>
                        <th class="pd-y-5">Budget</th>
                        <th class="pd-y-5">Duration</th>
                        <th class="pd-y-5">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $q7 = mysqli_query($con, "SELECT * FROM $project_table INNER JOIN $status_table
ON $project_table.projectStatus=$status_table.statusID WHERE managerID='$managerID'");
                        while ($v = mysqli_fetch_assoc($q7)) {
                            ?>
                            <tr>
                                <td>

                                    <!-- <a href="" class="btn btn-info pd-x-20" data-toggle="modal" data-target="#modaldemo1">View Live Demo</a> -->
                                    <a href="project/<?php echo $v['pslug']; ?>"><?php echo $v['title']; ?></a>
                                    <br><a class="btn btn-success" data-toggle="modal"
                                           data-target="#ViewProject<?php echo $v['projectID']; ?>">View Details</a>

                                </td>
                                <div id="ViewProject<?php echo $v['projectID']; ?>" class="modal fade">
                                    <div class="modal-dialog modal-dialog-vertical-center" role="document">
                                        <div class="modal-content bd-0 tx-14">
                                            <div class="modal-header pd-y-20 pd-x-25">
                                                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Project
                                                    Details</h6>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body pd-25">
                                                <h4 class="lh-3 mg-b-20"><a
                                                            class="tx-inverse hover-primary"><?php echo $v['title']; ?></a>
                                                </h4>
                                                <p class="mg-b-5"><?php echo html_entity_decode(htmlspecialchars_decode($v['detail'])); ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary pd-x-20"
                                                        data-dismiss="modal">Close
                                                </button>
                                            </div>
                                        </div>
                                    </div><!-- modal-dialog -->
                                </div>
                                <td class="tx-12">
                                    <?php echo '&#x20A6;'.number_format($v['budget']); ?>
                                </td>
                                <td><?php echo date('d M Y', $v['startDate']), ' to '.date('d M Y', $v['endDate']); ?></td>
                                <td><?php echo $v['sdetail']; ?></td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                    <div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-gray-200">
                        <a href="AllProjects"><i class="fa fa-angle-down mg-r-5"></i>View All Projects</a>
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div><!-- col-6 -->
            <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                <div class="card">
                    <div class="card-header pd-20 bg-transparent bd-b bd-gray-200">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Latest Chats</h6>
                    </div><!-- card-header -->
                    <table class="table table-white table-responsive mg-b-0 tx-12">
                        <thead>
                        <tr class="tx-10">
                            <th class="pd-y-5">Message</th>
                            <th class="pd-y-5">Sender</th>
                            <th class="pd-y-5">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $q2 = mysqli_query($con, "SELECT * FROM $chat_table WHERE senderID='".$manager['email']."' OR recipientID='".$manager['email']."' and sendDate>=(select lastLogin from $user_table where managerID='$managerID') GROUP BY chatID DESC LIMIT 5");
                        while ($b = mysqli_fetch_assoc($q2)) {
                            ?>
                            <tr>
                                <td>
                                    <a href="ViewChat?id=<?php echo strtolower($b['chatID']); ?>"
                                       class="tx-inverse tx-14 tx-medium d-block"><?php echo $b['message'] ? html_entity_decode(htmlspecialchars_decode(substr($b['message'], 0, 50))) : '<a target="_blank" href="'.$b['attachment'].'">View Image</a>'; ?></a>
                                    <!--   <span class="tx-11 d-block"><span class="square-8 bg-danger mg-r-5 rounded-circle"></span> 20 remaining</span>  -->
                                </td>
                                <td class="valign-middle"><span
                                            class="tx-success"></span> <?php echo $b['recipientID']; ?></td>
                                <td class="valign-middle">
                                    <?php echo time_elapsed_string('@'.$b['sendDate']); ?>
                                </td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                    <div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-b-200">
                        <a href="AllChats"><i class="fa fa-angle-down mg-r-5"></i>View All Chats</a>
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div><!-- col-6 -->
        </div><!-- row -->

        <div class="row row-sm mg-t-20">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-transparent pd-20 bd-b bd-gray-200">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Project Activities</h6>
                    </div><!-- card-header -->
                    <table class="table table-white table-responsive mg-b-0 tx-12">
                        <thead>
                        <tr class="tx-10">
                            <th class="pd-y-5">Activity</th>
                            <th class="pd-y-5">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $q6 = mysqli_query($con, "SELECT * FROM $projectlog WHERE managerID='$managerID' and addDate>=(select LastLogin from $user_table where managerID='$managerID') order by logID desc limit 5");
                        while ($m = mysqli_fetch_assoc($q6)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $m['detail']; ?></span>
                                </td>
                                <td><?php echo time_elapsed_string('@'.$m['addDate']); ?></td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                    <div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-gray-200">
                        <a href="ProjectActivity"><i class="fa fa-angle-down mg-r-5"></i>View All Project Activities</a>
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div><!-- col-6 -->
            <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                <div class="card">
                    <div class="card-header pd-20 bg-transparent bd-b bd-gray-200">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Account Activities</h6>
                    </div><!-- card-header -->
                    <table class="table table-white table-responsive mg-b-0 tx-12">
                        <thead>
                        <tr class="tx-10">
                            <th class="pd-y-5">Activity</th>
                            <th class="pd-y-5 tx-center">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $q3 = mysqli_query($con, "SELECT * FROM $activity_table WHERE userID='$managerID' and addDate>=(select LastLogin from $user_table where managerID='$managerID') order by activityID desc LIMIT 5");
                        while ($l = mysqli_fetch_assoc($q3)) {
                            ?>
                            <tr>
                                <td>
                                    <a class="tx-inverse tx-14 tx-medium d-block"><?php echo $l['adetail']; ?></a>
                                    <!--   <span class="tx-11 d-block"><span class="square-8 bg-danger mg-r-5 rounded-circle"></span> 20 remaining</span>  -->
                                </td>
                                <td class="valign-middle"> <?php echo time_elapsed_string('@'.$l['addDate']); ?></td>

                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                    <div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-b-200">
                        <a href="AccountActivity"><i class="fa fa-angle-down mg-r-5"></i>View All Account Activities</a>
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div><!-- col-6 -->
        </div><!-- row -->
    </div><!-- sl-pagebody -->

    <!-- ########## END: MAIN PANEL ########## -->
    <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
    <script src="../lib/jquery-ui/jquery-ui.js"></script>
    <script src="../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="../lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
    <script src="../lib/d3/d3.js"></script>
    <script src="../lib/rickshaw/rickshaw.min.js"></script>
    <script src="../lib/chart.js/Chart.js"></script>
    <script src="../lib/Flot/jquery.flot.js"></script>
    <script src="../lib/Flot/jquery.flot.pie.js"></script>
    <script src="../lib/Flot/jquery.flot.resize.js"></script>
    <script src="../lib/flot-spline/jquery.flot.spline.js"></script>

    <script src="../js/starlight.js"></script>
    <script src="../js/ResizeSensor.js"></script>
    <script src="../js/dashboard.js"></script>

<?php include '../views/manager_footer.php'; ?>
