<?php
$page_name = "ChatBox";
$chatid = strtoupper(filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING));
include '../views/manager_header.php';	
$chat = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM $chat_table WHERE chatID='$chatid' ORDER BY sendDate ASC LIMIT 1"));
?>
<link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../lib/highlightjs/github.css" rel="stylesheet">
    <link href="../lib/jquery.steps/jquery.steps.css" rel="stylesheet">	 
    <link href="../lib/summernote/summernote-bs4.css" rel="stylesheet">
    <!-- Starlight CSS -->
	 <script src="../lib/jquery/jquery.js"></script>
    <link rel="stylesheet" href="../css/starlight.css">
    <!-- ########## START: MAIN PANEL ########## -->
  <div class="sl-mainpanel">
     <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index"><?php echo $option['website_name']; ?></a>
        <span class="breadcrumb-item active"><?php echo $page_name; ?></span>
      </nav>

      <div class="sl-pagebody">
	  <div class="card pd-20 pd-sm-40">
<div id="links" style="padding:5px;"></div>   
<div style="display:none" class="alert alert-info delete-error"></div>
<form id="add_chat" role="form" enctype="multipart/form-data">
<label class="form-control-label">Message: <span class="tx-danger">*</span></label>
                <textarea id="message" class="form-control" name="message" ></textarea><br>
				<label class="form-control-label">Attachment: <span class="tx-danger">*</span></label>
                <input onblur="check_doc(this.value)" class="form-control" name="fileToUpload" type="file"><br>
				  <div class=" alert alert-danger pphoto_error_show" style="display:none"></div>
				<input type="hidden" value="<?php echo $manager['email']; ?>" name="senderid">
				<input type="hidden" value="<?php echo $chat['recipientID']; ?>" name="recipientid">
				<input type="hidden" value="<?php echo $chatid; ?>" name="chatid">
		  <button id="btnSubmit" type="submit" class="btn btn-info btn-block">SEND</button></form>
													<div style="display:none" class="alert alert-info loading">Loading...</div>		  
													<div style="display:none" class="alert alert-info success"></div>		  
 </div><!-- table-wrapper -->
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
    <script src="../lib/summernote/summernote-bs4.min.js"></script>
		<script>
		$(document).ready(function (e) {
	$("#add_chat").on('submit',(function(e) {
		e.preventDefault();
		$('.loading').show();
		$('.success').hide();
		$('.error').hide();
		$('#finish').attr('disabled','disabled');
		$.ajax({
			url: "<?php echo $website_url; ?>/ajax_form_process?value=add_chat",
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data)
			{
				$('#finish').removeAttr('disabled');
				$('.loading').hide();
				if(data.length != 0){
					$('.success').show();
					$('.success').html(data);
				}
			}
		});
	}));
});
function check_doc(value){
	$.post("<?php echo $website_url; ?>/ajax_check_input?value=doc",{udoc:value},function(data){
		if(data.length != 0){
			$('.pphoto_error_show').show();
			$('.pphoto_error_show').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.pphoto_error_show').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
function del_message(value){
	$.post("<?php echo $website_url; ?>/ajax_form_process?value=del_message",{mid:value},function(data){
		if(data.length != 0){
			$('.delete-error').show();
			$('.delete-error').html(data);
		}
	});
}
        $('#message').summernote({
          height: 150,
          tooltip: false
        });
function loadlink(){
    $('#links').load('<?php echo $website_url; ?>/ajax_form_process?value=load_chat&id=<?php echo $chatid; ?>&senderid=<?php echo $manager['email']; ?>&utype=1',function () {
         $(this).wrap();
    });
}

loadlink(); // This will run on page load
setInterval(function(){
    loadlink() // this will run after every 5 seconds
}, 1000);
</script>
    <script src="../js/starlight.js"></script>
    
</div>

    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>