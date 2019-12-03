<?php

error_reporting(0);
session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'project';

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die('Connection failed: ' . $con->connect_error);
}
$website_code = '0X&KHJ22hast';
$user_table = 'managers';
$option_table = 'options';
$template_table = 'email_templates';
$chat_table = 'chats';
$project_table = 'projects';
$activity_table = 'activities';
$milestone_table = 'milestones';
$employee_table = 'employees';
$task_table = 'tasks';
$status_table = 'statuses';
$tag_table = 'tags';
$projectlog = 'projectlog';
$dependency_table = 'dependencies';
$assigned_table = 'assigned';
$apartment_table = 'apartments';
$apartment_type = 'apartment_types';
$listing_type = 'listing_types';
$website_url = 'http://localhost/project_management';
$option = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM $option_table WHERE website_code='$website_code'"));
