<?php
class validateInput {
	/*Method to validate password
	*example: echo $object->password($value,$mininum_length,$maximum_length);
	*last 2 parameters are optional
	*comment out unnecessary validation
	*/
	function password($value,$min=6,$max=20) {
		if(!is_int($min) || !is_int($max)) {$output = 'Invalid arguments supplied!';}
		elseif(strlen($value)<$min) {$output = "Password too short! Minimum $min characters."; }
		elseif(strlen($value)>$max) {$output = "Password too long! Maximum $max characters."; }
		elseif(!preg_match("#[0-9]+#", $value)) {$output = "Password must include at least one number!"; }
		elseif(!preg_match("#[a-z]+#", $value)) {$output = "Password must include at least one letter!"; } 
	//	elseif(!preg_match("#[A-Z]+#", $value)) {$output = "Password must include at least one CAPS!"; } 
	//	elseif( !preg_match("#\W+#", $value)) {$output = "Password must include at least one symbol!"; }
return $output;
	}

	function email($email,$dns_check=true) {
		if(filter_var($email,FILTER_VALIDATE_EMAIL)==false) {
			return FALSE; }
		if(!preg_match("#[a-z]+#", $email)) {
			return FALSE; }
 $array = explode('@', $email);
  if(count($array) < 2) {
    return FALSE;
  }
  $domain = end($array);
  array_pop($array);
  if(function_exists('idn_to_ascii')) {
    //php filter no workie with unicode characters
    $domain = idn_to_ascii($domain);
  }
  $ipcheck = preg_replace(array('/^\[ipv6\:/i', '/^\[/', '/\]$/'), '', $domain);
  if(filter_var($ipcheck, FILTER_VALIDATE_IP)) {
    // it's an IP address
    if(! filter_var($ipcheck, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
      return FALSE;
    }
  } else {
    // it's a domain name
    //   php bug - FILTER_VALIDATE_EMAIL doesn't like naked TLD
    if(! filter_var('user@a.' . $domain, FILTER_VALIDATE_EMAIL)) {
      return FALSE;
    }
    if($dns_check) {
      if(! dns_get_record($domain)) {
        return FALSE;
      }
    }
  }
			}	

/*Method to validate numbers
	*example: echo $object->number($value,$type);
	*$type options
	0: all numbers ( e.g 111222 | 2.3223 | -343 | 2.343e7 )
	1: non-negative numbers ( e.g 111222 | 2.3223 | 2.343e7 )
	2: all integers ( e.g 1112 | -343  )
	3: non-negative integers ( e.g 1112  )
	4: STRING numbers ( e.g 1112  )
	*$type is optional
	*/
	function number($value,$type=0) {
		//check if is number
		switch($type) {
			
			case 0:
			if(!is_numeric($value) || !ctype_digit($value)) {
				$output = 'Not a Valid Number';
			}
			break;
			case 1:
			if(!is_numeric($value) || $value<0) {
				$output = 'Only positive Numbers allowed';
			}
			break;
			case 2:
			if(!is_int($value)) {
				$output = 'Not a Valid Integer';
			}
			break;
			case 3:
			if(!is_int($value) || $value<0) {
				$output = 'Not a Valid Integer';
			}
			case 4:
			if(!ctype_digit($value) || $value<0) {
				$output = 'Not a Valid Number';
			}
			break;
			default:
			$output = 'Invalid argument passed!';
			break;
		}
			return $output;
}

	function strings($input) {
        $o = preg_replace('/\n{2,}/', "\n\n", $input);
        $o = nl2br($o,FALSE);
        // Strip any odd characters
        $output = preg_replace('/[^A-Za-z0-9\. -\!\?\(\)\<\>\@]/', "", $o);
    // Return the array
    return $output;
}

	function url($value) {
		if(filter_var($value, FILTER_SANITIZE_URL)===false) {
		$output = "Invalid URL!";	
		} elseif (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$value)) {
		$output = "Please enter a valid URL!";
		}
	return $output;
}

function dates($date) { 
    if (false === strtotime($date)) { 
        return false;
    } 
    list($year, $month, $day) = explode('-', $date); 
    return true;
}
}

class validateFile {
	function photo($file,$max=0.2) {
//Get the temp file path
$filename = $file['name'];
$owo = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
$size = $file['size'];
if (!in_array($owo, array('jpg','jpeg','png','gif')) )
{
$output = "Invalid File <b>".$filename."</b> - Only 'jpg','jpeg','png','gif' allowed!";
}
elseif((number_format(($size/1024/1024),2))>$max)
{
$output = "Maximum filesize is $max MB. <b>".$filename."</b> is ".number_format(($size/1024/1024),2)." MB";
}
return $output;
	}
}
?>