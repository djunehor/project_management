<?php
$page_name = "New Listing";
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
          <h6 class="card-body-title">New Listing</h6>
          <p class="mg-b-20 mg-sm-b-30">Create New Listing to be displayed on the home page</p>
<form id="new_listing" role="form">
          <div id="wizard1">
            <section>
         <!--     <p>Try the keyboard navigation by clicking arrow left or right!</p> -->
                <label class="form-control-label">Title: <span class="tx-danger">*</span></label>
                <input onblur="check_title(this.value)" id="title" class="form-control" name="title" placeholder="Enter listing name" type="text" required>
   <div class=" alert alert-danger pname_error_show" style="display:none"></div>
            </section><br>
            <section>
          <!--    <p>Wonderful transition effects.</p>  -->
         
                <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                <textarea onblur="check_desc(this.value)" id="info" class="form-control" name="info" placeholder="Enter description" type="text" required>
				<h3>General Information</h3>
										<p>Place general decription here</p>
										<h3>Features</h3>
										<div class="features">
											<ul>
												<li>Garage</li>
												<li>Internet</li>
												<li>Guest house</li>
											</ul>
										</div>
				</textarea>
          <div class=" alert alert-danger pdesc_error_show" style="display:none"></div>
            </section><br>
            <section>
           <label class="form-control-label">Country: <span class="tx-danger">*</span></label>
                <select onblur="check_state(this.value)" id="project" class="form-control" name="country">
       <?php
	  $oop  = mysqli_query($con,"SELECT * FROM countries");
	  while($ool = mysqli_fetch_assoc($oop))
	  {
	 echo '<option value="'.$ool['id'].'">'.$ool['name'].'</option>';
	  }
	  ?>
			 </select><div class="milestonep" style="display:none"><br></div><div class="milep" style="display:none"><br></div>
			 <br><div class="address" style="display:none"> <label class="form-control-label">Address: <span class="tx-danger">*</span></label>
                <textarea class="form-control" name="address" placeholder="Enter address" type="text"></textarea>
         </div>
            </section><br>
			 <section>
           
                <label class="form-control-label">Price: <span class="tx-danger">*</span></label>
                <input  onblur="check_number(this.value)" id="number" class="form-control" name="price" type="number" required />
				  <div class=" alert alert-danger pnum_error_show" style="display:none"></div>
			 <br>
                <label class="form-control-label">Listing Type: <span class="tx-danger">*</span></label>
                <select class="form-control" name="ltype">
<?php
$h3 = mysqli_query($con,"SELECT * FROM $listing_type");
while($b = mysqli_fetch_assoc($h3))
{
echo '<option value="'.$b['id'].'">'.$b['ldetail'].'</option>';
} ?>
			 </select>
			 <br>
                <label class="form-control-label">Apartment Type: <span class="tx-danger">*</span></label>
                <select class="form-control" name="atype">
<?php
$h4 = mysqli_query($con,"SELECT * FROM $apartment_type");
while($c = mysqli_fetch_assoc($h4))
{
echo '<option value="'.$c['id'].'">'.$c['adetail'].'</option>';
} ?>
			 </select>
            </section><br>
			<section>
			<label class="form-control-label">Photo(s): <span class="tx-danger">*</span></label>
		<input type="file" onblur="check_photo(this.value)" id="picture" name="upload[]" multiple>	
		<div class=" alert alert-danger pphoto_error_show" style="display:none"></div></section><br>
          </div>
		  <input type="hidden" value="<?php echo $managerID; ?>" name="managerid">
		  <button id="btnSubmit" type="submit" class="btn btn-info btn-block">Add Listing</button></form>
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
	$("#new_listing").on('submit',(function(e) {
		e.preventDefault();
		$('.loading').show();
		$('.success').hide();
		$('.error').hide();
		$('#finish').attr('disabled','disabled');
		$.ajax({
			url: "<?php echo $website_url; ?>/includes/form_process?value=new_listing",
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data)
			{
				$('#finish').removeAttr('disabled');
				$('.loading').hide();
				
				if(data.search("Error")!=-1){
					$('.error').show();
					$('.success').hide();
					$('.error').html(data);
				}
				else{
					$('.success').show();
					$('.error').hide();
					$('.success').html(data);
				}
			}
		});
	}));
});
function check_title(value){
	$.post("<?php echo $website_url; ?>/includes/ajax_check_input?value=ltitle",{title:value},function(data){
		if(data.length != 0){
			$('.pname_error_show').show();
			$('.pname_error_show').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.pname_error_show').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
function check_state(value){
	$.post("<?php echo $website_url; ?>/includes/ajax_check_input?value=state",{ucountry:value},function(data){
		if(data.length != 0){
			$('.milestonep').show();
			$('.milestonep').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.milestonep').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
function check_city(value){
	$.post("<?php echo $website_url; ?>/includes/ajax_check_input?value=city",{ustate:value},function(data){
		if(data.length != 0){
			$('.milep').show();
			$('.address').show();
			$('.milep').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.milep').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
function check_photo(value){
	$.post("<?php echo $website_url; ?>/includes/ajax_check_input?value=photo",{uphoto:value},function(data){
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
function check_number(value){
	$.post("<?php echo $website_url; ?>/includes/ajax_check_input?value=number",{unum:value},function(data){
		if(data.length != 0){
			$('.pnum_error_show').show();
			$('.pnum_error_show').html(data);
			$('#btnSubmit').attr('disabled','disabled');
		}else{
			$('.pnum_error_show').hide();
			$('#btnSubmit').removeAttr('disabled');
		}
	});
}
// Summernote editor
        $('#info').summernote({
          height: 150,
          tooltip: false
        });
</script>
    <script src="../js/starlight.js"></script>	
	
    <!-- ########## END: MAIN PANEL ########## -->
<?php include '../views/manager_footer.php'; ?>