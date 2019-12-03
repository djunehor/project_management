<?php
$page_name = 'Dashboard';
include '../views/employee_header.php'; ?>
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
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Total Tasks</h6>
                        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="mg-b-0 tx-white tx-lato tx-bold"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM $assigned_table WHERE employeeEmail='".$employee['email']."'")); ?></h3>
                    </div><!-- card-body -->
                    <!--     <div class="d-flex align-items-center justify-content-between mg-t-15 bd-t bd-white-2 pd-t-10">
                           <div>
                             <span class="tx-11 tx-white-6">Gross Sales</span>
                             <h6 class="tx-white mg-b-0">$2,210</h6>
                           </div>
                           <div>
                             <span class="tx-11 tx-white-6">Tax Return</span>
                             <h6 class="tx-white mg-b-0">$320</h6>
                           </div>
                         </div> -->
                </div><!-- card -->
            </div><!-- col-3 -->
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                <div class="card pd-20 bg-info">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Pending Tasks</h6>
                        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">

                        <h3 class="mg-b-0 tx-white tx-lato tx-bold"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM $assigned_table WHERE employeeEmail='".$employee['email']."' AND astatus=1")); ?></h3>
                    </div><!-- card-body -->
                    <!--     <div class="d-flex align-items-center justify-content-between mg-t-15 bd-t bd-white-2 pd-t-10">
                           <div>
                             <span class="tx-11 tx-white-6">Gross Sales</span>
                             <h6 class="tx-white mg-b-0">$2,210</h6>
                           </div>
                           <div>
                             <span class="tx-11 tx-white-6">Tax Return</span>
                             <h6 class="tx-white mg-b-0">$320</h6>
                           </div>
                         </div> -->
                </div><!-- card -->
            </div><!-- col-3 -->
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="card pd-20 bg-purple">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Completed Tasks</h6>
                        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">

                        <h3 class="mg-b-0 tx-white tx-lato tx-bold"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM $assigned_table WHERE employeeEmail='".$employee['email']."' AND astatus=3")); ?></h3>
                    </div><!-- card-body -->
                    <!--    <div class="d-flex align-items-center justify-content-between mg-t-15 bd-t bd-white-2 pd-t-10">
                          <div>
                            <span class="tx-11 tx-white-6">Gross Sales</span>
                            <h6 class="tx-white mg-b-0">$2,210</h6>
                          </div>
                          <div>
                            <span class="tx-11 tx-white-6">Tax Return</span>
                            <h6 class="tx-white mg-b-0">$320</h6>
                          </div>
                        </div> -->
                </div><!-- card -->
            </div><!-- col-3 -->
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="card pd-20 bg-sl-primary">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                        <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Due Tasks</h6>
                        <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">

                        <h3 class="mg-b-0 tx-white tx-lato tx-bold"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM $task_table INNER JOIN $assigned_table WHERE $task_table.taskID=(SELECT taskID FROM $assigned_table WHERE employeeEmail='".$employee['email']."') AND ($assigned_table.startDate+($task_table.duration*3600))<'".time()."'")); ?></h3>
                    </div><!-- card-body -->
                    <!--      <div class="d-flex align-items-center justify-content-between mg-t-15 bd-t bd-white-2 pd-t-10">
                            <div>
                              <span class="tx-11 tx-white-6">Gross Sales</span>
                              <h6 class="tx-white mg-b-0">$2,210</h6>
                            </div>
                            <div>
                              <span class="tx-11 tx-white-6">Tax Return</span>
                              <h6 class="tx-white mg-b-0">$320</h6>
                            </div>
                          </div>-->
                </div><!-- card -->
            </div><!-- col-3 -->
        </div><!-- row -->

        <div class="row row-sm mg-t-20">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-transparent pd-20 bd-b bd-gray-200">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Completed Tasks</h6>
                    </div><!-- card-header -->
                    <table class="table table-white table-responsive mg-b-0 tx-12">
                        <thead>
                        <th class="pd-y-5">Title</th>
                        <th class="pd-y-5">TimeLine</th>
                        <th class="pd-y-5">Planned Duration</th>
                        <th class="pd-y-5">Real Duration</th>
                        <th class="pd-y-5">Expenses</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $q7 = mysqli_query($con, "SELECT * FROM $assigned_table INNER JOIN $task_table
ON $assigned_table.taskID=$task_table.taskID WHERE employeeEmail='".$employee['email']."' AND $assigned_table.astatus=3");
                        while ($v = mysqli_fetch_assoc($q7)) {
                            ?>
                            <tr>
                                <td>
                                    <a href="ViewTask?id=<?php echo $v['taskID']; ?>"
                                       class="tx-inverse tx-14 tx-medium d-block"><?php echo $v['ttitle']; ?></a>
                                </td>
                                <td class="tx-12">
                                    <?php echo date('d-M-Y', $v['startDate']).' to '.date('d-M-Y', $v['eDate']); ?>
                                </td>
                                <td class="tx-12">
                                    <?php echo $v['duration'].' hours'; ?>
                                </td>
                                <td class="tx-12">
                                    <?php echo $v['eDate'] - $v['startDate'].' hours'; ?>
                                </td>
                                <td><?php echo number_format($v['eCost']); ?></td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                    <div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-gray-200">
                        <a href="AllTasks?sort=1"><i class="fa fa-angle-down mg-r-5"></i>View All Tasks</a>
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div><!-- col-6 -->
            <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                <div class="card">
                    <div class="card-header pd-20 bg-transparent bd-b bd-gray-200">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Assigned Tasks</h6>
                    </div><!-- card-header -->
                    <table class="table table-white table-responsive mg-b-0 tx-12">
                        <thead>
                        <tr>
                            <th class="pd-y-5">Title</th>
                            <th class="pd-y-5">Assign Date</th>
                            <th class="pd-y-5">Planned Duration</th>
                            <th class="pd-y-5">Deadline</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $q2 = mysqli_query($con, "SELECT * FROM $assigned_table INNER JOIN $task_table
ON $assigned_table.taskID=$task_table.taskID WHERE employeeEmail='".$employee['email']."' AND $assigned_table.astatus=0");
                        while ($v = mysqli_fetch_assoc($q2)) {
                            ?>
                            <tr>
                                <td>
                                    <a href="ViewTask?id=<?php echo $v['taskID']; ?>"
                                       class="tx-inverse tx-14 tx-medium d-block"><?php echo $v['ttitle']; ?></a>
                                </td>
                                <!-- <td>
					<?php echo html_entity_decode(htmlspecialchars_decode(substr($v['tdetail'], 0, 50))); ?>
					</td> -->
                                <td class="tx-12">
                                    <?php echo time_elapsed_string('@'.$v['startDate']); ?>
                                </td>
                                <td class="tx-12">
                                    <?php echo $v['duration'].' hours'; ?>
                                </td>
                                <td class="tx-12">
                                    <?php echo date('d-M-Y', ($v['startDate'] + ($v['duration'] * 3600))); ?>
                                </td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                    <div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-b-200">
                        <a href="AllTasks?sort=2"><i class="fa fa-angle-down mg-r-5"></i>View All Assigned Tasks</a>
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div><!-- col-6 -->
        </div><!-- row -->

        <div class="row row-sm mg-t-20">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-transparent pd-20 bd-b bd-gray-200">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Late Tasks</h6>
                    </div><!-- card-header -->
                    <table class="table table-white table-responsive mg-b-0 tx-12">
                        <thead>
                        <tr class="tx-10">
                            <th class="pd-y-5">Title</th>
                            <th class="pd-y-5">Deadline</th>
                            <th class="pd-y-5">Behind Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $q6 = mysqli_query($con, "SELECT * FROM tasks INNER JOIN assigned WHERE tasks.taskID=(SELECT taskID FROM assigned WHERE employeeEmail='".$employee['email']."') AND (assigned.startDate+(tasks.duration*3600))<".time().'');
                        while ($m = mysqli_fetch_assoc($q6)) {
                            ?>
                            <tr>
                                <td>
                                    <a href="ViewTask?id=<?php echo $m['taskID']; ?>"><?php echo $m['ttitle']; ?></a>
                                </td>
                                <td><?php echo date('d-M-Y', ($m['startDate'] + ($m['duration'] * 3600))); ?></td>
                                <td><?php echo time_elapsed_string('@'.(time() - ($m['startDate'] + ($m['duration'] * 3600)))); ?></td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                    <div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-gray-200">
                        <a href="AllTasks?sort=3"><i class="fa fa-angle-down mg-r-5"></i>View All Due Tasks</a>
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
                        $q3 = mysqli_query($con, "SELECT * FROM $activity_table WHERE userID='$employeeID' and type=1 and addDate>=(select lastLogin from $employee_table where employeeID='$employeeID') order by activityID DESC LIMIT 5");
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
                        <a href="AccountActivities"><i class="fa fa-angle-down mg-r-5"></i>View All Account
                            Activities</a>
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
<?php include '../views/employee_footer.php'; ?>
