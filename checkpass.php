<?php 
	$data = json_decode(file_get_contents("php://input"));
	$oldpass = mysql_real_escape_string($data->oldpass);
	$hvalue = mysql_real_escape_string($data->hashvalue);

	$hvalue = md5($hvalue);
	if ($hvalue == $oldpass) {
			$data = 1;
		}
		else{
			$data = 0;
		}
		print json_encode($data);
 ?>