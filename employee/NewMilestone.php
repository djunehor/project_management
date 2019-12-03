<?php
$page_name = 'New Milestone';
include '../views/manager_header.php'; ?>
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/highlightjs/github.css" rel="stylesheet">
    <link href="../lib/jquery.steps/jquery.steps.css" rel="stylesheet">
    <link href="../lib/summernote/summernote-bs4.css" rel="stylesheet">
    <!-- Starlight CSS -->
    <link rel="stylesheet" href="../css/starlight.css">
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index"><?php echo $option['website_name']; ?></a>
        <span class="breadcrumb-item active"><?php echo $page_name; ?></span>
    </nav>

    <div class="sl-pagebody">


        <div class="card pd-20 pd-sm-40 mg-t-50">
            <h6 class="card-body-title">New Milestone</h6>
            <p class="mg-b-20 mg-sm-b-30">Create milestones for your project</p>
            <form id="new_mile" role="form">
                <div id="wizard1">
                    <section>
                        <!--     <p>Try the keyboard navigation by clicking arrow left or right!</p> -->
                        <label class="form-control-label">Title: <span class="tx-danger">*</span></label>
                        <input onblur="check_mtitle(this.value)" id="mile_name" class="form-control" name="title"
                               placeholder="Enter title" type="text" required>
                        <div class=" alert alert-danger pname_error_show" style="display:none"></div>
                        <br>
                        <label class="form-control-label">Project: <span class="tx-danger">*</span></label>
                        <select class="form-control" name="projectid">
                            <?php
                            $oop = mysqli_query($con, "SELECT * FROM $project_table WHERE managerID='$managerID'");
                            while ($ool = mysqli_fetch_assoc($oop)) {
                                echo '<option value="' . $ool['projectID'] . '">' . $ool['title'] . '</option>';
                            }
                            ?>
                        </select>
                    </section>
                    <br>
                    <section>
                        <!--    <p>Wonderful transition effects.</p>  -->

                        <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                        <textarea onblur="check_desc(this.value)" id="mile_desc" class="form-control" name="desc"
                                  placeholder="Enter description" type="text" required></textarea>
                        <div class=" alert alert-danger pdesc_error_show" style="display:none"></div>
                    </section>
                    <br>
                    <section><label class="form-control-label">Date: <span class="tx-danger">*</span></label>
                        <input onblur="check_date(this.value)" id="date" class="form-control" name="startdate"
                               type="date" required/>
                        <div class=" alert alert-danger pddate_error_show" style="display:none"></div>
                    </section>
                    <br>
                    <label class="form-control-label">Phase: <span class="tx-danger">*</span></label>
                    <select class="form-control" name="tag">
                        <?php
                        $oopl = mysqli_query($con, "SELECT * FROM $tag_table");
                        while ($ol = mysqli_fetch_assoc($oopl)) {
                            echo '<option value="' . $ol['tagID'] . '">' . $ol['detail'] . '</option>';
                        }
                        ?>
                    </select><br>
                </div>
                <input name="managername" type="hidden" value="<?php echo $manager['fullname']; ?>"/>
                <input name="managerid" type="hidden" value="<?php echo $manager['managerID']; ?>"/>
                <button id="btnSubmit" type="submit" class="btn btn-info btn-block">Add MileStone</button>
            </form>
            <div style="display:none" class="alert alert-success success"></div>
            <div style="display:none" class="alert alert-info loading">Loading...</div>
            <div style="display:none" class="alert alert-danger error"></div>

        </div><!-- card -->
    </div><!-- sl-pagebody -->
    <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
    <script src="../lib/summernote/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function (e) {
            $("#new_mile").on('submit', (function (e) {
                e.preventDefault();
                $('.loading').show();
                $('.success').hide();
                $('.error').hide();
                $('#finish').attr('disabled', 'disabled');
                $.ajax({
                    url: "<?php echo $website_url; ?>/ajax_form_process?value=new_milestone",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $('#finish').removeAttr('disabled');
                        $('.loading').hide();

                        if (data.search("Error") != -1) {
                            $('.error').show();
                            $('.success').hide();
                            $('.error').html(data);
                        } else {
                            $('.success').show();
                            $('.error').hide();
                            $('.success').html(data);
                        }
                    }
                });
            }));
        });

        function check_mtitle(value) {
            $.post("<?php echo $website_url; ?>/ajax_check_input?value=mtitle", {title: value}, function (data) {
                if (data.length != 0) {
                    $('.pname_error_show').show();
                    $('.pname_error_show').html(data);
                    $('#btnSubmit').attr('disabled', 'disabled');
                } else {
                    $('.pname_error_show').hide();
                    $('#btnSubmit').removeAttr('disabled');
                }
            });
        }

        function check_desc(value) {
            $.post("<?php echo $website_url; ?>/ajax_check_input?value=desc", {desc: value}, function (data) {
                if (data.length != 0) {
                    $('.pdesc_error_show').show();
                    $('.pdesc_error_show').html(data);
                    $('#btnSubmit').attr('disabled', 'disabled');
                } else {
                    $('.pdesc_error_show').hide();
                    $('#btnSubmit').removeAttr('disabled');
                }
            });
        }

        function check_date(value) {
            $.post("<?php echo $website_url; ?>/ajax_check_input?value=date", {udate: value}, function (data) {
                if (data.length != 0) {
                    $('.pddate_error_show').show();
                    $('.pddate_error_show').html(data);
                    $('#btnSubmit').attr('disabled', 'disabled');
                } else {
                    $('.pddate_error_show').hide();
                    $('#btnSubmit').removeAttr('disabled');
                }
            });
        }

        function check_number(value) {
            $.post("<?php echo $website_url; ?>/ajax_check_input?value=number", {unum: value}, function (data) {
                if (data.length != 0) {
                    $('.pnum_error_show').show();
                    $('.pnum_error_show').html(data);
                    $('#btnSubmit').attr('disabled', 'disabled');
                } else {
                    $('.pnum_error_show').hide();
                    $('#btnSubmit').removeAttr('disabled');
                }
            });
        }

        // Summernote editor
        $('#mile_desc').summernote({
            height: 150,
            tooltip: false
        });
    </script>
    <script src="../js/starlight.js"></script>

    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>
