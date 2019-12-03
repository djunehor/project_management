<?php

require 'includes/config.php';
require 'includes/functions.php';
require 'includes/class.validate_input.php';
$validate = new validateInput();
$file = new validateFile();
$type = $_GET['value'];
switch ($type) {
    case 'del_message':
        @$password = $_REQUEST['mid'];
        if (!is_int($password)) {
            $error = 'Invalid ChatID';
        }
        $fpy = mysqli_query($con, "DELETE FROM $chat_table WHERE ID='$password'") or die('Error: '.mysqli_error($con));
        break;

    case 'load_chat':
        $utype = filter_input(INPUT_GET, 'utype', FILTER_SANITIZE_STRING);
        $chatid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $senderid = filter_input(INPUT_GET, 'senderid', FILTER_SANITIZE_STRING);
        $mum = mysqli_query($con, "SELECT * FROM $chat_table WHERE chatID='$chatid' ORDER BY sendDate DESC LIMIT 100");

//start pagination here

//end pagination
        $mum2 = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $chat_table WHERE chatID='$chatid' ORDER BY sendDate DESC LIMIT 1"));
        if ($mum2['senderID'] != $senderid && ($mum2['sendDate'] + 3) == time()) {
            echo '<audio autoplay="autoplay" src="../uploads/beep1.wav" type="audio/wav"><embed src="../uploads/beep1.wav" hidden="true" autostart="true" loop="false" /></audio>';
        }
        if ($mum2['senderID'] != $senderid) {
            $dad = $mum2['senderID'];
        } else {
            $dad = $mum2['recipientID'];
        }
        if ($utype == 2) {
            $mum3 = mysqli_fetch_assoc(mysqli_query($con, "SELECT lastseen FROM $user_table WHERE email='$dad'"));
        } elseif ($utype == 1) {
            $mum3 = mysqli_fetch_assoc(mysqli_query($con, "SELECT lastseen FROM $employee_table WHERE email='$dad'"));
        }
        if ($mum3['lastseen'] + 60 >= time()) {
            $status = 'Online';
        } else {
            $status = 'Offline';
        }
        echo '<h6 class="card-body-title">Chat with '.$dad.'</h6><i>('.$status.')</i>';
        while ($f = mysqli_fetch_array($mum)) {
            echo '<div ';
            if ($f['senderID'] == $senderid) {
                echo 'style="text-align:right;" class="alert alert-success"><button style="float:right;" class="btn btn-danger btn-icon rounded-circle mg-r-5 mg-b-10" onclick="del_message(this.value)" name="btnDelete" value="'.$f['ID'].'">Delete</button>';
            } else {
                echo 'class="alert alert-danger">';
            }

            if (!empty($f['message'])) {
                echo substr(html_entity_decode(htmlspecialchars_decode($f['message'])), 3, -8);
            }
            if (!empty($f['attachment'])) {
                echo '<a target="_blank" href="'.$f['attachment'].'"><img src="'.$f['attachment'].'" width="50px" height="50px">View/Download Image</a>';
            }
            echo '<br><small>'.time_elapsed_string('@'.$f['sendDate']).'</small></div>';
        }
        $ltime = time();
        if ($utype == 1) {
            $mum4 = mysqli_query($con, "UPDATE $user_table SET lastseen='$ltime' WHERE email='$senderid'");
        }
        if ($utype == 2) {
            $mum4 = mysqli_query($con, "UPDATE $employee_table SET lastseen='$ltime' WHERE email='$senderid'");
        }
        break;

    case 'add_chat':
        $array = ['chatid', 'recipientid', 'senderid', 'message'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        if (empty($chatid) || empty($recipientid) || empty($senderid)) {
            $error .= 'Some Required fields are missing!';
        } elseif (filter_var($recipientid, FILTER_VALIDATE_EMAIL) === false || filter_var($senderid, FILTER_VALIDATE_EMAIL) === false) {
            $error .= 'Form contains invalid fields!';
        } else {
            $chatid = filter_var($chatid, FILTER_SANITIZE_STRING);
            $message = htmlentities(htmlspecialchars($message));
            if (!empty($_FILES['fileToUpload']['name'])) {
                $uploaddir = '../uploads/';
                $uploadfile = $uploaddir.basename($_FILES['fileToUpload']['name']);
                $imageFileType = pathinfo($uploadfile, PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile);
            } else {
                $uploadfile = '';
            }
            $datetime = time(); //create date time
            //$ss3  = mysqli_fetch_assoc(mysqli_query($con,"select employeeID from $employee_table where email='$recipient'"));
            $sql = mysqli_query($con, "INSERT INTO $chat_table(chatID,senderID,recipientID,message,sendDate,attachment) VALUES('$chatid','$senderid','$recipientid','$message', '$datetime','$uploadfile')") or die(mysqli_error($con));
        }
        echo $error;
        break;

    case 'new_chat':
        $array = ['recipient', 'message', 'senderid'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $message = htmlentities(htmlspecialchars($message));
        if (empty($recipient) || (empty($message) && empty($_FILES['fileToUpload']['name']))) {
            $error .= 'Recipient and Message Required!';
        } elseif (filter_var($senderid, FILTER_VALIDATE_EMAIL) === false) {
            $error .= 'A required field is missing!';
        } elseif (filter_var($recipient, FILTER_VALIDATE_EMAIL) === false) {
            $error .= 'Please enter a valid email!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $employee_table where email='$recipient'")) != 1) {
            $error .= 'User Not Found!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $chat_table where recipientID='$password' and senderID='".$_SESSION['managerID']."'")) > 0) {
            $chatID = mysqli_fetch_assoc(mysqli_query($con, "select chatID from $chat_table where recipientID='$password' and senderID='".$_SESSION['managerID']."' limit 1"));
            $error .= 'You have an existing chat with this user! <a target="_blank" href="ViewChat?id='.$chatID.'">Continue Chat</a>';
        } else {
            if (!empty($_FILES['fileToUpload']['name'])) {
                $uploaddir = '../uploads/';
                $uploadfile = $uploaddir.basename($_FILES['fileToUpload']['name']);
                $imageFileType = pathinfo($uploadfile, PATHINFO_EXTENSION);
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)) {
                    $result .= 'File <b>'.$_FILES['fileToUpload']['name'].'</b> successfully uploaded.';
                }
            } else {
                $uploadfile = '';
            }
            $datetime = time(); //create date time
            //generate PIN
            $chatid = strtoupper(bin2hex(openssl_random_pseudo_bytes(8)));
            $ss3 = mysqli_fetch_assoc(mysqli_query($con, "select email from $employee_table where email='$recipient'"));
            $sql = mysqli_query($con, "INSERT INTO $chat_table(chatID,senderID,recipientID,message,sendDate,attachment) VALUES('$chatid','$senderid','".$ss3['email']."','$message', '$datetime','$uploadfile')");

            if ($sql) {
                $result .= ' Chat Started Successfully. <a href="ViewChat?id='.$chatid.'">Start Conversation</a>';
                $detail = 'New Chat with <b>'.$recipient.'</b> was started';
                ActivityLog($con, $detail, $managerid);
            } else {
                $error .= 'Insert Error: '.mysqli_error($con);
            }
        }

        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'assign_task':
        $array = ['projectid', 'milestoneid', 'taskid', 'email', 'comment', 'managername', 'managerid'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $comment = htmlentities(htmlspecialchars($comment));
        if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $error = 'Enter Valid Email!';
        } elseif (!is_numeric($projectid) || !is_numeric($managerid) || !is_numeric($taskid) || !is_numeric($milestoneid)) {
            $error = 'Your form contains invalid characters!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $task_table where taskID='$taskid'")) != 1) {
            $error = 'Task Not Found!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $project_table where projectID='$projectid'")) != 1) {
            $error = 'Project Not found!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $milestone_table where milestoneID='$milestoneid'")) != 1) {
            $error = 'Milestone Not found!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $employee_table where email='$email'")) != 1) {
            $error = 'Employee does not exist. Employee must register first!';
        } else {
            $reg_time = time();
            $insert5 = mysqli_query($con, "INSERT INTO $assigned_table(employeeEmail,taskID,startDate,comment) VALUES ('$email','$taskid','$reg_time','$comment')");
            if (!$insert5) {
                $error = 'Insert Error - '.mysqli_error($con);
            } else {
                $select4 = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $task_table WHERE taskID='$taskid'"));
                //$update5 = mysqli_fetch_assoc(mysqli_query($con,"UPDATE $task_table SET status=2 WHERE taskID='$taskid'"));
                $detail = 'Task <b>'.$select4['title'].'</b> was assigned to '.$email.' by '.$managername;
                ActivityLog($con, $detail, $managerid, $projectid);
                $result = 'Task <b>'.$select4['title'].'</b> was successfully assigned to '.$email;
            }
        }
        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'task_com':
        $array = ['managerid', 'projectid', 'milestoneid', 'taskid', 'tcomment', 'tcost', 'employeeid'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $tcomment = htmlentities(htmlspecialchars($tcomment));
        if (empty($tcomment)) {
            $error = 'Comment is empty!';
        } elseif (empty($employeeid) || filter_var($employeeid, FILTER_VALIDATE_EMAIL) === false) {
            $error = 'Enter Valid Email!';
        } elseif (!is_numeric($projectid) || !is_numeric($managerid) || !is_numeric($taskid) || !is_numeric($milestoneid) || !is_numeric($tcost)) {
            $error = 'Your form contains invalid characters!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $task_table where taskID='$taskid'")) != 1) {
            $error = 'Task Not Found!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $project_table where projectID='$projectid'")) != 1) {
            $error = 'Project Not found!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $milestone_table where milestoneID='$milestoneid'")) != 1) {
            $error = 'Milestone Not found!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $employee_table where email='$employeeid'")) != 1) {
            $error = 'Employee does not exist. Employee must register first!';
        } else {
            $total = count($_FILES['upload']['name']);

            // Loop through each file
            for ($i = 0; $i < $total; $i++) {
                //Get the temp file path
                $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
                $filename = $_FILES['upload']['name'][$i];
                //Make sure we have a filepath
                if ($tmpFilePath != '') {
                    //Setup our new file path
                    $newFilePath[] = '../uploads/'.$_FILES['upload']['name'][$i];
                    //Upload the file into the temp dir
                    move_uploaded_file($tmpFilePath, $newFilePath);
                }
                $result .= ' '.$filename.' was uploaded successfully ';
            }
            $reg_time = time();
            $update7 = mysqli_query($con, "UPDATE $assigned_table SET eCost='$tcost',ecomment='$tcomment',astatus=3,eDate='$reg_time',eCost='$cost',ephoto='$newFilePath[0]',ephoto2='$newFilePath[1]',ephoto3='$newFilePath[2]' WHERE taskID='$taskid' and employeeEmail='$employeeid'");
            if (!$update7) {
                $error = 'Update Error - '.mysqli_error($con);
            } else {
                $select9 = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $task_table WHERE taskID='$taskid'"));
                $detail = 'Task <b>'.$select9['ttitle'].'</b> was completed by '.$employeeid;
                ProjectLog($con, $detail, $projectid, $managerid);
                $result = 'Task <b>'.$select9['ttitle'].'</b> has been marked as complete';
            }
        }
        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'new_task':
        $array = ['title', 'desc', 'projectid', 'milestoneid', 'duration', 'depend', 'managerid'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $desc = htmlentities(htmlspecialchars($desc));
        if (empty($title) || empty($desc)) {
            $error = 'All fields are required!';
        } elseif (!is_numeric($projectid) || !is_numeric($managerid) || !is_numeric($depend) || !is_numeric($duration) || !is_numeric($milestoneid)) {
            $error = 'Your form contains invalid characters!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select title from $task_table where projectID='$projectid' AND milestoneID='$milestoneid'")) > 0) {
            $error = 'Task Title Already Exist';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $project_table where projectID='$projectid'")) != 1) {
            $error = 'Project Not found!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $milestone_table where milestoneID='$milestoneid'")) != 1) {
            $error = 'Milestone Not found!';
        } else {
            $reg_time = time();
            $insert4 = mysqli_query($con, "INSERT INTO $task_table (ttitle,tdetail,milestoneID,projectID,duration,dependID,addDate,managerID) VALUES ('$title','$desc','$milestoneid','$projectid','$duration','$depend','$reg_time','$managerid')");
            if (!$insert4) {
                $error = 'Insert Error - '.mysqli_error($con);
            } else {
                $detail = 'New Task <b>'.$title.'</b> was created';
                ActivityLog($con, $detail, $projectid, $managerid);
                $result = 'New Task was added successfully';
            }
        }
        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'new_listing':
        $array = ['title', 'info', 'city', 'state', 'country', 'info', 'price', 'ltype', 'atype', 'managerid', 'address'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', substr($title, 0, 50)));
        $address = filter_var($address, FILTER_SANITIZE_STRING);
        $desc = htmlentities(htmlspecialchars($info));
        if (empty($title) || empty($desc)) {
            $error = 'All fields are required!';
        } elseif (!is_numeric($city) || !is_numeric($state) || !is_numeric($country) || !is_numeric($price) || !is_numeric($managerid) || !is_numeric($atype) || !is_numeric($ltype)) {
            $error = 'Your form contains invalid characters!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $apartment_table where name='$title'")) > 0) {
            $error = 'Title Already Exists!';
        } elseif (count($_FILES['upload']['name']) < 1) {
            $error = 'You must upload at least 1 photo!';
        } elseif (count($_FILES['upload']['name']) > 8) {
            $error = 'You can upload maximum of 8 photos!';
        } else {
            if (isset($_FILES['upload']['name'])) {
                $total = count($_FILES['upload']['name']);

                // Loop through each file
                for ($i = 0; $i < $total; $i++) {
                    //Get the temp file path
                    $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
                    $filename = $_FILES['upload']['name'][$i];
                    $owo = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $size = $_FILES['upload']['size'][$i];
                    if (!in_array($owo, ['jpg', 'jpeg', 'png', 'gif'])) {
                        echo 'Error: Invalid File <b>'.$filename."</b> - Only 'jpg','jpeg','png','gif' allowed!";
                        exit();
                    } elseif ((number_format(($size / 1024 / 1024), 2)) > 2) {
                        echo 'Error: Maximum filesize is 2MB. <b>'.$filename.'</b> is '.number_format(($size / 1024 / 1024), 2).' MB';
                        exit();
                    }
                    //Make sure we have a filepath
                    if ($tmpFilePath != '') {
                        //Setup our new file path
                        $newFilePath = '../uploads/'.$_FILES['upload']['name'][$i];

                        //Upload the file into the temp dir
                        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $file[] = 'uploads/'.$_FILES['upload']['name'][$i];
                        }
                    }
                }
                $result .= ' '.$total.' file(s) have been uploaded. ';
            }
            $reg_time = time();
            $insert4 = mysqli_query($con, "INSERT INTO $apartment_table(
		name,slug,info,price,agentID,addDate,atype,ltype,city,state,country,address,image1,image2,image3,image4,image5,image6,image7,image8)
		VALUES
		('$title','$slug','$desc','$price','$managerid','$reg_time','$atype','$ltype','$city','$state','$country','$address','$file[0]','$file[1]','$file[2]','$file[3]','$file[4]','$file[5]','$file[6]','$file[7]'
		)
		");
            if (!$insert4) {
                $error = 'Insert Error - '.mysqli_error($con);
            } else {
                $detail = 'New Listing <b>'.$title.'</b> was created';
                ActivityLog($con, $detail, $managerid);
                $result = 'New Listing was added successfully';
            }
        }
        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'mprofile':
//error_reporting(E_WARNING);
        $array = ['fullname', 'phone', 'managerID'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $fullname = filter_var($fullname, FILTER_SANITIZE_STRING);
        $error = $validate->number($managerID, 4);
        $error .= $validate->number($phone, 4);
        if (strlen($_FILES['myphoto']['name']) > 4) {
            $filearray = $_FILES['myphoto'];
            $error .= $file->photo($filearray, 2);
        }
        if (!$error) {
            if (strlen($_FILES['myphoto']['name']) > 4) {
                $name = $filearray['name'];
                $tmpName = $filearray['tmp_name'];
                $uploaddir = 'uploads/';
                $uploadfile = $uploaddir.basename($name);
                $url = '../'.$uploadfile;
                if (move_uploaded_file($tmpName, $uploadfile)) {
                    $result = 'File <b>'.$name.'</b> was successfully uploaded!';
                } else {
                    $error = 'File upload failed!';
                }
            }
            $uptime = time();
            $update = mysqli_query($con, "UPDATE $user_table SET fullname='$fullname', phone='$phone',photo='$url' WHERE managerID='$managerID'");
            if (!$update) {
                $error = 'Update Error - '.mysqli_error($con);
            } else {
                $detail = 'Account <b>'.$fullname.'</b> was updated';
                ActivityLog($con, $detail, $managerID);
                $result .= ' Profile Updated successfully';
            }
        }
        if (isset($error) && strlen($error) > 10) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'eprofile':
        $array = ['fullname', 'phone', 'employeeID', 'website', 'jobdesc'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $fullname = filter_var($fullname, FILTER_SANITIZE_STRING);
        $jobdesc = htmlentities(htmlspecialchars($jobdesc));
        if (!is_numeric($phone)) {
            $error = 'Enter a valid phone number!';
        } elseif (!is_numeric($employeeID)) {
            $error = 'Your form contains invalid chaaracters!';
        } elseif (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
            $error .= 'Please enter a valid URL!';
        } else {
            if (isset($_FILES['myphoto']['name'])) {
                $name = $_FILES['myphoto']['name'];
                $tmpName = $_FILES['myphoto']['tmp_name'];
                $error = $_FILES['myphoto']['error'];
                $size = $_FILES['myphoto']['size'];
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $error = 'Invalid file extension.';
                } elseif ($size / 512 / 512 > 2) {
                    $error = 'File size is exceeding maximum allowed size.';
                } else {
                    $uploaddir = '../uploads/';
                    $uploadfile = $uploaddir.basename($name);
                    if (move_uploaded_file($tmpName, $uploadfile)) {
                        $result = 'File <b>'.$name.'</b> was successfully uploaded!';
                    } else {
                        $error = 'File upload failed!';
                    }
                }
            }
            $uptime = time();
            $update2 = mysqli_query($con, "UPDATE $employee_table SET fullname='$fullname', phone='$phone',photo='$uploadfile',website='$website',jobDesc='$jobdesc' WHERE employeeID='$employeeID'");
            if (!$update2) {
                $error = 'Update Error - '.mysqli_error($con);
            } else {
                $detail = 'Account <b>'.$fullname.'</b> was updated';
                ActivityLog($con, $detail, $employeeID, $type = 1);
                $result .= ' Profile Updated successfully';
            }
        }
        if (isset($error) && strlen($error) > 10) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'new_project':
        $array = ['title', 'desc', 'startdate', 'enddate', 'budget', 'status'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $desc = htmlentities(htmlspecialchars($desc));
        $startdate = strtotime(filter_var($startdate, FILTER_SANITIZE_STRING));
        $enddate = strtotime(filter_var($enddate, FILTER_SANITIZE_STRING));
        $budget = filter_var($budget, FILTER_SANITIZE_STRING);
        $status = filter_var($status, FILTER_SANITIZE_STRING);
        if (empty($title) || empty($desc) || empty($startdate) || empty($enddate)) {
            $error = 'All fields are required!';
        } elseif ($enddate < strtotime('today') || $startdate < strtotime('today')) {
            $error = 'Date cannot be less than today!';
        } elseif ($enddate < $startdate) {
            $error = 'End Date must be greater than Start date';
        } elseif ($status == 1 && $startdate > strtotime('today')) {
            $error = 'Start date must be today if project should start immediately';
        } elseif (mysqli_num_rows(mysqli_query($con, "select title from $project_table where title='$title'")) > 0) {
            $error = 'Title Already Exist';
        } else {
            $reg_time = time();
            $m = mysqli_fetch_assoc(mysqli_query($con, "SELECT fullname from $user_table where managerID='".$_SESSION['managerID']."'"));
            $managername = $m['fullname'];
            $insert = mysqli_query($con, "INSERT INTO $project_table (title,detail,startDate,endDate,addDate,budget,projectStatus,managerID) VALUES ('$title','$desc','$startdate','$enddate','$reg_time','$budget','$status','".$_SESSION['managerID']."')");
            if (!$insert) {
                $error = 'Insert Error - '.mysqli_error($con);
            } else {
                $detail = 'Project <b>'.$title.'</b> was created';
                $f = mysqli_fetch_assoc(mysqli_query($con, "SELECT max(projectID) as id FROM $project_table"));
                $projectid = $f['id'];
                ProjectLog($con, $detail, $projectid, $_SESSION['managerID']);
                $result = 'New Project added successfully by <b>'.$managername.'</b>';
            }
        }
        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'new_milestone':
        $array = ['title', 'desc', 'startdate', 'projectid', 'managerid', 'tag'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $desc = htmlentities(htmlspecialchars($desc));
        $startdate = strtotime(filter_var($startdate, FILTER_SANITIZE_STRING));
        if (empty($title) || empty($desc) || empty($startdate)) {
            $error = 'All fields are required!';
        } elseif (!is_numeric($projectid) || !is_numeric($managerid) || !is_numeric($tag)) {
            $error = 'Your form contains invalid characters!';
        } elseif ($startdate < strtotime('today')) {
            $error = 'Date cannot be less than today!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select title from $milestone_table where title='$title'")) > 0) {
            $error = 'Title Already Exist';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $project_table where projectID='$projectid'")) != 1) {
            $error = 'Project Not found!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select startDate from $milestone_table where projectID='$projectid' and startDate='$startdate'")) > 0) {
            $error = 'A Milestone already exists on this date for this project';
        } else {
            $po = mysqli_fetch_assoc(mysqli_query($con, "select * from $project_table where projectID='$projectid'"));
            if ($startdate < $po['startDate'] || $startdate > $po['endDate']) {
                $error = 'Milestone Date Must be within Project Duration!';
            } else {
                $reg_time = time();
                $insert3 = mysqli_query($con, "INSERT INTO $milestone_table (mtitle,mdetail,startDate,addDate,projectID,tagID,managerID) VALUES ('$title','$desc','$startdate','$reg_time','$projectid','$tag','$managerid')");
                if (!$insert3) {
                    $error = 'Insert Error - '.mysqli_error($con);
                } else {
                    $detail = 'Milestone <b>'.$title.'</b> was created';
                    ProjectLog($con, $detail, $projectid, $managerid);
                    $result = 'New Milestone was added successfully';
                }
            }
        }
        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'login':
        $array = ['email', 'password', 'remember'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }

        $uemail = filter_var($email, FILTER_SANITIZE_STRING);
        $pasword = filter_var($password, FILTER_SANITIZE_STRING);
        $pword = md5($pasword);

        if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM $user_table WHERE email='$uemail' AND password='$pword'")) != 1) {
            $error = 'Email and password does not match!';
        } else {
            $login = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $user_table WHERE email='$uemail' AND password='$pword'"));
            session_regenerate_id(true);
            //session_start();
            $_SESSION['managerID'] = $login['managerID'];
            $last_login = time();
            $update_login = mysqli_query($con, "UPDATE $user_table SET lastLogin='$last_login' where managerID='".$_SESSION['managerID']."'");
            $detail = 'New Login from <b>'.$_SERVER['HTTP_USER_AGENT'].'</b>';
            ActivityLog($con, $detail, $_SESSION['managerID']);
            if ($remember == 1) {
                $cookie_name = 'managerID';
                $cookie_value = $login['managerID'];
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/'); // 86400 = 1 day
            }
            if ($login['LastLogin'] < 1) {
                $result = 'Login Successful. Redirecting to profile page in 3 seconds. <script>window.setTimeout(function(){ window.location = "'.$website_url.'/manager/EditProfile"; },3000)</script>';
            } else {
                $result = 'Login Successful. Redirecting in 5 seconds. <script>window.setTimeout(function(){ window.location = "'.$website_url.'/manager/"; },5000)</script>';
            }
        }
        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'elogin':
        $array = ['email', 'password', 'remember'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }

        $uemail = filter_var($email, FILTER_SANITIZE_STRING);
        $pasword = filter_var($password, FILTER_SANITIZE_STRING);
        $pword = md5($pasword);

        if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM $employee_table WHERE email='$uemail' AND password='$pword'")) != 1) {
            $error = 'Email and password does not match!';
        } else {
            $login = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $employee_table WHERE email='$uemail' AND password='$pword'"));
            session_regenerate_id(true);
            //session_start();
            $_SESSION['employeeID'] = $login['employeeID'];
            $last_login = time();
            $update_login = mysqli_query($con, "UPDATE $employee_table SET lastLogin='$last_login' where employeeID='".$_SESSION['employeeID']."'");
            $detail = 'New Login from <b>'.$_SERVER['HTTP_USER_AGENT'].'</b>';
            ActivityLog($con, $detail, $_SESSION['employeeID'], $type = 1);
            if ($remember == 1) {
                $cookie_name = 'employeeID';
                $cookie_value = $login['employeeID'];
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/'); // 86400 = 1 day
            }
            if ($login['lastLogin'] < 1) {
                $result = 'Login Successful. Redirecting to profile page in 3 seconds. <script>window.setTimeout(function(){ window.location = "'.$website_url.'/employee/EditProfile"; },3000)</script>';
            } else {
                $result = 'Login Successful. Redirecting in 5 seconds. <script>window.setTimeout(function(){ window.location = "'.$website_url.'/employee/"; },5000)</script>';
            }
        }
        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'register':
//error_reporting(E_ALL);
        $array = ['email', 'password', 'confpass'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $confpass = filter_var($confpass, FILTER_SANITIZE_STRING);
        if (empty($email) || empty($password) || empty($confpass)) {
            $error = 'All fields are required!';
        } elseif (($validate->email($email, false)) === false) {
            $error = 'Enter a valid Email';
        } elseif (strlen($validate->password($password)) > 5) {
            $error = $validate->password($password);
        } elseif ($password != $confpass) {
            $error = 'Passwords do not match!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $user_table where email='$email'")) > 0) {
            $error = 'Email Already Exist';
        } else {
            $pword = md5($password);
            $reg_time = time();
            $date = date('D M Y g:i a', $reg_time);
            $insert = mysqli_query($con, "INSERT INTO $user_table (email,password,addDate) VALUES ('$email','$pword','$reg_time')");
            if (!$insert) {
                $error = 'Insert Error: '.mysqli_error($con);
            } else {
                $result = 'Registration Successful.';
                /*
                //send welcome email
                        $query = mysqli_query($con,"SELECT * FROM $template_page WHERE type=1");
                        $tempData = mysqli_fetch_assoc($query);

                        //replace template var with value
                        //$actlink = 'https://'.$_SERVER['SERVER_NAME'].'/Manager/EmailVerification?a='.$k['managerID'].'&b='.$k['email_code'];
                        $fullname="";
                        $token = array(
                    'SITE_URL'  => 'http://'.$_SERVER['SERVER_NAME'],
                    'SITE_NAME' => $option['website_name'],
                    'USER_NAME' => $fullame,
                    'USER_EMAIL'=> $email,
                    'SEND_DATE'=> date('D M Y g:i a',time())
                  //  'ACTIVE_LINK'=> $actlink
                );
                $pattern = '[%s]';
                foreach($token as $key=>$val){
                    $varMap[sprintf($pattern,$key)] = $val;
                }
                $emailContent = strtr($tempData['content'],$varMap);
                        require 'phpmail/PHPMailerAutoload.php';
                        $from = 'noreply@'.$_SERVER['SERVER_NAME'];
                        //$from = $option['sender_email'];
                        //$replyto = $option['reply_email'];
                        $mail = new PHPMailer;
                            try
                                {
                                    $mail->setFrom($from,$option['website_name']);
                                    $mail->addAddress($email);
                                    $mail->addReplyTo($from,'NoReply');
                                    $mail->isHTML(true);
                                    $mail->Subject = $tempData['subject'];
                                    $mail->Body    = $emailContent;
                                    $mail->send();
                                    $result .= " Welcome message sent to <b>".$email."</b>";

                                    $detail = "New sign up as <b>".$email."</b>";
                                    ActivityLog($con,$detail,$k['managerID']);
                                }
                                catch (Exception $e)
                                {
                                    $error .= ' Message could not be sent to '.$email;
                                    $error .=  '<br>Mailer Error: '.$mail->ErrorInfo;
                                }
                                */
            }
        }
        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'eregister':
        $array = ['email', 'password', 'confpass'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $confpass = filter_var($confpass, FILTER_SANITIZE_STRING);
        if (empty($email) || empty($password) || empty($confpass)) {
            $error = 'All fields are required!';
        } elseif (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $error = 'Enter a valid Email';
        } elseif (empty($password) || strlen($password) < 9) {
            $error = 'Password must be greater than 8 Characters';
        } elseif ($password != $confpass) {
            $error = 'Passwords do not match!';
        } elseif (mysqli_num_rows(mysqli_query($con, "select * from $employee_table where email='$email'")) > 0) {
            $error = 'Email Already Exist';
        } else {
            $pword = md5($password);
            $reg_time = time();
            $date = date('D M Y g:i a', $reg_time);
            $insert = mysqli_query($con, "INSERT INTO $employee_table (email,password,joinDate) VALUES ('$email','$pword','$reg_time')");
            if (!$insert) {
                $error = 'Insert Error: '.mysqli_error($con);
            } else {
                $result = 'Registration Successful.';
                //select new user data;
                $k = mysqli_fetch_assoc(mysqli_query($con, "SELECT employeeID FROM $employee_table ORDER BY employeeID DESC LIMIT 1"));
                //send welcome email
                $query = mysqli_query($con, "SELECT * FROM $template_page WHERE type=1");
                $tempData = mysqli_fetch_assoc($query);

                //replace template var with value
                //	$actlink = 'http://'.$_SERVER['SERVER_NAME'].'/EmailVerification?a='.$k['employeeID'].'&b='.$k['email_code'];
                $fullname = '';
                $token = [
                    'SITE_URL'   => 'http://'.$_SERVER['SERVER_NAME'],
                    'SITE_NAME'  => $option['website_name'],
                    'USER_NAME'  => $fullame,
                    'USER_EMAIL' => $email,
                    'SEND_DATE'  => date('D M Y g:i a', time()),
                ];
                $pattern = '[%s]';
                foreach ($token as $key => $val) {
                    $varMap[sprintf($pattern, $key)] = $val;
                }
                $emailContent = strtr($tempData['content'], $varMap);
                require 'phpmail/PHPMailerAutoload.php';
                $from = 'noreply@'.$_SERVER['SERVER_NAME'];
                //$from = $option['sender_email'];
                //$replyto = $option['reply_email'];
                $mail = new PHPMailer();

                try {
                    $mail->setFrom($from, $option['website_name']);
                    $mail->addAddress($email);
                    $mail->addReplyTo($from, 'NoReply');
                    $mail->isHTML(true);
                    $mail->Subject = $tempData['subject'];
                    $mail->Body = $emailContent;
                    $mail->send();
                    $result .= ' Welcome message sent to <b>'.$email.'</b>';

                    $detail = 'New sign up as <b>'.$email.'</b>';
                    ActivityLog($con, $detail, $k['employeeID'], $type = 1);
                } catch (Exception $e) {
                    $error .= ' Message could not be sent to '.$email;
                    $error .= '<br>Mailer Error: '.$mail->ErrorInfo;
                }
            }
        }
        if (isset($error)) {
            echo 'Error: '.$error;
        } else {
            echo $result;
        }
        break;

    case 'contact':
        $array = ['email', 'message', 'website', 'name'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $message = filter_var($message, FILTER_SANITIZE_STRING);
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $website = filter_var($website, FILTER_SANITIZE_STRING);
        if (empty($name) || empty($message)) {
            $error = 'All fields are required!';
        } elseif (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $error = 'Enter a valid Email';
        } else {
            echo SendMail('noreply@'.$_SERVER['SERVER_NAME'], 'Contact Us', 'support@'.$_SERVER['SERVER_NAME'], $message.'<br>Website: '.$website, $name, 'Support');
        }
        break;

    case 'contact_agent':
        $array = ['email', 'message', 'recipient', 'listingid'];
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, $array)) {
                $$key = addslashes($value);
            }
        }
        $message = filter_var($message, FILTER_SANITIZE_STRING);
        if (empty($message)) {
            $error = 'All fields are required!';
        } elseif (!is_numeric($recipient) || !is_numeric($listingid)) {
            $error = 'Your form contins invalid characters!';
        } elseif (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $error = 'Enter a valid Email';
        } elseif (mysqli_num_rows(mysqli_query($con, "SELECT email FROM $user_table WHERE managerID='$recipient'")) != 1) {
            $error = 'All fields are required!';
        } else {
            $fpy = mysqli_fetch_assoc(mysqli_query($con, "SELECT email FROM $user_table WHERE managerID='$recipient'"));
            $it = mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM $apartment_table WHERE aID='$listingid'"));
            echo SendMail('noreply@'.$_SERVER['SERVER_NAME'], 'New Message: '.$it['name'], $fpy['email'], $message.'<br>Date: '.date('d M Y g:i a', time()));
        }
        break;

    default:
        $error = '';
        break;
}
