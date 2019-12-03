<?php

require 'includes/config.php';
require 'includes/functions.php';
$type = filter_input(INPUT_GET, 'value', FILTER_SANITIZE_STRING);
switch ($type) {
case 'recipient':
@$password = $_REQUEST['uemail'];
if (filter_var($password, FILTER_VALIDATE_EMAIL) === false) {
    $error .= 'Please enter a valid email!';
} elseif (mysqli_num_rows(mysqli_query($con, "select * from $employee_table where email='$password'")) != 1) {
    $error .= 'User Not Found!';
} elseif (mysqli_num_rows(mysqli_query($con, "select * from $chat_table where recipientID='$password' and senderID='".$_SESSION['managerID']."'")) > 0) {
    $chatID = mysqli_fetch_assoc(mysqli_query($con, "select chatID from $chat_table where recipientID='$password' and senderID='".$_SESSION['managerID']."' limit 1"));
    $error .= 'You have an existing chat with this user! <a target="_blank" href="ViewChat?id='.$chatID.'">Continue Chat</a>';
}
echo $error;
break;

case 'del_chat':
@$password = filter_var($_REQUEST['pid'], FILTER_SANITIZE_STRING);
if (mysqli_num_rows(mysqli_query($con, "select * from $chat_table where chatID='$password'")) < 1) {
    $error .= 'Chat Not Found! <br>';
} else {
    mysqli_query($con, "DELETE from $chat_table where chatID='$password'") or die('Error: '.mysqli_error($con));
    $error .= "Chat deleted successfully! <script>$('.$password').hide();</script>";
    $detail = 'Chat <b>'.$password.'</b> was deleted';
    ActivityLog($con, $detail, $_SESSION['managerID']);
}
echo $error;
break;

case 'del_listing':

@$password = filter_var($_REQUEST['lid'], FILTER_SANITIZE_STRING);
if (mysqli_num_rows(mysqli_query($con, "select * from $apartment_table where aID='$password'")) < 1) {
    $error .= 'Listing Not Found! <br>';
} else {
    mysqli_query($con, "DELETE from $apartment_table where aID='$password'") or die('Error: '.mysqli_error($con));
    $error .= "Listing deleted successfully! <script>$('.$password').hide();</script>";
    $detail = 'Listing <b>'.$password.'</b> was deleted';
    ActivityLog($con, $detail, $_SESSION['managerID']);
}
echo $error;
break;

case 'del_mile':

@$password = filter_var($_REQUEST['pid'], FILTER_SANITIZE_STRING);
if (!is_numeric($password)) {
    $error .= 'Invalid MilestoneID. Recieved ID is '.$password;
} elseif (mysqli_num_rows(mysqli_query($con, "select * from $milestone_table where milestoneID='$password'")) != 1) {
    $error .= 'Milestone Not Found! <br>';
} else {
    $mmm1 = mysqli_fetch_assoc(mysqli_query($con, "select * from $milestone_table where milestoneID='$password'"));
    mysqli_query($con, "DELETE from $milestone_table where milestoneID='$password'") or die('Error: '.mysqli_error($con));
    $error .= "Milestone deleted successfully! <script>$('.$password').hide();</script>";
    $detail = 'Milestone <b>'.$mmm1['title'].'</b> was deleted';
    $projectid = $mmm1['projectID'];
    ActivityLog($con, $detail, $_SESSION['managerID'], $projectid);
}
echo $error;
break;

case 'del_task':

@$password = filter_var($_REQUEST['pid'], FILTER_SANITIZE_STRING);
if (!is_numeric($password)) {
    $error .= 'Invalid TaskID. Recieved ID is '.$password;
} elseif (mysqli_num_rows(mysqli_query($con, "select * from $task_table where taskID='$password'")) != 1) {
    $error .= 'Task Not Found! <br>';
} else {
    $mmm2 = mysqli_fetch_assoc(mysqli_query($con, "select * from $task_table where taskID='$password'"));
    mysqli_query($con, "DELETE from $task_table where taskID='$password'");
    $error .= "Task deleted successfully! <script>$('.$password').hide();</script>";
    $detail = 'Task <b>'.$mmm2['title'].'</b> was deleted';
    $projectid = $mmm2['projectID'];
    ActivityLog($con, $detail, $_SESSION['managerID'], $projectid);
}
echo $error;
break;

case 'del_con':

@$password = filter_var($_REQUEST['pid'], FILTER_SANITIZE_STRING);
if (filter_var($password, FILTER_VALIDATE_EMAIL) === false) {
    $error .= 'Invalid Contractor Email';
} elseif (mysqli_num_rows(mysqli_query($con, "select * from $assigned_table where employeeEmail='$password'")) != 1) {
    $error .= 'Contractor Not Found! <br>';
} else {
    $mmm4 = mysqli_fetch_assoc(mysqli_query($con, "select taskID from $assigned_table where employeeEmail='$password'"));
    $mmm5 = mysqli_fetch_assoc(mysqli_query($con, "select projectID from $task_table where taskID='".$mmm4['taskID']."'"));
    mysqli_query($con, "DELETE from $assigned_table where employeeEmail='$password'");
    $error .= "Contractor deleted successfully! <script>$('.$password').hide();</script>";
    $detail = 'Contractor <b>'.$password.'</b> was deleted';
    $projectid = $mmm5['projectID'];
    ActivityLog($con, $detail, $_SESSION['managerID'], $projectid);
}
echo $error;
break;

case 'del_project':

@$password = filter_var($_REQUEST['pid'], FILTER_SANITIZE_STRING);
if (!is_numeric($password)) {
    $error .= 'Invalid projectID. Recieved ID is '.$password;
} elseif (mysqli_num_rows(mysqli_query($con, "select title from $project_table where projectID='$password'")) != 1) {
    $error .= 'Project Not Found! <br>';
} else {
    $mmm3 = mysqli_fetch_assoc(mysqli_query($con, "select * from $project_table where projectID='$password'"));
    mysqli_query($con, "DELETE from $project_table where projectID='$password'");
    $error .= "Project deleted successfully! <script>$('.$password').hide();</script>";
    $detail = 'Project <b>'.$mmm3['title'].'</b> was deleted';
    $projectid = $mmm3['projectID'];
    ActivityLog($con, $detail, $_SESSION['managerID'], $projectid);
}
echo $error;
break;

case 'start_project':

@$password = filter_var($_REQUEST['pid'], FILTER_SANITIZE_STRING);
if (!is_numeric($password)) {
    $error .= 'Invalid projectID.';
} elseif (mysqli_num_rows(mysqli_query($con, "select title from $project_table where projectID='$password'")) != 1) {
    $error .= 'Project Not Found! <br>';
} else {
    $o = time();
    $mmm4 = mysqli_fetch_assoc(mysqli_query($con, "select * from $project_table where projectID='$password'"));
    mysqli_query($con, "UPDATE $project_table SET projectStatus=1,startDate='$o' where projectID='$password'");
    $error .= "Project started successfully! <script>$('.btn-success').hide();</script>";
    $detail = 'Project <b>'.$mmm4['title'].'</b> was started';
    $projectid = $mmm4['projectID'];
    ProjectLog($con, $detail, $_SESSION['managerID'], $projectid);
}
echo $error;
break;

case 'start_task':

@$password = filter_var($_REQUEST['utask'], FILTER_SANITIZE_STRING);
if (!is_numeric($password)) {
    $error .= 'Invalid TaskID.';
} elseif (mysqli_num_rows(mysqli_query($con, "select * from $assigned_table where id='$password'")) != 1) {
    $error .= 'Task Not Found! <br>';
} else {
    $mmm6 = mysqli_fetch_assoc(mysqli_query($con, "select * from $assigned_table INNER JOIN $task_table ON $assigned_table.taskID=$task_table.taskID where id='$password'"));
    mysqli_query($con, "UPDATE $assigned_table SET astatus=1 where id='$password'");
    $error .= "Task started successfully!<script>$('.btn-success').hide();</script>";
    $detail = 'Task <b>'.html_entity_decode(htmlspecialchars_decode($mmm6['ttitle'])).'</b> was started';
    $projectid = $mmm6['projectID'];
    ProjectLog($con, $detail, $projectid, $_SESSION['employeeID']);
}
echo $error;
break;
case 'ctask':

@$password = filter_var($_REQUEST['utask'], FILTER_SANITIZE_STRING);
$mp = mysqli_query($con, "select * from $milestone_table where projectID='$password'");
$error .= '<br><label class="form-control-label">Milestone: <span class="tx-danger">*</span></label><select onblur="check_mile(this.value)" class="form-control" name="milestoneid">';
while ($mp3 = mysqli_fetch_assoc($mp)) {
    $error .= '<option value="'.$mp3['milestoneID'].'">'.$mp3['mtitle'].'</option>';
}
$error .= '</select>';
echo $error;
break;

case 'state':

@$password = filter_var($_REQUEST['ucountry'], FILTER_SANITIZE_STRING);
$mp = mysqli_query($con, "select * from states where country_id='$password'");
$error .= '<label class="form-control-label">State: <span class="tx-danger">*</span></label><select select-category onblur="check_city(this.value)" class="form-control" name="state">';
while ($mp3 = mysqli_fetch_assoc($mp)) {
    $error .= '<option value="'.$mp3['id'].'">'.$mp3['name'].'</option>';
}
$error .= '</select>';
echo $error;
break;

case 'city':

@$password = filter_var($_REQUEST['ustate'], FILTER_SANITIZE_STRING);
$mp = mysqli_query($con, "select * from cities where state_id='$password'");
$error .= '<label class="form-control-label">City: <span class="tx-danger">*</span></label><select select-category class="form-control" name="city">';
while ($mp3 = mysqli_fetch_assoc($mp)) {
    $error .= '<option value="'.$mp3['id'].'">'.$mp3['name'].'</option>';
}
$error .= '</select>';
echo $error;
break;

case 'cmil':

@$password = filter_var($_REQUEST['umil'], FILTER_SANITIZE_STRING);
$mp = mysqli_query($con, "select * from $task_table where milestoneID='$password'");
$error .= '<br><label class="form-control-label">Task: <span class="tx-danger">*</span></label><select class="form-control" name="taskid">';
while ($mp3 = mysqli_fetch_assoc($mp)) {
    $error .= '<option value="'.$mp3['taskID'].'">'.$mp3['ttitle'].'</option>';
}
$error .= '</select>';
echo $error;
break;

case 'ttitle':

@$password = filter_var($_REQUEST['title'], FILTER_SANITIZE_STRING);
if (strlen($password) < 10) {
    $error .= 'Title too short! Minimum 10 characters. <br>';
} elseif (strlen($password) > 100) {
    $error .= 'Title too long! Maximum 100 characters. <br>';
} elseif (!preg_match('#[a-z]+#', $password)) {
    $error .= 'Title must include at least one letter! <br>';
} elseif (mysqli_num_rows(mysqli_query($con, "select title from $task_table where title='$title'")) > 0) {
    $error .= 'Title Already Exists! <br>';
}
echo $error;
break;
case 'title':

@$password = filter_var($_REQUEST['title'], FILTER_SANITIZE_STRING);
if (strlen($password) < 10) {
    $error .= 'Title too short! Minimum 10 characters. <br>';
} elseif (strlen($password) > 100) {
    $error .= 'Title too long! Maximum 100 characters. <br>';
} elseif (!preg_match('#[a-z]+#', $password)) {
    $error .= 'Title must include at least one letter! <br>';
} elseif (mysqli_num_rows(mysqli_query($con, "select title from $project_table where title='$password'")) > 0) {
    $error .= 'Title Already Exists! <br>';
}
echo $error;
break;

case 'mtitle':

@$password = filter_var($_REQUEST['title'], FILTER_SANITIZE_STRING);
if (strlen($password) < 10) {
    $error .= 'Title too short! Minimum 10 characters. <br>';
} elseif (strlen($password) > 100) {
    $error .= 'Title too long! Maximum 100 characters. <br>';
} elseif (!preg_match('#[A-Za-z]+#', $password)) {
    $error .= 'Title must include at least one letter! <br>';
} elseif (mysqli_num_rows(mysqli_query($con, "select title from $milestone_table where title='$password'")) > 0) {
    $error .= 'Title Already Exists! <br>';
}
echo $error;
break;

case 'ltitle':

@$password = filter_var($_REQUEST['title'], FILTER_SANITIZE_STRING);
if (strlen($password) < 10) {
    $error .= 'Title too short! Minimum 10 characters. <br>';
} elseif (strlen($password) > 100) {
    $error .= 'Title too long! Maximum 100 characters. <br>';
} elseif (!preg_match('#[A-Za-z]+#', $password)) {
    $error .= 'Title must include at least one letter! <br>';
} elseif (mysqli_num_rows(mysqli_query($con, "select name from $apartment_table where name='$password'")) > 0) {
    $error .= 'Title Already Exists! <br>';
}
echo $error;
break;
}
