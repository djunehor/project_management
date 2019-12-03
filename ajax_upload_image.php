<?php
require 'includes/config.php';
@$client_id = $_SESSION['managerID'];
$main_folder = '../uploads';
if (!is_dir($main_folder)) {
    mkdir($main_folder);
}

$sub_folder = "uploads/$client_id";
if (!is_dir($sub_folder)) {
    mkdir($sub_folder);
}

    $images_arr = [];
    foreach ($_FILES['images']['name'] as $key=>$val) {
        $image_name = $_FILES['images']['name'][$key];
        $tmp_name = $_FILES['images']['tmp_name'][$key];
        $size = $_FILES['images']['size'][$key];
        $type = $_FILES['images']['type'][$key];
        $error = $_FILES['images']['error'][$key];

        //########### Remove comments if you want to upload and stored images into the "uploads/" folder #############

        $target_dir = "$sub_folder/";
        $target_file = $target_dir.$_FILES['images']['name'][$key];
        if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
            $images_arr[] = $target_file;
        }

        //display images without stored
    /*	$extra_info = getimagesize($_FILES['images']['tmp_name'][$key]);
    	$images_arr[] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['images']['tmp_name'][$key])); */
    }

    //Generate images view
    if (!empty($images_arr)) {
        $count = 0;
        echo '<ul class="reorder_ul reorder-photos-list">';
        foreach ($images_arr as $image_src) {
            $count++; ?>
            	<li id="image_li_<?php echo $count; ?>" class="ui-sortable-handle col-sm-3">
                	<a href="javascript:void(0);" style="float:none;" class="image_link">
						<img src="<?php echo $image_src; ?>" alt="">
					</a>
					<img id="remove_img" class="remove" data-path="<?php echo $image_src; ?>" data-id="<?php echo $count; ?>" src="../uploads/no_photo_img.png"/>
					<input type="hidden" name="up_image[]" id="hidden_<?php echo $count; ?>" value="<?php echo $image_src; ?>" />
               	</li>
	<?php
        }
        echo '</ul>';
    }
?>

<script type="text/javascript">
$(document).ready(function(){
	$('.remove').click(function(){
		var path=$(this).attr('data-path');
		var id=$(this).attr('data-id');
		$.post("ajax_remove_image.php",{path:path},function(data){
			$('#image_li_'+id).remove();
			$('#hidden_'+id).remove();
		});
	});
});</script>