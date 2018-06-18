<?php 
	date_default_timezone_set("Asia/Rangoon");
	$d=date("Y/m/d");
	$today = date("m-d-Y");
	//echo $today;
	/*date_sub($today,date_interval_create_from_date_string("1 day"));
	echo date_format($today,"Y-m-d");*/
	//echo $today."</br>";
	 $time = strtotime($d.' -1 day');
    	$yesterday = date("m-d-Y", $time);
    	$dashyesterday = date("Y-m-d", $time);

    	$time3 = strtotime($d.' -7 day');
    	$week = date("m-d-Y", $time3);

    	$time2 = strtotime($d.' -1 month');
    	$specdate = date("m-d-Y", $time2);

    	$time1 = strtotime($d.' +1 day');
    	$tomorrow = date("m-d-Y", $time1);
    	$dashtomorrow = date("Y-m-d", $time1);

	//echo $tomorrow;
	$dd=explode("/",$d);
	$s=implode("",$dd);
	$time=strtotime($s);
	$date=date("Y/m/d", $time);
	
	/*$date = new DateTime('19:24:15 06/13/2013');
	echo $date->format('h:i:s a m/d/Y') ;*/
	$cutime = date("h:i:s");
	$autotime = date("h:i a");
	$aatime = date("h:i:s a");
	//echo $autotime;
	//echo $cutime;
	$tt=explode(":",$cutime);
	$t=implode("",$tt);


	// set default timezone

$a = ['aper'=>'aa','uper'=>'bb'];
$b = ['aper'=>'aa','uper'=>'bb'];
$arrequal = array_diff($a, $b);
//print_r($arrequal);
/*if ($a == $b) {
	echo "arraysAreEqual";
}
else{
	echo "not";
}*/

?>