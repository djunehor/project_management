<?php
require 'includes/config.php';
//$validate = new validateInput();
$type = $_GET['value'];
$error="";
switch($type) {
case 'photo':
$file = @$_REQUEST['uphoto'];
$imageFileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));
$filename = pathinfo($file,PATHINFO_BASENAME);
if (!in_array($imageFileType, array('jpg','jpeg','png','gif')) )
{
$error .= "Invalid File: Only 'jpg','jpeg','png','gif' allowed! File is ".$filename;
}
elseif (preg_match('/ /',$filename))
{
$error .= "Invalid Filename: File name should not contain space!";	
}
echo $error;
break;

case 'doc':
$imageFileType = pathinfo(@$_REQUEST['udoc'],PATHINFO_EXTENSION);
if ( !in_array($imageFileType, array('jpg','jpeg','png','gif','pdf','doc','docx')) )
{
$error .= "Invalid File: Only 'jpg','jpeg','png','gif','pdf','doc','docx' allowed!";
}
echo $error;
break;

default:
$error = '';
break;
}
?>