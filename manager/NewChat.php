<?php
$page_name = 'Open Chat';
include '../views/manager_header.php'; ?>
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/highlightjs/github.css" rel="stylesheet">
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
            <h6 class="card-body-title">Start New Chat</h6>
            <p class="mg-b-20 mg-sm-b-30">We suggest you complete your profile before proceeding</p>
            <form id="new_chat" role="form" enctype="multipart/form-data">
                <div id="wizard1">
                    <section>
                        <!--     <p>Try the keyboard navigation by clicking arrow left or right!</p> -->
                        <label class="form-control-label">Recipient: <span class="tx-danger">*</span></label>
                        <input class="form-control" onblur="check_recipient(this.value)" name="recipient"
                               placeholder="Enter recipient email" type="text">
                        <div class=" alert alert-danger prc_error_show" style="display:none"></div>
                    </section>
                    <br>
                    <section>
                        <!--    <p>Wonderful transition effects.</p>  -->

                        <label class="form-control-label">Message: <span class="tx-danger">*</span></label>
                        <textarea id="message" class="form-control" name="message"></textarea>
                    </section>
                    <br>
                    <section>
                        <label class="form-control-label">Photo: <span class="tx-danger">*</span></label>
                        <input onblur="check_doc(this.value)" class="form-control" name="fileToUpload" type="file">
                        <div class=" alert alert-danger pphoto_error_show" style="display:none"></div>
                    </section>
                    <br>
                </div>
                <input type="hidden" value="<?php echo $manager['email']; ?>" name="senderid">
                <button id="btnSubmit" type="submit" class="btn btn-info btn-block">Start Chat</button>
            </form>
            <div style="display:none" class="alert alert-success success"></div>
            <div style="display:none" class="alert alert-info loading">Loading...</div>
            <div style="display:none" class="alert alert-danger error"></div>

        </div><!-- card -->

        <script src="../lib/jquery/jquery.js"></script>
        <script src="../lib/popper.js/popper.js"></script>
        <script src="../lib/bootstrap/bootstrap.js"></script>
        <script src="../lib/summernote/summernote-bs4.min.js"></script>
        <script>
            $(document).ready(function (e) {
                $("#new_chat").on('submit', (function (e) {
                    e.preventDefault();
                    $('.loading').show();
                    $('.success').hide();
                    $('.error').hide();
                    $('#finish').attr('disabled', 'disabled');
                    $.ajax({
                        url: "<?php echo $website_url; ?>/ajax_form_process?value=new_chat",
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

            function check_doc(value) {
                $.post("<?php echo $website_url; ?>/ajax_check_input?value=doc", {udoc: value}, function (data) {
                    if (data.length != 0) {
                        $('.pphoto_error_show').show();
                        $('.pphoto_error_show').html(data);
                        $('#btnSubmit').attr('disabled', 'disabled');
                    } else {
                        $('.pphoto_error_show').hide();
                        $('#btnSubmit').removeAttr('disabled');
                    }
                });
            }

            function check_recipient(value) {
                $.post("<?php echo $website_url; ?>/ajax_check_input?value=recipient", {uemail: value}, function (data) {
                    if (data.length != 0) {
                        $('.prc_error_show').show();
                        $('.prc_error_show').html(data);
                        $('#btnSubmit').attr('disabled', 'disabled');
                    } else {
                        $('.prc_error_show').hide();
                        $('#btnSubmit').removeAttr('disabled');
                    }
                });
            }

            // Summernote editor
            $('#message').summernote({
                height: 150,
                tooltip: false
            });
        </script>
        <script src="../js/starlight.js"></script>

    </div>

    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>
