<?php
require 'includes/config.php';
require 'includes/class.validate_input.php';
$validate = new validateInput();
$type = $_GET['value'];
$error="";
switch($type)
{

case 'url':
@$url= filter_var($_REQUEST['uurl'], FILTER_SANITIZE_STRING); 
echo $validate->url($url);
break;

case 'cookie':
setcookie("test_cookie", "test", time() + 3600);
if(count($_COOKIE)<1)
	echo 'No Cookie permitted!';
break;

case 'number':
@$number= filter_var($_REQUEST['unum'], FILTER_SANITIZE_STRING); 
echo $validate->number($number,1);
break;

case 'email':
@$email= filter_var($_REQUEST['uemail']); 
if(($validate->email($email,false))===FALSE)
	echo 'Invalid Email';
break;

case 'password':
@$value= filter_var($_REQUEST['upass'], FILTER_SANITIZE_STRING); 
echo $validate->password($value,6);
break;

case 'date':
@$date= filter_var($_REQUEST['udate'], FILTER_SANITIZE_STRING); 
if(($validate->dates($date))===false)
	echo 'Invalid Date';
break;

default:
$error .= "No data to validate";
break;
}
?>