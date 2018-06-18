<?php 
	include("connectdb.inc");
  	$data1 = array();
  	$sql1="SELECT league_id, leaguename from leagues";
  	$res1=mysql_query($sql1, $connect)or die("Error in sql "+$sql1);	
	while($r1 = mysql_fetch_assoc($res1)){
		$data1[] = $r1;
	}
	$data2 = array();
	$sql2="SELECT team_id, teamname from teams";
  	$res2=mysql_query($sql2, $connect)or die("Error in sql "+$sql2);	
	while($r2 = mysql_fetch_assoc($res2)){
		$data2[] = $r2;
	}
	$data3 = array();
	$sql3="SELECT score_id, scorename from scores";
  	$res3=mysql_query($sql3, $connect)or die("Error in sql "+$sql3);	
	while($r3 = mysql_fetch_assoc($res3)){
		$data3[] = $r3;
	}
	$data4 = array();
	$sql4="SELECT body_id, bodyname from bodies";
  	$res4=mysql_query($sql4, $connect)or die("Error in sql "+$sql4);	
	while($r4 = mysql_fetch_assoc($res4)){
		$data4[] = $r4;
	}
	$data5 = array();
	$sql5="SELECT goalplus_id, goalname from goalplus";
  	$res5=mysql_query($sql5, $connect)or die("Error in sql "+$sql5);	
	while($r5 = mysql_fetch_assoc($res5)){
		$data5[] = $r5;
	}
	/*$data6 = array();
	$sql6="SELECT amount from members WHERE id=1";
  	$res6=mysql_query($sql6, $connect)or die("Error in sql "+$sql6);	
	while($r6 = mysql_fetch_assoc($res6)){
		$data6[] = $r6;
	}
	$data7 = array();
	$sql7="SELECT * from mledger WHERE member_id=1";
  	$res7=mysql_query($sql7, $connect)or die("Error in sql "+$sql7);	
	while($r7 = mysql_fetch_assoc($res7)){
		$data7[] = $r7;
	}*/
	$data = array("league"=>$data1,"team"=>$data2,"score"=>$data3,"body"=>$data4,"goal"=>$data5);
	print json_encode($data);
?>