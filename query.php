<?php 
	session_start();
	include("connectdb.inc");
	include("date.php");
	$data = json_decode(file_get_contents("php://input"));
	$table = mysqli_real_escape_string($connect,$data->type);

	$mainyear = "SELECT currentyear FROM currentyear";
	$resultyear = mysqli_query($connect,$mainyear)or die("Error in query".$mainyear);
	if (mysqli_num_rows($resultyear)<1) {
		$cmainyear = date("Y");
	}
	else{
		while ($a = mysqli_fetch_assoc($resultyear)) {
			$cmainyear = $a["currentyear"];
		}
	}

	function SendMail( $ToEmail, $MessageHTML, $MessageTEXT , $username , $password , $bookingname, $mailsubject) {
		  require_once ( 'class.phpmailer.php' ); // Add the path as appropriate
		  $Mail = new PHPMailer();
		  $Mail->IsSMTP(); 
		  $Mail->Host        = "smtp.gmail.com"; 
		  $Mail->SMTPDebug   = 2; // 2 to enable SMTP debug information
		  $Mail->SMTPAuth    = TRUE; // enable SMTP authentication
		  $Mail->SMTPSecure  = "tls"; //Secure conection
		  $Mail->Port        = 587; // set the SMTP port
		  $Mail->Username    = $username; // SMTP account username
		  $Mail->Password    = $password; // SMTP account password
		  $Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
		  $Mail->CharSet     = 'UTF-8';
		  $Mail->Encoding    = '8bit';
		  $Mail->Subject     = $mailsubject;
		  $Mail->ContentType = 'text/html; charset=utf-8\r\n';
		  
		  $Mail->From        = 'mailfromsitetrion@gmail.com';
		  $Mail->FromName    = 'The MMWBET Mail';
		  $Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line

		  $Mail->AddAddress( $ToEmail ); // To:
		  $Mail->isHTML( TRUE );
		  $Mail->Body    = $MessageHTML;
		  $Mail->AltBody = $MessageTEXT;
		  $Mail->Send();
		  $Mail->SmtpClose();

		  if ( $Mail->IsError() ) { // ADDED - This error checking was missing
		    return FALSE;
		  }
		  else {
		    return TRUE;
		  }
	}
	
	if ($table == "login") {
		$uname = mysqli_real_escape_string($connect,$data->username);
		$p = mysqli_real_escape_string($connect,$data->pass);	
		$logincode = mysqli_real_escape_string($connect,$data->logincode);	
		$pa = md5($p);
		$data =array();

		$sql1 ="SELECT d.*,b.bodyname,b.bodytype,g.goalname,g.goaltype,t.tdate,t.ttime,l.leaguename,t1.teamname as Home,t2.teamname as Away 
		FROM dashboard_".$cmainyear." as d 
		LEFT join bodies as b on b.body_id=d.body_id 
		LEFT join goalplus as g on g.goalplus_id=d.goalplus_id 
		inner join timetable as t on t.timetableid=d.timetableid 
		inner join leagues as l on t.league_id=l.league_id 
		inner join teams as t1 on t1.team_id=t.home 
		inner join teams as t2 on t2.team_id=t.away 
		where t.recordstatus=1 AND dash_status=2 and io_id!=3 and STR_TO_DATE(t.tdate, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y')  ORDER BY STR_TO_DATE(t.tdate, '%m-%d-%Y') DESC, str_to_date(t.ttime, '%h:%i%p') ASC";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		if (mysqli_num_rows($result)<1) {
			$dash = "No Record";
		}
		else{
			while ($a = mysqli_fetch_assoc($result)) {
				$dash[] = $a;
			}
		}	

		$sql = "SELECT * FROM users WHERE loginid='$uname' and password='$pa' and recordstatus=1";
		$result = mysqli_query($connect,$sql)or die("Error in query".$sql);
		while ($a = mysqli_fetch_assoc($result)) {
			$rid = $a["roleid"];
			$userid = $a["userid"];
		}
		if (isset($rid)) {
			if ($rid != 1) {
				$checklogin = "SELECT onoff_id FROM onoff WHERE onofftype='loginonoff' AND member_id=0";
				$checkresult = mysqli_query($connect,$checklogin)or die("Error in query".$checklogin);
				if (mysqli_num_rows($checkresult)>0) {
					echo "Site is under maintenance. You can't login now.";
				}
				else{
					$data = array("roleid"=>$rid, "userid"=>$userid, "dash"=>$dash);
					print json_encode($data);
				}
			}
			else{
				if ($logincode != null) {
					$sqlcheck = "SELECT user_token FROM users WHERE loginid='$uname' and password='$pa' and recordstatus=1";
					$rescheck = mysqli_query($connect,$sqlcheck)or die("Error in query".$sqlcheck);
					if (mysqli_num_rows($rescheck)>0) {
						while ($aa = mysqli_fetch_assoc($rescheck)) {
							$code = $aa["user_token"];
						}
						if ($logincode == $code) {
							$data = array("roleid"=>$rid, "userid"=>$userid, "dash"=>$dash);
							print json_encode($data);
						}
						else{
							echo "Invalid Code!";
						}
					}
					else{
						echo "Your Token Code has expired.";
					}					
					
				}
				else{
					$startval = strtotime($today);
					$endval = strtotime($aatime);
					$passcode = rand($startval,$endval);

					$username='mailfromsitetrion@gmail.com';
	            			$password='trionmail2017!';
					$mailsubject = "MMWBET Code for Login";
					$ToEmail = "adminmmwbet2017@mmwbet.com";
					$ToName = "MMWBET Admin";
					$MessageHTML = "<b>Hi Admin,</b></br><p style='font-weight:bold;'>Code for Login</p><p style='border:2px solid #aaa; width:50%; border-radius: 5px; text-align:center; padding:30px 0px;font-weight: bold;'>Your Code : &nbsp;&nbsp;&nbsp;<span style='font-size:25px;color:green;'>".$passcode."</span></p>";
					$MessageTEXT = "Code for Login";

					$sqladd = "UPDATE users SET user_token=$passcode WHERE loginid='$uname' and password='$pa' and recordstatus=1";
					mysqli_query($connect,$sqladd)or die("Error in query".$sqladd);
					
					//$send = SendMail( $ToEmail, $MessageHTML, $MessageTEXT , $username , $password , $ToName, $mailsubject);
					//echo $send;
					echo 1;
				}
			}
		}
		else{
			$checklogin = "SELECT onoff_id FROM onoff WHERE onofftype='loginonoff' AND member_id=0";
			$checkresult = mysqli_query($connect,$checklogin)or die("Error in query".$checklogin);
			if (mysqli_num_rows($checkresult)>0) {
				echo "Site is under maintenance. You can't login now.";
			}
			else{
				$sql2 = "SELECT * FROM members WHERE loginid='$uname' and password='$pa' and recordstatus=1";
				$result = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
				while ($a = mysqli_fetch_assoc($result)) {
					$rid = $a["roleid"];
					$mid = $a["member_id"];
					$amt = $a["amount"];
					$name = $a["username"];
				}

				if (isset($mid)) {
					$sql3 = "SELECT onoff_id FROM onoff WHERE member_id=$mid AND onofftype='loginonoff'";
					$result = mysqli_query($connect,$sql3)or die("Error in query".$sql3);

					if (mysqli_num_rows($result)<1) {
						$sql4 = "SELECT onoff_id FROM onoff WHERE member_id IN($mid,0) AND onofftype='bettingonoff'";
						$result4 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
						if (mysqli_num_rows($result4)<1) {
							$betonoff = "can";
						}
						else{
							$betonoff = "cannot";
						}

						$sql4 = "SELECT onoff_id FROM onoff WHERE member_id IN($mid,0) AND onofftype='mixbettingonoff'";
						$result4 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
						if (mysqli_num_rows($result4)<2) {
							$mixbetonoff = "cannot";
						}
						else{
							$mixbetonoff = "can";
						}

						$sql5 = "SELECT agent_id FROM agents WHERE member_id=$mid AND recordstatus=1";
						$result5 = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
						if (mysqli_num_rows($result5)<1) {
							$agentid = 0;
						}
						else{
							while ($a5 = mysqli_fetch_assoc($result5)) {
								$agentid = $a5["agent_id"];
							}
						}

						$data = array("roleid"=>$rid, "mname"=>$name, "userid"=>$mid, "total"=>$amt, "dash"=>$dash, "betonoff"=>$betonoff, "mixbetonoff"=>$mixbetonoff, "agentid"=>$agentid);
						print json_encode($data);
					}
					else{
						echo "You can't login now. Please contact with admin.";
					}
				}
				else{
					echo "User Name and Password don't match";
				}
			}			
		}
	}
	elseif ($table == "betmember") {
		$mid = mysqli_real_escape_string($connect,$data->mid);
		$dashid = mysqli_real_escape_string($connect,$data->dashid);
		$beton = mysqli_real_escape_string($connect,$data->beton);
		$betas = mysqli_real_escape_string($connect,$data->betas);
		$amount = mysqli_real_escape_string($connect,$data->amount);
		//$mamount = mysqli_real_escape_string($connect,$data->mamount);

		$sql1 = "SELECT amount FROM members WHERE member_id =$mid and recordstatus=1";
		$res1 = mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);
		while($r1 = mysqli_fetch_assoc($res1)){
			$mmamount = $r1["amount"];
		}
		
			$sql5 = "SELECT timetableid FROM dashboard_".$cmainyear." WHERE dashboard_id = $dashid  and recordstatus=1";
			$res5 = mysqli_query($connect,$sql5, $connect)or die("Error in SQL " .$sql5);
			while ($r5 = mysqli_fetch_assoc($res5)) {
				$tid = $r5["timetableid"];
			}
			$sql4 = "SELECT io_id,bio_id,gio_id,history_id as mid,bs,gs FROM history_".$cmainyear." WHERE history_id in (SELECT MAX(history_id) FROM history_".$cmainyear." WHERE timetableid = $tid)";
			$res4 = mysqli_query($connect,$sql4, $connect)or die("Error in sql ".$sql4);
			while($r4 = mysqli_fetch_assoc($res4)){
				$hid = $r4["mid"];
				$bs = $r4["bs"];
				$gs = $r4["gs"];
				$io = $r4["io_id"];
				$bio = $r4["bio_id"];
				$gio = $r4["gio_id"];
			}
			$mamount = $mmamount - $amount;
			if ($betas == "Body") {
				if ($bs == 1) {
					$sid = 6;
				}
				else{
					$sid = 2;
				}
				$bstateid = $bs;
				if ($beton == "Home") {
					if ($bio == 2 || $bio == 4) {
						$checkio = 0;
					}
					else{
						$checkio = 1;
					}
				}
				elseif ($beton == "Away") {
					if ($bio == 3 || $bio == 4) {
						$checkio = 0;
					}
					else{
						$checkio = 1;
					}
				}
			}
			else if ($betas == "Goal+"){
				if ($gs == 1) {
					$sid = 6;
				}
				else{
					$sid = 2;
				}
				$bstateid = $gs;

				if ($beton == "Over") {
					if ($gio == 2 || $gio == 4) {
						$checkio = 0;
					}
					else{
						$checkio = 1;
					}
				}
				elseif ($beton == "Down") {
					if ($gio == 3 || $gio == 4) {
						$checkio = 0;
					}
					else{
						$checkio = 1;
					}
				}
			}

			if ($checkio != 0) {
				if ($bstateid != 3) {

					$sql2="INSERT INTO mledger_".$cmainyear."(member_id, bet_date, bet_time, dashboard_id, history_id, bet_on, bet, org_amount, bet_amount, betstateid, status_id, recordstatus) 
					VALUES($mid, '$today', '$aatime', $dashid, $hid, '$beton', '$betas', $mamount, $amount, $bstateid, $sid, 1)";
					mysqli_query($connect,$sql2, $connect)or die("Error in sql ".$sql2);

					$sql3 = "UPDATE members SET amount = $mamount WHERE member_id = $mid and recordstatus=1";
					mysqli_query($connect,$sql3, $connect)or die("Error in sql".$sql3);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mid, $mmamount, $mamount, -$amount, 'Betting', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);

					//although can carry from http, to accurate data update(time)

					$sqlall = "SELECT onoff_id FROM onoff WHERE onofftype='commissiononoff' AND member_id=0";
					$resultall = mysqli_query($connect,$sqlall)or die("Error in query".$sqlall);
					if (mysqli_num_rows($resultall)>0) {
						$sql4 = "SELECT com_on_off FROM dashboard_".$cmainyear." WHERE dashboard_id = $dashid";
						$result4 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
						while ($a4 = mysqli_fetch_assoc($result4)) {
							$comonoff = $a4["com_on_off"];
						}

						if ($comonoff == 1) {
							$sql7 = "SELECT agent_id FROM agent_member WHERE member_id = $mid AND recordstatus = 1";
							$result7 = mysqli_query($connect,$sql7)or die("Error in query".$sql7);
							if (mysqli_num_rows($result7)>0) {
								while ($a7 = mysqli_fetch_assoc($result7)) {
									$agid = $a7["agent_id"];
								}

								$sql5 = "SELECT onoff_id FROM onoff WHERE onofftype = 'commissiononoff' AND member_id = $agid";
								$result5 = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
								if (mysqli_num_rows($result5)>0) {
									$sql6 = "SELECT onoff_id FROM onoff WHERE onofftype = 'commissiononoff' AND member_id = $mid";
									$result6 = mysqli_query($connect,$sql6)or die("Error in query".$sql6);
									if (mysqli_num_rows($result6)>0) {
										$sql8 = "SELECT MAX(mledger_id) as mledgerid FROM mledger_".$cmainyear." 
										WHERE member_id = $mid AND dashboard_id = $dashid AND recordstatus = 1";
										$result8 = mysqli_query($connect,$sql8)or die("Error in query".$sql8);
										while ($a8 = mysqli_fetch_assoc($result8)) {
											$mledgerid = $a8["mledgerid"];
										}
										$sql9 = "INSERT INTO agent_commission(member_id, agent_id, bet_type, ledger_id, dash_mix, createddate, createdtime) 
										VALUES($mid, $agid, 'bg', $mledgerid, $dashid, '$today', '$aatime')";
										mysqli_query($connect,$sql9)or die("Error in query".$sql9);
									}
								}
							}											
						}
					}	

					echo "Success Bet";	
				}
				else{
					echo "Sorry, this match is Reject";
				}
			}
			else{
				echo "Sorry, it's Close now";
			}	
	}
	elseif($table == "dash"){
		$mid = mysqli_real_escape_string($connect,$data->mid);
		$btn = mysqli_real_escape_string($connect,$data->btn);
		/*$sqlauto = "UPDATE  dashboard_".$cmainyear." dd
    		INNER JOIN timetable tt
        		ON dd.timetableid = tt.timetableid
		SET dd.io_id=2,dd.gio_id=4,dd.bio_id=4
		WHERE tt.ttime='$autotime' AND STR_TO_DATE(tt.tdate, '%m-%d-%Y')=STR_TO_DATE('".$today."', '%m-%d-%Y') AND dd.io_id!=3";*/
		/*$sqlauto = "UPDATE  dashboard_".$cmainyear." dd
    		INNER JOIN timetable tt
        		ON dd.timetableid = tt.timetableid
		SET dd.io_id=2,dd.gio_id=4,dd.bio_id=4,dd.mix_on_off=0
		WHERE tt.ttime='$autotime' AND tt.tdate='".$today."' AND dd.io_id!=3";*/
		
		$sqlauto = "UPDATE  dashboard_".$cmainyear." dd
		INNER JOIN timetable tt
		ON dd.timetableid = tt.timetableid
		SET dd.mix_on_off=IF(dd.mix_on_off=2,dd.mix_on_off,0),dd.io_id=2,dd.gio_id=4,dd.bio_id=4
		WHERE tt.ttime='$autotime' AND tt.tdate='".$today."' AND dd.io_id!=3";
		
		mysqli_query($connect,$sqlauto)or die("Error in query".$sqlauto);

		$sqlauto1 = "UPDATE  history_".$cmainyear." as h1
		INNER JOIN (SELECT Max(history_id)as history_id FROM history_".$cmainyear." as h INNER JOIN timetable on h.timetableid=timetable.timetableid WHERE timetable.recordstatus=1 AND timetable.ttime='$autotime' AND timetable.tdate='".$today."' GROUP BY h.timetableid) h2
		ON h1.history_id=h2.history_id
		SET h1.io_id=2,h1.gio_id=4,h1.bio_id=4
		WHERE h1.io_id!=3";
		mysqli_query($connect,$sqlauto1)or die("Error in query".$sqlauto1);
		//$sql1 ="SELECT d.*,b.bodyname,b.bodytype,g.goalname,g.goaltype,t.tdate,t.ttime,l.leaguename,t1.teamname as Home,t2.teamname as Away FROM dashboard_".$cmainyear." as d LEFT join bodies as b on b.body_id=d.body_id LEFT join goalplus as g on g.goalplus_id=d.goalplus_id inner join timetable as t on t.timetableid=d.timetableid inner join leagues as l on t.league_id=l.league_id inner join teams as t1 on t1.team_id=t.home inner join teams as t2 on t2.team_id=t.away where dash_status=2 and t.tdate='$today'";
		//$sql1 ="SELECT d.*,b.bodyname,b.bodytype,g.goalname,g.goaltype,t.tdate,t.ttime,l.leaguename,t1.teamname as Home,t2.teamname as Away FROM dashboard_".$cmainyear." as d LEFT join bodies as b on b.body_id=d.body_id LEFT join goalplus as g on g.goalplus_id=d.goalplus_id inner join timetable as t on t.timetableid=d.timetableid inner join leagues as l on t.league_id=l.league_id inner join teams as t1 on t1.team_id=t.home inner join teams as t2 on t2.team_id=t.away where dash_status=2 and io_id!=3";
		
		$sql1 ="SELECT d.*,b.bodyname,b.bodytype,g.goalname,g.goaltype,t.tdate,t.ttime,l.leaguename,t1.teamname as Home,t2.teamname as Away,
		(CASE WHEN(b.bodyname like 'H%') THEN 'hh' ELSE 'oth' END) as bodygoal,
		(CASE WHEN(b.bodyname like 'A%') THEN 'hh' ELSE 'oth' END) as goalbody,
		(CASE WHEN(d.hper<0) THEN 'red' ELSE 'black' END) as hclassname,
		(CASE WHEN(d.aper<0) THEN 'red' ELSE 'black' END) as aclassname,
		(CASE WHEN(d.dper<0) THEN 'red' ELSE 'black' END) as dclassname,
		(CASE WHEN(d.uper<0) THEN 'red' ELSE 'black' END) as uclassname 
		FROM dashboard_".$cmainyear." as d 
		LEFT join bodies as b on b.body_id=d.body_id 
		LEFT join goalplus as g on g.goalplus_id=d.goalplus_id 
		inner join timetable as t on t.timetableid=d.timetableid 
		inner join leagues as l on t.league_id=l.league_id 
		inner join teams as t1 on t1.team_id=t.home 
		inner join teams as t2 on t2.team_id=t.away 
		where dash_status=2 AND t.recordstatus=1 and io_id!=3  and STR_TO_DATE(t.tdate, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y')  ORDER BY STR_TO_DATE(t.tdate, '%m-%d-%Y') ASC, str_to_date(t.ttime, '%h:%i%p') ASC";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);

		if (mysqli_num_rows($result)<1) {
			$dash = "No Record";
		}
		else{
			while ($a = mysqli_fetch_assoc($result)) {
				$dash[] = $a;
			}
		}

		if ($btn == "bet") {
			$dashid = mysqli_real_escape_string($connect,$data->dashid);
			$sql11 = "SELECT history_".$cmainyear.".* FROM dashboard_".$cmainyear." 
			INNER JOIN timetable on dashboard_".$cmainyear.".timetableid = timetable.timetableid
			INNER JOIN history_".$cmainyear." on timetable.timetableid = history_".$cmainyear.".timetableid
			WHERE history_".$cmainyear.".history_id=(SELECT MAX(history_id) FROM history_".$cmainyear." INNER JOIN timetable ON timetable.timetableid=history_".$cmainyear.".timetableid INNER JOIN dashboard_".$cmainyear." ON dashboard_".$cmainyear.".timetableid=timetable.timetableid WHERE timetable.recordstatus=1 AND dashboard_".$cmainyear.".dashboard_id=$dashid)";
			$result11 = mysqli_query($connect,$sql11)or die("Error in query".$sql11);
			if (mysqli_num_rows($result11)<1) {
				$dashval = "No Record";
			}
			else{
				while ($a = mysqli_fetch_assoc($result11)) {
					$dashval[] = $a;
				}
			}
		}
		
		if ($mid == "and 1=1") {
			$m = "Admin";
			$mname = "Admin";
		}
		else{
			
			$sql2 = "SELECT a.* from members as a WHERE 1=1 $mid and recordstatus=1";
			$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			while ($a2 = mysqli_fetch_assoc($result2)) {
				$m = $a2["amount"];
				$mname = $a2["username"];
			}
		}

		$sql10 = "SELECT lg.leaguename,t.league_id FROM dashboard_".$cmainyear." as db inner join timetable as t on t.timetableid=db.timetableid INNER JOIN leagues as lg on t.league_id=lg.league_id  where t.recordstatus=1 AND db.dash_status=2 and db.io_id!=3 
		and STR_TO_DATE(t.tdate, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') 
		and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y') 
		GROUP by t.league_id
		ORDER BY STR_TO_DATE(t.tdate, '%m-%d-%Y') ASC, str_to_date(t.ttime, '%h:%i%p') ASC";

		$result10 = mysqli_query($connect,$sql10)or die("Error in query".$sql10);
		if (mysqli_num_rows($result10)<1) {
			$dashleague = "No Record";
		}
		else{
			while ($aa = mysqli_fetch_assoc($result10)) {
				$dashleague[] = $aa;
			}
		}

		$sql11 = "SELECT * FROM mix_min_max WHERE recordstatus=1";
		$result11 = mysqli_query($connect,$sql11)or die("Error in query".$sql11);
		if (mysqli_num_rows($result11)<1) {
			$min = 0;
			$max = 0;
		}
		else{
			while ($aaa = mysqli_fetch_assoc($result11)) {
				$min = $aaa["min_limit"];
				$max = $aaa["max_limit"];
			}
		}

		if ($btn == "bet") {
			$records = array("leag"=>$dashleague,"dash"=>$dash, "m"=>$m, "mname"=>$mname, "dashval"=>$dashval, "min"=>$min, "max"=>$max);
		}
		else{
			$records = array("leag"=>$dashleague,"dash"=>$dash, "m"=>$m, "mname"=>$mname, "min"=>$min, "max"=>$max);
		}
		
		print json_encode($records);
	}
	elseif($table == "checkpercent"){
		$btn = mysqli_real_escape_string($connect,$data->btn);		
		$mbrid = mysqli_real_escape_string($connect,$data->mbrid);

		if ($btn == "check") {
			$bg = mysqli_real_escape_string($connect,$data->bg);
			if ($bg == true) {
				$ck = "dashboard_".$cmainyear.".accbody_id = 0 AND ";
			}
			else{
				$ck = "dashboard_".$cmainyear.".accgoal_id = 0 AND ";
			}
			$dashid = mysqli_real_escape_string($connect,$data->dashid);
			$sql1 = "SELECT body_value, hper, aper, goalplus_value, uper, dper FROM history_".$cmainyear." 
			WHERE history_id =
			 (SELECT MAX(history_".$cmainyear.".history_id) as history_id FROM history_".$cmainyear." 
			 INNER JOIN dashboard_".$cmainyear." ON dashboard_".$cmainyear.".timetableid = history_".$cmainyear.".timetableid 
			 WHERE dashboard_".$cmainyear.".dashboard_id = $dashid AND $ck dashboard_".$cmainyear.".recordstatus = 1 AND history_".$cmainyear.".recordstatus=1)";
			$result1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($result1)<1) {
				$chdata = "No Record";
			}
			else{
				while ($aaa = mysqli_fetch_assoc($result1)) {
					$chdata[] = $aaa;
				}
			}

			$sql2 = "SELECT onoff_id FROM onoff WHERE member_id IN($mbrid,0) AND onofftype='bettingonoff'";
			$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($result2)<1) {
				$onoffbet = "can";
			}
			else{
				$onoffbet = "cannot";
			}

			$sql3 = "SELECT usertype.* FROM members
				INNER JOIN usertype ON members.membertype = usertype.typeid
				WHERE members.member_id=$mbrid AND members.recordstatus=1";
			$result3 = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
			if (mysqli_num_rows($result3)<1) {
				$membertype = "error";
			}
			else{
				while ($aaa = mysqli_fetch_assoc($result3)) {
					$membertype[] = $aaa;
				}
			}

			$sql4 = "SELECT SUM(bet_amount) AS amount FROM mledger_".$cmainyear." WHERE member_id=$mbrid AND recordstatus=1 AND bet_date='$today'";
			$result4 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
			if (mysqli_num_rows($result4)>0) {
				while ($aaa = mysqli_fetch_assoc($result4)) {
					$bgamt = $aaa["amount"];
				}
			}

			$sql5 = "SELECT SUM(bet_amount) AS amount FROM mixledger_".$cmainyear." WHERE member_id=$mbrid AND recordstatus=1 AND bet_date='$today'";
			$result5 = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
			if (mysqli_num_rows($result5)>0) {
				while ($bbb = mysqli_fetch_assoc($result5)) {
					$mixamt = $bbb["amount"];
				}
			}

			$totalbet = intval($bgamt)+intval($mixamt);

			$records = array("chdata"=>$chdata,"onoffbet"=>$onoffbet, "membertype"=>$membertype, "totalbet"=>$totalbet);
		}
		elseif ($btn == "mixcheck") {
			$breakbet = true;
			foreach ($data->arraydata as $rows) {
				
				$dashid = mysqli_real_escape_string($connect,$rows->dashid);
				$sql1 = "SELECT history_".$cmainyear.".aper, history_".$cmainyear.".body_value, dashboard_".$cmainyear.".dashboard_id as dashid, 
				history_".$cmainyear.".dper, history_".$cmainyear.".goalplus_value, history_".$cmainyear.".hper,  
				history_".$cmainyear.".uper 
				FROM history_".$cmainyear." 
				INNER JOIN dashboard_".$cmainyear." ON dashboard_".$cmainyear.".timetableid = history_".$cmainyear.".timetableid 
				WHERE history_".$cmainyear.".history_id =
				 (SELECT MAX(history_".$cmainyear.".history_id) as history_id FROM history_".$cmainyear." 
				 INNER JOIN dashboard_".$cmainyear." ON dashboard_".$cmainyear.".timetableid = history_".$cmainyear.".timetableid 
				 WHERE dashboard_".$cmainyear.".dashboard_id = $dashid AND dashboard_".$cmainyear.".recordstatus = 1 AND history_".$cmainyear.".recordstatus=1 AND dashboard_".$cmainyear.".mix_on_off = 1)";
				$result1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
				if (mysqli_num_rows($result1)<1) {
					$chdata = "No Record";
				}
				else{
					while ($aaa = mysqli_fetch_assoc($result1)) {
						$chdata[] = $aaa;
					}
				}
				
				if ($chdata == "No Record") {
					$breakbet = false;
					break;
				}
			}

		//	if ($breakbet == true) {
				/*for ($i=0; $i < sizeof($chdata)-1; $i++) { 
					for ($j=0; $j < 6; $j++) { 
						if ($chdata[$i]["aper"] == $data->checkarr[$i]["aper"]) {
							if ($chdata[$i]["body_value"] == $data->checkarr[$i]["body_value"]) {
								if ($chdata[$i]["dper"] == $data->checkarr[$i]["dper"]) {
									if ($chdata[$i]["goalplus_value"] == $data->checkarr[$i]["goalplus_value"]) {
										if ($chdata[$i]["hper"] == $data->checkarr[$i]["hper"]) {
											if ($chdata[$i]["uper"] == $data->checkarr[$i]["uper"]) {
												$arrequal = "equal";
											}
											else{
												$arrequal = "notequal";
												break;
											}
										}
										else{
											$arrequal = "notequal";
											break;
										}
									}
									else{
										$arrequal = "notequal";
										break;
									}
								}
								else{
									$arrequal = "notequal";
									break;
								}
							}
							else{
								$arrequal = "notequal";
								break;
							}
						}
						else{
							$arrequal = "notequal";
							break;
						}
					}
				}*/	
				/*foreach ($data->checkarr as $key) {
					if ($key->aper == $chdata->aper) {
						if ($chdata[$i]["body_value"] == $data->checkarr[$i]["body_value"]) {
							if ($chdata[$i]["dper"] == $data->checkarr[$i]["dper"]) {
								if ($chdata[$i]["goalplus_value"] == $data->checkarr[$i]["goalplus_value"]) {
									if ($chdata[$i]["hper"] == $data->checkarr[$i]["hper"]) {
										if ($chdata[$i]["uper"] == $data->checkarr[$i]["uper"]) {
											$arrequal = "equal";
										}
										else{
											$arrequal = "notequal";
											break;
										}
									}
									else{
										$arrequal = "notequal";
										break;
									}
								}
								else{
									$arrequal = "notequal";
									break;
								}
							}
							else{
								$arrequal = "notequal";
								break;
							}
						}
						else{
							$arrequal = "notequal";
							break;
						}
					}
					else{
						$arrequal = "notequal";
						break;
					}

				 	for ($j=0; $j < 6; $j++) { 
						if ($chdata[$i]["aper"] == $data->checkarr[$i]["aper"]) {
							if ($chdata[$i]["body_value"] == $data->checkarr[$i]["body_value"]) {
								if ($chdata[$i]["dper"] == $data->checkarr[$i]["dper"]) {
									if ($chdata[$i]["goalplus_value"] == $data->checkarr[$i]["goalplus_value"]) {
										if ($chdata[$i]["hper"] == $data->checkarr[$i]["hper"]) {
											if ($chdata[$i]["uper"] == $data->checkarr[$i]["uper"]) {
												$arrequal = "equal";
											}
											else{
												$arrequal = "notequal";
												break;
											}
										}
										else{
											$arrequal = "notequal";
											break;
										}
									}
									else{
										$arrequal = "notequal";
										break;
									}
								}
								else{
									$arrequal = "notequal";
									break;
								}
							}
							else{
								$arrequal = "notequal";
								break;
							}
						}
						else{
							$arrequal = "notequal";
							break;
						}
					}
				 }	*/	
		//	}
			
			
			$sql2 = "SELECT onoff_id FROM onoff WHERE member_id IN($mbrid,0) AND onofftype='mixbettingonoff'";
			$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($result2)<1) {
				$onoffbet = "cannot";
			}
			else{
				$onoffbet = "can";
			}

			$sql3 = "SELECT usertype.* FROM members
				INNER JOIN usertype ON members.membertype = usertype.typeid
				WHERE members.member_id=$mbrid AND members.recordstatus=1";
			$result3 = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
			if (mysqli_num_rows($result3)<1) {
				$membertype = "error";
			}
			else{
				while ($aaa = mysqli_fetch_assoc($result3)) {
					$membertype[] = $aaa;
				}
			}

			$sql4 = "SELECT SUM(bet_amount) AS amount FROM mledger_".$cmainyear." WHERE member_id=$mbrid AND recordstatus=1 AND bet_date='$today'";
			$result4 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
			if (mysqli_num_rows($result4)>0) {
				while ($aaa = mysqli_fetch_assoc($result4)) {
					$bgamt = $aaa["amount"];
				}
			}

			$sql5 = "SELECT SUM(bet_amount) AS amount FROM mixledger_".$cmainyear." WHERE member_id=$mbrid AND recordstatus=1 AND bet_date='$today'";
			$result5 = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
			if (mysqli_num_rows($result5)>0) {
				while ($bbb = mysqli_fetch_assoc($result5)) {
					$mixamt = $bbb["amount"];
				}
			}

			$totalbet = intval($bgamt)+intval($mixamt);

			$records = array("chdata"=>$chdata, "onoffbet"=>$onoffbet, "membertype"=>$membertype, "totalbet"=>$totalbet, "breakbet"=>$breakbet);
		}
		elseif ($btn == "transfercheck") {
			$sql2 = "SELECT onoff_id FROM onoff WHERE member_id IN($mbrid,0) AND onofftype='transferonoff'";
			$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($result2)<1) {
				$onoffbet = "can";
				$sqllimit = "SELECT min,max FROM tlimit WHERE limit_type='transfer'";
				$limitres = mysqli_query($connect,$sqllimit, $connect)or die("Error in sql tra".$sqllimit);
				if (mysqli_num_rows($limitres)>0) {
					
					while ($tl = mysqli_fetch_assoc($limitres)) {
						$min = $tl["min"];
						$max = $tl["max"];
					}
				}
			}
			else{
				$onoffbet = "cannot";
				$min = 0;
				$max = 0;
			}
			$records = array("onoffbet"=>$onoffbet,"min"=>$min, "max"=>$max);
		}
		elseif ($btn == "depocheck") {
			$sql2 = "SELECT onoff_id FROM onoff WHERE member_id IN($mbrid,0) AND onofftype='depositonoff'";
			$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($result2)<1) {
				$onoffbet = "can";
				$sqllimit = "SELECT min,max FROM tlimit WHERE limit_type='deposit'";
				$limitres = mysqli_query($connect,$sqllimit, $connect)or die("Error in sql tra".$sqllimit);
				if (mysqli_num_rows($limitres)>0) {
					
					while ($tl = mysqli_fetch_assoc($limitres)) {
						$min = $tl["min"];
						$max = $tl["max"];
					}
				}
			}
			else{
				$onoffbet = "cannot";
				$min = 0;
				$max = 0;
			}
			$records = array("onoffbet"=>$onoffbet,"min"=>$min, "max"=>$max);
		}
		elseif ($btn == "withcheck") {
			$sql2 = "SELECT onoff_id FROM onoff WHERE member_id IN($mbrid,0) AND onofftype='withdrawonoff'";
			$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($result2)<1) {
				$onoffbet = "can";
				$sqllimit = "SELECT min,max FROM tlimit WHERE limit_type='withdraw'";
				$limitres = mysqli_query($connect,$sqllimit, $connect)or die("Error in sql tra".$sqllimit);
				if (mysqli_num_rows($limitres)>0) {
					
					while ($tl = mysqli_fetch_assoc($limitres)) {
						$min = $tl["min"];
						$max = $tl["max"];
					}
				}
			}
			else{
				$onoffbet = "cannot";
				$min = 0;
				$max = 0;
			}
			$records = array("onoffbet"=>$onoffbet,"min"=>$min, "max"=>$max);
		}		
		
		print json_encode($records);
	}
	elseif($table == "accdash"){
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$fromdate = mysqli_real_escape_string($connect,$data->fromdate);		
		$todate = mysqli_real_escape_string($connect,$data->todate);
		$otherdate = mysqli_real_escape_string($connect,$data->otherdate);
		$datesign = mysqli_real_escape_string($connect,$data->datesign);
		$userid = mysqli_real_escape_string($connect,$data->userid);

		if ($datesign == "all") {
			$checkdate = "";
			$limit = "";
		}
		else if ($fromdate != "" && $todate != "" && $datesign == "btw") {
			$checkdate = " STR_TO_DATE(t.tdate, '%m-%d-%Y') between STR_TO_DATE('".$fromdate."', '%m-%d-%Y') and STR_TO_DATE('".$todate."', '%m-%d-%Y') AND";
			$limit = "";
		}
		else if($otherdate != "" && $datesign != ""){
			$checkdate = " STR_TO_DATE(t.tdate, '%m-%d-%Y')".$datesign." STR_TO_DATE('".$otherdate."', '%m-%d-%Y') AND";
			$limit = "";
		}
		else{
			$checkdate = "";
			//$limit = " and STR_TO_DATE(tdate, '%m-%d-%Y') between '".$dashyesterday."' and '".$dashtomorrow."' ";
			$limit = " STR_TO_DATE(t.tdate, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y') AND";
		}

		if ($btn == "save") {

			$tid = mysqli_real_escape_string($connect,$data->tid);		
			$score = mysqli_real_escape_string($connect,$data->score);
			$bodysl = mysqli_real_escape_string($connect,$data->bodysl);
			$bodytxt = mysqli_real_escape_string($connect,$data->bodytxt);
			$hper = mysqli_real_escape_string($connect,$data->hper);
			$aper = mysqli_real_escape_string($connect,$data->aper);		
			$goal = mysqli_real_escape_string($connect,$data->goal);
			$goaltxt = mysqli_real_escape_string($connect,$data->goaltxt);
			$uper = mysqli_real_escape_string($connect,$data->uper);
			$dper = mysqli_real_escape_string($connect,$data->dper);
			$blimitamt = mysqli_real_escape_string($connect,$data->blimitamt);
			$glimitamt = mysqli_real_escape_string($connect,$data->glimitamt);
			$bless = mysqli_real_escape_string($connect,$data->bless);
			$gless = mysqli_real_escape_string($connect,$data->gless);

			$io = mysqli_real_escape_string($connect,$data->io);
			$bio = mysqli_real_escape_string($connect,$data->bio);
			$gio = mysqli_real_escape_string($connect,$data->gio);
			$lb = mysqli_real_escape_string($connect,$data->lb);
			$lg = mysqli_real_escape_string($connect,$data->lg);
			$agoal = mysqli_real_escape_string($connect,$data->agoal);
			$abody = mysqli_real_escape_string($connect,$data->abody);
			$bs = mysqli_real_escape_string($connect,$data->bss);
			$gs = mysqli_real_escape_string($connect,$data->gss);

			$sql1 = "INSERT INTO history_".$cmainyear."(timetableid,score,body_id, body_value, hper, aper, goalplus_id, goalplus_value, uper, dper, io_id, bio_id, gio_id, lbamount, lgamount,accbody_id,accgoal_id,bs,gs,userid,modifieddate,createddate,bless,gless,blimitamt,glimitamt) VALUES($tid,'$score',$bodysl, $bodytxt, $hper, $aper, $goal, $goaltxt, $uper, $dper,$io,$bio,$gio, $lb,$lg,$abody,$agoal,$bs,$gs,$userid,'$today','$autotime',$bless,$gless,$blimitamt,$glimitamt)";
			mysqli_query($connect,$sql1)or die("Error in query".$sql1);

			$sql = "UPDATE dashboard_".$cmainyear." SET blimitamt=$blimitamt, glimitamt=$glimitamt, body_id=$bodysl,score='$score',body_value = $bodytxt, hper = $hper, aper = $aper, goalplus_id= $goal , goalplus_value = $goaltxt, uper = $uper, dper = $dper, io_id=$io, bio_id=$bio, gio_id=$gio, bless=$bless, gless=$gless, lbamount=$lb, lgamount=$lg, accbody_id=$abody, accgoal_id=$agoal, bs=$bs, gs=$gs, dash_status=2 WHERE timetableid = $tid";
			mysqli_query($connect,$sql, $connect)or die("Error in sql ".$sql);

			$mlgr = "UPDATE  mledger_".$cmainyear." as m JOIN dashboard_".$cmainyear." as d ON m.dashboard_id = d.dashboard_id SET m.accbgid = CASE WHEN m.bet = 'Goal+' THEN $agoal ELSE $abody END WHERE d.timetableid = $tid";
			mysqli_query($connect,$mlgr, $connect)or die("Error in sql ".$mlgr);
		}
		elseif ($btn == "ioallchange") {
			foreach ($data->arraydata as $rows) {

				$dashid = mysqli_real_escape_string($connect,$rows->dashboard_id);
				$tid = mysqli_real_escape_string($connect,$rows->timetableid);		
				$score = mysqli_real_escape_string($connect,$rows->score);
				$bodysl = mysqli_real_escape_string($connect,$rows->body_id);
				$bodytxt = mysqli_real_escape_string($connect,$rows->body_value);
				$hper = mysqli_real_escape_string($connect,$rows->hper);
				$aper = mysqli_real_escape_string($connect,$rows->aper);		
				$goal = mysqli_real_escape_string($connect,$rows->goalplus_id);
				$goaltxt = mysqli_real_escape_string($connect,$rows->goalplus_value);
				$uper = mysqli_real_escape_string($connect,$rows->uper);
				$dper = mysqli_real_escape_string($connect,$rows->dper);
				$blimitamt = mysqli_real_escape_string($connect,$rows->blimitamt);
				$glimitamt = mysqli_real_escape_string($connect,$rows->glimitamt);

				$mixid = mysqli_real_escape_string($connect,$rows->mix_on_off);
				$comid = mysqli_real_escape_string($connect,$rows->com_on_off);
				$ioid = mysqli_real_escape_string($connect,$rows->io_id);	
				$bio = mysqli_real_escape_string($connect,$rows->bio_id);
				$gio = mysqli_real_escape_string($connect,$rows->gio_id);
				$lb = mysqli_real_escape_string($connect,$rows->lbamount);
				$lg = mysqli_real_escape_string($connect,$rows->lgamount);
				$agoal = mysqli_real_escape_string($connect,$rows->accgoal_id);
				$abody = mysqli_real_escape_string($connect,$rows->accbody_id);
				$bs = mysqli_real_escape_string($connect,$rows->bs);
				$gs = mysqli_real_escape_string($connect,$rows->gs);

				if ($ioid == 2) {
					$bio = 4;
					$gio = 4;
				}

				$sql1 = "INSERT INTO history_".$cmainyear."(timetableid,score,body_id, body_value, hper, aper, goalplus_id, goalplus_value, uper, dper, mix_on_off, com_on_off, io_id, bio_id, gio_id, lbamount, lgamount,accbody_id,accgoal_id,bs,gs,userid,createddate,modifieddate) 
				VALUES($tid,'$score',$bodysl, $bodytxt, $hper, $aper, $goal, $goaltxt, $uper, $dper, $mixid, $comid, $ioid,$bio,$gio,$lb,$lg,$abody,$agoal,$bs,$gs,1,'$autotime','$today')";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);

				$sql = "UPDATE dashboard_".$cmainyear." SET io_id=$ioid, bio_id=$bio, gio_id=$gio WHERE timetableid = $tid";
				mysqli_query($connect,$sql, $connect)or die("Error in sql ".$sql);
			}
		}
		elseif ($btn == "mixchange") {
			foreach ($data->arraydata as $rows) {

				$dashid = mysqli_real_escape_string($connect,$rows->dashboard_id);
				$tid = mysqli_real_escape_string($connect,$rows->timetableid);		
				$score = mysqli_real_escape_string($connect,$rows->score);
				$bodysl = mysqli_real_escape_string($connect,$rows->body_id);
				$bodytxt = mysqli_real_escape_string($connect,$rows->body_value);
				$hper = mysqli_real_escape_string($connect,$rows->hper);
				$aper = mysqli_real_escape_string($connect,$rows->aper);		
				$goal = mysqli_real_escape_string($connect,$rows->goalplus_id);
				$goaltxt = mysqli_real_escape_string($connect,$rows->goalplus_value);
				$uper = mysqli_real_escape_string($connect,$rows->uper);
				$dper = mysqli_real_escape_string($connect,$rows->dper);
				$blimitamt = mysqli_real_escape_string($connect,$rows->blimitamt);
				$glimitamt = mysqli_real_escape_string($connect,$rows->glimitamt);

				$mixid = mysqli_real_escape_string($connect,$rows->mix_on_off);
				$comid = mysqli_real_escape_string($connect,$rows->com_on_off);
				$ioid = mysqli_real_escape_string($connect,$rows->io_id);	
				$bio = mysqli_real_escape_string($connect,$rows->bio_id);
				$gio = mysqli_real_escape_string($connect,$rows->gio_id);
				$lb = mysqli_real_escape_string($connect,$rows->lbamount);
				$lg = mysqli_real_escape_string($connect,$rows->lgamount);
				$agoal = mysqli_real_escape_string($connect,$rows->accgoal_id);
				$abody = mysqli_real_escape_string($connect,$rows->accbody_id);
				$bs = mysqli_real_escape_string($connect,$rows->bs);
				$gs = mysqli_real_escape_string($connect,$rows->gs);

				if ($ioid == 2) {
					$bio = 4;
					$gio = 4;
				}

				$sql1 = "INSERT INTO history_".$cmainyear."(timetableid,score,body_id, body_value, hper, aper, goalplus_id, goalplus_value, uper, dper, mix_on_off, com_on_off, io_id, bio_id, gio_id, lbamount, lgamount,accbody_id,accgoal_id,bs,gs,userid,createddate,modifieddate) 
				VALUES($tid,'$score',$bodysl, $bodytxt, $hper, $aper, $goal, $goaltxt, $uper, $dper, $mixid, $comid, $ioid,$bio,$gio,$lb,$lg,$abody,$agoal,$bs,$gs,1,'$autotime','$today')";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);

				$sql = "UPDATE dashboard_".$cmainyear." SET mix_on_off=$mixid WHERE timetableid = $tid";
				mysqli_query($connect,$sql, $connect)or die("Error in sql ".$sql);
			}
		}
		elseif ($btn == "comchange") {
			foreach ($data->arraydata as $rows) {

				$dashid = mysqli_real_escape_string($connect,$rows->dashboard_id);
				$tid = mysqli_real_escape_string($connect,$rows->timetableid);		
				$score = mysqli_real_escape_string($connect,$rows->score);
				$bodysl = mysqli_real_escape_string($connect,$rows->body_id);
				$bodytxt = mysqli_real_escape_string($connect,$rows->body_value);
				$hper = mysqli_real_escape_string($connect,$rows->hper);
				$aper = mysqli_real_escape_string($connect,$rows->aper);		
				$goal = mysqli_real_escape_string($connect,$rows->goalplus_id);
				$goaltxt = mysqli_real_escape_string($connect,$rows->goalplus_value);
				$uper = mysqli_real_escape_string($connect,$rows->uper);
				$dper = mysqli_real_escape_string($connect,$rows->dper);
				$blimitamt = mysqli_real_escape_string($connect,$rows->blimitamt);
				$glimitamt = mysqli_real_escape_string($connect,$rows->glimitamt);

				$mixid = mysqli_real_escape_string($connect,$rows->mix_on_off);
				$comid = mysqli_real_escape_string($connect,$rows->com_on_off);
				$ioid = mysqli_real_escape_string($connect,$rows->io_id);	
				$bio = mysqli_real_escape_string($connect,$rows->bio_id);
				$gio = mysqli_real_escape_string($connect,$rows->gio_id);
				$lb = mysqli_real_escape_string($connect,$rows->lbamount);
				$lg = mysqli_real_escape_string($connect,$rows->lgamount);
				$agoal = mysqli_real_escape_string($connect,$rows->accgoal_id);
				$abody = mysqli_real_escape_string($connect,$rows->accbody_id);
				$bs = mysqli_real_escape_string($connect,$rows->bs);
				$gs = mysqli_real_escape_string($connect,$rows->gs);

				if ($ioid == 2) {
					$bio = 4;
					$gio = 4;
				}

				$sql1 = "INSERT INTO history_".$cmainyear."(timetableid,score,body_id, body_value, hper, aper, goalplus_id, goalplus_value, uper, dper, mix_on_off, com_on_off, io_id, bio_id, gio_id, lbamount, lgamount,accbody_id,accgoal_id,bs,gs,userid,createddate,modifieddate) 
				VALUES($tid,'$score',$bodysl, $bodytxt, $hper, $aper, $goal, $goaltxt, $uper, $dper, $mixid, $comid, $ioid,$bio,$gio,$lb,$lg,$abody,$agoal,$bs,$gs,1,'$autotime','$today')";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);

				$sql = "UPDATE dashboard_".$cmainyear." SET com_on_off=$comid WHERE timetableid = $tid";
				mysqli_query($connect,$sql, $connect)or die("Error in sql ".$sql);
			}
		}
		
	         	$sql1 = "SELECT Tdata.*,
			(CASE WHEN(Tdata.bodyname like 'H%') THEN 'hh' ELSE 'oth' END) as bodygoal,
			(CASE WHEN(Tdata.mix_on_off=0) THEN 'Close' WHEN(Tdata.mix_on_off=1) THEN 'Open' ELSE 'Hide' END) as mixval,
			(CASE WHEN(Tdata.com_on_off=2) THEN 'Close' WHEN(Tdata.com_on_off=1) THEN 'Open' ELSE '' END) as comval,
			(CASE WHEN(Tdata.bodyname like 'A%') THEN 'hh' ELSE 'oth' END) as goalbody,
			(CASE WHEN(hper<0) THEN 'red' ELSE 'black' END) as hclassname,
			(CASE WHEN(aper<0) THEN 'red' ELSE 'black' END) as aclassname,
			(CASE WHEN(dper<0) THEN 'red' ELSE 'black' END) as dclassname,
			(CASE WHEN(uper<0) THEN 'red' ELSE 'black' END) as uclassname,
			(CASE WHEN(Tdata.mix_on_off=0) THEN 'black' WHEN(Tdata.mix_on_off=1) THEN 'gn' ELSE 'bk' END) as mixclassname,
			(CASE WHEN(Tdata.com_on_off=2) THEN 'black' WHEN(Tdata.com_on_off=1) THEN 'gn' ELSE '' END) as comclassname,
			(CASE WHEN(io_id=3) THEN 'bk' WHEN(io_id=1) THEN 'gn' ELSE 'black' END) as ioclassname			
			from
			(SELECT IFNULL(accbodies.description,'') as abody,IFNULL(accgoal.description,'') as agoal,io.description as aio,bsgs1.description as abs,
			bsgs2.description as ags,gio.description as agio,bio.description as abio,d.*,b.bodyname,b.bodytype,g.goalname,g.goaltype,
			t.tdate,t.ttime,l.league_id as lid,l.leaguename,t1.teamname as Home,t2.teamname as Away, mixd.accbgid AS mixfor							
		        FROM dashboard_".$cmainyear." as d 
		        LEFT join bodies as b on b.body_id=d.body_id 
		        LEFT join goalplus as g on g.goalplus_id=d.goalplus_id 
		        inner join timetable as t on t.timetableid=d.timetableid 
		        inner join leagues as l on t.league_id=l.league_id 
		        inner join teams as t1 on t1.team_id=t.home 
		        inner join teams as t2 on t2.team_id=t.away
		        LEFT JOIN mledger_".$cmainyear." as m on m.dashboard_id=d.dashboard_id
		        LEFT join bio on bio.bio_id=d.bio_id
		        LEFT join gio on gio.gio_id=d.gio_id
		        LEFT JOIN bs_gs as bsgs1 ON bsgs1.bs_gs_id=d.bs
		        LEFT JOIN bs_gs as bsgs2 ON bsgs2.bs_gs_id=d.gs
		        LEFT join io on io.io_id=d.io_id
		        LEFT JOIN accbodies on accbodies.accbody_id=d.accbody_id
		        LEFT JOIN accgoal on accgoal.accgoal_id=d.accgoal_id
		        LEFT JOIN mixledger_detail_".$cmainyear." as mixd ON mixd.dashboard_id=d.dashboard_id
		        WHERE $checkdate $limit d.recordstatus=1 AND t.recordstatus=1 GROUP BY d.dashboard_id				
		        ) as Tdata order by STR_TO_DATE(tdate, '%m-%d-%Y') DESC,str_to_date(ttime, '%h:%i%p') DESC,leaguename ASC, Home ASC";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		if (mysqli_num_rows($result)<1) {
			$records = "No Record";
		}
		else{
			while ($a = mysqli_fetch_assoc($result)) {
				$records[] = $a;
			}
		}		
		$sql3 ="SELECT * from bodies WHERE recordstatus=1";
		$resultbodies = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
		while ($b = mysqli_fetch_assoc($resultbodies)) {
			$bodies[] = $b;
		}
		$sql4 ="SELECT * from goalplus WHERE recordstatus=1";
		$resultgoal = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
		while ($g = mysqli_fetch_assoc($resultgoal)) {
			$goalplus[] = $g;
		}
		$sql5 ="SELECT * from bio WHERE recordstatus=1";
		$resultbio = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
		while ($b2 = mysqli_fetch_assoc($resultbio)) {
			$bios[] = $b2;
		}
		$sql6 ="SELECT * from io WHERE recordstatus=1";
		$resultio = mysqli_query($connect,$sql6)or die("Error in query".$sql6);
		while ($i = mysqli_fetch_assoc($resultio)) {
			$ios[] = $i;
		}
		$sql7 ="SELECT * from gio WHERE recordstatus=1";
		$resultgio = mysqli_query($connect,$sql7)or die("Error in query".$sql7);
		while ($g = mysqli_fetch_assoc($resultgio)) {
			$gios[] = $g;
		}
		$sql8 ="SELECT bs_gs_id as bs,description from bs_gs WHERE recordstatus=1 AND bs_gs_id!=9";
		$resultbs = mysqli_query($connect,$sql8)or die("Error in query".$sql8);
		while ($bs = mysqli_fetch_assoc($resultbs)) {
			$bss[] = $bs;
		}
		$sql9 ="SELECT bs_gs_id as gs,description from bs_gs WHERE recordstatus=1 AND bs_gs_id!=9";
		$resultgs = mysqli_query($connect,$sql9)or die("Error in query".$sql9);
		while ($gs = mysqli_fetch_assoc($resultgs)) {
			$gss[] = $gs;
		}
		$sql10 ="SELECT accgoal_id,description,formula from accgoal WHERE recordstatus=1 AND formulatype=0";
		$resultaccgoal = mysqli_query($connect,$sql10)or die("Error in query".$sql10);
		while ($ag = mysqli_fetch_assoc($resultaccgoal)) {
			$agg[] = $ag;
		}
		$sql11 ="SELECT accbody_id,description,formula from accbodies WHERE recordstatus=1 AND formulatype=0";
		$resultaccbody = mysqli_query($connect,$sql11)or die("Error in query".$sql11);
		while ($ab = mysqli_fetch_assoc($resultaccbody)) {
			$abb[] = $ab;
		}
		$sql12 ="SELECT leaguename,league_id from leagues WHERE recordstatus=1 ORDER BY(leaguename)";
		$lea = mysqli_query($connect,$sql12)or die("Error in query".$sql12);
		while ($lg = mysqli_fetch_assoc($lea)) {
			$leagu[] = $lg;
		}

		$data = array("leag"=>$leagu,"dashboard"=>$records,"bodies"=>$bodies,"goalplus"=>$goalplus,"bio"=>$bios, "io"=>$ios, "gio"=>$gios, "bs"=>$bss, "gs"=>$gss, "ag"=>$agg, "ab"=>$abb);
		print json_encode($data);
	}
	elseif ($table == "team") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$tname = mysqli_real_escape_string($connect,$data->teamname);
			$sql = "INSERT INTO teams(teamname, recordstatus) VALUES('$tname', 1)";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$tid = mysqli_real_escape_string($connect,$data->teamid);
			$sql = "UPDATE teams SET recordstatus=2 WHERE team_id=$tid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$tid = mysqli_real_escape_string($connect,$data->teamid);
			$tname = mysqli_real_escape_string($connect,$data->teamname);
			$sql = "UPDATE teams SET teamname='$tname' WHERE team_id=$tid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 = "SELECT * FROM teams WHERE recordstatus =1 ORDER BY teamname";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		print json_encode($records);
	}
	elseif ($table == "member") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
				
		if ($btn == "save") {
			$mname = mysqli_real_escape_string($connect,$data->username);	
			$lgid = mysqli_real_escape_string($connect,$data->loginid);	
			$m = mysqli_real_escape_string($connect,$data->mail);
			$d = mysqli_real_escape_string($connect,$data->dob);
			$ph = mysqli_real_escape_string($connect,$data->ph);
			$fid = mysqli_real_escape_string($connect,$data->finid);
			$p = mysqli_real_escape_string($connect,$data->pass);
			$pass = md5($p);
			//$agentmbr = mysqli_real_escape_string($connect,$data->agentfinanceid);
			$joinagent = mysqli_real_escape_string($connect,$data->joinagent);
			
			$sql = "INSERT INTO members(username,loginid,financeid,password,mail,dob,phone,createddate,modifieddate) VALUES('$mname','$lgid','$fid','$pass','$m','$d','$ph','$today','$autotime')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);

			if ($joinagent != 0) {
				$sql1 = "SELECT MAX(member_id) as member_id FROM members where recordstatus = 1";
				$result1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
				while ($a1 = mysqli_fetch_assoc($result1)) {
					$maxmbrid = $a1["member_id"];
				}

				$sql2 = "INSERT INTO agent_member (agent_id,member_id,createddate) VALUES ($joinagent,$maxmbrid,'$today')";
				mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			}
		}
		elseif ($btn == "delete") {
			$mid = mysqli_real_escape_string($connect,$data->mid);
			$sql = "UPDATE members SET recordstatus=2 WHERE member_id=$mid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$mid = mysqli_real_escape_string($connect,$data->mid);
			$mname = mysqli_real_escape_string($connect,$data->username);		
			$m = mysqli_real_escape_string($connect,$data->mail);
			$d = mysqli_real_escape_string($connect,$data->dob);
			$ph = mysqli_real_escape_string($connect,$data->ph);
			$sql = "UPDATE members SET username='$mname',mail='$m',dob='$d',phone='$ph' WHERE member_id=$mid and recordstatus=1";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		
		$sql1 = "SELECT * FROM members WHERE recordstatus=1";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		print json_encode($records);
	}
	elseif ($table == "score") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$sname = mysqli_real_escape_string($connect,$data->scorename);
			$sql = "INSERT INTO scores(scorename) VALUES('$sname')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$sid = mysqli_real_escape_string($connect,$data->scoreid);
			$sql = "UPDATE scores SET recordstatus=2 WHERE score_id=$sid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$sid = mysqli_real_escape_string($connect,$data->scoreid);
			$sname = mysqli_real_escape_string($connect,$data->scorename);
			$sql = "UPDATE scores SET scorename='$sname' WHERE score_id=$sid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 = "SELECT * FROM scores WHERE recordstatus=1";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		print json_encode($records);
	}
	elseif ($table == "league") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$lname = mysqli_real_escape_string($connect,$data->leaguename);
			$sql = "INSERT INTO leagues(leaguename) VALUES('$lname')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$lid = mysqli_real_escape_string($connect,$data->leagueid);
			$sql = "UPDATE leagues SET recordstatus=2 WHERE league_id=$lid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$lid = mysqli_real_escape_string($connect,$data->leagueid);
			$lname = mysqli_real_escape_string($connect,$data->leaguename);
			$sql = "UPDATE leagues SET leaguename='$lname' WHERE league_id=$lid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 = "SELECT * FROM leagues WHERE recordstatus=1";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		print json_encode($records);
	}
	elseif ($table == "mix") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$mname = mysqli_real_escape_string($connect,$data->mixname);
			$minamt = mysqli_real_escape_string($connect,$data->minamt);
			$maxamt = mysqli_real_escape_string($connect,$data->maxamt);
			$limitval = mysqli_real_escape_string($connect,$data->limitval);
			$mmval = mysqli_real_escape_string($connect,$data->mmval);
			$bs = mysqli_real_escape_string($connect,$data->bs);

			$sql = "INSERT INTO mix(mixname, min_amount, max_amount, limit_amount, mmval, bs) 
				VALUES($mname, $minamt, $maxamt, $limitval, $mmval, $bs)";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$mid = mysqli_real_escape_string($connect,$data->mixid);
			$sql = "UPDATE mix SET recordstatus=2 WHERE mix_id=$mid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$mid = mysqli_real_escape_string($connect,$data->mixid);
			$mname = mysqli_real_escape_string($connect,$data->mixname);
			$minamt = mysqli_real_escape_string($connect,$data->minamt);
			$maxamt = mysqli_real_escape_string($connect,$data->maxamt);
			$limitval = mysqli_real_escape_string($connect,$data->limitval);
			$mmval = mysqli_real_escape_string($connect,$data->mmval);
			$bs = mysqli_real_escape_string($connect,$data->bs);

			$sql = "UPDATE mix SET mixname=$mname, min_amount=$minamt, max_amount=$maxamt, limit_amount=$limitval, mmval=$mmval, bs=$bs 
			WHERE mix_id=$mid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "setmix") {
			$min = mysqli_real_escape_string($connect,$data->min);
			$max = mysqli_real_escape_string($connect,$data->max);
			$sqldel = "DELETE FROM mix_min_max";
			mysqli_query($connect,$sqldel)or die("Error in query".$sqldel);

			$sql = "INSERT INTO mix_min_max(min_limit,max_limit,createddate) VALUES($min, $max, '$today')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "editstatus") {
			$mixid = mysqli_real_escape_string($connect,$data->mixid);
			$statusval = mysqli_real_escape_string($connect,$data->statusval);
			
			$sql = "UPDATE mix SET com_on_off=$statusval WHERE mix_id=$mixid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 = "SELECT mix.*, CONCAT(mix.mixname,'mix') as mix_name, bs_gs.description, mix.com_on_off as comval FROM mix 
			INNER JOIN bs_gs ON mix.bs=bs_gs.bs_gs_id
			WHERE mix.recordstatus=1 ORDER BY mix.mix_id";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}

		$sql2 = "SELECT * FROM mix_min_max WHERE recordstatus=1";
		$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
		if (mysqli_num_rows($result2)<1) {
			$minmax = "No Record";
		}
		else{
			while ($aa = mysqli_fetch_assoc($result2)) {
				$minmax[] = $aa;
			}
		}

		$sql3 = "SELECT CONCAT(mixname,'mix') as mix_name FROM mix WHERE recordstatus = 1";
		$result3 = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
		if (mysqli_num_rows($result3)<1) {
			$onoffarr = "No Record";
		}
		else{
			while ($aa = mysqli_fetch_assoc($result3)) {
				$onoffarr[] = $aa["mix_name"];
			}
		}
		
		$sql8 ="SELECT bs_gs_id as bs,description from bs_gs WHERE recordstatus=1 AND bs_gs_id!=9";
		$resultbs = mysqli_query($connect,$sql8)or die("Error in query".$sql8);
		while ($bs = mysqli_fetch_assoc($resultbs)) {
			$bss[] = $bs;
		}
		
		$data = array("names"=>$records, "minmax"=>$minmax, "bs"=>$bss, "onoffarr"=>$onoffarr);
		print json_encode($data);
	}
	elseif ($table == "goal") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$gname = mysqli_real_escape_string($connect,$data->goalname);
			$sql = "INSERT INTO goalplus(goalname) VALUES('$gname')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$gid = mysqli_real_escape_string($connect,$data->gid);
			$sql = "UPDATE goalplus SET recordstatus=2 WHERE goalplus_id=$gid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$gid = mysqli_real_escape_string($connect,$data->gid);
			$gname = mysqli_real_escape_string($connect,$data->goalname);
			$sql = "UPDATE goalplus SET goalname='$gname' WHERE goalplus_id=$gid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 = "SELECT * FROM goalplus WHERE recordstatus=1";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		print json_encode($records);
	}
	elseif ($table == "body") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$bname = mysqli_real_escape_string($connect,$data->bname);
			$sql = "INSERT INTO bodies(bodyname) VALUES('$bname')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$bid = mysqli_real_escape_string($connect,$data->bid);
			$sql = "UPDATE bodies SET recordstatus=2 WHERE body_id=$bid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$bid = mysqli_real_escape_string($connect,$data->bid);
			$bname = mysqli_real_escape_string($connect,$data->bname);
			$sql = "UPDATE bodies SET bodyname='$bname' WHERE body_id=$bid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 = "SELECT * FROM bodies WHERE recordstatus=1";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		print json_encode($records);
	}
	elseif ($table == "user") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$uname = mysqli_real_escape_string($connect,$data->username);
			$loginid = mysqli_real_escape_string($connect,$data->loginid);
			$gmail = mysqli_real_escape_string($connect,$data->gmail);
			$urole = mysqli_real_escape_string($connect,$data->roleid);
			$upass = mysqli_real_escape_string($connect,$data->pass);
			$pa = md5($upass);
			$sql = "INSERT INTO users(username,loginid,mail, roleid,password) VALUES('$uname','$loginid','$gmail','$urole','$pa')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$uid = mysqli_real_escape_string($connect,$data->uid);
			$sql = "UPDATE users SET recordstatus =2 WHERE userid=$uid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$uid = mysqli_real_escape_string($connect,$data->uid);
			$uname = mysqli_real_escape_string($connect,$data->username);
			$gmail = mysqli_real_escape_string($connect,$data->gmail);
			$urole = mysqli_real_escape_string($connect,$data->roleid);
			$upass = mysqli_real_escape_string($connect,$data->pass);
			if(isset($upass)){
			$pa = md5($upass);
			$sql = "UPDATE users SET username='$uname',roleid='$urole',password='$pa',mail='$gmail' WHERE userid=$uid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
			}
			else{
			$sql = "UPDATE users SET username='$uname',roleid='$urole' WHERE userid=$uid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
			}

		}
		$sql1 = "SELECT * FROM roles";
			$resultrole = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			while ($r = mysqli_fetch_assoc($resultrole)) {
			$roles[] = $r;
		}
		$sql2 = "SELECT * FROM users as u inner join roles as r on u.roleid=r.roleid WHERE u.recordstatus=1";
		$result = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		$data = array("roles"=>$roles,"users"=>$records);
		print json_encode($data);
	}
	elseif ($table == "time") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$tdate = mysqli_real_escape_string($connect,$data->tdate);
			$ttime = mysqli_real_escape_string($connect,$data->ttime);
			$league = mysqli_real_escape_string($connect,$data->league);
			$home = mysqli_real_escape_string($connect,$data->home);
			$away = mysqli_real_escape_string($connect,$data->away);
			$sql = "INSERT INTO timetable(tdate,ttime,league_id,home,away) VALUES('$tdate','$ttime',$league,'$home','$away')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
			$sql1 = "SELECT MAX(timetableid) as mid FROM timetable";
			$res1=mysqli_query($connect,$sql1, $connect)or die("Error in query " .$sql1);
			while ($r1=mysqli_fetch_assoc($res1)) {
				$tid = $r1["mid"];
			}
			$sql2= "INSERT INTO dashboard_".$cmainyear."(timetableid) VALUES($tid)";
			mysqli_query($connect,$sql2)or die("Error in query".$sql2);
		}
		elseif ($btn == "delete") {
			$tid = mysqli_real_escape_string($connect,$data->tid);
			$sql3 ="SELECT dash_status from dashboard_".$cmainyear." WHERE timetableid=$tid";
			$res3 = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
			while ($r = mysqli_fetch_assoc($res3)) {
				$dashstatus = $r["dash_status"];
			}
			if ($dashstatus == 1) {
				$sql = "UPDATE timetable SET recordstatus=2 WHERE timetableid=$tid";
				mysqli_query($connect,$sql)or die("Error in query".$sql);
				$sql2 = "UPDATE dashboard_".$cmainyear." SET recordstatus=2 WHERE timetableid=$tid";
				mysqli_query($connect,$sql2)or die("Error in query".$sql2);
				$del = 1;
			}
			else if($dashstatus == 2){
				$del = 0;
			}
		}
		elseif ($btn == "edit") {
			$tid = mysqli_real_escape_string($connect,$data->tid);
			$tdate = mysqli_real_escape_string($connect,$data->tdate);
			$ttime = mysqli_real_escape_string($connect,$data->ttime);
			$league = mysqli_real_escape_string($connect,$data->league);
			$home = mysqli_real_escape_string($connect,$data->home);
			$away = mysqli_real_escape_string($connect,$data->away);
			$sql = "UPDATE timetable SET tdate='$tdate',ttime='$ttime',league_id='$league',home='$home',away='$away' WHERE timetableid=$tid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 = "SELECT * FROM leagues WHERE recordstatus=1 ORDER by leaguename";
			$resultleagues = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			while ($r = mysqli_fetch_assoc($resultleagues)) {
			$leagues[] = $r;
		}
		$sql2 = "SELECT *,t.timetableid,t1.teamname as hname,t2.teamname as aname,t.tdate,t.ttime,l.leaguename FROM timetable as t 
		inner join leagues as l on t.league_id=l.league_id  
		inner join teams as t1 on t1.team_id=t.home 
		inner join teams as t2 on t2.team_id=t.away 
		WHERE t.recordstatus=1 and STR_TO_DATE(t.tdate, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y') order by STR_TO_DATE(t.tdate, '%m-%d-%Y') desc, str_to_date(ttime, '%h:%i%p') desc";
		$result = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
		if (mysqli_num_rows($result)<1) {
			$timetables = "No Record";
		}
		else{
			while ($a = mysqli_fetch_assoc($result)) {
				$timetables[] = $a;
			}
		}
		$sql3 = "SELECT ht.team_id as home,ht.teamname as hname  FROM teams as ht WHERE ht.recordstatus=1 ORDER BY ht.teamname";
			$resultteams = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
			while ($t1 = mysqli_fetch_assoc($resultteams)) {
			$teams1[] = $t1;
		}
		$sql4 = "SELECT at.team_id as away,at.teamname as aname  FROM teams as at WHERE at.recordstatus=1 ORDER BY at.teamname";
			$resultteams2 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
			while ($t2 = mysqli_fetch_assoc($resultteams2)) {
			$teams2[] = $t2;
		}
		if ($btn == "delete") {
			$data = array("leagues"=>$leagues,"timetables"=>$timetables,"teams1"=>$teams1,"teams2"=>$teams2,"delstatus"=>$del);
		}
		else{
			$data = array("leagues"=>$leagues,"timetables"=>$timetables,"teams1"=>$teams1,"teams2"=>$teams2);
		}
		
		print json_encode($data);
	}
	elseif ($table == "allledger") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "all") {
			$dd = mysqli_real_escape_string($connect,$data->d);
			$all = "SELECT alltable.* FROM ((SELECT 'd' as cname,
			IFNULL((a.deposite_id),0) as allid,
			IFNULL((a.action_date),' ') as dates,
			IFNULL((SUM(a.amount)),0) as amount,
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,
			IFNULL((a.state_id),0) as state_id,
			'undefined' as page,
			'Deposit' as alltype,COUNT(a.deposite_id) as numofrow from deposite as a WHERE a.state_id=1 GROUP BY a.action_date)
			UNION
			(SELECT 'dpending' as cname,
			IFNULL((a.deposite_id),0) as allid,
			IFNULL((a.action_date),' ') as dates,
			IFNULL((SUM(a.amount)),0) as amount,
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount, 
			IFNULL((a.state_id),0) as state_id,
			'deposite' as page,
			'Deposit Pending' as alltype,COUNT(a.deposite_id) as numofrow from deposite as a WHERE a.state_id=2 GROUP BY a.action_date)
			UNION
			(SELECT 'dreject' as cname,
			IFNULL((a.deposite_id),0) as allid,
			IFNULL((a.action_date),' ') as dates,
			IFNULL((SUM(a.amount)),0) as amount,
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount, 
			IFNULL((a.state_id),0) as state_id,
			'deposite' as page,
			'Deposit Reject' as alltype,COUNT(a.deposite_id) as numofrow from deposite as a WHERE a.state_id=3 GROUP BY a.action_date)
			UNION
			(SELECT 'w' as cname,
			IFNULL((a.withdraw_id),0) as allid,
			IFNULL((a.action_date),' ') as dates,
			IFNULL((SUM(a.amount)*(-1)),0) as amount,	
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,
			IFNULL((a.state_id),0) as state_id,
			'withdraw' as page,
			'Withdraw' as alltype,COUNT(a.withdraw_id) as numofrow from withdraw as a WHERE a.state_id=1 GROUP BY a.action_date)
			UNION
			(SELECT 'wpending' as cname,
			IFNULL((a.withdraw_id),0) as allid,
			IFNULL((a.action_date),' ') as dates,
			IFNULL((SUM(a.amount)),0) as amount,
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,
			IFNULL((a.state_id),0) as state_id,
			'withdraw' as page,
			'Withdraw Pending' as alltype,COUNT(a.withdraw_id) as numofrow from withdraw as a WHERE a.state_id=2 GROUP BY a.action_date)
			UNION
			(SELECT 'wreject' as cname,
			IFNULL((a.withdraw_id),0) as allid,
			IFNULL((a.action_date),' ') as dates,
			IFNULL((SUM(a.amount)),0) as amount,
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,
			IFNULL((a.state_id),0) as state_id,
			'withdraw' as page,
			'Withdraw Reject' as alltype,COUNT(a.withdraw_id) as numofrow from withdraw as a WHERE a.state_id=3 GROUP BY a.action_date)
			UNION
			(SELECT c.cname,
			IFNULL((c.allid),0),
			IFNULL((c.dates),' '),
			IFNULL((SUM(c.amt)*(-1)),0) as amount,		                
			c.turnover,c.wl,c.betamount,
			IFNULL((c.state_id),0) as state_id,
			'undefined' as page,
			c.alltype,COUNT(c.allid) as numofrow from 
			((SELECT 'cash' as cname,a.deposite_id as allid,a.action_date as dates, SUM(a.amount) as amt,cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount, a.state_id, 'Cash Account' as alltype,COUNT(a.deposite_id) as numofrow from deposite as a WHERE a.state_id=1 GROUP BY a.action_date)
			UNION
			(SELECT 'cash' as cname,a.withdraw_id as allid,a.action_date as dates, ((-1)*SUM(a.amount)) as amt,cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,a.state_id, 'Cash Account' as alltype,COUNT(a.withdraw_id) as numofrow from withdraw as a WHERE a.state_id=1 GROUP BY a.action_date)) as c GROUP BY c.dates)
			UNION
			(SELECT 'tf' as cname,
			IFNULL((t.transfer_id),0) as allid,
			IFNULL((t.action_date),' ') as dates,
			IFNULL((SUM(t.amount)*(-1)),0) as amount,				
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,
			IFNULL((t.state_id),0) as state_id,
			'undefined' as page,
			'Transfer From' as alltype,COUNT(t.transfer_id) as numofrow from transfer as t 
			INNER JOIN members as a on a.member_id=t.mfrom_id GROUP BY t.action_date)
			UNION
			(SELECT 'tt' as cname,
			IFNULL((t.transfer_id),0) as allid,
			IFNULL((t.action_date),' ') as dates,
			IFNULL((SUM(t.amount)),0) as amount,
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,
			IFNULL((t.state_id),0) as state_id,
			'undefined' as page,
			'Transfer To' as alltype,COUNT(t.transfer_id) as numofrow from transfer as t 
			INNER JOIN members as a on a.member_id=t.mto_id GROUP BY t.action_date)		                      
			UNION
			(SELECT 'p' as cname,
			'0' as allid,
			IFNULL((a.bet_date),' ') as dates,
			IFNULL((SUM(a.bet_amount)),0) as amount,
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,
			IFNULL((a.betstateid),0) as state_id,
			'undefined' as page,
			'Betting Pending' as alltype,COUNT(a.mledger_id) as numofrow FROM mledger_".$cmainyear." as a WHERE a.betstateid=2)
			UNION
			(SELECT 'un' as cname,
			'0' as allid,
			IFNULL((a.bet_date),' ') as dates,
			IFNULL((SUM(a.bet_amount)),0) as amount,
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,
			IFNULL((a.betstateid),0) as state_id,
			'undefined' as page,
			'Betting Undefined' as alltype,COUNT(a.mledger_id) as numofrow FROM mledger_".$cmainyear." as a WHERE  a.betstateid=1 and a.accbgid=0)
			UNION
			(SELECT (CASE WHEN SUM(a.result_amount)<0 THEN 'g' ELSE 'l' END) as cname,
			'0' as allid,
			IFNULL((a.bet_date),' ') as dates,
			IFNULL((SUM(a.result_amount)),0) as amount,
			cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,
			IFNULL((a.betstateid),0) as state_id,
			'undefined' as page,
			'Win Lose' as alltype,COUNT(a.mledger_id) as numofrow FROM mledger_".$cmainyear." as a WHERE a.betstateid=1)) as alltable WHERE alltable.dates='$dd' GROUP BY alltable.dates,alltable.alltype ORDER BY(alltable.dates)";
			$allres = mysqli_query($connect,$all, $connect)or die("Error in sql ".$all);
			if (mysqli_num_rows($allres)<1) {
			$allresult = "No Record";
			$num = 0;
			}
			else{
			$num[] = mysqli_num_rows($allres);
			while ($aaa = mysqli_fetch_assoc($allres)) {
			$allresult[] = $aaa;
			}

			}

			$ann = "(SELECT 'd' as cname,

			IFNULL((SUM(a.amount)),0) as amount,

			'Deposit' as alltype from deposite as a WHERE a.state_id=1)
			UNION
			(SELECT 'w' as cname,

			IFNULL((SUM(a.amount)*(-1)),0) as amount,	

			'Withdraw' as alltype from withdraw as a WHERE a.state_id=1)
			UNION
			(SELECT 'tf' as cname,

			IFNULL((SUM(t.amount)*(-1)),0) as amount,				

			'Transfer From' as alltype from transfer as t 
			INNER JOIN members as a on a.member_id=t.mfrom_id)
			UNION
			(SELECT 'tt' as cname,

			IFNULL((SUM(t.amount)),0) as amount,

			'Transfer To' as alltype from transfer as t 
			INNER JOIN members as a on a.member_id=t.mto_id)
			UNION
			(SELECT 'wreject' as cname,

			IFNULL((SUM(a.amount)),0) as amount,

			'Withdraw Reject' as alltype from withdraw as a WHERE a.state_id=3)
			UNION
			(SELECT 'dpending' as cname,

			IFNULL((SUM(a.amount)),0) as amount,

			'Deposit Pending' as alltype from deposite as a WHERE a.state_id=2)
			UNION
			(SELECT 'dreject' as cname,

			IFNULL((SUM(a.amount)),0) as amount,

			'Deposit Reject' as alltype from deposite as a WHERE a.state_id=3)
			";
			$annual = mysqli_query($connect,$ann)or die("Error in query".$ann);
			while ($a2 = mysqli_fetch_assoc($annual)) {
			$lgr[] = $a2;
			}

			/*$ann2 = "(SELECT c.cname,  
			IFNULL((SUM(c.amt)*(-1)),0) as amount,  
			c.alltype from 
			((SELECT 'cash' as cname, SUM(a.amount) as amt,'Cash Account' as alltype from deposite as a WHERE a.state_id=1)
			UNION
			(SELECT 'cash' as cname, ((-1)*SUM(a.amount)) as amt, 'Cash Account' as alltype from withdraw as a WHERE a.state_id=1)) as c)
			UNION
			(SELECT (CASE WHEN SUM(a.result_amount)<0 THEN 'g' ELSE 'l' END) as cname,

			IFNULL((SUM(a.result_amount)*(-1)),0) as amount,                 
			'Win Lose' as alltype FROM mledger_".$cmainyear." as a WHERE a.betstateid=1)
			UNION
			(SELECT 'mb' as cname,SUM(a.amount) as amount,'Members' as alltype FROM members AS a)
			UNION
			(SELECT 'p' as cname,
			IFNULL((SUM(a.bet_amount)),0) as amount,

			'Betting Pending' as alltype FROM mledger_".$cmainyear." as a WHERE a.betstateid=2)
			UNION
			(SELECT 'un' as cname,

			IFNULL((SUM(a.bet_amount)),0) as amount,

			'Betting Undefined' as alltype FROM mledger_".$cmainyear." as a WHERE  a.betstateid=1 and a.accbgid=0)

			UNION
			(SELECT 'wpending' as cname,

			IFNULL((SUM(a.amount)),0) as amount,

			'Withdraw Pending' as alltype from withdraw as a WHERE a.state_id=2)
			";*/
			$recentmledger = "SELECT SUM(win_lose) AS winlose,SUM(pending) AS pen,SUM(undefined) AS undefine 
					FROM create_table WHERE table_name LIKE 'mledger_%'";
			$recentmledgerres = mysqli_query($connect,$recentmledger)or die("Error in query".$recentmledger);
			while ($all2 = mysqli_fetch_assoc($recentmledgerres)) {
				$winlose = $all2["winlose"];
				$pen = $all2["pen"];
				$undefine = $all2["undefine"];
			}


			$recentmix = "SELECT SUM(win_lose) AS winlose,SUM(pending) AS pen,SUM(undefined) AS undefine 
			FROM create_table WHERE table_name LIKE 'mixledger_%'";
			$recentmixres = mysqli_query($connect,$recentmix)or die("Error in query".$recentmix);
			while ($all3 = mysqli_fetch_assoc($recentmixres)) {
				$mixwinlose = $all3["winlose"];
				$mixpen = $all3["pen"];
				$mixundefine = $all3["undefine"];
			}

			$ann2 = "(SELECT c.cname,  
			IFNULL((SUM(c.amt)*(-1)),0) as amount,  
			c.alltype from 
			((SELECT 'cash' as cname, SUM(a.amount) as amt,'Cash Account' as alltype from deposite as a WHERE a.state_id=1)
			UNION
			(SELECT 'cash' as cname, ((-1)*SUM(a.amount)) as amt, 'Cash Account' as alltype from withdraw as a WHERE a.state_id=1)) as c)
			UNION
			(SELECT (CASE WHEN SUM(a.result_amount)<0 THEN 'g' ELSE 'l' END) as cname,
			IFNULL((SUM(a.result_amount)*(-1)),0) as amount,                 
			'Win Lose' as alltype FROM mledger_".$cmainyear." as a WHERE a.betstateid=1)
			
			UNION
			(SELECT (CASE WHEN SUM(a.result_amount)<0 THEN 'g' ELSE 'l' END) as cname,
			IFNULL((SUM(a.result_amount)*(-1)),0) as amount,                 
			'Mix Win Lose' as alltype FROM mixledger_".$cmainyear." as a WHERE a.betstateid=1)

			UNION
			(SELECT 'w' as cname,
			IFNULL(((-1)*SUM(a.commission_amt)),0) as amount,                 
			'BG Commission' as alltype FROM agent_commission as a WHERE a.bet_type='bg')
			
			UNION
			(SELECT 'w' as cname,
			IFNULL(((-1)*SUM(a.commission_amt)),0) as amount,                 
			'Mix Commission' as alltype FROM agent_commission as a WHERE a.bet_type='mix')
			
			UNION
			(SELECT 'mb' as cname,SUM(a.amount) as amount,'Members' as alltype FROM members AS a)

			UNION
			(SELECT 'p' as cname,
			IFNULL((SUM(a.bet_amount)),0) as amount,
			'Betting Pending' as alltype FROM mledger_".$cmainyear." as a WHERE a.betstateid=2)
			
			UNION
			(SELECT 'p' as cname,
			IFNULL((SUM(a.bet_amount)),0) as amount,

			'Mix Betting Pending' as alltype FROM mixledger_".$cmainyear." as a WHERE a.betstateid=2)
			UNION
			(SELECT 'un' as cname,

			IFNULL((SUM(a.bet_amount)),0) as amount,

			'Betting Undefined' as alltype FROM mledger_".$cmainyear." as a WHERE  a.betstateid=1 and a.accbgid=0)
			UNION
			(SELECT 'un' as cname,

			IFNULL((SUM(a.bet_amount)),0) as amount,

			'Mix Betting Undefined' as alltype FROM mixledger_".$cmainyear." as a WHERE  a.betstateid=1 and a.status_id=6)

			UNION
			(SELECT 'wpending' as cname,

			IFNULL((SUM(a.amount)),0) as amount,

			'Withdraw Pending' as alltype from withdraw as a WHERE a.state_id=2)
			";

			$annual2 = mysqli_query($connect,$ann2)or die("Error in query".$ann2);
				$aa = array();
				while ($a = mysqli_fetch_assoc($annual2)) {
					if ($a["alltype"] == "Win Lose") {
						$dd = $a["amount"];
						$dd = $dd + $winlose;
						$aa["amount"]=$dd;
						$lgr2[] = array_merge($a,$aa);
					}
					elseif ($a["alltype"] == "Mix Win Lose") {
						$dd = $a["amount"];
						$dd = $dd + $mixwinlose;
						$aa["amount"]=$dd;
						$lgr2[] = array_merge($a,$aa);
					}
					elseif ($a["alltype"] == "Betting Pending") {
						$dd = $a["amount"];
						$dd = $dd + $pen;
						$aa["amount"]=$dd;
						$lgr2[] = array_merge($a,$aa);
					}
					elseif ($a["alltype"] == "Mix Betting Pending") {
						$dd = $a["amount"];
						$dd = $dd + $mixpen;
						$aa["amount"]=$dd;
						$lgr2[] = array_merge($a,$aa);
					}
					elseif ($a["alltype"] == "Betting Undefined") {
						$dd = $a["amount"];
						$dd = $dd + $undefine;
						$aa["amount"]=$dd;
						$lgr2[] = array_merge($a,$aa);
					}
					elseif ($a["alltype"] == "Mix Betting Undefined") {
						$dd = $a["amount"];
						$dd = $dd + $mixundefine;
						$aa["amount"]=$dd;
						$lgr2[] = array_merge($a,$aa);
					}
					elseif ($a["alltype"] == "Cash Account") {
						$aa["amount"]=$a["amount"];
						$lgr2[] = array_merge($a,$aa);
					}
					elseif ($a["alltype"] == "BG Commission") {
						$aa["amount"]=$a["amount"];
						$lgr2[] = array_merge($a,$aa);
					}
					elseif ($a["alltype"] == "Mix Commission") {
						$aa["amount"]=$a["amount"];
						$lgr2[] = array_merge($a,$aa);
					}
					elseif ($a["alltype"] == "Members") {
						$aa["amount"]=$a["amount"];
						$lgr2[] = array_merge($a,$aa);
					}
					elseif ($a["alltype"] == "Withdraw Pending") {						
						$aa["amount"]=$a["amount"];
						$lgr2[] = array_merge($a,$aa);
					}
				}				

			$sql5 = "SELECT IFNULL(SUM(amount),0) as negamt FROM members WHERE amount<0";
			$res5 = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
			if (mysqli_num_rows($res5)<1) {
				$namt = "0";				
			}
			else{
				while ($a5 = mysqli_fetch_assoc($res5)) {
					$namt = $a5["negamt"];
				}
			}

			$data = array("allresult"=>$allresult, "num"=>$num, "annual"=>$lgr, "annual2"=>$lgr2, "namt"=>$namt);
			print json_encode($data);
		}
	}
	elseif ($table == "bankselect") {
		$btn = mysqli_real_escape_string($connect,$data->btn);		
		$mid = mysqli_real_escape_string($connect,$data->mid);
		if ($btn == "bankselect") {
			$bid = mysqli_real_escape_string($connect,$data->bid);
			$sql1 = "SELECT bh.cardnumber,banks.description as bname from bank_history as bh inner JOIN banks on bh.bank_id=banks.bank_id WHERE bh.bank_history_id=$bid";
			$res1=mysqli_query($connect,$sql1, $connect)or die("Error in sql "+$sql1);
			while($r1 = mysqli_fetch_assoc($res1)){
				$data1[]= $r1;
			}
			$sql1 = "SELECT bank_id from bank_history WHERE bank_history_id=$bid";
			$res1=mysqli_query($connect,$sql1, $connect)or die("Error in sql "+$sql1);
			while($r1 = mysqli_fetch_assoc($res1)){
				$b= $r1["bank_id"];
			}
			$sql2 = "SELECT cardnumber from bank_history WHERE bank_id=$b and member_id=$mid and type='m'";
			$res2=mysqli_query($connect,$sql2, $connect)or die("Error in sql "+$sql2);
			if (mysqli_num_rows($res2)<1) {
				$data2 = "No record";				
			}
			else{
				while($r2 = mysqli_fetch_assoc($res2)){
					$data2[]= $r2;
				}
			}			
			$data = array("ucard"=>$data1, "mbrcard"=>$data2);	
		}
		elseif ($btn == "mbankselect") {
			$bid = mysqli_real_escape_string($connect,$data->bid);
			$sql1 = "SELECT bh.cardnumber,banks.description as bname from bank_history as bh inner JOIN banks on bh.bank_id=banks.bank_id WHERE bh.bank_history_id=$bid and bh.member_id=$mid and type='m'";
			$res1=mysqli_query($connect,$sql1, $connect)or die("Error in sql "+$sql1);			
			
			if (mysqli_num_rows($res1)<1) {
				$sql2 = "SELECT ' ' as cardnumber,bank_id as bank_history_id,description as bname FROM banks";
				$res2=mysqli_query($connect,$sql2, $connect)or die("Error in sql "+$sql2);	
				while($r2 = mysqli_fetch_assoc($res2)){
					$data1[]= $r2;
				}		
			}
			else{
				while($r1 = mysqli_fetch_assoc($res1)){
					$data1[]= $r1;
				}
			}			
			$data = array("mbrcard"=>$data1);		
		}		
		print json_encode($data);
	}
	elseif ($table == "checktransfer") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$sub = mysqli_real_escape_string($connect,$data->sub);
		if ($sub == "admin") {
			if ($btn == "usercode") {
				$userid = mysqli_real_escape_string($connect,$data->userid);
				$pass = mysqli_real_escape_string($connect,$data->pass);
				$pa = md5($pass);
				/*$sql1 = "SELECT transfercode FROM roles
				INNER JOIN users ON users.roleid = roles.roleid 
				WHERE users.userid = $userid AND users.recordstatus=1";*/
				$sql1 = "SELECT transfercode FROM roles WHERE rolename='admin'";
				$res1=mysqli_query($connect,$sql1, $connect)or die("Error in sql "+$sql1);
				if (mysqli_num_rows($res1)>0) {
					while($r1 = mysqli_fetch_assoc($res1)){
						$p= $r1["transfercode"];
					}
					if ($pa == $p) {
						echo 1;
					}
					else{
						echo 0;
					}
				}
				else{
					echo 0;
				}
			}
		}
		elseif ($sub == "mbr") {
			if ($btn == "usercode") {
				$userid = mysqli_real_escape_string($connect,$data->userid);
				$pass = mysqli_real_escape_string($connect,$data->pass);
				$pa = md5($pass);
				$sql1 = "SELECT password FROM members WHERE member_id=$userid AND recordstatus=1";
				$res1=mysqli_query($connect,$sql1, $connect)or die("Error in sql "+$sql1);			
				
				if (mysqli_num_rows($res1)>0) {
					while($r1 = mysqli_fetch_assoc($res1)){
						$p= $r1["password"];
					}
					if ($pa == $p) {
						echo 1;
					}
					else{
						echo 0;
					}
				}
				else{
					echo 0;
				}
			}
		}		
	}
	elseif ($table == "testing") {
		$btn = mysqli_real_escape_string($connect,$data->btn);		

		if ($btn == "finuniqueid") {
			$testfinanceid = mysqli_real_escape_string($connect,$data->testfinid);
			$sql = "SELECT financeid,username from members WHERE financeid='$testfinanceid' and recordstatus=1";
			$res = mysqli_query($connect,$sql)or die("Error in query".$sql);
			if (mysqli_num_rows($res)<1) {
				$records = 1;
			}
			else{
				while ($dd = mysqli_fetch_assoc($res)) {
					$records = $dd;
				}
			}
		}		
		elseif ($btn == "admintransfer") {
			$toid = mysqli_real_escape_string($connect,$data->testtoid);
			$fromid = mysqli_real_escape_string($connect,$data->testfromid);
			$sql = "SELECT member_id,financeid,username,amount from members WHERE financeid='$toid' and recordstatus=1";
			$res = mysqli_query($connect,$sql)or die("Error in query".$sql);
			if (mysqli_num_rows($res)<1) {
				$torecords = 1;
			}
			else{
				while ($dd = mysqli_fetch_assoc($res)) {
					$torecords = $dd;
				}
			}

			$sql1 = "SELECT member_id,financeid,username,amount from members WHERE financeid='$fromid' and recordstatus=1";
			$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$fromrecords = 1;
			}
			else{
				while ($dd1 = mysqli_fetch_assoc($res1)) {
					$fromrecords = $dd1;
				}
			}
		}
		elseif ($btn == "loguniqueid") {
			$testlogid = mysqli_real_escape_string($connect,$data->testlogid);
			$sql = "SELECT * from members WHERE loginid='$testlogid' and recordstatus=1";
			$res = mysqli_query($connect,$sql)or die("Error in query".$sql);
			if (mysqli_num_rows($res)<1) {
				$records = 1;
			}
			else{
				$records = 0;
			}
		}
		elseif ($btn == "agentuniqueid") {
			$testagentid = mysqli_real_escape_string($connect,$data->testagentid);
			$sql = "SELECT agents.agent_id,members.username from agents
			INNER JOIN members ON agents.member_id = members.member_id 
			WHERE members.financeid='$testagentid' and members.recordstatus=1";
			$res = mysqli_query($connect,$sql)or die("Error in query".$sql);
			if (mysqli_num_rows($res)<1) {
				$records = 0;
			}
			else{
				$records = 1;
				while ($dd11 = mysqli_fetch_assoc($res)) {
					$agentid = $dd11["agent_id"];
					$agentname = $dd11["username"];
				}
			}
		}
		elseif ($btn == "betbodyamt") {
			$dashid = mysqli_real_escape_string($connect,$data->dashid);
			$lbamt = mysqli_real_escape_string($connect,$data->lbamt);
			$blimitamt = mysqli_real_escape_string($connect,$data->blimitamt);
			$sql = "SELECT sum(bet_amount) as totalamt FROM mledger_".$cmainyear." WHERE dashboard_id=$dashid and betstateid!=3 and bet='Body'";
			$res = mysqli_query($connect,$sql, $connect)or die("Error in sql dep insert".$sql);
			while ($d = mysqli_fetch_assoc($res)) {
				$total = $d["totalamt"];
			}
			if ($total<$lbamt) {
				if ($blimitamt>($lbamt-$total)) {
					$records = $lbamt-$total;
				}else{
					$records = 1;
				}				
			}
			else{
				$records = 2;
			}
		}
		elseif ($btn == "betgoalamt") {
			$dashid = mysqli_real_escape_string($connect,$data->dashid);
			$lgamt = mysqli_real_escape_string($connect,$data->lgamt);
			$glimitamt = mysqli_real_escape_string($connect,$data->glimitamt);
			$sql = "SELECT sum(bet_amount) as totalamt FROM mledger_".$cmainyear." WHERE dashboard_id=$dashid and betstateid!=3 and bet='Goal+'";
			$res = mysqli_query($connect,$sql, $connect)or die("Error in sql dep insert".$sql);
			while ($d = mysqli_fetch_assoc($res)) {
				$total = $d["totalamt"];
			}
			if ($total<$lgamt) {
				if ($glimitamt>($lgamt-$total)) {
					$records = $lgamt-$total;
				}else{
					$records = 1;
				}				
			}
			elseif ($total == $lgamt || $total > $lgamt) {
				$sql = "UPDATE dashboard_".$cmainyear." SET  WHERE dashboard_id=$dashid";
				mysqli_query($connect,$sql, $connect)or die("Error in sql ".$sql);
				$records = 1;
			}else{
				$records = 1;
			}
		}
		elseif ($btn == "betmix") {
			$mixnum = mysqli_real_escape_string($connect,$data->mixnum);
			$sql1 = "SELECT * FROM mix WHERE mixname=$mixnum";
			$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$selectmix = "error";
			}
			else{
				while ($dd1 = mysqli_fetch_assoc($res1)) {
					$mixid = $dd1["mix_id"];
					$limitamt = $dd1["limit_amount"];
					$minamt = $dd1["min_amount"];
					$maxamt = $dd1["max_amount"];
				}
			}
			if (isset($mixid)) {
				$sql = "SELECT IFNULL(sum(bet_amount),0) as totalamt FROM mixledger_".$cmainyear." WHERE mixname=$mixnum AND betstateid!=3";
				$res = mysqli_query($connect,$sql, $connect)or die("Error in sql dep insert".$sql);
				while ($d = mysqli_fetch_assoc($res)) {
					$total = $d["totalamt"];
				}
				if ($total<$limitamt) {
					if ($maxamt>($limitamt-$total)) {
						$records = $limitamt-$total;
					}else{
						$records = 1;
					}				
				}
				else{
					$records = 2;
				}
			}
		}
		/*elseif ($btn == "checktranoff") {
			$mbrid = mysqli_real_escape_string($connect,$data->mbrid);
			$sql = "SELECT tranoff from members WHERE member_id=$mbrid and recordstatus=1";
			$res = mysqli_query($connect,$sql)or die("Error in query".$sql);
			if (mysqli_num_rows($res)<1) {
				$records = "error";
			}
			else{
				while ($dd = mysqli_fetch_assoc($res)) {
					$records = $dd;
				}
			}
		}*/

		if ($btn == "admintransfer") {
			$data = array("todata"=>$torecords, "fromdata"=>$fromrecords);
			print json_encode($data);
		}
		elseif ($btn == "betmix") {
			$data = array("limitamt"=>$limitamt, "minamt"=>$minamt, "maxamt"=>$maxamt, "records"=>$records);
			print json_encode($data);
		}
		elseif ($btn == "agentuniqueid") {
			$data = array("can"=>$records, "agentid"=>$agentid, "agentname"=>$agentname);
			print json_encode($data);
		}
		else{
			print json_encode($records);
		}		
	}
	elseif ($table == "mpage") {	
		$bgbetlist = "";
		$mixbetlist = "";
		$transfercan = "";
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$mid = mysqli_real_escape_string($connect,$data->mid);
		if ($btn == "allwdt") {
			$sub = mysqli_real_escape_string($connect,$data->sub);
			if ($sub == "deposite") {
				$inn = mysqli_real_escape_string($connect,$data->inner);
				$dvalue = mysqli_real_escape_string($connect,$data->datevalue);				
				$tvalue = mysqli_real_escape_string($connect,$data->typevalue);
				if ($dvalue == "f" || $dvalue == "") {
					$dvalue = "and 2=2";
				}
				else{
					$dvalue = "and a.action_date ='".$dvalue."'";
				}

					if ($inn == "reqdeposite") {
						$transfercan = "";
						$mbrid =mysqli_real_escape_string($connect,$data->mbrid); 
						$amt = mysqli_real_escape_string($connect,$data->amt);
						$bankhid = mysqli_real_escape_string($connect,$data->bid);
						$usrname = mysqli_real_escape_string($connect,$data->usrname);
						$cdnum = mysqli_real_escape_string($connect,$data->cardnrc);
						$ph = mysqli_real_escape_string($connect,$data->phone);
						$c = mysqli_real_escape_string($connect,$data->city);
						$branch = mysqli_real_escape_string($connect,$data->branch);

						$sql11 = "SELECT member_id FROM members 						 
						WHERE member_id=$mbrid AND recordstatus=1 
						AND member_id NOT IN (SELECT member_id FROM onoff WHERE onofftype='depositonoff')";
						$r11 = mysqli_query($connect,$sql11, $connect)or die("Error in sql ".$sql11);
						if (mysqli_num_rows($r11)<1) {
							$transfercan = "cannot";
						}
						else{
							$sql1 = "INSERT INTO deposite(member_id,bank_history_id,username,acc_nrc,action_date,action_time,amount,ph,city,branch) VALUES($mbrid,$bankhid,'$usrname','$cdnum','$today','$aatime',$amt,'$ph','$c','$branch')";
							mysqli_query($connect,$sql1, $connect)or die("Error in sql dep insert".$sql1);
							$transfercan = "can";
						}							
					}
					else if ($inn == "alltype") {
						$stateid = mysqli_real_escape_string($connect,$data->state);
						$amt = mysqli_real_escape_string($connect,$data->amt);
						$m = mysqli_real_escape_string($connect,$data->mm);
						$allid = mysqli_real_escape_string($connect,$data->allid);
						if ($stateid == "1") {
							$sql1 = "SELECT state_id FROM deposite WHERE deposite_id=$allid";
							$resultcover = mysqli_query($connect,$sql1, $connect)or die("Error in sql dep".$sql1);
							while ($rcover = mysqli_fetch_assoc($resultcover)) {
								$acover = $rcover["state_id"];
							}
							if ($acover != 1) {
								$s = "SELECT amount FROM members WHERE member_id=$m and recordstatus=1";
								$result = mysqli_query($connect,$s, $connect)or die("Error in sql dep".$s);
								while ($r = mysqli_fetch_assoc($result)) {
									$a = $r["amount"];
								}
								$amount = $a + $amt;
								$upd = "UPDATE members SET amount=$amount WHERE member_id=$m and recordstatus=1";
								mysqli_query($connect,$upd, $connect)or die("Error in sql mem".$upd);

								$u = "UPDATE deposite SET state_id=$stateid WHERE deposite_id=$allid";
								mysqli_query($connect,$u, $connect)or die("Error in sql dep".$u);

								$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
								VALUES ($m, $a, $amount, $amt, 'Deposit Confirm', '$today', '$aatime')";
								mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
							}							
						}
						elseif ($stateid == "2") {
							$sql1 = "SELECT state_id FROM deposite WHERE deposite_id=$allid";
							$result = mysqli_query($connect,$sql1, $connect)or die("Error in sql dep".$sql1);
							while ($r = mysqli_fetch_assoc($result)) {
								$a = $r["state_id"];
							}
							if ($a == 1) {
								$s = "SELECT amount FROM members WHERE member_id=$m and recordstatus=1";
								$result = mysqli_query($connect,$s, $connect)or die("Error in sql dep".$s);
								while ($r = mysqli_fetch_assoc($result)) {
									$aa = $r["amount"];
								}

								$upd = "UPDATE members SET amount=amount-$amt WHERE member_id=$m and recordstatus=1";
								mysqli_query($connect,$upd, $connect)or die("Error in sql mem".$upd);

								$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
								VALUES ($m, $aa, $aa-$amt, $amt, 'Deposit Pending', '$today', '$aatime')";
								mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
							}

							$u = "UPDATE deposite SET state_id=$stateid WHERE deposite_id=$allid";
							mysqli_query($connect,$u, $connect)or die("Error in sql dep".$u);
						}
						elseif ($stateid == "3") {
							$sql1 = "SELECT state_id FROM deposite WHERE deposite_id=$allid";
							$result = mysqli_query($connect,$sql1, $connect)or die("Error in sql dep".$sql1);
							while ($r = mysqli_fetch_assoc($result)) {
								$a = $r["state_id"];
							}
							if ($a == 1) {
								$s = "SELECT amount FROM members WHERE member_id=$m and recordstatus=1";
								$result = mysqli_query($connect,$s, $connect)or die("Error in sql dep".$s);
								while ($r = mysqli_fetch_assoc($result)) {
									$aa = $r["amount"];
								}

								$upd = "UPDATE members SET amount=amount-$amt WHERE member_id=$m and recordstatus=1";
								mysqli_query($connect,$upd, $connect)or die("Error in sql mem".$upd);

								$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
								VALUES ($m, $aa, $aa-$amt, $amt, 'Deposit Reject', '$today', '$aatime')";
								mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
							}

							$u = "UPDATE deposite SET state_id=$stateid WHERE deposite_id=$allid";
							mysqli_query($connect,$u, $connect)or die("Error in sql dep".$u);
						}
					}
				$dep = "SELECT m.loginid,a.member_id as mbrid,m.username as mname,a.deposite_id as allid,a.*,a.acc_nrc,bh.*,b.*,'Deposit' as alltype from deposite as a 
				LEFT JOIN bank_history as bh on a.bank_history_id=bh.bank_history_id 
				LEFT JOIN members as m on m.member_id=a.member_id
				LEFT JOIN banks as b on bh.bank_id=b.bank_id WHERE a.recordstatus=1 $dvalue $tvalue $mid ORDER BY STR_TO_DATE(a.action_date, '%m-%d-%Y') DESC, STR_TO_DATE(a.action_time, '%h:%i:%s%p') DESC";
				$resdep = mysqli_query($connect,$dep, $connect)or die("Error in sql dep".$dep);
				if (mysqli_num_rows($resdep)<1) {
					$wdt = "No Record";
				}
				else{
					while ($d = mysqli_fetch_assoc($resdep)) {
						$wdt[] = $d;
					}
				}
			}
			else if ($sub == "withdraw") {
				$transfercan = "";
				$inn = mysqli_real_escape_string($connect,$data->inner);
				$dvalue = mysqli_real_escape_string($connect,$data->datevalue);				
				$tvalue = mysqli_real_escape_string($connect,$data->typevalue);
				if ($dvalue == "f" || $dvalue == "") {
					$dvalue = "and 2=2";
				}
				else{
					$dvalue = "and a.action_date ='".$dvalue."'";
				}
					if ($inn == "reqwithdraw") {
						$mbrid =mysqli_real_escape_string($connect,$data->mbrid); 
						$amt = mysqli_real_escape_string($connect,$data->amt);
						$bname = mysqli_real_escape_string($connect,$data->bid);
						$usrname = mysqli_real_escape_string($connect,$data->usrname);
						$cdnum = mysqli_real_escape_string($connect,$data->cardnrc);
						$ph = mysqli_real_escape_string($connect,$data->phone);
						$c = mysqli_real_escape_string($connect,$data->city);
						$branch = mysqli_real_escape_string($connect,$data->branch);

						$sql11 = "SELECT member_id FROM members 						 
						WHERE member_id=$mbrid AND recordstatus=1 
						AND member_id NOT IN (SELECT member_id FROM onoff WHERE onofftype='withdrawonoff')";
						$r11 = mysqli_query($connect,$sql11, $connect)or die("Error in sql ".$sql11);
						if (mysqli_num_rows($r11)<1) {
							$transfercan = "cannot";
						}
						else{
							$sql1 = "INSERT INTO withdraw(member_id,bank,username,acc_nrc,action_date,action_time,amount,ph,city,branch) VALUES($mbrid,'$bname','$usrname','$cdnum','$today','$aatime',$amt,'$ph','$c','$branch')";
							mysqli_query($connect,$sql1, $connect)or die("Error in sql dep insert".$sql1);	

							$s = "SELECT amount FROM members WHERE member_id=$mbrid and recordstatus=1";
							$result = mysqli_query($connect,$s, $connect)or die("Error in sql dep".$s);
							while ($r = mysqli_fetch_assoc($result)) {
								$a = $r["amount"];
							}
							$amount = $a - $amt;
							$upd = "UPDATE members SET amount=$amount WHERE member_id=$mbrid and recordstatus=1";
							mysqli_query($connect,$upd, $connect)or die("Error in sql mem".$upd);

							$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
							VALUES ($mbrid, $a, $amount, $amt, 'Withdraw Request', '$today', '$aatime')";
							mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
							$transfercan = "can";
						}						
					}
					else if ($inn == "alltype") {
						$stateid = mysqli_real_escape_string($connect,$data->state);
						$amt = mysqli_real_escape_string($connect,$data->amt);
						$m = mysqli_real_escape_string($connect,$data->mm);
						$allid = mysqli_real_escape_string($connect,$data->allid);
						if ($stateid == "1") {
							$sql1 = "SELECT state_id FROM withdraw WHERE withdraw_id=$allid";
							$result = mysqli_query($connect,$sql1, $connect)or die("Error in sql dep".$sql1);
							while ($r = mysqli_fetch_assoc($result)) {
								$a = $r["state_id"];
							}

							if ($a == 3) {
								$s = "SELECT amount FROM members WHERE member_id=$m and recordstatus=1";
								$result = mysqli_query($connect,$s, $connect)or die("Error in sql dep".$s);
								while ($r = mysqli_fetch_assoc($result)) {
									$aa = $r["amount"];
								}

								$upd = "UPDATE members SET amount=amount-$amt WHERE member_id=$m";
								mysqli_query($connect,$upd, $connect)or die("Error in sql mem".$upd);

								$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
								VALUES ($m, $aa, $aa-$amt, $amt, 'Withdraw ReConfirm', '$today', '$aatime')";
								mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
							}
							/*$s = "SELECT amount FROM members WHERE member_id=$m";
							$result = mysqli_query($connect,$s, $connect)or die("Error in sql dep".$s);
							while ($r = mysqli_fetch_assoc($result)) {
								$a = $r["amount"];
							}
							$amount = $a - $amt;
							$upd = "UPDATE members SET amount=$amount WHERE member_id=$m";
							mysqli_query($connect,$upd, $connect)or die("Error in sql mem".$upd);*/

							$u = "UPDATE withdraw SET state_id=$stateid WHERE withdraw_id=$allid";
							mysqli_query($connect,$u, $connect)or die("Error in sql dep".$u);
						}
						elseif ($stateid == "2") {
							$sql1 = "SELECT state_id FROM withdraw WHERE withdraw_id=$allid";
							$result = mysqli_query($connect,$sql1, $connect)or die("Error in sql dep".$sql1);
							while ($r = mysqli_fetch_assoc($result)) {
								$a = $r["state_id"];
							}

							if ($a == 3) {
								$s = "SELECT amount FROM members WHERE member_id=$m and recordstatus=1";
								$result = mysqli_query($connect,$s, $connect)or die("Error in sql dep".$s);
								while ($r = mysqli_fetch_assoc($result)) {
									$aa = $r["amount"];
								}

								$upd = "UPDATE members SET amount=amount-$amt WHERE member_id=$m";
								mysqli_query($connect,$upd, $connect)or die("Error in sql mem".$upd);

								$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
								VALUES ($m, $aa, $aa-$amt, $amt, 'Withdraw RePending', '$today', '$aatime')";
								mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
							}
							$u = "UPDATE withdraw SET state_id=$stateid WHERE withdraw_id=$allid";
							mysqli_query($connect,$u, $connect)or die("Error in sql dep".$u);
						}
						elseif ($stateid == "3") {
							$cover = "SELECT state_id FROM withdraw WHERE withdraw_id=$allid";
							$resultcover = mysqli_query($connect,$cover, $connect)or die("Error in sql dep".$cover);
							while ($rcover = mysqli_fetch_assoc($resultcover)) {
								$acover = $rcover["state_id"];
							}

							if ($acover != 3) {
								$s = "SELECT amount FROM members WHERE member_id=$m and recordstatus=1";
								$result = mysqli_query($connect,$s, $connect)or die("Error in sql dep".$s);
								while ($r = mysqli_fetch_assoc($result)) {
									$a = $r["amount"];
								}
								$amount = $a + $amt;
								$upd = "UPDATE members SET amount=$amount WHERE member_id=$m and recordstatus=1";
								mysqli_query($connect,$upd, $connect)or die("Error in sql mem".$upd);

								$u = "UPDATE withdraw SET state_id=$stateid WHERE withdraw_id=$allid";
								mysqli_query($connect,$u, $connect)or die("Error in sql dep".$u);

								$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
								VALUES ($m, $a, $amount, $amt, 'Withdraw Reject', '$today', '$aatime')";
								mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);	
							}							
						}
					}
				$wit = "SELECT m.loginid,a.withdraw_id as allid,a.*,'Withdraw' as alltype,m.username as mname from withdraw as a 
				LEFT JOIN members as m on m.member_id=a.member_id
				WHERE a.recordstatus=1 and m.recordstatus=1 $dvalue $tvalue $mid ORDER BY STR_TO_DATE(a.action_date, '%m-%d-%Y') DESC, STR_TO_DATE(a.action_time, '%h:%i:%s%p') DESC";
				$reswit = mysqli_query($connect,$wit, $connect)or die("Error in sql wit".$wit);
				if (mysqli_num_rows($reswit)<1) {
					$wdt = "No Record";
				}
				else{
					while ($w = mysqli_fetch_assoc($reswit)) {
						$wdt[] = $w;
					}
				}
			}
			else if ($sub == "transfer") {
				$inn = mysqli_real_escape_string($connect,$data->inner);
				$transfercan = "";
				if ($inn == "reqtransfer") {
					$mbrid =mysqli_real_escape_string($connect,$data->mbrid); 
					$amt = mysqli_real_escape_string($connect,$data->amt);
					$tfid = mysqli_real_escape_string($connect,$data->transferid);
					$transfertext = mysqli_real_escape_string($connect,$data->transfertext);
					//$oramt = mysqli_real_escape_string($connect,$data->oramt);

					$sql11 = "SELECT member_id FROM members 						 
						WHERE member_id=$mbrid AND recordstatus=1 
						AND member_id NOT IN (SELECT member_id FROM onoff WHERE onofftype='transferonoff')";
					$r11 = mysqli_query($connect,$sql11, $connect)or die("Error in sql ".$sql11);
					if (mysqli_num_rows($r11)<1) {
						$transfercan = "cannot";
					}
					else{
						$sql1 = "SELECT amount,member_id from members WHERE financeid='$tfid' and recordstatus=1";
						$r1 = mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);
						while ($t = mysqli_fetch_assoc($r1)) {
							$tran = $t["amount"];
							$mtoid = $t["member_id"];
						}
						$newamt = $tran+$amt;
						$sql2 = "UPDATE members SET amount=$newamt WHERE financeid='$tfid' and recordstatus=1";
						mysqli_query($connect,$sql2, $connect)or die("Error in sql ".$sql2);	

						$sql4 = "SELECT amount from members WHERE member_id=$mbrid and recordstatus=1";
						$r4 = mysqli_query($connect,$sql4, $connect)or die("Error in sql ".$sql4);
						while ($oramt = mysqli_fetch_assoc($r4)) {
							$orgamt = $oramt["amount"];
						}					

						$newamt2 = $orgamt-$amt;
						$sql3 = "UPDATE members SET amount=$newamt2 WHERE member_id=$mbrid and recordstatus=1";
						mysqli_query($connect,$sql3, $connect)or die("Error in sql ".$sql3);

						$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
						VALUES ($mbrid, $orgamt, $newamt2, $amt, 'Transfer To Other Member', '$today', '$aatime')";
						mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);

						$sql4 = "INSERT INTO transfer(mfrom_id,mto_id,amount,action_date,action_time,state_id,transfertext,createddate) VALUES($mbrid,$mtoid,$amt,'$today','$aatime',1,'$transfertext','$today')";
						mysqli_query($connect,$sql4, $connect)or die("Error in sql ".$sql4);					

						$detail1 = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
						VALUES ($mtoid, $tran, $newamt, $amt, 'Transfer From Other Member', '$today', '$aatime')";
						mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail1);

						$transfercan = "can";
					}					
				}
				elseif ($inn == "reqadtransfer") {
					$toid =mysqli_real_escape_string($connect,$data->transfertoid); 
					$amt = mysqli_real_escape_string($connect,$data->amt);
					$fromid = mysqli_real_escape_string($connect,$data->transferfromid);
					$fmbrid = mysqli_real_escape_string($connect,$data->fmbrid);
					$tmbrid = mysqli_real_escape_string($connect,$data->tmbrid);
					$transfertext = mysqli_real_escape_string($connect,$data->transfertext);

					$sql4 = "SELECT amount from members WHERE member_id=$fmbrid and recordstatus=1";
					$r4 = mysqli_query($connect,$sql4, $connect)or die("Error in sql ".$sql4);
					while ($foramt = mysqli_fetch_assoc($r4)) {
						$famt = $foramt["amount"];
					}

					$sql5 = "SELECT amount from members WHERE member_id=$tmbrid and recordstatus=1";
					$r5 = mysqli_query($connect,$sql5, $connect)or die("Error in sql ".$sql5);
					while ($toramt = mysqli_fetch_assoc($r5)) {
						$tamt = $toramt["amount"];
					}

					$sql1 = "UPDATE members set amount=amount-$amt WHERE financeid='$fromid' and recordstatus=1";
					mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);

					$sql2 = "UPDATE members set amount=amount+$amt WHERE financeid='$toid' and recordstatus=1";
					mysqli_query($connect,$sql2, $connect)or die("Error in sql ".$sql2);

					$sql4 = "INSERT INTO transfer(mfrom_id,mto_id,amount,action_date,action_time,state_id,transfertext,createddate) VALUES($fmbrid,$tmbrid,$amt,'$today','$aatime',1,'$transfertext','$today')";
					mysqli_query($connect,$sql4, $connect)or die("Error in sql ".$sql4);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($fmbrid, $famt, $famt-$amt, $amt, 'Transfer To Other Member', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);

					$detail1 = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($tmbrid, $tamt, $tamt+$amt, $amt, 'Transfer From Other Member', '$today', '$aatime')";
					mysqli_query($connect,$detail1, $connect)or die("Error in sql dep".$detail1);
				}

				$trf = "(SELECT a.loginid,t.*,(t.amount)*(-1) as ttamount,a.financeid as fromid,mt.financeid as toid,mt.username as touser,a.username as fuser,'famount' as classname from transfer as t 
				INNER JOIN members as a on a.member_id=t.mfrom_id
				INNER JOIN members as mt on mt.member_id=t.mto_id
				WHERE t.recordstatus=1 $mid ORDER BY STR_TO_DATE(t.action_date, '%m-%d-%Y') DESC, STR_TO_DATE(t.action_time, '%h:%i:%s%p') DESC)
		                      UNION
		                      (SELECT a.loginid,t.*,(t.amount)*(1) as ttamount,mf.financeid as fromid,a.financeid as toid,a.username as touser,mf.username as fuser,'tamount' as classname from transfer as t 
				INNER JOIN members as a on a.member_id=t.mto_id
				INNER JOIN members as mf on mf.member_id=t.mfrom_id
				WHERE t.recordstatus=1 $mid ORDER BY STR_TO_DATE(t.action_date, '%m-%d-%Y') DESC, STR_TO_DATE(t.action_time, '%h:%i:%s%p') DESC)";
				$restrf = mysqli_query($connect,$trf, $connect)or die("Error in sql tra".$trf);
				if (mysqli_num_rows($restrf)<1) {
					$wdt = "No Record";
				}
				else{
					while ($t = mysqli_fetch_assoc($restrf)) {
						$wdt[] = $t;
					}
				}
				$sqllimit = "SELECT min,max FROM tlimit WHERE limit_type='transfer'";
				$limitres = mysqli_query($connect,$sqllimit, $connect)or die("Error in sql tra".$sqllimit);
				if (mysqli_num_rows($limitres)<1) {
					$min = "No Record";
					$max = "No Record";
				}
				else{
					while ($tl = mysqli_fetch_assoc($limitres)) {
						$min = $tl["min"];
						$max = $tl["max"];
					}
				}
			}	

			$st = "SELECT bs_gs_id as state_id,description FROM bs_gs WHERE recordstatus=1 AND bs_gs_id!=9";
			$res = mysqli_query($connect,$st, $connect)or die("Error in sql ".$st);
			while ($sta = mysqli_fetch_assoc($res)) {
				$ss[] = $sta;
			}

			if ($mid != "and 1=1"){
				$amt = "SELECT a.* from members as a WHERE 1=1 AND a.recordstatus=1 $mid";
				$a = mysqli_query($connect,$amt, $connect)or die("Error in sql ".$amt);
				while ($amount = mysqli_fetch_assoc($a)) {
					$m[] = $amount;
					$mname = $amount["username"];
				}
			}
			else{
				$m = "Admin";
				$mname = "Admin";
			}

			$bk = "SELECT bh.bank_history_id,bh.cardnumber,b.description as bname FROM bank_history as bh 
			INNER JOIN banks as b on bh.bank_id=b.bank_id 
			WHERE type='u' and bh.recordstatus=1";
			$resbk = mysqli_query($connect,$bk, $connect)or die("Error in sql ".$bk);
			if (mysqli_num_rows($resbk)<1) {
				$bks = "No Record";
			}
			else{
				while ($b = mysqli_fetch_assoc($resbk)) {
					$bks[] = $b;
				}
			}
			$mbk = "SELECT a.bank_history_id,a.cardnumber,b.description as bname,b.bank_id  FROM bank_history as a 
			INNER JOIN banks as b on a.bank_id=b.bank_id 
			WHERE a.type='m' and a.recordstatus=1 and b.recordstatus=1 $mid";
			$resbk = mysqli_query($connect,$mbk, $connect)or die("Error in sql ".$mbk);
			if (mysqli_num_rows($resbk)<1) {
				$sql2 = "SELECT bank_id as bank_history_id,description as bname FROM banks WHERE banks.recordstatus=1";
				$res2=mysqli_query($connect,$sql2, $connect)or die("Error in sql "+$sql2);	
				while($r2 = mysqli_fetch_assoc($res2)){
					$mbks[]= $r2;
				}
			}
			else{
				while ($mb = mysqli_fetch_assoc($resbk)) {
					$mbks[] = $mb;
				}
			}
			if ($sub == "transfer") {				
				$data = array("wdt"=>$wdt, "sta"=>$ss, "m"=>$m, "bks"=>$bks, "mbks"=>$mbks, "mname"=>$mname, "minlimit"=>$min, "maxlimit"=>$max, "transfercan"=>$transfercan);
			}
			else{
				$data = array("wdt"=>$wdt, "sta"=>$ss, "m"=>$m, "bks"=>$bks, "mbks"=>$mbks, "mname"=>$mname, "transfercan"=>$transfercan);
			}
			
		}
		elseif ($btn == "ledger") {
				$dvalue = mysqli_real_escape_string($connect,$data->datevalue);	
				$mbrid = mysqli_real_escape_string($connect,$data->mbrid);	
				$mix = mysqli_real_escape_string($connect,$data->mix);
				$chyear = mysqli_real_escape_string($connect,$data->chyear);
				if ($chyear != 0) {
					$cmainyear = $chyear;
				}

				if ($dvalue == "f" || $dvalue == "") {
					$dvalue = "and 2=2";
				}
				else{
					$dvalue = "and a.bet_date ='".$dvalue."'";
				}
				
				$sql6="SELECT a.* from members as a WHERE a.recordstatus=1 $mid";
			  	$res6=mysqli_query($connect,$sql6, $connect)or die("Error in sql "+$sql6);
			  	if (mysqli_num_rows($res6)<1) {
					$data6 = "Admin";
					$mname = "Admin";
				}
				else{
					while($r6 = mysqli_fetch_assoc($res6)){
						$data6[]= $r6["amount"];
						$mname = $r6["username"];
					}
				}

				if ($mix == "mix") {
					$all = "SELECT members.username,bg.description as bgdescription, a.member_id, a.mixledger_id, a.betstateid,
				            dashboard_".$cmainyear.".score, mixledger_detail_".$cmainyear.".bet_on, a.bet_date, 
				            a.bet_time, a.mixledger_id as mid,leagues.league_id as lid, leagues.leaguename, thome.teamname as h,
				            taway.teamname as a,status.*,status1.description as ddescription, status1.status_id as bgstatusid, 
				            a.bet_amount, mix.mixname,mix.mix_id,
				           (CASE WHEN(a.result_amount<0) THEN 'red' ELSE 'black' END) as resultclass,
					(CASE WHEN(a.bet_amount<0) THEN 'red' ELSE 'black' END) as betamtclass,
					(CASE WHEN(a.net_amount<0) THEN 'red' ELSE 'black' END) as netclass,
					
					(CASE mixledger_detail_".$cmainyear.".bet_on 
				            WHEN 'home' THEN bodies.bodyname
				            WHEN 'away' THEN bodies.bodyname
				            WHEN 'over' THEN goalplus.goalname
				            WHEN 'down' THEN goalplus.goalname
				            ELSE 'None' END) AS bgname,

					(CASE mixledger_detail_".$cmainyear.".bet_on 
				            WHEN 'home' THEN history_".$cmainyear.".body_value
				            WHEN 'away' THEN history_".$cmainyear.".body_value
				            WHEN 'over' THEN history_".$cmainyear.".goalplus_value
				            WHEN 'down' THEN history_".$cmainyear.".goalplus_value
				            ELSE 'None' END) AS bgval,

				            (CASE a.betstateid 
				            WHEN '2' THEN 'WAITING'
				            WHEN '1' THEN
				            CASE a.accbgid
				            WHEN '0' THEN 'RUNNING'
				            ELSE a.result_amount END
				            ELSE a.result_amount END) AS result_amount, 

				            (CASE a.betstateid 
				            WHEN '2' THEN 'WAITING' 
				            WHEN '1' THEN
				            CASE a.accbgid
				            WHEN '0' THEN 'RUNNING'
				            ELSE a.net_amount END
				            ELSE a.net_amount END) AS net_amount,

					(CASE mixledger_detail_".$cmainyear.".bet_on 
				            WHEN 'home' THEN thome.teamname
				            WHEN 'away' THEN taway.teamname
				            WHEN 'over' THEN 'Over'
				            WHEN 'down' THEN 'Down'
				            ELSE 'None' END) AS bet_on_name,

					(CASE status.status_id 
				            WHEN '1' THEN 'gn'
				            WHEN '6' THEN 'gn'
				            WHEN '7' THEN 'gn'
				            WHEN '3' THEN 'minus'
				            WHEN '4' THEN 'minus'
				            WHEN '8' THEN 'minus'
				            ELSE 'bk' END) AS desclass,

				            (CASE a.betstateid 
				            WHEN '1' THEN
				            CASE a.accbgid
				            WHEN '0' THEN 'RUNNING'
				            ELSE status.description END
				            ELSE status.description END) AS sdescription

				            FROM mixledger_detail_".$cmainyear." 
				            INNER JOIN mixledger_".$cmainyear." as a ON a.mixledger_id=mixledger_detail_".$cmainyear.".mixledger_id
				            INNER JOIN status on a.status_id=status.status_id 
				            INNER JOIN status as status1 on mixledger_detail_".$cmainyear.".status_id=status1.status_id 
				            INNER JOIN bs_gs as bg on a.betstateid = bg.bs_gs_id
				            INNER JOIN dashboard_".$cmainyear." on mixledger_detail_".$cmainyear.".dashboard_id=dashboard_".$cmainyear.".dashboard_id			
				            INNER JOIN timetable on dashboard_".$cmainyear.".timetableid=timetable.timetableid
				            INNER JOIN leagues on timetable.league_id=leagues.league_id 
				            INNER JOIN teams as thome on thome.team_id=timetable.home
				            INNER JOIN history_".$cmainyear." ON history_".$cmainyear.".history_id=mixledger_detail_".$cmainyear.".history_id
				            LEFT JOIN goalplus on goalplus.goalplus_id = dashboard_".$cmainyear.".goalplus_id 
				            LEFT JOIN bodies on bodies.body_id = dashboard_".$cmainyear.".body_id
				            INNER JOIN members on members.member_id =a.member_id 
				            INNER JOIN teams as taway on taway.team_id=timetable.away 
				            INNER JOIN mix ON mix.mixname=a.mixname
				            WHERE a.recordstatus=1 $mbrid $dvalue 
				            ORDER BY STR_TO_DATE(a.bet_time, '%h:%i:%s%p') DESC,mixledger_detail_".$cmainyear.".mixledger_detail_id";
				}
				elseif ($mix == "no") {
					$all = "SELECT a.*,
					(CASE WHEN a.bet like '%Goal+%' THEN g.goalname ELSE b.bodyname END) AS bgname, 
					(CASE WHEN a.bet like '%Goal+%' THEN his.goalplus_value ELSE his.body_value END) AS bgval, 
					(CASE a.status_id WHEN 1 THEN 'wgn' WHEN 2 THEN 'yw' WHEN 3 THEN 'rd' WHEN 4 THEN 'lrd' WHEN 6 THEN 'gn' ELSE 'df' END) as sname,
					(CASE WHEN ((a.result_amount)>=0) THEN 'p' ELSE 'minus' END) as numformat,
					 a.org_amount as oramount,
					 a.member_id,
			                       a.bet_date as dates,
			                       a.bet_time as time,
			                       m.username,
			                       a.net_amount as turnover,
			                       a.result_amount as wl,
			                       a.bet_amount as betamount,
			                       a.status_id as state_id,
			                       status.description as statusdes,
			                       bs_gs.description as betstatedes,
			                       lg.leaguename, 
			                       h.teamname as hometeam,
			                       d.score,
			                       aw.teamname as awayteam,
			                       (CASE a.bet_on WHEN 'Home' THEN his.hper WHEN 'Away' THEN his.aper WHEN 'Over' THEN his.uper WHEN 'Down' THEN his.dper END) as percent
					 from mledger_".$cmainyear." as a 
					 LEFT JOIN status on a.status_id=status.status_id
					 LEFT JOIN bs_gs on a.betstateid=bs_gs.bs_gs_id
					 LEFT JOIN dashboard_".$cmainyear." as d on a.dashboard_id=d.dashboard_id
					 INNER JOIN timetable as t on t.timetableid=d.timetableid
					 LEFT JOIN leagues as lg on t.league_id=lg.league_id
					 LEFT JOIN teams as h on t.home=h.team_id
					 LEFT JOIN teams as aw on t.away=aw.team_id
					 LEFT JOIN history_".$cmainyear." as his on a.history_id = his.history_id
					 LEFT JOIN bodies as b on his.body_id=b.body_id
					 LEFT JOIN goalplus as g on his.goalplus_id=g.goalplus_id
					 INNER JOIN members as m on a.member_id=m.member_id WHERE 1=1 $mbrid $dvalue 
					 ORDER BY STR_TO_DATE(a.bet_date, '%m-%d-%Y') DESC, STR_TO_DATE(a.bet_time, '%h:%i:%s%p') DESC";
				}

				$allres = mysqli_query($connect,$all, $connect)or die("Error in sql 1".$all);
				if (mysqli_num_rows($allres)<1) {
					$allresult = "No Record";
				}
				else{
					while ($aaa = mysqli_fetch_assoc($allres)) {
						$allresult[] = $aaa;
					}
				}

				$y=date("Y");
				$start = $y - 5;
				$end = $y + 10;
				$yeararr = [];
				for ($i=$start; $i < $end; $i++) { 
					$yeararr[$i]["year"] = intval($i);
				}

				$data = array("yeararr"=>$yeararr, "m"=>$data6,"ledger"=>$allresult, "mname"=>$mname);
			}
		elseif ($btn == "mprofile") {
			$sub = mysqli_real_escape_string($connect,$data->sub);
			if ($sub == "edit") {
				$p = mysqli_real_escape_string($connect,$data->pass);
				
				$sql = "UPDATE members SET password='$p' WHERE member_id=$mid and recordstatus=1";
				mysqli_query($connect,$sql)or die("Error in query".$sql);								
			}
			elseif ($sub == "addcard") {
				$c = mysqli_real_escape_string($connect,$data->card);
				$b = mysqli_real_escape_string($connect,$data->bank);
				$sql = "INSERT INTO bank_history(bank_id,type,cardnumber,member_id) VALUES($b,'m','$c','$mid')";
				mysqli_query($connect,$sql)or die("Error in query".$sql);	
			}
			elseif ($sub == "delcard") {
				$bh = mysqli_real_escape_string($connect,$data->bh);
				$sql = "DELETE FROM bank_history WHERE bank_history_id=$bh";
				mysqli_query($connect,$sql)or die("Error in query".$sql);	
			}
			elseif ($sub == "ecard") {
				$bh = mysqli_real_escape_string($connect,$data->bh);
				$c = mysqli_real_escape_string($connect,$data->card);
				$b = mysqli_real_escape_string($connect,$data->bank);
				$sql = "UPDATE bank_history SET bank_id=$b, cardnumber=$c WHERE bank_history_id=$bh";
				mysqli_query($connect,$sql)or die("Error in query".$sql);	
			}
			elseif ($sub == "betlist") {
				$fromdate = mysqli_real_escape_string($connect,$data->fromdate);		
				$todate = mysqli_real_escape_string($connect,$data->todate);
				$otherdate = mysqli_real_escape_string($connect,$data->otherdate);
				$datesign = mysqli_real_escape_string($connect,$data->datesign);

				if ($datesign == "all") {
					$checkdate = "";
				}
				else if ($fromdate != "" && $todate != "" && $datesign == "btw") {
					$checkdate = " and STR_TO_DATE(a.bet_date, '%m-%d-%Y') between STR_TO_DATE('".$fromdate."', '%m-%d-%Y') and STR_TO_DATE('".$todate."', '%m-%d-%Y')";
				}
				else if($otherdate != "" && $datesign != ""){
					$checkdate = " and STR_TO_DATE(a.bet_date, '%m-%d-%Y')".$datesign." STR_TO_DATE('".$otherdate."', '%m-%d-%Y') ";
				}
				else{
					$checkdate = " and STR_TO_DATE(a.bet_date, '%m-%d-%Y') = STR_TO_DATE('".$today."', '%m-%d-%Y')";
				}

				/*$sql = "SELECT a.*,status.description as wlstatus FROM mledger_".$cmainyear." as a 
				INNER JOIN status ON status.status_id=a.status_id
				WHERE a.member_id=$mid $checkdate";*/

				$sql = "SELECT a.*,
					(CASE WHEN a.bet like '%Goal+%' THEN g.goalname ELSE b.bodyname END) AS bgname, 
					(CASE WHEN a.bet like '%Goal+%' THEN his.goalplus_value ELSE his.body_value END) AS bgval, 
					(CASE a.status_id WHEN 1 THEN 'wgn' WHEN 2 THEN 'yw' WHEN 3 THEN 'rd' WHEN 4 THEN 'lrd' WHEN 6 THEN 'gn' ELSE 'df' END) as sname,
					(CASE WHEN ((a.result_amount)>=0) THEN 'p' ELSE 'minus' END) as numformat,
					 a.org_amount as oramount,
					 a.member_id,
			                       a.bet_date as dates,
			                       a.bet_time as time,
			                       m.username,
			                       a.net_amount as turnover,
			                       a.result_amount as wl,
			                       a.bet_amount as betamount,
			                       a.status_id as state_id,
			                       status.description as statusdes,
			                       bs_gs.description as betstatedes,
			                       lg.leaguename, 
			                       h.teamname as hometeam,
			                       d.score,
			                       aw.teamname as awayteam,
			                       (CASE a.bet_on WHEN 'Home' THEN his.hper WHEN 'Away' THEN his.aper WHEN 'Over' THEN his.uper WHEN 'Down' THEN his.dper END) as percent
					 from mledger_".$cmainyear." as a 
					 LEFT JOIN status on a.status_id=status.status_id
					 LEFT JOIN bs_gs on a.betstateid=bs_gs.bs_gs_id
					 LEFT JOIN dashboard_".$cmainyear." as d on a.dashboard_id=d.dashboard_id
					 INNER JOIN timetable as t on t.timetableid=d.timetableid
					 LEFT JOIN leagues as lg on t.league_id=lg.league_id
					 LEFT JOIN teams as h on t.home=h.team_id
					 LEFT JOIN teams as aw on t.away=aw.team_id
					 LEFT JOIN history_".$cmainyear." as his on a.history_id = his.history_id
					 LEFT JOIN bodies as b on his.body_id=b.body_id
					 LEFT JOIN goalplus as g on his.goalplus_id=g.goalplus_id
					 INNER JOIN members as m on a.member_id=m.member_id WHERE a.member_id=$mid $checkdate
					 ORDER BY STR_TO_DATE(a.bet_date, '%m-%d-%Y') DESC, STR_TO_DATE(a.bet_time, '%h:%i:%s%p') DESC";
				$res1 = mysqli_query($connect,$sql)or die("Error in query".$sql);
				if (mysqli_num_rows($res1)<1) {
					$bgbetlist = "No Record";
				}
				else{
					while ($dd1 = mysqli_fetch_assoc($res1)) {
						$bgbetlist[] = $dd1;
					}
				}

				$sqlmix = "SELECT a.*,members.loginid,members.username,bg.description as bgdescription, a.member_id, a.mixledger_id, a.betstateid,
			            dashboard_".$cmainyear.".score, mixledger_detail_".$cmainyear.".bet_on, a.bet_date, 
			            a.bet_time, a.mixledger_id as mid,leagues.league_id as lid, leagues.leaguename, thome.teamname as h,
			            taway.teamname as a,status.*,status1.description as ddescription, status1.status_id as bgstatusid, 
			            a.bet_amount, mix.mixname,mix.mix_id,mix.mmval,

			            (CASE a.betstateid 
			            WHEN '2' THEN 'WAITING'
			            WHEN '1' THEN
			            CASE a.accbgid
			            WHEN '0' THEN 'RUNNING'
			            ELSE a.result_amount END
			            ELSE a.result_amount END) AS result_amount, 

			            (CASE a.betstateid 
			            WHEN '2' THEN 'WAITING' 
			            WHEN '1' THEN
			            CASE a.accbgid
			            WHEN '0' THEN 'RUNNING'
			            ELSE a.net_amount END
			            ELSE a.net_amount END) AS net_amount,

				(CASE mixledger_detail_".$cmainyear.".bet_on 
			            WHEN 'home' THEN thome.teamname
			            WHEN 'away' THEN taway.teamname
			            WHEN 'over' THEN 'Over'
			            WHEN 'down' THEN 'Down'
			            ELSE 'None' END) AS bet_on_name,

			            (CASE a.betstateid 
			            WHEN '1' THEN
			            CASE a.accbgid
			            WHEN '0' THEN 'RUNNING'
			            ELSE status.description END
			            ELSE status.description END) AS sdescription

			            FROM mixledger_detail_".$cmainyear." 
			            INNER JOIN mixledger_".$cmainyear." as a ON a.mixledger_id=mixledger_detail_".$cmainyear.".mixledger_id
			            INNER JOIN status on a.status_id=status.status_id 
			            INNER JOIN status as status1 on mixledger_detail_".$cmainyear.".status_id=status1.status_id 
			            INNER JOIN bs_gs as bg on a.betstateid = bg.bs_gs_id
			            INNER JOIN dashboard_".$cmainyear." on mixledger_detail_".$cmainyear.".dashboard_id=dashboard_".$cmainyear.".dashboard_id			
			            INNER JOIN timetable on dashboard_".$cmainyear.".timetableid=timetable.timetableid
			            INNER JOIN leagues on timetable.league_id=leagues.league_id 
			            INNER JOIN teams as thome on thome.team_id=timetable.home
			            INNER JOIN history_".$cmainyear." ON history_".$cmainyear.".history_id=mixledger_detail_".$cmainyear.".history_id
			            LEFT JOIN goalplus on goalplus.goalplus_id = dashboard_".$cmainyear.".goalplus_id 
			            LEFT JOIN bodies on bodies.body_id = dashboard_".$cmainyear.".body_id
			            INNER JOIN members on members.member_id =a.member_id 
			            INNER JOIN teams as taway on taway.team_id=timetable.away 
			            INNER JOIN mix ON mix.mixname=a.mixname
			            WHERE a.recordstatus=1 AND a.member_id=$mid $checkdate
				 ORDER BY STR_TO_DATE(a.bet_date, '%m-%d-%Y') DESC, STR_TO_DATE(a.bet_time, '%h:%i:%s%p') DESC,mixledger_detail_".$cmainyear.".mixledger_detail_id";
				$resmix = mysqli_query($connect,$sqlmix)or die("Error in query".$sqlmix);
				if (mysqli_num_rows($resmix)<1) {
					$mixbetlist = "No Record";
				}
				else{
					while ($ddmix = mysqli_fetch_assoc($resmix)) {
						$mixbetlist[] = $ddmix;
					}
				}
			}
			elseif ($sub == "agentsetup") {
				$userid = mysqli_real_escape_string($connect,$data->userid);
				$sql = "INSERT INTO agents(member_id,userid,createddate,createdtime) VALUES($mid, $userid, '$today', '$aatime')";
				mysqli_query($connect,$sql, $connect)or die("Error in sql "+$sql);
			}
			elseif ($sub == "editagent") {
				$winper = mysqli_real_escape_string($connect,$data->winper);
				$loseper = mysqli_real_escape_string($connect,$data->loseper);
				$mixwinper = mysqli_real_escape_string($connect,$data->mixwinper);
				$mixloseper = mysqli_real_escape_string($connect,$data->mixloseper);
				$onoffag = mysqli_real_escape_string($connect,$data->onoffag);
				$onoffagcom = mysqli_real_escape_string($connect,$data->onoffagcom);

				$sql = "UPDATE agents SET winper = $winper, loseper = $loseper,mixwinper=$mixwinper,mixloseper=$mixloseper WHERE member_id = $mid AND recordstatus = 1";
				mysqli_query($connect,$sql, $connect)or die("Error in sql "+$sql);

				$sql1 = "DELETE FROM onoff WHERE member_id = $mid AND onofftype IN('agentonoff','commissiononoff')";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);

				if ($onoffagcom == true) {
					$sql2 = "INSERT INTO onoff(member_id,onofftype,createddate) VALUES($mid,'commissiononoff','$today')";
					mysqli_query($connect,$sql2)or die("Error in query".$sql2);
				}
				if ($onoffag == true) {
					$sql2 = "INSERT INTO onoff(member_id,onofftype,createddate) VALUES($mid,'agentonoff','$today')";
					mysqli_query($connect,$sql2)or die("Error in query".$sql2);
				}
								
			}
			elseif ($sub == "chmembertype") {
				$typeid = mysqli_real_escape_string($connect,$data->typeid);
				$sql1 = "UPDATE members SET membertype=$typeid WHERE member_id=$mid AND recordstatus=1";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			}

			$sql6="SELECT ROUND((agents.winper)*100) as winper,ROUND((agents.loseper)*100) as loseper,
			ROUND((agents.mixwinper)*100) as mixwinper,ROUND((agents.mixloseper)*100) as mixloseper,
			members.*,usertype.maxbet,usertype.minbet,usertype.totalamt,
			(ifnull(agenttbl.username,'-')) as youragent,(ifnull(agents.agent_id,0)) as agentid,
			(CASE WHEN members.membertype=0 THEN 'DEFAULT' ELSE usertype.typename END) as typename,usertype.typeid 
			FROM members 
			LEFT JOIN agents ON agents.member_id = members.member_id 
			LEFT JOIN usertype ON usertype.typeid = members.membertype
			LEFT JOIN agent_member ON agent_member.member_id = members.member_id
			LEFT JOIN agents AS agent ON agent.agent_id = agent_member.agent_id 
			LEFT JOIN members AS agenttbl ON agenttbl.member_id = agent.agent_id
			WHERE members.member_id=$mid AND members.recordstatus=1";
			$res6=mysqli_query($connect,$sql6, $connect)or die("Error in sql "+$sql6);	
			while($r6 = mysqli_fetch_assoc($res6)){
				$data6[]= $r6;
			}

			$sql10 = "SELECT * FROM usertype WHERE recordstatus=1";
			$res10=mysqli_query($connect,$sql10, $connect)or die("Error in sql "+$sql10);	
			while($r10 = mysqli_fetch_assoc($res10)){
				$data10[]= $r10;
			}

			$sql9="SELECT * from agents WHERE member_id=$mid AND recordstatus=1";
			$res9=mysqli_query($connect,$sql9, $connect)or die("Error in sql "+$sql9);	
			if (mysqli_num_rows($res9)<1) {
				$agents = 0;
				$agentdata = null;
				$commission = null;
				$agentonoff = null;
			}
			else{
				while($r9 = mysqli_fetch_assoc($res9)){
					$agentdata[] = $r9;				
				}
				$agents = 1;

				$sql10 = "SELECT onoff_id from onoff WHERE onofftype='commissiononoff' AND member_id=$mid";
				$res10 = mysqli_query($connect,$sql10, $connect)or die("Error in sql "+$sql10);
				if (mysqli_num_rows($res10)>0) {
					$commission = false;
				}
				else{
					$commission = true;
				}

				$sql11 = "SELECT onoff_id from onoff WHERE onofftype='agentonoff' AND member_id=$mid";
				$res11 = mysqli_query($connect,$sql11, $connect)or die("Error in sql "+$sql11);
				if (mysqli_num_rows($res11)<1) {
					$agentonoff = false;
				}
				else{
					$agentonoff = true;
				}
			}
			

			$sql7="SELECT bh.*,b.description from bank_history as bh INNER JOIN banks as b ON bh.bank_id=b.bank_id WHERE member_id=$mid AND type='m' AND bh.recordstatus=1";
			$res7=mysqli_query($connect,$sql7, $connect)or die("Error in sql "+$sql7);	
			while($r7 = mysqli_fetch_assoc($res7)){
				$data7[]= $r7;
			}
			$sql8="SELECT * from banks WHERE recordstatus=1";
			$res8=mysqli_query($connect,$sql8, $connect)or die("Error in sql "+$sql8);	
			while($r8 = mysqli_fetch_assoc($res8)){
				$data8[]= $r8;
			}
			if (mysqli_num_rows($res7)<1) {
				$data = array("mp"=>$data6, "bank"=>$data8, "bgbetlist"=>$bgbetlist, "mixbetlist"=>$mixbetlist, "agent"=>$agents, "agentdata"=>$agentdata, "commission"=>$commission, "usertype"=>$data10, "agentonoff"=>$agentonoff);
			}else{
				$data = array("mp"=>$data6, "bankcard"=>$data7, "bank"=>$data8, "bgbetlist"=>$bgbetlist, "mixbetlist"=>$mixbetlist, "agent"=>$agents, "agentdata"=>$agentdata, "commission"=>$commission, "usertype"=>$data10, "agentonoff"=>$agentonoff);
			}				
		}
		elseif ($btn == "wdt") {
			$fromdate = mysqli_real_escape_string($connect,$data->fromdate);		
			$todate = mysqli_real_escape_string($connect,$data->todate);
			$otherdate = mysqli_real_escape_string($connect,$data->otherdate);
			$datesign = mysqli_real_escape_string($connect,$data->datesign);

			if ($datesign == "all") {
				$checkdate = "";
				//$limit = "";
			}
			else if ($fromdate != "" && $todate != "" && $datesign == "btw") {
				$checkdate = " and STR_TO_DATE(a.dates, '%m-%d-%Y') between STR_TO_DATE('".$fromdate."', '%m-%d-%Y') and STR_TO_DATE('".$todate."', '%m-%d-%Y')";
				//$limit = "";
			}
			else if($otherdate != "" && $datesign != ""){
				$checkdate = " and STR_TO_DATE(a.dates, '%m-%d-%Y')".$datesign." STR_TO_DATE('".$otherdate."', '%m-%d-%Y') ";
				//$limit = "";
			}
			else{
				$checkdate = " and STR_TO_DATE(a.dates, '%m-%d-%Y') between STR_TO_DATE('".$specdate."', '%m-%d-%Y') and STR_TO_DATE('".$today."', '%m-%d-%Y')";
				//$limit = " and STR_TO_DATE(a.dates, '%m-%d-%Y') between STR_TO_DATE('".$specdate."', '%m-%d-%Y') and STR_TO_DATE('".$today."', '%m-%d-%Y')";
			}
			
			$st = "SELECT bs_gs_id as state_id,description FROM bs_gs WHERE recordstatus=1 AND bs_gs_id!=9";
			//$sql8 ="SELECT accgoal_id as accbgid,description,formula from accgoal WHERE recordstatus=1";
			$res = mysqli_query($connect,$st, $connect)or die("Error in sql ".$st);
			while ($sta = mysqli_fetch_assoc($res)) {
					$ss[] = $sta;
			}

			/*$all = "SELECT aa.* from ((SELECT 'd' as cname,m.amount as oramount,a.deposite_id as allid,a.member_id,a.action_date as dates,a.action_time as time,m.username, a.amount,cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount, 'Deposite' as alltype, b.description as bk, bh.cardnumber, a.city, a.ph, '-' as fromid, '-' as toid,a.state_id from deposite as a 
				LEFT JOIN members as m on a.member_id=m.member_id
				LEFT JOIN bank_history as bh on a.bank_history_id=bh.bank_history_id 
				LEFT JOIN banks as b on bh.bank_id=b.bank_id WHERE 1=1 $mid)
				UNION
				(SELECT 'w' as cname,m.amount as oramount,a.withdraw_id as allid,a.member_id,a.action_date as dates,a.action_time as time, m.username, a.amount,cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,'Withdraw' as alltype, a.bank as bk, a.acc_nrc as cardnumber, a.city, a.ph, '-' as fromid, '-' as toid,a.state_id from withdraw as a 
				LEFT JOIN members as m on a.member_id=m.member_id
				WHERE 1=1 $mid)
				UNION
				(SELECT 'tf' as cname,a.amount as oramount,t.transfer_id as allid,a.member_id,t.action_date as dates,t.action_time as time, a.username,t.amount,cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,'Transfer To (Sent)' as alltype, '-' as bk, '-' as cardnumber, '-' as city, '-' as ph, a.financeid as fromid,mt.financeid as toid,t.state_id from transfer as t 
				INNER JOIN members as a on a.member_id=t.mfrom_id
				INNER JOIN members as mt on mt.member_id=t.mto_id WHERE 1=1 $mid)
		                      UNION
		                      (SELECT 'tt' as cname,a.amount as oramount,t.transfer_id as allid,a.member_id,t.action_date as dates,t.action_time as time, a.username,t.amount,cast('0' as CHARACTER) as turnover,cast('0' as CHARACTER) as wl,cast('0' as CHARACTER) as betamount,'Transfer From (Received)' as alltype, '-' as bk, '-' as cardnumber, '-' as city, '-' as ph, a.financeid as fromid,mt.financeid as toid,t.state_id from transfer as t 
				INNER JOIN members as a on a.member_id=t.mto_id
				INNER JOIN members as mt on mt.member_id=t.mfrom_id WHERE 1=1 $mid)
		                      UNION
		                      (SELECT (CASE WHEN (SUM(a.net_amount)-SUM(a.bet_amount))>0 THEN 'g' ELSE 'l' END) as cname,a.org_amount as oramount,'0' as allid,a.member_id,a.bet_date as dates,a.bet_time as time,m.username,(SUM(a.net_amount)-SUM(a.bet_amount)) as amount, SUM(a.net_amount) as turnover,SUM(a.result_amount) as wl,SUM(a.bet_amount) as betamount, 'Betting' as alltype, '-' as bk, '-' as cardnumber, m.city, m.phone as ph, '-' as fromid, '-' as toid,'' as state_id FROM mledger_".$cmainyear." as a
		                      LEFT JOIN members as m on a.member_id=m.member_id WHERE 1=1 $mid GROUP BY(a.bet_date))) as aa WHERE aa.dates between '$specdate' and '$today' ORDER BY aa.dates DESC, aa.time DESC";
			*/
			
			$all = "SELECT a.* from ((SELECT 'd' as cname,a.deposite_id as allid,a.member_id,a.action_date as dates,a.action_time as time,
				sum(a.amount) as amount,
				'Deposit' as alltype from deposite as a WHERE 1=1 AND a.state_id=1 $mid
				GROUP BY(a.action_date))
				UNION
				(SELECT 'w' as cname,a.withdraw_id as allid,a.member_id,a.action_date as dates,a.action_time as time, 
				sum(a.amount) as amount,
				'Withdraw' as alltype from withdraw as a WHERE 1=1 AND a.state_id!=3 $mid
				GROUP BY(a.action_date))
				UNION
				(SELECT 'tf' as cname,t.transfer_id as allid,a.member_id,t.action_date as dates,t.action_time as time,
				sum(t.amount) as amount,
				'Transfer To (Sent)' as alltype from transfer as t 
				INNER JOIN members as a on a.member_id=t.mfrom_id
				INNER JOIN members as mt on mt.member_id=t.mto_id WHERE 1=1 $mid GROUP BY(t.action_date))
		                      UNION
		                      (SELECT 'tt' as cname,t.transfer_id as allid,a.member_id,t.action_date as dates,t.action_time as time, 
		                      sum(t.amount) as amount,
		                      	'Transfer From (Received)' as alltype from transfer as t 
				INNER JOIN members as a on a.member_id=t.mto_id
				INNER JOIN members as mt on mt.member_id=t.mfrom_id WHERE 1=1 $mid GROUP BY(t.action_date))
		                      UNION
		                      (SELECT (CASE WHEN (SUM(a.net_amount)-SUM(a.bet_amount))>0 THEN 'g' ELSE 'l' END) as cname,'0' as allid,a.member_id,a.bet_date as dates,a.bet_time as time, 
		                      	(SUM(a.net_amount)-SUM(a.bet_amount)) as amount,
		                      	'Betting' as alltype FROM mledger_".$cmainyear." as a
		                      LEFT JOIN members as m on a.member_id=m.member_id WHERE a.accbgid!=0 and a.betstateid=1 $mid GROUP BY(a.bet_date))
		                      UNION
		                      (SELECT (CASE WHEN (SUM(aa.commission_amt))>0 THEN 'g' ELSE 'l' END) as cname,'0' as allid,a.member_id,aa.createddate as dates,aa.createdtime as time, 
		                      	(SUM(aa.commission_amt)) as amount,
		                      	'Mix Commission' as alltype FROM agent_commission as aa
		                      INNER JOIN agents as a ON a.agent_id = aa.agent_id
		                      LEFT JOIN members as m on a.member_id=m.member_id WHERE aa.bet_type='mix' AND aa.commission_amt!=0 $mid GROUP BY(aa.createddate))
				  UNION
		                      (SELECT (CASE WHEN (SUM(aa.commission_amt))>0 THEN 'g' ELSE 'l' END) as cname,'0' as allid,a.member_id,aa.createddate as dates,aa.createdtime as time, 
		                      	(SUM(aa.commission_amt)) as amount,
		                      	'BG Commission' as alltype FROM agent_commission as aa
		                      INNER JOIN agents as a ON a.agent_id = aa.agent_id
		                      LEFT JOIN members as m on a.member_id=m.member_id WHERE aa.bet_type='bg' AND aa.commission_amt!=0 $mid GROUP BY(aa.createddate))
				  UNION
		                      (SELECT (CASE WHEN (SUM(a.net_amount)-SUM(a.bet_amount))>0 THEN 'g' ELSE 'l' END) as cname,'0' as allid,a.member_id,a.bet_date as dates,a.bet_time as time, 
		                      	(SUM(a.net_amount)-SUM(a.bet_amount)) as amount,
		                      	'Mix Betting' as alltype FROM mixledger_".$cmainyear." as a
		                      LEFT JOIN members as m on a.member_id=m.member_id WHERE a.accbgid!=0 and a.betstateid=1 AND a.status_id!=6 $mid GROUP BY(a.bet_date))
		                      ) as a WHERE 1=1 $checkdate $mid ORDER BY STR_TO_DATE(a.dates, '%m-%d-%Y') DESC, a.time DESC";

		

			$allres = mysqli_query($connect,$all, $connect)or die("Error in sql ".$all);
			if (mysqli_num_rows($allres)<1) {
				$allresult = "No Record";
			}
			else{
				while ($aaa = mysqli_fetch_assoc($allres)) {
					$allresult[] = $aaa;
				}
			}
			if ($mid != "and 1=1"){
				/*$amt = "SELECT a.*,bh.*,b.description as bname from members as a 
				INNER JOIN bank_history as bh on a.member_id=bh.member_id 
				INNER JOIN banks as b on bh.bank_id=b.bank_id
				WHERE 1=1 $mid";*/
				$amt = "SELECT a.* from members as a WHERE 1=1 and a.recordstatus=1 $mid";
				$a = mysqli_query($connect,$amt, $connect)or die("Error in sql ".$amt);
				while ($amount = mysqli_fetch_assoc($a)) {
					$m[] = $amount;
					$mname = $amount["username"];
				}
			}
			else{
				$m = "Admin";
				$mname = "Admin";
			}

			$bk = "SELECT bh.bank_history_id,bh.cardnumber,b.description as bname FROM bank_history as bh 
			INNER JOIN banks as b on bh.bank_id=b.bank_id 
			WHERE type='u'";
			$resbk = mysqli_query($connect,$bk, $connect)or die("Error in sql ".$bk);
			if (mysqli_num_rows($resbk)<1) {
				$bks = "No Record";
			}
			else{
				while ($b = mysqli_fetch_assoc($resbk)) {
					$bks[] = $b;
				}
			}
			$mbk = "SELECT bh.bank_history_id,bh.cardnumber,b.description,b.bank_id as bname FROM bank_history as bh 
			INNER JOIN banks as b on bh.bank_id=b.bank_id 
			WHERE type='m' AND b.recordstatus=1 and bh.recordstatus=1";
			$resbk = mysqli_query($connect,$mbk, $connect)or die("Error in sql ".$mbk);
			if (mysqli_num_rows($resbk)<1) {
				$sql2 = "SELECT bank_id as bank_history_id,description as bname FROM banks WHERE banks.recordstatus=1";
				$res2=mysqli_query($connect,$sql2, $connect)or die("Error in sql "+$sql2);	
				while($r2 = mysqli_fetch_assoc($res2)){
					$mbks[]= $r2;
				}
			}
			else{
				while ($mb = mysqli_fetch_assoc($resbk)) {
					$mbks[] = $mb;
				}
			}
			$data = array("sta"=>$ss, "allresult"=>$allresult, "m"=>$m, "bks"=>$bks, "mbks"=>$mbks, "mname"=>$mname);				
		}
		
		print json_encode($data);
	}
	elseif($table == "select"){
		$tid = mysqli_real_escape_string($connect,$data->tid);
		$mid = mysqli_real_escape_string($connect,$data->mid);
		$bsid = mysqli_real_escape_string($connect,$data->betstateid);
		$upd = "UPDATE mledger_".$cmainyear." SET betstateid =$bsid WHERE mledger_id=$mid";
		mysqli_query($connect,$upd, $connect)or die("Error in sql ".$upd);

		$sql7="SELECT mledger_".$cmainyear.".mledger_id,mledger_".$cmainyear.".accbgid,mledger_".$cmainyear.".betstateid,CONCAT('B',LPAD( mledger_id, 6, '0')) as reference,
		goalplus.goalname,  members.username, dashboard_".$cmainyear.".score, history_".$cmainyear.".goalplus_value, bodies.bodyname, history_".$cmainyear.".body_value, 
		history_".$cmainyear.".hper, history_".$cmainyear.".aper, history_".$cmainyear.".uper, history_".$cmainyear.".dper, mledger_".$cmainyear.".bet_on,mledger_".$cmainyear.".bet, mledger_".$cmainyear.".bet_date, mledger_".$cmainyear.".bet_time, 
		mledger_".$cmainyear.".mledger_id as mid,leagues.league_id as lid,
		leagues.leaguename,thome.teamname as h,taway.teamname as a,status.*,mledger_".$cmainyear.".bet_amount,
		(CASE mledger_".$cmainyear.".betstateid WHEN '2' THEN 'WAITING' ELSE mledger_".$cmainyear.".result_amount END) AS result_amount, 
	        	(CASE mledger_".$cmainyear.".betstateid WHEN '2' THEN 'WAITING' ELSE mledger_".$cmainyear.".net_amount END) AS net_amount,
	      	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN bodies.bodyname ELSE goalplus.goalname END) AS bg_name,
	       	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN history_".$cmainyear.".body_value ELSE history_".$cmainyear.".goalplus_value END) AS bg_value,
	      	 (CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN (CASE mledger_".$cmainyear.".bet_on WHEN 'Home' THEN thome.teamname ELSE taway.teamname END) ELSE mledger_".$cmainyear.".bet_on END) AS betname,
	      	 (CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN (CASE mledger_".$cmainyear.".bet_on WHEN 'Home' THEN history_".$cmainyear.".hper ELSE history_".$cmainyear.".aper END) 
	       	 ELSE (CASE mledger_".$cmainyear.".bet_on WHEN 'Over' THEN history_".$cmainyear.".uper ELSE history_".$cmainyear.".dper END) END) AS per
	        	from mledger_".$cmainyear." 
		inner join status on mledger_".$cmainyear.".status_id=status.status_id 
		inner join dashboard_".$cmainyear." on mledger_".$cmainyear.".dashboard_id=dashboard_".$cmainyear.".dashboard_id
		inner join history_".$cmainyear." on mledger_".$cmainyear.".history_id = history_".$cmainyear.".history_id
		inner join timetable on dashboard_".$cmainyear.".timetableid=timetable.timetableid
		inner join leagues on timetable.league_id=leagues.league_id 
		inner join teams as thome on thome.team_id=timetable.home
        		inner join goalplus on goalplus.goalplus_id = history_".$cmainyear.".goalplus_id 
         		inner join bodies on bodies.body_id = history_".$cmainyear.".body_id
         		inner join members on members.member_id =mledger_".$cmainyear.".member_id 
		inner join teams as taway on taway.team_id=timetable.away WHERE mledger_".$cmainyear.".mledger_id=$mid and timetable.timetableid = $tid and mledger_".$cmainyear.".recordstatus=1";
	  	$res7=mysqli_query($connect,$sql7, $connect)or die("Error in sql "+$sql7);	
		while($r7 = mysqli_fetch_assoc($res7)){
			$data7[] = $r7;
		}
		print json_encode($data7);
		
			//$data = array("ledger"=>$data7);
	}
	elseif ($table == "usrlistleague") {
		$tid = mysqli_real_escape_string($connect,$data->tid);			
		$btn = mysqli_real_escape_string($connect,$data->btn);

		$fromdate = mysqli_real_escape_string($connect,$data->fromdate);		
		$todate = mysqli_real_escape_string($connect,$data->todate);
		$otherdate = mysqli_real_escape_string($connect,$data->otherdate);
		$datesign = mysqli_real_escape_string($connect,$data->datesign);

		if ($datesign == "all") {
			$checkdate = "";
		}
		else if ($fromdate != "" && $todate != "" && $datesign == "btw") {
			$checkdate = " and STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y') between STR_TO_DATE('".$fromdate."', '%m-%d-%Y') and STR_TO_DATE('".$todate."', '%m-%d-%Y')";
		}
		else if($otherdate != "" && $datesign != ""){
			$checkdate = " and STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y')".$datesign." STR_TO_DATE('".$otherdate."', '%m-%d-%Y') ";
		}
		else{
			//$checkdate = " and STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y') between STR_TO_DATE('".$week."', '%m-%d-%Y') and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y')";
			$checkdate = "";
		}

		if ($btn == "save") {
			$sid = mysqli_real_escape_string($connect,$data->betstateid);	
			//$betamt = mysqli_real_escape_string($connect,$data->betamt);
			$mid = mysqli_real_escape_string($connect,$data->mid);
			$net = mysqli_real_escape_string($connect,$data->net);
			$result = mysqli_real_escape_string($connect,$data->result);
			$stid = mysqli_real_escape_string($connect,$data->status);
			$mbid = mysqli_real_escape_string($connect,$data->memberid);
			$bgid = mysqli_real_escape_string($connect,$data->accbg);

				$sql12="SELECT betstateid,bet_amount FROM mledger_".$cmainyear." WHERE mledger_id = $mid";					
				$res12=mysqli_query($connect,$sql12, $connect)or die("Error in sql ".$sql12);
				while ($r12 = mysqli_fetch_assoc($res12)) {
					$bm=$r12["bet_amount"];
					$betst=$r12["betstateid"];
				}
				$amt = "SELECT amount FROM members WHERE member_id=$mbid and recordstatus=1";
				$amtres=mysqli_query($connect,$amt, $connect)or die("Error in sql ".$amt);
				while ($a12 = mysqli_fetch_assoc($amtres)) {
					$am=$a12["amount"];
				}

				if ($sid == 2) {
					if ($betst == 1) {
						$sql11="UPDATE mledger_".$cmainyear." SET status_id = $stid, accbgid=$bgid, betstateid =$sid WHERE mledger_id = $mid";
						mysqli_query($connect,$sql11, $connect)or die("Error in sql ".$sql11);	
					}
				}
				else{
					$sql11="UPDATE mledger_".$cmainyear." SET status_id = $stid, accbgid=$bgid, result_amount=$result, net_amount=$net, betstateid =$sid WHERE mledger_id = $mid";
					mysqli_query($connect,$sql11, $connect)or die("Error in sql ".$sql11);	
				}
				

			if ($sid ==3) {	
				$amt = $am+$bm;						
				$sql13="UPDATE members SET amount=$amt WHERE member_id =$mbid and recordstatus=1";
				mysqli_query($connect,$sql13, $connect)or die("Error in sql ".$sql13);

				$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
				VALUES ($mbid, $am, $amt, $bm, 'Betting Reject', '$today', '$aatime')";
				mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
			}
			elseif ($sid == 1) {
				if ($betst == 3) {
					$sql13="UPDATE members SET amount=amount-$bm WHERE member_id =$mbid and recordstatus=1";
					mysqli_query($connect,$sql13, $connect)or die("Error in sql ".$sql13);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbid, $am, $am-$bm, $bm, 'Betting Reject to Confirm', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
				}
				if ($bgid != 0) {
					$newval = $am+$net;
					$sql13="UPDATE members SET amount=$newval WHERE member_id =$mbid and recordstatus=1";
					mysqli_query($connect,$sql13, $connect)or die("Error in sql ".$sql13);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbid, $am, $newval, $net, 'Betting Result', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
				}					
			}
			elseif ($sid == 2) {
				if ($betst == 3) {
					$sql13="UPDATE members SET amount=amount-$bm WHERE member_id =$mbid and recordstatus=1";
					mysqli_query($connect,$sql13, $connect)or die("Error in sql ".$sql13);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbid, $am, $am-$bm, $bm, 'Betting Reject to Pending', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
				}
			}
		}

		$searchlea = "SELECT league_id from timetable WHERE timetableid=$tid";		
		$lea = mysqli_query($connect,$searchlea, $connect)or die("Error in sql ".$searchlea);
		while ($leares = mysqli_fetch_assoc($lea)) {
			$leaid=$leares["league_id"];
		}
					
		$sql7="SELECT members.loginid,bg.description as bgdescription,mledger_".$cmainyear.".member_id,mledger_".$cmainyear.".mledger_id,mledger_".$cmainyear.".accbgid,mledger_".$cmainyear.".betstateid,CONCAT('B',LPAD( mledger_id, 6, '0')) as reference,goalplus.goalname,  members.username, dashboard_".$cmainyear.".score, history_".$cmainyear.".goalplus_value, bodies.bodyname, history_".$cmainyear.".body_value, history_".$cmainyear.".hper, history_".$cmainyear.".aper, history_".$cmainyear.".uper, history_".$cmainyear.".dper, mledger_".$cmainyear.".bet_on,mledger_".$cmainyear.".bet, mledger_".$cmainyear.".bet_date, mledger_".$cmainyear.".bet_time, mledger_".$cmainyear.".mledger_id as mid,leagues.league_id as lid,
			leagues.leaguename,thome.teamname as h,taway.teamname as a,status.*, status.description as sdescription,mledger_".$cmainyear.".bet_amount,
			(CASE mledger_".$cmainyear.".betstateid 
             WHEN '2' THEN 'WAITING'
             WHEN '1' THEN
             	CASE mledger_".$cmainyear.".accbgid
             	WHEN '0' THEN 'RUNNING'
             	ELSE mledger_".$cmainyear.".result_amount END
             ELSE mledger_".$cmainyear.".result_amount END) AS result_amount, 
		    (CASE mledger_".$cmainyear.".betstateid 
             WHEN '2' THEN 'WAITING' 
             WHEN '1' THEN
             	CASE mledger_".$cmainyear.".accbgid
             	WHEN '0' THEN 'RUNNING'
             	ELSE mledger_".$cmainyear.".net_amount END
             ELSE mledger_".$cmainyear.".net_amount END) AS net_amount,
		(CASE mledger_".$cmainyear.".betstateid 
	           WHEN '1' THEN
	         	CASE mledger_".$cmainyear.".accbgid
	         	WHEN '0' THEN 'RUNNING'
	         	ELSE status.description END
	         	ELSE status.description END) AS sdescription,            
	      	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN bodies.bodyname ELSE goalplus.goalname END) AS bg_name,
	       	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN history_".$cmainyear.".body_value ELSE history_".$cmainyear.".goalplus_value END) AS bg_value,
	      	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN (CASE mledger_".$cmainyear.".bet_on WHEN 'Home' THEN thome.teamname ELSE taway.teamname END) ELSE mledger_".$cmainyear.".bet_on END) AS betname,
	      	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN (CASE mledger_".$cmainyear.".bet_on WHEN 'Home' THEN history_".$cmainyear.".hper ELSE history_".$cmainyear.".aper END) 
	       	ELSE (CASE mledger_".$cmainyear.".bet_on WHEN 'Over' THEN history_".$cmainyear.".uper ELSE history_".$cmainyear.".dper END) END) AS per
	        	from mledger_".$cmainyear." 
		inner join status on mledger_".$cmainyear.".status_id=status.status_id 
		inner join bs_gs as bg on mledger_".$cmainyear.".betstateid = bg.bs_gs_id
		inner join dashboard_".$cmainyear." on mledger_".$cmainyear.".dashboard_id=dashboard_".$cmainyear.".dashboard_id
		inner join history_".$cmainyear." on mledger_".$cmainyear.".history_id = history_".$cmainyear.".history_id
		inner join timetable on dashboard_".$cmainyear.".timetableid=timetable.timetableid
		inner join leagues on timetable.league_id=leagues.league_id 
		inner join teams as thome on thome.team_id=timetable.home
    		inner join goalplus on goalplus.goalplus_id = history_".$cmainyear.".goalplus_id 
     		inner join bodies on bodies.body_id = history_".$cmainyear.".body_id
     		inner join members on members.member_id =mledger_".$cmainyear.".member_id 
		inner join teams as taway on taway.team_id=timetable.away 
		WHERE timetable.league_id = $leaid and mledger_".$cmainyear.".recordstatus=1 $checkdate order by STR_TO_DATE(mledger_".$cmainyear.".bet_time, '%h:%i%p')";
	  	$res7=mysqli_query($connect,$sql7, $connect)or die("Error in sql "+$sql7);	
	  	if (mysqli_num_rows($res7) > 0) {
			while($r7 = mysqli_fetch_assoc($res7)){
				$data7[] = $r7;
			}
		} else {
		    	$data7 = "No Record";	
		}

		
		$sql8 ="SELECT accgoal_id as accbgid,description,formula from accgoal WHERE recordstatus=1 AND formulatype=0";
		$resultaccgoal = mysqli_query($connect,$sql8)or die("Error in query".$sql8);
		while ($ag = mysqli_fetch_assoc($resultaccgoal)) {
			$agg[] = $ag;
		}
		$sql9 ="SELECT accbody_id as accbgid,description,formula from accbodies WHERE recordstatus=1 AND formulatype=0";
		$resultaccbody = mysqli_query($connect,$sql9)or die("Error in query".$sql9);
		while ($ab = mysqli_fetch_assoc($resultaccbody)) {
			$abb[] = $ab;
		}
		$sql10 ="SELECT bs_gs_id as betstateid,description from bs_gs WHERE recordstatus=1 AND bs_gs_id!=9";
		$resultbg = mysqli_query($connect,$sql10)or die("Error in query".$sql10);
		while ($bg = mysqli_fetch_assoc($resultbg)) {
			$bgval[] = $bg;
		}
		$data = array("ledger"=>$data7, "agoal"=>$agg, "abody"=>$abb, "bgval"=>$bgval);		
		print json_encode($data);
	}
	elseif ($table == "mixbetlist") {
		$aaa = 0;
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$fromdate = mysqli_real_escape_string($connect,$data->fromdate);		
		$todate = mysqli_real_escape_string($connect,$data->todate);
		$otherdate = mysqli_real_escape_string($connect,$data->otherdate);
		$datesign = mysqli_real_escape_string($connect,$data->datesign);
		$chyear = mysqli_real_escape_string($connect,$data->chyear);
		if ($chyear != 0) {
			$cmainyear = $chyear;
		}

		if ($datesign == "all") {
			$checkdate = "";
		}
		else if ($fromdate != "" && $todate != "" && $datesign == "btw") {
			$checkdate = " and STR_TO_DATE(mixledger_".$cmainyear.".bet_date, '%m-%d-%Y') between STR_TO_DATE('".$fromdate."', '%m-%d-%Y') and STR_TO_DATE('".$todate."', '%m-%d-%Y')";
		}
		else if($otherdate != "" && $datesign != ""){
			$checkdate = " and STR_TO_DATE(mixledger_".$cmainyear.".bet_date, '%m-%d-%Y')".$datesign." STR_TO_DATE('".$otherdate."', '%m-%d-%Y') ";
		}
		else{
			$checkdate = " and STR_TO_DATE(mixledger_".$cmainyear.".bet_date, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y')";
		}

		if ($btn == "save") {
			foreach ($data->arrdata as $rows) {
				$mixid = mysqli_real_escape_string($connect,$rows->mixid);
				$resval = mysqli_real_escape_string($connect,$rows->resval);
				$turnval = mysqli_real_escape_string($connect,$rows->turnval);
				$resamtval = mysqli_real_escape_string($connect,$rows->resamtval);
				$stid = mysqli_real_escape_string($connect,$rows->status);
				$mbrid = mysqli_real_escape_string($connect,$rows->mbrid);

				$amt = "SELECT amount FROM members WHERE member_id=$mbrid and recordstatus=1";
				$amtres=mysqli_query($connect,$amt, $connect)or die("Error in sql ".$amt);
				if (mysqli_num_rows($amtres)<1) {
					$am = 0;				
				}
				else{
					while ($a12 = mysqli_fetch_assoc($amtres)) {
						$am=$a12["amount"];
					}
				}				

				$sqlsave = "UPDATE mixledger_".$cmainyear." SET mpp = $resval, accbgid=1, result_amount=$resamtval, net_amount=$turnval, status_id=$stid, modifieddate='$today' WHERE betstateid=1 AND mixledger_id=$mixid AND recordstatus=1";
				mysqli_query($connect,$sqlsave)or die("Error in query".$sqlsave);

				if (mysqli_affected_rows() == 1) {
					$sqlmbr = "UPDATE members SET amount = amount+$turnval WHERE member_id=$mbrid";
					mysqli_query($connect,$sqlmbr)or die("Error in query".$sqlmbr);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbrid, $am, $am+$turnval, $turnval, 'Mix Betting Result', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
				}
			}
		}
		elseif ($btn == "chbetstate") {
			foreach ($data->arrdata as $rows) {
				$mixid = mysqli_real_escape_string($connect,$rows->mixledger_id);
				$betstateid = mysqli_real_escape_string($connect,$rows->betstateid);
				$betamt = mysqli_real_escape_string($connect,$rows->bet_amount);
				$mbrid = mysqli_real_escape_string($connect,$rows->member_id);

				if ($betstateid == 1 || $betstateid == 2) {
					$sqlsave = "UPDATE mixledger_".$cmainyear." SET betstateid = $betstateid, status_id=$betstateid, modifieddate='$today' WHERE mixledger_id=$mixid AND recordstatus=1";
					mysqli_query($connect,$sqlsave)or die("Error in query".$sqlsave);

					/*$sqlmbr = "UPDATE members SET amount = amount-$betamt WHERE member_id = $mbrid AND recordstatus = 1";
					mysqli_query($connect,$sqlmbr)or die("Error in query".$sqlmbr);*/
				}
				elseif ($betstateid == 3 || $betstateid == 9) {
					$amt = "SELECT amount FROM members WHERE member_id=$mbrid and recordstatus=1";
					$amtres=mysqli_query($connect,$amt, $connect)or die("Error in sql ".$amt);
					while ($a12 = mysqli_fetch_assoc($amtres)) {
						$am=$a12["amount"];
					}

					$sqlsave = "UPDATE mixledger_".$cmainyear." SET net_amount = $betamt, betstateid = $betstateid, status_id=$betstateid, modifieddate='$today' WHERE mixledger_id=$mixid AND recordstatus=1";
					mysqli_query($connect,$sqlsave)or die("Error in query".$sqlsave);

					/*$sqlsave = "UPDATE mixledger_".$cmainyear." SET net_amount = $betamt, modifieddate='$today' WHERE mixledger_id=$mixid AND recordstatus=1";
					mysqli_query($connect,$sqlsave)or die("Error in query".$sqlsave);*/

					$sqlmbr = "UPDATE members SET amount = amount+$betamt WHERE member_id = $mbrid AND recordstatus = 1";
					mysqli_query($connect,$sqlmbr)or die("Error in query".$sqlmbr);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbrid, $am, $am+$betamt, $betamt, 'Mix Betting Cancel/ Reject', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
				}

			}
		}

		$sql1 = "SELECT *,
		(CASE alldata.sdescription WHEN 'WIN' THEN 'wgn' WHEN 'WAITING' THEN 'yw' WHEN 'REJECT' THEN 'rd' WHEN 'LOSE' THEN 'lrd' WHEN 'RUNNING' THEN 'gn' ELSE 'df' END) as sname FROM
		(SELECT agent_commission.commission_amt, mbr.loginid as agloginid, mixledger_detail_".$cmainyear.".mixledger_detail_id,members.loginid,mixledger_".$cmainyear.".mpp,mixledger_detail_".$cmainyear.".mp,bg.description as bgdescription, mixledger_".$cmainyear.".member_id, mixledger_".$cmainyear.".mixledger_id, mixledger_".$cmainyear.".betstateid,
	            CONCAT('B',LPAD( mixledger_".$cmainyear.".mixledger_id, 6, '0')) as reference, members.username, dashboard_".$cmainyear.".score, history_".$cmainyear.".goalplus_value, 
	            history_".$cmainyear.".body_value, history_".$cmainyear.".hper, history_".$cmainyear.".aper, history_".$cmainyear.".uper, history_".$cmainyear.".dper, mixledger_detail_".$cmainyear.".bet_on, mixledger_".$cmainyear.".bet_date, 
	            mixledger_".$cmainyear.".bet_time, mixledger_".$cmainyear.".mixledger_id as mid,leagues.league_id as lid, leagues.leaguename, thome.teamname as h,
	            taway.teamname as a,status.*,status1.description as ddescription, status1.status_id as bgstatusid, mixledger_".$cmainyear.".bet_amount, mix.mmval,mix.mixname,mix.mix_id,
	            
	            (CASE mixledger_detail_".$cmainyear.".bet_on 
	            WHEN 'home' THEN history_".$cmainyear.".body_value
	            WHEN 'away' THEN history_".$cmainyear.".body_value
	            WHEN 'over' THEN history_".$cmainyear.".goalplus_value
	            WHEN 'down' THEN history_".$cmainyear.".goalplus_value
	            ELSE 'None' END) AS bgvalue,

		(CASE mixledger_detail_".$cmainyear.".bet_on 
	            WHEN 'home' THEN history_".$cmainyear.".hper
	            WHEN 'away' THEN history_".$cmainyear.".aper
	            WHEN 'over' THEN history_".$cmainyear.".uper
	            WHEN 'down' THEN history_".$cmainyear.".dper
	            ELSE 'None' END) AS bgper,

		(CASE mixledger_detail_".$cmainyear.".bet_on 
	            WHEN 'home' THEN bodies.bodyname
	            WHEN 'away' THEN bodies.bodyname
	            WHEN 'over' THEN goalplus.goalname
	            WHEN 'down' THEN goalplus.goalname
	            ELSE 'None' END) AS bgname,

		(CASE mixledger_detail_".$cmainyear.".bet_on 
	            WHEN 'home' THEN thome.teamname
	            WHEN 'away' THEN taway.teamname
	            WHEN 'over' THEN 'Over'
	            WHEN 'down' THEN 'Down'
	            ELSE 'None' END) AS bet_on_name,

	            (CASE mixledger_".$cmainyear.".betstateid 
	            WHEN '2' THEN 'WAITING'
	            WHEN '1' THEN
	            CASE mixledger_".$cmainyear.".accbgid
	            WHEN '0' THEN 'RUNNING'
	            ELSE mixledger_".$cmainyear.".result_amount END
	            ELSE mixledger_".$cmainyear.".result_amount END) AS result_amount, 

	            (CASE mixledger_".$cmainyear.".betstateid 
	            WHEN '2' THEN 'WAITING'	            
	            WHEN '1' THEN
	            CASE mixledger_".$cmainyear.".accbgid
	            WHEN '0' THEN 'RUNNING'
	            ELSE mixledger_".$cmainyear.".net_amount END
	            ELSE mixledger_".$cmainyear.".net_amount END) AS net_amount,

	            (CASE mixledger_".$cmainyear.".betstateid 
	            WHEN '4' THEN status.description
	            WHEN '1' THEN
	            CASE mixledger_".$cmainyear.".accbgid
	            WHEN '0' THEN 'RUNNING'
	            ELSE status.description END
	            ELSE status.description END) AS sdescription

	            FROM mixledger_detail_".$cmainyear." 
	            INNER JOIN mixledger_".$cmainyear." ON mixledger_".$cmainyear.".mixledger_id=mixledger_detail_".$cmainyear.".mixledger_id
	            INNER JOIN status on mixledger_".$cmainyear.".status_id=status.status_id 
	            INNER JOIN status as status1 on mixledger_detail_".$cmainyear.".status_id=status1.status_id 
	            INNER JOIN bs_gs as bg on mixledger_".$cmainyear.".betstateid = bg.bs_gs_id
	            INNER JOIN dashboard_".$cmainyear." on mixledger_detail_".$cmainyear.".dashboard_id=dashboard_".$cmainyear.".dashboard_id			
	            INNER JOIN timetable on dashboard_".$cmainyear.".timetableid=timetable.timetableid
	            INNER JOIN leagues on timetable.league_id=leagues.league_id 
	            INNER JOIN teams as thome on thome.team_id=timetable.home
	            INNER JOIN history_".$cmainyear." ON history_".$cmainyear.".history_id=mixledger_detail_".$cmainyear.".history_id
	            LEFT JOIN goalplus on goalplus.goalplus_id = dashboard_".$cmainyear.".goalplus_id 
	            LEFT JOIN bodies on bodies.body_id = dashboard_".$cmainyear.".body_id
	            INNER JOIN members on members.member_id =mixledger_".$cmainyear.".member_id 
	            INNER JOIN teams as taway on taway.team_id=timetable.away 
	            INNER JOIN mix ON mix.mixname=mixledger_".$cmainyear.".mixname
	            LEFT JOIN agent_commission ON agent_commission.ledger_id=mixledger_".$cmainyear.".mixledger_id
		  LEFT JOIN agents on agents.agent_id =agent_commission.agent_id 
		  LEFT JOIN members as mbr on mbr.member_id =agents.member_id
	            WHERE mixledger_".$cmainyear.".recordstatus=1 $checkdate) as alldata
	            ORDER BY STR_TO_DATE(alldata.bet_date, '%m-%d-%Y') DESC, STR_TO_DATE(alldata.bet_time, '%h:%i:%s%p') DESC,alldata.mixledger_detail_id";

	           $result1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		if (mysqli_num_rows($result1) > 0) {
			   while($r1 = mysqli_fetch_assoc($result1)){
				$data1[] = $r1;
			}
		} else {
		    	$data1 = "No Record";	
		}

		/*$sql1 = "SELECT members.loginid,bg.description as bgdescription, mixledger_".$cmainyear.".*,
	            CONCAT('MB',LPAD( mixledger_".$cmainyear.".mixledger_id, 6, '0')) as reference, members.username, 
	            mixledger_".$cmainyear.".mixledger_id as mid,status.*,status.description as sdescription 
	            FROM mixledger
	            INNER JOIN mixledger_detail_".$cmainyear." ON mixledger_".$cmainyear.".mixledger_id=mixledger_detail_".$cmainyear.".mixledger_id
	            INNER JOIN status ON mixledger_".$cmainyear.".status_id=status.status_id 
	            INNER JOIN bs_gs as bg ON mixledger_".$cmainyear.".betstateid = bg.bs_gs_id
	            INNER JOIN members ON members.member_id =mixledger_".$cmainyear.".member_id 
	            WHERE mixledger_".$cmainyear.".recordstatus=1 GROUP BY(mixledger_".$cmainyear.".mixledger_id) ORDER BY(mixledger_".$cmainyear.".bet_time)";*/

	           $sql2 = "SELECT count(mixledger_id) as total, SUM(net_amount) as turnover, SUM(bet_amount) as bet, SUM(result_amount) as result 
	           FROM mixledger_".$cmainyear." WHERE recordstatus=1";
	           $result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
		if (mysqli_num_rows($result2) > 0) {
			   while($r2 = mysqli_fetch_assoc($result2)){
				$data2 = $r2["total"];
				$turnover = $r2["turnover"];
				$bet = $r2["bet"];
				$result = $r2["result"];
			}
		} else {
		    	$data2 = "No Record";	
		}

		$sql3 = "SELECT mixledger_id FROM mixledger_".$cmainyear." WHERE recordstatus=1";
	           $result3 = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
		if (mysqli_num_rows($result3) > 0) {
			   while($r3 = mysqli_fetch_assoc($result3)){
				$data3[] = $r3["mixledger_id"];
			}
		} else {
		    	$data3 = "No Record";	
		}

		$sql4 = "SELECT status_id,(CASE description WHEN 'DEFAULT' THEN '-- Win / Lose --' ELSE description END) as description FROM status WHERE recordstatus=1";
		$result4 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
		if (mysqli_num_rows($result4) > 0) {
			   while($r4 = mysqli_fetch_assoc($result4)){
				$data4[] = $r4;
			}
		} else {
		    	$data4 = "No Record";	
		}

		$sql5 = "SELECT bs_gs_id,(CASE description WHEN 'Default' THEN '-- Bet Status --' ELSE description END) as description FROM bs_gs WHERE recordstatus=1";
		$result5 = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
		if (mysqli_num_rows($result5) > 0) {
			   while($r5 = mysqli_fetch_assoc($result5)){
				$data5[] = $r5;
			}
		} else {
		    	$data5 = "No Record";	
		}

		$sql6 = "SELECT mix_id, CONCAT(mixname,' Mix') as mixname FROM mix WHERE recordstatus=1";
		$result6 = mysqli_query($connect,$sql6)or die("Error in query".$sql6);
		if (mysqli_num_rows($result6) > 0) {
			   while($r6 = mysqli_fetch_assoc($result6)){
				$data6[] = $r6;
			}
		} else {
		    	$data6 = "No Record";	
		}
		
		$sql7 = "SELECT mix_id, CONCAT(mixname,' Mix') as mixname FROM mix WHERE recordstatus=1";
		$result7 = mysqli_query($connect,$sql7)or die("Error in query".$sql7);
		if (mysqli_num_rows($result7) > 0) {
			   while($r7 = mysqli_fetch_assoc($result7)){
				$data7[] = $r7;
			}
		} else {
		    	$data7 = "No Record";	
		}

		$y=date("Y");
		$start = $y - 5;
		$end = $y + 10;
		$yeararr = [];
		for ($i=$start; $i < $end; $i++) { 
			$yeararr[$i]["year"] = intval($i);
		}

		$data = array("yeararr"=>$yeararr, "aa"=>$aaa, "mixledger"=>$data1, "mix"=>$data6, "mixdata"=>$data7, "betstate"=>$data5, "statusdata"=>$data4, "totalrow"=>$data2, "mixid"=>$data3, "turnover"=>$turnover, "bet"=>$bet, "result"=>$result);		
		print json_encode($data);
	}
	elseif ($table == "usrlist") {		
		$tid = mysqli_real_escape_string($connect,$data->tid);			
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$fromdate = mysqli_real_escape_string($connect,$data->fromdate);		
		$todate = mysqli_real_escape_string($connect,$data->todate);
		$otherdate = mysqli_real_escape_string($connect,$data->otherdate);
		$datesign = mysqli_real_escape_string($connect,$data->datesign);
		$chyear = mysqli_real_escape_string($connect,$data->chyear);
		if ($chyear != 0) {
			$cmainyear = $chyear;
		}

		if ($datesign == "all") {
			$checkdate = "";
		}
		else if ($fromdate != "" && $todate != "" && $datesign == "btw") {
			$checkdate = " and STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y') between STR_TO_DATE('".$fromdate."', '%m-%d-%Y') and STR_TO_DATE('".$todate."', '%m-%d-%Y')";
		}
		else if($otherdate != "" && $datesign != ""){
			$checkdate = " and STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y')".$datesign." STR_TO_DATE('".$otherdate."', '%m-%d-%Y') ";
		}
		else{
			//$checkdate = " and STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y') between STR_TO_DATE('".$week."', '%m-%d-%Y') and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y')";
			$checkdate = "";
		}

		if ($btn == "save") {
			$sid = mysqli_real_escape_string($connect,$data->betstateid);	
			//$betamt = mysqli_real_escape_string($connect,$data->betamt);
			$mid = mysqli_real_escape_string($connect,$data->mid);
			$net = mysqli_real_escape_string($connect,$data->net);
			$result = mysqli_real_escape_string($connect,$data->result);
			$stid = mysqli_real_escape_string($connect,$data->status);
			$mbid = mysqli_real_escape_string($connect,$data->memberid);
			$bgid = mysqli_real_escape_string($connect,$data->accbg);			

				$sql12="SELECT betstateid,bet_amount FROM mledger_".$cmainyear." WHERE mledger_id = $mid";					
				$res12=mysqli_query($connect,$sql12, $connect)or die("Error in sql ".$sql12);
				while ($r12 = mysqli_fetch_assoc($res12)) {
					$bm=$r12["bet_amount"];
					$betst=$r12["betstateid"];
				}
				$amt = "SELECT amount FROM members WHERE member_id=$mbid and recordstatus=1";
				$amtres=mysqli_query($connect,$amt, $connect)or die("Error in sql ".$amt);
				while ($a12 = mysqli_fetch_assoc($amtres)) {
					$am=$a12["amount"];
				}

				if ($sid == 2) {
					if ($betst == 1) {
						$sql11="UPDATE mledger_".$cmainyear." SET status_id = $stid, accbgid=$bgid, betstateid =$sid WHERE mledger_id = $mid";
						mysqli_query($connect,$sql11, $connect)or die("Error in sql ".$sql11);	
					}
				}
				else{
					$sql11="UPDATE mledger_".$cmainyear." SET status_id = $stid, accbgid=$bgid, result_amount=$result, net_amount=$net, betstateid =$sid WHERE mledger_id = $mid";
					mysqli_query($connect,$sql11, $connect)or die("Error in sql ".$sql11);	
				}
				

			if ($sid ==3) {	
				$amt = $am+$bm;						
				$sql13="UPDATE members SET amount=$amt WHERE member_id =$mbid and recordstatus=1";
				mysqli_query($connect,$sql13, $connect)or die("Error in sql ".$sql13);

				$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
				VALUES ($mbid, $am, $amt, $bm, 'Betting Reject', '$today', '$aatime')";
				mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
			}
			elseif ($sid == 1) {
				if ($betst == 3) {
					$sql13="UPDATE members SET amount=amount-$bm WHERE member_id =$mbid and recordstatus=1";
					mysqli_query($connect,$sql13, $connect)or die("Error in sql ".$sql13);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbid, $am, $am-$bm, $bm, 'Betting Reject to Confirm', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
				}
				if ($bgid != 0) {
					$newval = $am+$net;
					$sql13="UPDATE members SET amount=$newval WHERE member_id =$mbid and recordstatus=1";
					mysqli_query($connect,$sql13, $connect)or die("Error in sql ".$sql13);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbid, $am, $newval, $net, 'Betting Result', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
				}					
			}
			elseif ($sid == 2) {
				if ($betst == 3) {
					$sql13="UPDATE members SET amount=amount-$bm WHERE member_id =$mbid and recordstatus=1";
					mysqli_query($connect,$sql13, $connect)or die("Error in sql ".$sql13);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbid, $am, $newval, $net, 'Betting Reject to Pending', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
				}
			}
		}
				
					
		$sql7="SELECT agent_commission.commission_amt, mbr.loginid as agloginid, members.loginid,bg.description as bgdescription,mledger_".$cmainyear.".member_id,mledger_".$cmainyear.".mledger_id,mledger_".$cmainyear.".accbgid,mledger_".$cmainyear.".betstateid,CONCAT('B',LPAD( mledger_id, 6, '0')) as reference,
		goalplus.goalname,  members.username, dashboard_".$cmainyear.".score, history_".$cmainyear.".goalplus_value, bodies.bodyname, history_".$cmainyear.".body_value, history_".$cmainyear.".hper, history_".$cmainyear.".aper, history_".$cmainyear.".uper, history_".$cmainyear.".dper, mledger_".$cmainyear.".bet_on,
		mledger_".$cmainyear.".bet, mledger_".$cmainyear.".bet_date, mledger_".$cmainyear.".bet_time, mledger_".$cmainyear.".mledger_id as mid,leagues.league_id as lid,
			leagues.leaguename,thome.teamname as h,taway.teamname as a,status.*,status.description as sdescription, mledger_".$cmainyear.".bet_amount,
			(CASE mledger_".$cmainyear.".betstateid 
		             WHEN '2' THEN 'WAITING'
		             WHEN '1' THEN
		             	CASE mledger_".$cmainyear.".accbgid
		             	WHEN '0' THEN 'RUNNING'
		             	ELSE mledger_".$cmainyear.".result_amount END
		             ELSE mledger_".$cmainyear.".result_amount END) AS result_amount, 
				    (CASE mledger_".$cmainyear.".betstateid 
		             WHEN '2' THEN 'WAITING' 
		             WHEN '1' THEN
		             	CASE mledger_".$cmainyear.".accbgid
		             	WHEN '0' THEN 'RUNNING'
		             	ELSE mledger_".$cmainyear.".net_amount END
		             ELSE mledger_".$cmainyear.".net_amount END) AS net_amount,
			(CASE mledger_".$cmainyear.".betstateid 
		             WHEN '1' THEN
		             	CASE mledger_".$cmainyear.".accbgid
		             	WHEN '0' THEN 'RUNNING'
		             	ELSE status.description END
		             ELSE status.description END) AS sdescription,
            
		      	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN bodies.bodyname ELSE goalplus.goalname END) AS bg_name,
		       	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN history_".$cmainyear.".body_value ELSE history_".$cmainyear.".goalplus_value END) AS bg_value,
		      	 (CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN (CASE mledger_".$cmainyear.".bet_on WHEN 'Home' THEN thome.teamname ELSE taway.teamname END) ELSE mledger_".$cmainyear.".bet_on END) AS betname,
		      	 (CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN (CASE mledger_".$cmainyear.".bet_on WHEN 'Home' THEN history_".$cmainyear.".hper ELSE history_".$cmainyear.".aper END) 
		       	 ELSE (CASE mledger_".$cmainyear.".bet_on WHEN 'Over' THEN history_".$cmainyear.".uper ELSE history_".$cmainyear.".dper END) END) AS per
		        	from mledger_".$cmainyear." 
			inner join status on mledger_".$cmainyear.".status_id=status.status_id 
			inner join bs_gs as bg on mledger_".$cmainyear.".betstateid = bg.bs_gs_id
			inner join dashboard_".$cmainyear." on mledger_".$cmainyear.".dashboard_id=dashboard_".$cmainyear.".dashboard_id
			inner join history_".$cmainyear." on mledger_".$cmainyear.".history_id = history_".$cmainyear.".history_id
			inner join timetable on dashboard_".$cmainyear.".timetableid=timetable.timetableid
			inner join leagues on timetable.league_id=leagues.league_id 
			inner join teams as thome on thome.team_id=timetable.home
	        		LEFT join goalplus on goalplus.goalplus_id = history_".$cmainyear.".goalplus_id 
	         		LEFT join bodies on bodies.body_id = history_".$cmainyear.".body_id
	         		inner join members on members.member_id =mledger_".$cmainyear.".member_id 
			inner join teams as taway on taway.team_id=timetable.away 
			LEFT JOIN agent_commission ON agent_commission.ledger_id=mledger_".$cmainyear.".mledger_id
			LEFT join agents on agents.agent_id =agent_commission.agent_id 
			LEFT join members as mbr on mbr.member_id =agents.member_id 
			WHERE timetable.timetableid = $tid and mledger_".$cmainyear.".recordstatus=1 $checkdate order by STR_TO_DATE(mledger_".$cmainyear.".bet_time, '%h:%i:%s%p') DESC";

	  	$res7=mysqli_query($connect,$sql7, $connect)or die("Error in sql "+$sql7);
	  	if (mysqli_num_rows($res7) > 0) {
			   while($r7 = mysqli_fetch_assoc($res7)){
				$data7[] = $r7;
			}
		} else {
			    $data7 = "No Record";	
			}		

		$sql8 ="SELECT accgoal_id as accbgid,description,formula from accgoal WHERE recordstatus=1 AND formulatype=0";
		$resultaccgoal = mysqli_query($connect,$sql8)or die("Error in query".$sql8);
		while ($ag = mysqli_fetch_assoc($resultaccgoal)) {
			$agg[] = $ag;
		}

		$sql9 ="SELECT accbody_id as accbgid,description,formula from accbodies WHERE recordstatus=1 AND formulatype=0";
		$resultaccbody = mysqli_query($connect,$sql9)or die("Error in query".$sql9);
		while ($ab = mysqli_fetch_assoc($resultaccbody)) {
			$abb[] = $ab;
		}

		$sql10 ="SELECT bs_gs_id as betstateid,description from bs_gs WHERE recordstatus=1 AND bs_gs_id!=9";
		$resultbg = mysqli_query($connect,$sql10)or die("Error in query".$sql10);
		while ($bg = mysqli_fetch_assoc($resultbg)) {
			$bgval[] = $bg;
		}

		$y=date("Y");
		$start = $y - 5;
		$end = $y + 10;
		$yeararr = [];
		for ($i=$start; $i < $end; $i++) { 
			$yeararr[$i]["year"] = intval($i);
		}

		$data = array("yeararr"=>$yeararr, "ledger"=>$data7, "agoal"=>$agg, "abody"=>$abb, "bgval"=>$bgval);

		/*if (isset($bb)) {
			$data = array("ledger"=>$data7, "agoal"=>$agg, "abody"=>$abb, "bgval"=>$bgval, "select"=>$bb);	
		}
		else{*/
			
		//}
		
		
		print json_encode($data);
	}
	elseif ($table == "allusrlist") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);

		if ($btn == "alllist") {
			$fromdate = mysqli_real_escape_string($connect,$data->fromdate);		
			$todate = mysqli_real_escape_string($connect,$data->todate);
			$otherdate = mysqli_real_escape_string($connect,$data->otherdate);
			$datesign = mysqli_real_escape_string($connect,$data->datesign);
			$chyear = mysqli_real_escape_string($connect,$data->chyear);
			if ($chyear != 0) {
				$cmainyear = $chyear;
			}

			if ($datesign == "all") {
				$checkdate = "";
			}
			else if ($fromdate != "" && $todate != "" && $datesign == "btw") {
				$checkdate = " and STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y') between STR_TO_DATE('".$fromdate."', '%m-%d-%Y') and STR_TO_DATE('".$todate."', '%m-%d-%Y')";
			}
			else if($otherdate != "" && $datesign != ""){
				$checkdate = " and STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y')".$datesign." STR_TO_DATE('".$otherdate."', '%m-%d-%Y') ";
			}
			else{
				$checkdate = " and STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y')";
			}
			
			$sql7="SELECT agent_commission.commission_amt, mbr.loginid as agloginid,members.loginid,bg.description as bgdescription,mledger_".$cmainyear.".member_id,mledger_".$cmainyear.".mledger_id,mledger_".$cmainyear.".accbgid,mledger_".$cmainyear.".betstateid,CONCAT('B',LPAD( mledger_id, 6, '0')) as reference,goalplus.goalname,  members.username, dashboard_".$cmainyear.".score, history_".$cmainyear.".goalplus_value, bodies.bodyname, history_".$cmainyear.".body_value, history_".$cmainyear.".hper, history_".$cmainyear.".aper, history_".$cmainyear.".uper, history_".$cmainyear.".dper, mledger_".$cmainyear.".bet_on,mledger_".$cmainyear.".bet, mledger_".$cmainyear.".bet_date, mledger_".$cmainyear.".bet_time, mledger_".$cmainyear.".mledger_id as mid,leagues.league_id as lid,
			leagues.leaguename,thome.teamname as h,taway.teamname as a,status.*,status.description as sdescription, mledger_".$cmainyear.".bet_amount,
			(CASE mledger_".$cmainyear.".betstateid 
             		WHEN '2' THEN 'WAITING'
             		WHEN '1' THEN
             		CASE mledger_".$cmainyear.".accbgid
             		WHEN '0' THEN 'RUNNING'
             		ELSE mledger_".$cmainyear.".result_amount END
             		ELSE mledger_".$cmainyear.".result_amount END) AS result_amount, 
		    	(CASE mledger_".$cmainyear.".betstateid 
             		WHEN '2' THEN 'WAITING' 
             		WHEN '1' THEN
	             	CASE mledger_".$cmainyear.".accbgid
	             	WHEN '0' THEN 'RUNNING'
	             	ELSE mledger_".$cmainyear.".net_amount END
		           ELSE mledger_".$cmainyear.".net_amount END) AS net_amount,
			(CASE mledger_".$cmainyear.".betstateid 
		           WHEN '1' THEN
	             	CASE mledger_".$cmainyear.".accbgid
	             	WHEN '0' THEN 'RUNNING'
	             	ELSE status.description END
             		ELSE status.description END) AS sdescription,	            
		      	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN bodies.bodyname ELSE goalplus.goalname END) AS bg_name,
		       	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN history_".$cmainyear.".body_value ELSE history_".$cmainyear.".goalplus_value END) AS bg_value,
		      	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN (CASE mledger_".$cmainyear.".bet_on WHEN 'Home' THEN thome.teamname ELSE taway.teamname END) ELSE mledger_".$cmainyear.".bet_on END) AS betname,
		      	(CASE mledger_".$cmainyear.".bet WHEN 'Body' THEN (CASE mledger_".$cmainyear.".bet_on WHEN 'Home' THEN history_".$cmainyear.".hper ELSE history_".$cmainyear.".aper END) 
		       	ELSE (CASE mledger_".$cmainyear.".bet_on WHEN 'Over' THEN history_".$cmainyear.".uper ELSE history_".$cmainyear.".dper END) END) AS per
		        	from mledger_".$cmainyear." 
			inner join status on mledger_".$cmainyear.".status_id=status.status_id 
			inner join bs_gs as bg on mledger_".$cmainyear.".betstateid = bg.bs_gs_id
			inner join dashboard_".$cmainyear." on mledger_".$cmainyear.".dashboard_id=dashboard_".$cmainyear.".dashboard_id
			inner join history_".$cmainyear." on mledger_".$cmainyear.".history_id = history_".$cmainyear.".history_id
			inner join timetable on dashboard_".$cmainyear.".timetableid=timetable.timetableid
			inner join leagues on timetable.league_id=leagues.league_id 
			inner join teams as thome on thome.team_id=timetable.home
	        		inner join goalplus on goalplus.goalplus_id = history_".$cmainyear.".goalplus_id 
	         		inner join bodies on bodies.body_id = history_".$cmainyear.".body_id
	         		inner join members on members.member_id =mledger_".$cmainyear.".member_id 
			inner join teams as taway on taway.team_id=timetable.away 
			LEFT JOIN agent_commission ON agent_commission.ledger_id=mledger_".$cmainyear.".mledger_id
			LEFT join agents on agents.agent_id =agent_commission.agent_id 
			LEFT join members as mbr on mbr.member_id =agents.member_id 
			WHERE mledger_".$cmainyear.".recordstatus=1 
			$checkdate ORDER BY STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y') DESC, STR_TO_DATE(mledger_".$cmainyear.".bet_time, '%h:%i:%s%p') DESC";
		
			$res7=mysqli_query($connect,$sql7, $connect)or die("Error in sql "+$sql7);
		  	if (mysqli_num_rows($res7) > 0) {
				   while($r7 = mysqli_fetch_assoc($res7)){
					$data7[] = $r7;
				}
			} else {
				    $data7 = "No Record";	
				}
		} 	

		$sql8 ="SELECT accgoal_id as accbgid,description,formula from accgoal WHERE recordstatus=1 AND formulatype=0";
		$resultaccgoal = mysqli_query($connect,$sql8)or die("Error in query".$sql8);
		while ($ag = mysqli_fetch_assoc($resultaccgoal)) {
			$agg[] = $ag;
		}

		$sql9 ="SELECT accbody_id as accbgid,description,formula from accbodies WHERE recordstatus=1 AND formulatype=0";
		$resultaccbody = mysqli_query($connect,$sql9)or die("Error in query".$sql9);
		while ($ab = mysqli_fetch_assoc($resultaccbody)) {
			$abb[] = $ab;
		}

		$sql10 ="SELECT bs_gs_id as betstateid,description from bs_gs WHERE recordstatus=1 AND bs_gs_id!=9";
		$resultbg = mysqli_query($connect,$sql10)or die("Error in query".$sql10);
		while ($bg = mysqli_fetch_assoc($resultbg)) {
			$bgval[] = $bg;
		}

		$y=date("Y");
		$start = $y - 5;
		$end = $y + 10;
		$yeararr = [];
		for ($i=$start; $i < $end; $i++) { 
			$yeararr[$i]["year"] = intval($i);
		}

		$data = array("yeararr"=>$yeararr, "ledger"=>$data7, "agoal"=>$agg, "abody"=>$abb, "bgval"=>$bgval);		
		
		print json_encode($data);
	}

	elseif ($table == "accbody") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$des = mysqli_real_escape_string($connect,$data->des);
			$f = mysqli_real_escape_string($connect,$data->formula);
			$sql = "INSERT INTO accbodies(description,formula) VALUES('$des','$f')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$abid = mysqli_real_escape_string($connect,$data->abid);
			$sql = "UPDATE accbodies SET recordstatus=2 WHERE accbody_id=$abid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$abid = mysqli_real_escape_string($connect,$data->abid);
			$des = mysqli_real_escape_string($connect,$data->des);
			$f = mysqli_real_escape_string($connect,$data->formula);
			$sql = "UPDATE accbodies SET description='$des',formula='$f' WHERE accbody_id=$abid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 = "SELECT * FROM accbodies WHERE recordstatus=1 AND formulatype=0";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		$sql2= "SELECT * FROM formulalist WHERE recordstatus=1";
		$formu = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
		while ($f = mysqli_fetch_assoc($formu)) {
			$formula[] = $f;
		}
		$sql3= "SELECT * FROM formulalist WHERE recordstatus=1";
		$formu2 = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
		while ($f2 = mysqli_fetch_assoc($formu2)) {
			$formula2[] = $f2;
		}
		$sql4= "SELECT * FROM formulalist WHERE recordstatus=1";
		$formu3 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
		while ($f3 = mysqli_fetch_assoc($formu3)) {
			$formula3[] = $f3;
		}
		$sql5= "SELECT * FROM formulalist WHERE recordstatus=1";
		$formu4 = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
		while ($f4 = mysqli_fetch_assoc($formu4)) {
			$formula4[] = $f4;
		}
		$data = array("accbody"=>$records, "fromula"=>$formula, "fromula2"=>$formula2, "fromula3"=>$formula3, "fromula4"=>$formula4);
		print json_encode($data);
	}
	elseif ($table == "accgoal") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$des = mysqli_real_escape_string($connect,$data->des);
			$f = mysqli_real_escape_string($connect,$data->formula);
			$sql = "INSERT INTO accgoal(description,formula) VALUES('$des','$f')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$agid = mysqli_real_escape_string($connect,$data->agid);
			$sql = "UPDATE accgoal SET recordstatus=2 WHERE accgoal_id=$agid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$agid = mysqli_real_escape_string($connect,$data->agid);
			$f = mysqli_real_escape_string($connect,$data->formula);
			$des = mysqli_real_escape_string($connect,$data->des);
			$sql = "UPDATE accgoal SET description='$des',formula='$f' WHERE accgoal_id=$agid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 = "SELECT * FROM accgoal WHERE recordstatus=1 AND formulatype=0";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		$sql2= "SELECT * FROM formulalist WHERE recordstatus=1";
		$formu = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
		while ($f = mysqli_fetch_assoc($formu)) {
			$formula[] = $f;
		}
		$sql3= "SELECT * FROM formulalist WHERE recordstatus=1";
		$formu2 = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
		while ($f2 = mysqli_fetch_assoc($formu2)) {
			$formula2[] = $f2;
		}
		$sql4= "SELECT * FROM formulalist WHERE recordstatus=1";
		$formu3 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
		while ($f3 = mysqli_fetch_assoc($formu3)) {
			$formula3[] = $f3;
		}
		$sql5= "SELECT * FROM formulalist WHERE recordstatus=1";
		$formu4 = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
		while ($f4 = mysqli_fetch_assoc($formu4)) {
			$formula4[] = $f4;
		}
		$data = array("accgoal"=>$records, "fromula"=>$formula, "fromula2"=>$formula2, "fromula3"=>$formula3, "fromula4"=>$formula4);
		print json_encode($data);
	}
	elseif ($table == "formulalist") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "formula") {
			$bg = mysqli_real_escape_string($connect,$data->bg);
			$bgid = mysqli_real_escape_string($connect,$data->bgid);
			if ($bg == 'Body') {
				$sql9 ="SELECT accbody_id as accbgid,description,formula from accbodies WHERE accbody_id=$bgid and recordstatus=1 AND formulatype=0";
				$resultaccbody = mysqli_query($connect,$sql9)or die("Error in query".$sql9);
				while ($ab = mysqli_fetch_assoc($resultaccbody)) {
					$aa[] = $ab["formula"];
				}
			}
			else{
				$sql8 ="SELECT accgoal_id as accbgid,description,formula from accgoal WHERE accgoal_id=$bgid and recordstatus=1 AND formulatype=0";
				$resultaccgoal = mysqli_query($connect,$sql8)or die("Error in query".$sql8);
				while ($ag = mysqli_fetch_assoc($resultaccgoal)) {
					$aa[] = $ag["formula"];
				}				
			}
			
			$data = array("formula"=>$aa);
		}
		else{
			$sql1 = "SELECT * FROM formulalist WHERE recordstatus=1";
			$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			while ($a = mysqli_fetch_assoc($result)) {
				$records[] = $a["description"];
			}
			$data = array("description"=>$records);
		}
		print json_encode($data);
	}
	elseif ($table == "bank") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$cannot = "1";
		if ($btn == "save") {
			$des = mysqli_real_escape_string($connect,$data->desc);
			$sql = "INSERT INTO banks(description) VALUES('$des')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
			$cannot = "No";
		}
		elseif ($btn == "delete") {
			$bankid = mysqli_real_escape_string($connect,$data->bid);
			$sql1 = "SELECT bank_history_id FROM bank_history WHERE bank_id=$bankid and bank_history.recordstatus=1";
			$rrbank = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($rrbank)<1) {
				$sql = "UPDATE banks SET recordstatus=2 WHERE bank_id=$bankid";
			    	mysqli_query($connect,$sql)or die("Error in query".$sql);
			    	$cannot = "can";
			}
			else{
				$cannot = "cannot";
			}
			
		}
		elseif ($btn == "edit") {
			$bankid = mysqli_real_escape_string($connect,$data->bid);
			$des = mysqli_real_escape_string($connect,$data->desc);
			$sql = "UPDATE banks SET description='$des' WHERE bank_id=$bankid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
			$cannot = "No";
		}
		$sql1 = "SELECT * FROM banks WHERE recordstatus=1";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		$data = array("records"=>$records, "delstatus"=>$cannot);
		print json_encode($data);
	}
	elseif ($table == "hbank") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$mid = mysqli_real_escape_string($connect,$data->m);
			$bid = mysqli_real_escape_string($connect,$data->b);
			$cardno = mysqli_real_escape_string($connect,$data->c);
			$sql = "INSERT INTO bank_history(member_id,bank_id,cardnumber,type,createddate,modifieddate) VALUES('$mid','$bid','$cardno','u',NOW(),NOW())";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$bhid = mysqli_real_escape_string($connect,$data->hid);
			$sql = "UPDATE bank_history SET recordstatus=2 WHERE bank_history_id=$bhid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$bhid = mysqli_real_escape_string($connect,$data->hid);
			$mid = mysqli_real_escape_string($connect,$data->m);
			$bid = mysqli_real_escape_string($connect,$data->b);
			$cardno = mysqli_real_escape_string($connect,$data->c);
			$sql = "UPDATE bank_history SET member_id='$mid',bank_id='$bid',cardnumber='$cardno' WHERE bank_history_id=$bhid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 ="SELECT h.*,b.description,u.username from bank_history as h inner join banks as b on h.bank_id=b.bank_id
			inner join users as u on u.userid=h.member_id 
			where h.recordstatus=1 and h.type='u' ";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);  
			if (mysqli_num_rows($result) > 0) {
			   while ($a = mysqli_fetch_assoc($result)) {
				$records[] = $a;
				$resquer=true;			
				}
			} else {
			    $resquer=false;	
			}							
		$sql2= "SELECT userid as member_id,username FROM users WHERE recordstatus=1";
		$user = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
		while ($f = mysqli_fetch_assoc($user)) {
			$users[] = $f;
		}
		$sql3= "SELECT * FROM banks WHERE recordstatus=1";
		$bank = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
		while ($f2 = mysqli_fetch_assoc($bank)) {
			$banks[] = $f2;
		}
		if ($resquer==true) {
			$data = array("bhistory"=>$records,"user"=>$users, "bank"=>$banks);
		}
		else
		{
			$data = array("user"=>$users, "bank"=>$banks);
		}		
		print json_encode($data);
	}
	elseif ($table == "ttc") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$h = mysqli_real_escape_string($connect,$data->h);
			$b = mysqli_real_escape_string($connect,$data->b);
			$f = mysqli_real_escape_string($connect,$data->f);
			$sql = "INSERT INTO tac(header,body,footer,createddate,modifieddate) VALUES('$h','$b','$f','$today','$today')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$h = mysqli_real_escape_string($connect,$data->h);
			$b = mysqli_real_escape_string($connect,$data->b);
			$f = mysqli_real_escape_string($connect,$data->f);
			$tacid = mysqli_real_escape_string($connect,$data->tacid);
			$sql = "UPDATE tac SET header='$h',body='$b',footer='$f' WHERE tacid=$tacid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql3= "SELECT * from tac where recordstatus=1";
		$tac = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
		if (mysqli_num_rows($tac)<1) {
			$tacs = "No Record";
		}
		else{
			while ($t = mysqli_fetch_assoc($tac)) {
				$tacs[] = $t;
			}
		}
		$data = array("tacs"=>$tacs);
		print json_encode($data);
	}
	elseif ($table == "changemixfor") {
		$dashid = mysqli_real_escape_string($connect,$data->dashid);
		$btn = mysqli_real_escape_string($connect,$data->btn);

		if ($btn == "mix") {
			$sql5 = "UPDATE mixledger_detail_".$cmainyear." SET accbgid=0, status_id=6,mp=0, modifieddate='$today' WHERE dashboard_id=$dashid AND recordstatus=1";
			mysqli_query($connect,$sql5)or die("Error in query".$sql5);

			$sql6 = "SELECT mixledger_".$cmainyear.".mixledger_id,mixledger_".$cmainyear.".member_id,mixledger_".$cmainyear.".net_amount FROM mixledger_".$cmainyear." 
			INNER JOIN mixledger_detail_".$cmainyear." ON mixledger_".$cmainyear.".mixledger_id = mixledger_detail_".$cmainyear.".mixledger_id
			WHERE mixledger_".$cmainyear.".accbgid = 1 AND mixledger_".$cmainyear.".recordstatus = 1 AND mixledger_detail_".$cmainyear.".dashboard_id = $dashid";
			$res6 = mysqli_query($connect,$sql6)or die("Error in query".$sql6);
			if (mysqli_num_rows($res6)>0) {
				while ($a = mysqli_fetch_assoc($res6)) {
					$amountlist1[] = $a["net_amount"];
					$mbrlist1[] = $a["member_id"];
				}
				for ($i=0; $i < sizeof($mbrlist1); $i++) { 
					$org = $amountlist1[$i];

					$sql1 = "SELECT amount FROM members WHERE member_id =$mbrlist1[$i] and recordstatus=1";
					$res1 = mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);
					while($r1 = mysqli_fetch_assoc($res1)){
						$oramt = $r1["amount"];
					}

					$sql8 = "UPDATE members set amount=amount-$org WHERE member_id=$mbrlist1[$i]";
					mysqli_query($connect,$sql8)or die("Error in query".$sql8);					

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbrlist1[$i], $oramt, $oramt-$org, $org, 'Mix Change Formula', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
				}
			}

			$sql7 = "UPDATE mixledger_".$cmainyear." SET mpp = 0, accbgid = 0,status_id = 6, result_amount=0, net_amount=0, modifieddate = '$today' 
			WHERE mixledger_id IN (SELECT mixledger_id FROM mixledger_detail_".$cmainyear." WHERE dashboard_id = $dashid AND recordstatus = 1) AND recordstatus=1";
			mysqli_query($connect,$sql7)or die("Error in query".$sql7);	

			echo "Successfully Changed!";
		}
		elseif ($btn == "calculate") {
			$bid = mysqli_real_escape_string($connect,$data->bid);
			$gid = mysqli_real_escape_string($connect,$data->gid);
			$sql90 ="SELECT accbody_id as accbgid,description as fname,formula,formulatype from accbodies WHERE formulatype=$bid and recordstatus=1";
			$resultaccbody0 = mysqli_query($connect,$sql90)or die("Error in query".$sql90);
			if (mysqli_num_rows($resultaccbody0)<1) {
				$mixbody = "No Record";
			}
			else{
				while ($mixb = mysqli_fetch_assoc($resultaccbody0)) {
					$mixbody[] = $mixb;
				}
			}

			$sql80 ="SELECT accgoal_id as accbgid,description as fname,formula,formulatype from accgoal WHERE formulatype=$gid and recordstatus=1";
			$resultaccgoal0 = mysqli_query($connect,$sql80)or die("Error in query".$sql80);
			if (mysqli_num_rows($resultaccgoal0)<1) {
				$mixgoal = "No Record";
			}
			else{
				while ($mixg = mysqli_fetch_assoc($resultaccgoal0)) {
					$mixgoal[] = $mixg;
				}
			}

			$sql7 = "SELECT formulalist_id,description FROM formulalist WHERE recordstatus=1";
			$result7 = mysqli_query($connect,$sql7)or die("Error in query".$sql7);
			if (mysqli_num_rows($result7)<1) {
				$forname = "No Record";
			}
			else{
				while ($a = mysqli_fetch_assoc($result7)) {
					$forname[] = $a["description"];
				}
			}

			$sql10 = "SELECT mixledger_detail_".$cmainyear.".bet,mixledger_detail_".$cmainyear.".bet_on,history_".$cmainyear.".uper,history_".$cmainyear.".dper,history_".$cmainyear.".goalplus_value,
			history_".$cmainyear.".hper,history_".$cmainyear.".aper,history_".$cmainyear.".body_value,mixledger_detail_".$cmainyear.".mixledger_detail_id,
			history_".$cmainyear.".body_value, history_".$cmainyear.".goalplus_value, history_".$cmainyear.".hper, history_".$cmainyear.".aper, history_".$cmainyear.".uper, history_".$cmainyear.".dper 
			FROM mixledger_detail_".$cmainyear."
			INNER JOIN mixledger_".$cmainyear." ON mixledger_detail_".$cmainyear.".mixledger_id = mixledger_".$cmainyear.".mixledger_id
			INNER JOIN history_".$cmainyear." ON mixledger_detail_".$cmainyear.".history_id=history_".$cmainyear.".history_id 
			WHERE mixledger_detail_".$cmainyear.".accbgid=0 and mixledger_detail_".$cmainyear.".dashboard_id=$dashid";

			$res10 = mysqli_query($connect,$sql10)or die("Error in query".$sql10);
			if (mysqli_num_rows($res10)<1) {
				$arr10 = "No Record";
			}
			else{
				while ($t = mysqli_fetch_assoc($res10)) {
					$arr10[] = $t;
				}
			}

			$data = array("forname"=>$forname, "mixbody"=>$mixbody, "mixgoal"=>$mixgoal, "mixarr"=>$arr10);
			print json_encode($data);
		}
	}
	elseif ($table == "checkformula") {
		$did = mysqli_real_escape_string($connect,$data->dashid);
		$bid = mysqli_real_escape_string($connect,$data->bid);
		$gid = mysqli_real_escape_string($connect,$data->gid);		

		$sql10 = "SELECT mixledger_detail_".$cmainyear.".bet,mixledger_detail_".$cmainyear.".bet_on,history_".$cmainyear.".uper,history_".$cmainyear.".dper,history_".$cmainyear.".goalplus_value,
		history_".$cmainyear.".hper,history_".$cmainyear.".aper,history_".$cmainyear.".body_value,mixledger_detail_".$cmainyear.".mixledger_detail_id,
		history_".$cmainyear.".body_value, history_".$cmainyear.".goalplus_value, history_".$cmainyear.".hper, history_".$cmainyear.".aper, history_".$cmainyear.".uper, history_".$cmainyear.".dper 
		FROM mixledger_detail_".$cmainyear."
		INNER JOIN mixledger_".$cmainyear." ON mixledger_detail_".$cmainyear.".mixledger_id = mixledger_".$cmainyear.".mixledger_id
		INNER JOIN history_".$cmainyear." ON mixledger_detail_".$cmainyear.".history_id=history_".$cmainyear.".history_id 
		WHERE mixledger_detail_".$cmainyear.".accbgid=0 and mixledger_detail_".$cmainyear.".dashboard_id=$did";

		/*$sql10 = "SELECT mixledger_detail_".$cmainyear.".*,history_".$cmainyear.".*
		FROM mixledger_detail
		INNER JOIN mixledger_".$cmainyear." ON mixledger_detail_".$cmainyear.".mixledger_id = mixledger_".$cmainyear.".mixledger_id
		INNER JOIN history_".$cmainyear." ON mixledger_detail_".$cmainyear.".history_id=history_".$cmainyear.".history_id 
		WHERE mixledger_detail_".$cmainyear.".accbgid=0 and mixledger_detail_".$cmainyear.".dashboard_id=$did";*/

		$res10 = mysqli_query($connect,$sql10)or die("Error in query".$sql10);
		if (mysqli_num_rows($res10)<1) {
			$arr10 = "No Record";
		}
		else{
			while ($t = mysqli_fetch_assoc($res10)) {
				$arr10[] = $t;
			}
		}

		$sql1 = "SELECT m.bet_on,m.bet,m.accbgid,h.hper,h.aper,h.body_value,h.uper,h.dper,h.goalplus_value,m.betstateid,m.accbgid,
		m.net_amount,m.result_amount,m.bet_amount,m.mledger_id,m.member_id 
		FROM mledger_".$cmainyear." as m 
		inner JOIN dashboard_".$cmainyear." as d on m.dashboard_id=d.dashboard_id
		INNER JOIN history_".$cmainyear." as h on m.history_id=h.history_id WHERE m.betstateid=1 and m.accbgid=0 and m.dashboard_id=$did";

		/*$sql1 = "SELECT h.*,m.*
		FROM mledger_".$cmainyear." as m 
		inner JOIN dashboard_".$cmainyear." as d on m.dashboard_id=d.dashboard_id
		INNER JOIN history_".$cmainyear." as h on m.history_id=h.history_id WHERE m.betstateid=1 and m.accbgid=0 and m.dashboard_id=$did";*/

		$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		if (mysqli_num_rows($res1)<1) {
			$arr = "No Record";
		}
		else{
			while ($t = mysqli_fetch_assoc($res1)) {
				$arr[] = $t;
			}
		}

		$sql9 ="SELECT accbody_id as accbgid,description,formula from accbodies WHERE accbody_id=$bid and recordstatus=1 AND formulatype=0";
		$resultaccbody = mysqli_query($connect,$sql9)or die("Error in query".$sql9);
		if (mysqli_num_rows($resultaccbody)<1) {
			$abody = "No Record";
		}
		else{
			while ($ab = mysqli_fetch_assoc($resultaccbody)) {
				$abody[] = $ab["formula"];
			}
		}

		if ($bid != 0) {
			$sql90 ="SELECT accbody_id as accbgid,description as fname,formula,formulatype from accbodies WHERE formulatype=$bid and recordstatus=1";
			$resultaccbody0 = mysqli_query($connect,$sql90)or die("Error in query".$sql90);
			if (mysqli_num_rows($resultaccbody0)<1) {
				$mixbody = "No Record";
			}
			else{
				while ($mixb = mysqli_fetch_assoc($resultaccbody0)) {
					$mixbody[] = $mixb;
				}
			}
		}
		else{
			$mixbody = "No Record";
		}		
	
		$sql8 ="SELECT accgoal_id as accbgid,description,formula from accgoal WHERE accgoal_id=$gid and recordstatus=1 AND formulatype=0";
		$resultaccgoal = mysqli_query($connect,$sql8)or die("Error in query".$sql8);
		if (mysqli_num_rows($resultaccgoal)<1) {
			$agoal = "No Record";
		}
		else{
			while ($ag = mysqli_fetch_assoc($resultaccgoal)) {
				$agoal[] = $ag["formula"];
			}
		}

		if ($gid != 0) {
			$sql80 ="SELECT accgoal_id as accbgid,description as fname,formula,formulatype from accgoal WHERE formulatype=$gid and recordstatus=1";
			$resultaccgoal0 = mysqli_query($connect,$sql80)or die("Error in query".$sql80);
			if (mysqli_num_rows($resultaccgoal0)<1) {
				$mixgoal = "No Record";
			}
			else{
				while ($mixg = mysqli_fetch_assoc($resultaccgoal0)) {
					$mixgoal[] = $mixg;
				}
			}
		}
		else{
			$mixgoal = "No Record";
		}		

		$sql7 = "SELECT formulalist_id,description FROM formulalist WHERE recordstatus=1";
		$result7 = mysqli_query($connect,$sql7)or die("Error in query".$sql7);
		if (mysqli_num_rows($result7)<1) {
			$forname = "No Record";
		}
		else{
			while ($a = mysqli_fetch_assoc($result7)) {
				$forname[] = $a["description"];
			}
		}			

		$data = array("arr"=>$arr, "abody"=>$abody, "agoal"=>$agoal, "forname"=>$forname, "mixbody"=>$mixbody, "mixgoal"=>$mixgoal, "mixarr"=>$arr10);
		print json_encode($data);
	}
	/*elseif ($table == "checkformula") {
		$did = mysqli_real_escape_string($connect,$data->dashid);
		$bid = mysqli_real_escape_string($connect,$data->bid);
		$gid = mysqli_real_escape_string($connect,$data->gid);
		$sql1 = "SELECT m.*,h.* FROM mledger_".$cmainyear." as m inner JOIN dashboard_".$cmainyear." as d on m.dashboard_id=d.dashboard_id
		INNER JOIN history_".$cmainyear." as h on m.history_id=h.history_id WHERE m.betstateid=1 and m.accbgid=0 and m.dashboard_id=$did";
		$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		if (mysqli_num_rows($res1)<1) {
			$arr = "No Record";
		}
		else{
			while ($t = mysqli_fetch_assoc($res1)) {
				$arr[] = $t;
			}
		}

				$sql9 ="SELECT accbody_id as accbgid,description,formula from accbodies WHERE accbody_id=$bid and recordstatus=1 AND formulatype=0";
				$resultaccbody = mysqli_query($connect,$sql9)or die("Error in query".$sql9);
				if (mysqli_num_rows($resultaccbody)<1) {
					$abody = "No Record";
				}
				else{
					while ($ab = mysqli_fetch_assoc($resultaccbody)) {
						$abody[] = $ab["formula"];
					}
				}
				
			
				$sql8 ="SELECT accgoal_id as accbgid,description,formula from accgoal WHERE accgoal_id=$gid and recordstatus=1";
				$resultaccgoal = mysqli_query($connect,$sql8)or die("Error in query".$sql8);
				if (mysqli_num_rows($resultaccgoal)<1) {
					$agoal = "No Record";
				}
				else{
					while ($ag = mysqli_fetch_assoc($resultaccgoal)) {
						$agoal[] = $ag["formula"];
					}
				}

				$sql7 = "SELECT * FROM formulalist WHERE recordstatus=1";
				$result7 = mysqli_query($connect,$sql7)or die("Error in query".$sql7);
				if (mysqli_num_rows($result7)<1) {
					$forname = "No Record";
				}
				else{
					while ($a = mysqli_fetch_assoc($result7)) {
						$forname[] = $a["description"];
					}
				}			

		$data = array("arr"=>$arr, "abody"=>$abody, "agoal"=>$agoal, "forname"=>$forname);
		print json_encode($data);
	}*/
	elseif ($table == "addmledger") {
		//$userid = mysqli_real_escape_string($connect,$data->userid);
		if ($data->arraydata != "No Record") {
			foreach ($data->arraydata as $rows) {
				$bgid = mysqli_real_escape_string($connect,$rows->accbgid);
				$net = mysqli_real_escape_string($connect,$rows->net);
				$res = mysqli_real_escape_string($connect,$rows->result);
				$staid = mysqli_real_escape_string($connect,$rows->status);
				$mlgrid = mysqli_real_escape_string($connect,$rows->mid);
				$mbrid = mysqli_real_escape_string($connect,$rows->memberid);

				$sql1 = "UPDATE mledger_".$cmainyear." set accbgid=$bgid, net_amount=$net, result_amount=$res, status_id=$staid WHERE mledger_id=$mlgrid and accbgid=0 and recordstatus=1";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);

				if (mysqli_affected_rows() == 1) {
					$sql2 = "SELECT amount from members WHERE member_id = $mbrid and recordstatus=1";
					$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
					while ($aa = mysqli_fetch_assoc($result2)) {
						$amt = $aa["amount"];
					}

					$newamt = $amt + $net;

					$sql3 = "UPDATE members set amount = $newamt WHERE member_id = $mbrid and recordstatus=1";
					mysqli_query($connect,$sql3)or die("Error in query".$sql3);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbrid, $amt, $newamt, $net, 'Body Bet', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);
				}				
			}
		}		

		if ($data->mixarrdata != "No Record") {
			foreach ($data->mixarrdata as $rows) {
				$mdetailid = mysqli_real_escape_string($connect,$rows->mixledger_detail_id);
				$res = mysqli_real_escape_string($connect,$rows->result);
				$staid = mysqli_real_escape_string($connect,$rows->status);
				$accbgid = mysqli_real_escape_string($connect,$rows->accbgid);
				
				$sql1 = "UPDATE mixledger_detail_".$cmainyear." set accbgid=$accbgid, mp=$res, status_id=$staid WHERE mixledger_detail_id=$mdetailid and accbgid=0 and recordstatus=1";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			}
		}				

		print json_encode($data);
	}
	elseif ($table == "bettingmix") {
		$amount = mysqli_real_escape_string($connect,$data->amount);
		$mid = mysqli_real_escape_string($connect,$data->mid);
		$mix = mysqli_real_escape_string($connect,$data->mix); 
		
		$arraydata = array();
		foreach ($data->arraydata as $rows) {
			$arraydata[] = mysqli_real_escape_string($connect,$rows->mix);			
		}

			$sql1 = "SELECT amount FROM members WHERE member_id =$mid and recordstatus=1";
			$res1 = mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);
			while($r1 = mysqli_fetch_assoc($res1)){
				$mamount = $r1["amount"];
			}

			$sql2 = "SELECT * FROM mix WHERE mixname =$mix and recordstatus=1";
			$res2 = mysqli_query($connect,$sql2, $connect)or die("Error in sql ".$sql2);
			while($r2 = mysqli_fetch_assoc($res2)){
				$mixbs = $r2["bs"];
			}

			if ($mixbs == 1) {
				$sid = 6;
			}
			else{
				$sid = 2;
			}
			
			if ($mixbs != 3) {
				$sql2="INSERT INTO mixledger_".$cmainyear."(member_id, bet_date, bet_time, mixname, betstateid, status_id, bet_amount, createddate) VALUES($mid, '$today', '$aatime', $mix, $mixbs, $sid, $amount, '$today')";
				mysqli_query($connect,$sql2, $connect)or die("Error in sql ".$sql2);

				$sql3 = "UPDATE members SET amount = amount-$amount WHERE member_id = $mid and recordstatus=1";
				mysqli_query($connect,$sql3, $connect)or die("Error in sql".$sql3);
				$msg = "Success Bet";	

				$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
				VALUES ($mid, $mamount, $mamount-$amount, -$amount, 'Mix Betting', '$today', '$aatime')";
				mysqli_query($connect,$detail, $connect)or die("Error in sql ".$detail);

				$sql4 = "SELECT MAX(mixledger_id) as mixledgerid FROM mixledger_".$cmainyear." WHERE recordstatus=1";
				$res4 = mysqli_query($connect,$sql4, $connect)or die("Error in sql ".$sql4);
				if (mysqli_num_rows($res4)<1) {
					$mixledgerid = "error";
				}
				else{
					while ($aa = mysqli_fetch_assoc($res4)) {
						$mixledgerid = $aa["mixledgerid"];
					}
				}

				foreach ($data->arraydata as $rows) {
					$mixname = mysqli_real_escape_string($connect,$rows->mix);
					$dashid = mysqli_real_escape_string($connect,$rows->dashid);	
					$dashid = mysqli_real_escape_string($connect,$rows->dashid);
					$beton = mysqli_real_escape_string($connect,$rows->beton);	

					$sql6 = "SELECT MAX(history_".$cmainyear.".history_id) as hs FROM history_".$cmainyear." 
					INNER JOIN dashboard_".$cmainyear." ON dashboard_".$cmainyear.".timetableid=history_".$cmainyear.".timetableid
					WHERE dashboard_".$cmainyear.".dashboard_id=$dashid AND history_".$cmainyear.".recordstatus=1";
					$res6 = mysqli_query($connect,$sql6)or die("Error in query".$sql6);
					if (mysqli_num_rows($res6)<1) {
						$hisid = 0;
					}
					else{
						while ($a = mysqli_fetch_assoc($res6)) {
							$hisid = $a["hs"];
						}
					}

					if ($beton == 'Home' || $beton == 'Away') {
						$bet = "Body";
					}
					elseif ($beton == 'Over' || $beton == 'Down') {
						$bet = "Goal";
					}

					$sql5 = "INSERT INTO mixledger_detail_".$cmainyear."(mixledger_id, history_id, dashboard_id, bet_on, bet, createddate) 
					VALUES($mixledgerid, $hisid, $dashid, '$beton', '$bet', '$today')";
					mysqli_query($connect,$sql5, $connect)or die("Error in sql ".$sql5);
				}

				$sqlall = "SELECT onoff_id FROM onoff WHERE onofftype='commissiononoff' AND member_id=0";
				$resultall = mysqli_query($connect,$sqlall)or die("Error in query".$sqlall);
				if (mysqli_num_rows($resultall)>0) {
					$sql4 = "SELECT com_on_off FROM mix WHERE mixname = $mix";
					$result4 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
					while ($a4 = mysqli_fetch_assoc($result4)) {
						$comonoff = $a4["com_on_off"];
					}

					if ($comonoff == 1) {
						$sql7 = "SELECT agent_id FROM agent_member WHERE member_id = $mid AND recordstatus = 1";
						$result7 = mysqli_query($connect,$sql7)or die("Error in query".$sql7);
						if (mysqli_num_rows($result7)>0) {
							while ($a7 = mysqli_fetch_assoc($result7)) {
								$agid = $a7["agent_id"];
							}

							$sql5 = "SELECT onoff_id FROM onoff WHERE onofftype = 'commissiononoff' AND member_id = $agid";
							$result5 = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
							if (mysqli_num_rows($result5)>0) {
								$sql6 = "SELECT onoff_id FROM onoff WHERE onofftype = 'commissiononoff' AND member_id = $mid";
								$result6 = mysqli_query($connect,$sql6)or die("Error in query".$sql6);
								if (mysqli_num_rows($result6)>0) {
									$sql8 = "SELECT MAX(mixledger_id) as mixledgerid FROM mixledger_".$cmainyear." 
									WHERE member_id = $mid AND mixname=$mix AND recordstatus = 1";
									$result8 = mysqli_query($connect,$sql8)or die("Error in query".$sql8);
									while ($a8 = mysqli_fetch_assoc($result8)) {
										$mixledgerid = $a8["mixledgerid"];
									}
									$sql9 = "INSERT INTO agent_commission(member_id, agent_id, bet_type, ledger_id, dash_mix, createddate, createdtime) 
									VALUES($mid, $agid, 'mix', $mixledgerid, $mix, '$today', '$aatime')";
									mysqli_query($connect,$sql9)or die("Error in query".$sql9);
								}
							}
						}											
					}
				}
				
			}
			else{
				$msg = "Sorry, this mix is Reject";
			}			
	
		$data = array("msg"=>$msg,"mamount"=>$mamount, "mid"=>$mid);
		print json_encode($data);
	}
	elseif ($table == "alluser") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$cannot = "";
		$onoff = "WHERE members.recordstatus=1";
		
		if ($btn == "del") {
			$mbrid = mysqli_real_escape_string($connect,$data->mbrid);

			$sql1 = "SELECT * FROM deposite WHERE member_id = $mbrid";
			$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$sql2 = "SELECT * FROM withdraw WHERE member_id = $mbrid";
				$res2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
				if (mysqli_num_rows($res2)<1) {
					$sql3 = "SELECT * FROM transfer WHERE mfrom_id = $mbrid OR mto_id = $mbrid";
					$res3 = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
					if (mysqli_num_rows($res3)<1) {
						$sql4 = "SELECT * FROM mledger_".$cmainyear." WHERE member_id = $mbrid";
						$res4 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
						if (mysqli_num_rows($res4)<1) {
							$sql5 = "SELECT * FROM mixledger_".$cmainyear." WHERE member_id = $mbrid";
							$res5 = mysqli_query($connect,$sql5)or die("Error in query".$sql5);
							if (mysqli_num_rows($res5)<1) {
								$sql = "UPDATE members set recordstatus=2 WHERE member_id=$mbrid";
								mysqli_query($connect,$sql)or die("Error in query".$sql);
							}
							else{
								$cannot = "Can't Delete! There are some transactions.";
							}
						}
						else{
							$cannot = "Can't Delete! There are some transactions.";
						}
					}
					else{
						$cannot = "Can't Delete! There are some transactions.";
					}
				}
				else{
					$cannot = "Can't Delete! There are some transactions.";
				}
			}
			else{
				$cannot = "Can't Delete! There are some transactions.";
			}			
		}
		elseif ($btn == "tranoff") {
			$mbrid = mysqli_real_escape_string($connect,$data->mid);
			$off = mysqli_real_escape_string($connect,$data->off);
			$sql = "UPDATE members set tranoff=$off WHERE member_id=$mbrid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "onofffilter") {
			$onofftype = mysqli_real_escape_string($connect,$data->onofftype);
			if ($onofftype == "") {
				$onoff = "WHERE members.recordstatus=1";
			}
			else{
				$onoff = "INNER JOIN onoff ON onoff.member_id=members.member_id
				WHERE members.recordstatus=1 AND onoff.onofftype='$onofftype'";
			}			
		}
		//$sql1 = "SELECT *,SUBSTRING_INDEX(SUBSTRING_INDEX(createddate, ' ', 1), ' ', -1) as cdate from members WHERE recordstatus = 1";
		$sql1 = "SELECT members.*,(ifnull(agents1.agent_id,0)) as agentid,
			(ifnull(agents.agent_id,0)) as ownagentid,SUBSTRING_INDEX(SUBSTRING_INDEX(members.createddate, ' ', 1), ' ', -1) as cdate,
			(ifnull(members1.loginid,'-')) as agentloginid
			FROM members 
			LEFT JOIN agent_member ON agent_member.member_id = members.member_id
			LEFT JOIN agents AS agents1 ON agents1.member_id = members.member_id
			LEFT JOIN agents ON agents.agent_id = agent_member.agent_id
			LEFT JOIN members as members1 ON agents.member_id=members1.member_id
			$onoff";
		$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		if (mysqli_num_rows($res1)<1) {
			$alluser = "No Record";
		}
		else{
			while ($a = mysqli_fetch_assoc($res1)) {
				$alluser[] = $a;
			}
		}

		$sql2 = "SELECT count(*) as totaloff,onofftype FROM onoff WHERE member_id!=0 GROUP BY(onofftype)";
			$info2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($info2)<1) {
				$totaloff = "No Record";
			}
			else{
				while ($toff = mysqli_fetch_assoc($info2)) {
					$totaloff[] = $toff;
				}
			}

		$sql2 = "SELECT onoff_id FROM onoff WHERE onofftype='creatememberoff'";
			$info2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($info2)<1) {
				$creatembr = false;
			}
			else{
				$creatembr = true;
			}

		$data = array("alluser"=>$alluser, "totaloff"=>$totaloff, "cannot"=>$cannot, "creatembr"=>$creatembr);
		print json_encode($data);
	}
	elseif ($table == "editformula") {
		$did = mysqli_real_escape_string($connect,$data->dashid);
		$btn = mysqli_real_escape_string($connect,$data->btn);
		//$userid = mysqli_real_escape_string($connect,$data->userid);
		if ($btn == "body") {
			$sql1 = "UPDATE dashboard_".$cmainyear." SET accbody_id=0 WHERE dashboard_id=$did";
			mysqli_query($connect,$sql1)or die("Error in query".$sql1);

			$sql2 ="UPDATE mledger_".$cmainyear." SET accbgid=0 WHERE dashboard_id=$did AND bet like 'Body%'";
			mysqli_query($connect,$sql2)or die("Error in query".$sql2);

			echo "Success !";
		}
		elseif ($btn == "goal") {
			$sql1 = "UPDATE dashboard_".$cmainyear." SET accgoal_id=0 WHERE dashboard_id=$did";
			mysqli_query($connect,$sql1)or die("Error in query".$sql1);

			$sql2 ="UPDATE mledger_".$cmainyear." SET accbgid=0 WHERE dashboard_id=$did AND bet like 'Goal%'";
			mysqli_query($connect,$sql2)or die("Error in query".$sql2);

			echo "Success !";
		}		
	}
	elseif ($table == "mixdetail") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$dashid = mysqli_real_escape_string($connect,$data->dashid);

		$sql1 = "SELECT 
		(CASE status.status_id WHEN 1 THEN 'wgn' WHEN 2 THEN 'yw' WHEN 3 THEN 'rd' WHEN 4 THEN 'lrd' WHEN 6 THEN 'gn' WHEN 7 THEN 'gn' WHEN 8 THEN 'lrd' ELSE 'df' END) as sname,
		status.status_id,status.description, mixledger_detail_".$cmainyear.".bet_on, mixledger_".$cmainyear.".bet_time, mixledger_detail_".$cmainyear.".accbgid,mixledger_detail_".$cmainyear.".mp,mixledger_".$cmainyear.".mpp,
		mixledger_".$cmainyear.".bet_date, members.username, members.loginid,leagues.leaguename,t1.teamname as home,t2.teamname as away,dashboard_".$cmainyear.".score,
		(CASE mixledger_detail_".$cmainyear.".bet_on 
	            WHEN 'home' THEN history_".$cmainyear.".body_value
	            WHEN 'away' THEN history_".$cmainyear.".body_value
	            WHEN 'over' THEN history_".$cmainyear.".goalplus_value
	            WHEN 'down' THEN history_".$cmainyear.".goalplus_value
	            ELSE 'None' END) AS bgvalue,

		(CASE mixledger_detail_".$cmainyear.".bet_on 
	            WHEN 'home' THEN history_".$cmainyear.".hper
	            WHEN 'away' THEN history_".$cmainyear.".aper
	            WHEN 'over' THEN history_".$cmainyear.".uper
	            WHEN 'down' THEN history_".$cmainyear.".dper
	            ELSE 'None' END) AS bgper,
	
		(CASE mixledger_detail_".$cmainyear.".bet_on 
	            WHEN 'home' THEN t1.teamname
	            WHEN 'away' THEN t2.teamname
	            WHEN 'over' THEN 'Over'
	            WHEN 'down' THEN 'Down'
	            ELSE 'None' END) AS bet_on_name,

		(CASE mixledger_detail_".$cmainyear.".bet_on 
	            WHEN 'home' THEN bodies.bodyname
	            WHEN 'away' THEN bodies.bodyname
	            WHEN 'over' THEN goalplus.goalname
	            WHEN 'down' THEN goalplus.goalname
	            ELSE 'None' END) AS bgname

		FROM mixledger_detail_".$cmainyear." 
		INNER JOIN status ON mixledger_detail_".$cmainyear.".status_id = status.status_id
		INNER JOIN dashboard_".$cmainyear." ON mixledger_detail_".$cmainyear.".dashboard_id=dashboard_".$cmainyear.".dashboard_id	
		INNER JOIN mixledger_".$cmainyear." ON mixledger_".$cmainyear.".mixledger_id = mixledger_detail_".$cmainyear.".mixledger_id
		INNER JOIN members ON members.member_id = mixledger_".$cmainyear.".member_id
		INNER JOIN history_".$cmainyear." ON history_".$cmainyear.".history_id=mixledger_detail_".$cmainyear.".history_id
		INNER JOIN timetable ON history_".$cmainyear.".timetableid = timetable.timetableid
		INNER JOIN teams as t1 on t1.team_id=timetable.home
		INNER JOIN teams as t2 on t2.team_id=timetable.away
		INNER JOIN leagues on leagues.league_id = timetable.league_id
	           LEFT JOIN goalplus ON goalplus.goalplus_id = dashboard_".$cmainyear.".goalplus_id
	           LEFT JOIN bodies ON bodies.body_id = dashboard_".$cmainyear.".body_id
		WHERE mixledger_detail_".$cmainyear.".dashboard_id=$dashid";

	           $result1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		if (mysqli_num_rows($result1) > 0) {
			   while($r1 = mysqli_fetch_assoc($result1)){
				$data1[] = $r1;
			}
		} else {
		    	$data1 = "No Record";	
		}

		$sql4 = "SELECT status_id,(CASE description WHEN 'DEFAULT' THEN '-- Win / Lose --' ELSE description END) as description FROM status WHERE recordstatus=1";
		$result4 = mysqli_query($connect,$sql4)or die("Error in query".$sql4);
		if (mysqli_num_rows($result4) > 0) {
			   while($r4 = mysqli_fetch_assoc($result4)){
				$data4[] = $r4;
			}
		} else {
		    	$data4 = "No Record";	
		}

		$data = array("mixdetail"=>$data1, "statusdata"=>$data4);
		print json_encode($data);
	}
	elseif ($table == "comformula") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "bg") {
			$dashid = mysqli_real_escape_string($connect,$data->dashid);
			$abody = mysqli_real_escape_string($connect,$data->abody);
			$agoal = mysqli_real_escape_string($connect,$data->agoal);
			$sql = "SELECT * FROM formulalist WHERE com = 1";
			$result = mysqli_query($connect,$sql)or die("Error in query".$sql);
			if (mysqli_num_rows($result)<1) {
				$forname = "No Record";
			}
			else{
				while ($a = mysqli_fetch_assoc($result)) {
					$forname[] = $a["description"];
				}
			}

			$sql1 = "SELECT formula as fordes FROM com_formula WHERE description='$abody'";
			//$sql1 = "SELECT * FROM agent_commission WHERE bet_type='bg' AND dash_mix = $dashid";
			$result1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($result1)<1) {
				$abodyfor = "No Record";
			}
			else{
				while ($a1 = mysqli_fetch_assoc($result1)) {
					$abodyfor = $a1["fordes"];
				}
			}

			$sql11 = "SELECT formula as fordes FROM com_formula WHERE description='$agoal'";
			//$sql1 = "SELECT * FROM agent_commission WHERE bet_type='bg' AND dash_mix = $dashid";
			$result11 = mysqli_query($connect,$sql11)or die("Error in query".$sql11);
			if (mysqli_num_rows($result11)<1) {
				$agoalfor = "No Record";
			}
			else{
				while ($a11 = mysqli_fetch_assoc($result11)) {
					$agoalfor = $a11["fordes"];
				}
			}

			$sql2 = "SELECT mledger_".$cmainyear.".*,history_".$cmainyear.".goalplus_value,history_".$cmainyear.".body_value,agents.loseper,agents.winper,agents.member_id as agentmemberid,agent_commission.* FROM mledger_".$cmainyear." 
				INNER JOIN agent_commission ON mledger_".$cmainyear.".mledger_id = agent_commission.ledger_id
				INNER JOIN agents ON agents.agent_id = agent_commission.agent_id
				INNER JOIN history_".$cmainyear." ON history_".$cmainyear.".history_id = mledger_".$cmainyear.".history_id
				WHERE agent_commission.bet_type='bg' AND mledger_".$cmainyear.".betstateid=1
				AND agent_commission.dash_mix = $dashid";
			$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($result2)<1) {
				$comledger = "No Record";
			}
			else{
				while ($a1 = mysqli_fetch_assoc($result2)) {
					$comledger[] = $a1;
				}
			}
			
			$data = array("forname"=>$forname, "comledger"=>$comledger, "agoalfor"=>$agoalfor, "abodyfor"=>$abodyfor);
		}
		elseif ($btn == "mix") {
			$mix = mysqli_real_escape_string($connect,$data->mix);
			$sql2 = "SELECT mixledger_".$cmainyear.".bet_amount, mixledger_".$cmainyear.".net_amount,mixledger_".$cmainyear.".result_amount,agents.mixloseper,
				agents.mixwinper,agents.member_id as agentmemberid,agent_commission.* FROM mixledger_".$cmainyear." 
				INNER JOIN agent_commission ON mixledger_".$cmainyear.".mixledger_id = agent_commission.ledger_id
				INNER JOIN agents ON agents.agent_id = agent_commission.agent_id
				WHERE agent_commission.bet_type='mix' AND mixledger_".$cmainyear.".betstateid=1
				AND agent_commission.dash_mix = $mix";
			$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($result2)<1) {
				$comledger = "No Record";
			}
			else{
				while ($a1 = mysqli_fetch_assoc($result2)) {
					$comledger[] = $a1;
				}
			}		

			$data = array("comledger"=>$comledger);
		}
		elseif ($btn == "checkcomcal") {
			$dashid = mysqli_real_escape_string($connect,$data->dashid);
			$sql1 = "SELECT com_for FROM dashboard_".$cmainyear." WHERE dashboard_id=$dashid AND recordstatus=1";
			$result1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($result1)<1) {
				$calculated = "No Record";
			}
			else{
				while ($a = mysqli_fetch_assoc($result1)) {
					$calculated = $a["com_for"];
				}
			}
			$data = array("calculated"=>$calculated);
		}
		elseif ($btn == "checkcomcalmix") {
			$mix = mysqli_real_escape_string($connect,$data->mix);
			$mix = intval($mix);
			$sql1 = "SELECT com_for FROM mix WHERE mixname=$mix AND recordstatus=1";
			$result1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($result1)>0) {
				while ($a = mysqli_fetch_assoc($result1)) {
					$calculated = $a["com_for"];
				}
			}
			
			$data = array("calculated"=>$calculated);
		}
		
		print json_encode($data);
	}
	elseif ($table == "addcommission") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$userid = mysqli_real_escape_string($connect,$data->userid);

		if ($btn == "update") {
			$comtype = mysqli_real_escape_string($connect,$data->comtype);
			foreach ($data->arraydata as $rows) {
				$result = mysqli_real_escape_string($connect,$rows->result);
				$lgrid = mysqli_real_escape_string($connect,$rows->lgrid);
				$agcomid = mysqli_real_escape_string($connect,$rows->agcomid);
				$agmbrid = mysqli_real_escape_string($connect,$rows->agmbrid);

				$sql = "UPDATE agent_commission SET commission_amt=$result 
				WHERE agent_commission_id=$agcomid AND ledger_id=$lgrid";
				mysqli_query($connect,$sql)or die("Error in query".$sql);

				$sql2 = "SELECT amount FROM members WHERE member_id=$agmbrid AND recordstatus=1";
				$result2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
				if (mysqli_num_rows($result2)<1) {
					$oramt = 0;
				}
				else{
					while ($a1 = mysqli_fetch_assoc($result2)) {
						$oramt = $a1["amount"];
					}
				}
				$newamt = $oramt+$result;

				$sql1 = "UPDATE members SET amount=$newamt
				WHERE member_id=$agmbrid AND recordstatus=1";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);

				$sql3 = "INSERT INTO amount_detail(member_id, old_amount, current_amount, change_amount, change_description, createdtime, createddate)
					VALUES($agmbrid, $oramt, $newamt, $result, 'Commission result', '$aatime', '$today')";
				mysqli_query($connect,$sql3)or die("Error in query".$sql3);
			}

			if ($comtype == "bg") {
				$dashid = mysqli_real_escape_string($connect,$data->dashid);
				$sql3 = "UPDATE dashboard_".$cmainyear." SET com_for=1,modifieddate='$today', userid=$userid WHERE dashboard_id=$dashid AND recordstatus=1";
				mysqli_query($connect,$sql3)or die("Error in query".$sql3);
			}
			elseif ($comtype == "mix") {
				$mix = mysqli_real_escape_string($connect,$data->mix);
				$sql3 = "UPDATE mix SET com_for=1,modifieddate='$today', userid=$userid WHERE mixname=$mix AND recordstatus=1";
				mysqli_query($connect,$sql3)or die("Error in query".$sql3);
			}			
		}
		echo "Successfully Calculated!";
	}
	elseif ($table == "mixbgledger") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "mix") {
			$sql1 = "SELECT *, (CASE WHEN (bet_amount<0) THEN 'red' ELSE 'black' END) as betclass, 
			(CASE WHEN (result_amount<0) THEN 'red' ELSE 'black' END) as resultclass, 
			(CASE WHEN (net_amount<0) THEN 'red' ELSE 'black' END) as netclass 
			FROM (SELECT SUM(bet_amount) as bet_amount, SUM(result_amount) as result_amount, SUM(net_amount) as net_amount, bet_date,mixname 
			FROM mixledger_".$cmainyear." WHERE recordstatus=1 AND accbgid!=0 AND STR_TO_DATE(bet_date, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') 
			and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y') GROUP BY bet_date,mixname) AS alldata";
			$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$mixtotal = "No Record";
			}
			else{
				while ($a = mysqli_fetch_assoc($res1)) {
					$mixtotal[] = $a;
				}
			}
			$data = array("mixtotal"=>$mixtotal);
		}
		elseif ($btn == "bg") {
			$dresult = "SELECT aio,tdate,ttime,resultbody,resultgoal,
			(CASE WHEN(io_id=3) THEN 'bk' WHEN(io_id=1) THEN 'gn' ELSE 'yel' END) as ioclassname,
			(CASE WHEN(resultbody<0) THEN 'minusclass' ELSE '' END) as bclass,
			(CASE WHEN(resultgoal<0) THEN 'minusclass' ELSE '' END) as gclass,
			(CASE WHEN(dbover>0) THEN CONCAT(Away,' - ',dbover) WHEN((dbover<0)) THEN CONCAT(Home,' - ',(dbover*-1)) ELSE '' END) as bover,
			(CASE WHEN(dgover>0) THEN CONCAT('Over - ',dgover) WHEN((dgover<0)) THEN CONCAT('Under - ',(dgover*-1)) ELSE '' END) as gover 
			FROM
			(SELECT io.io_id,io.description as aio,t.tdate,t.ttime,l.leaguename,t1.teamname as Home,t2.teamname as Away,
			IFNULL((SELECT SUM(mb.result_amount) from mledger_".$cmainyear." as mb WHERE mb.bet='Body' and d.dashboard_id=mb.dashboard_id GROUP BY mb.dashboard_id),0) as resultbody,
			IFNULL((SELECT SUM(mb.result_amount) from mledger_".$cmainyear." as mb WHERE mb.bet='Goal+' and d.dashboard_id=mb.dashboard_id GROUP BY mb.dashboard_id),0) as resultgoal,

			(IFNULL((select SUM(l.bet_amount) from mledger_".$cmainyear." as l 
			inner join dashboard_".$cmainyear." as dd on l.dashboard_id=dd.dashboard_id
			where l.bet_on='Away' and dd.timetableid=t.timetableid
			GROUP BY dd.timetableid,l.bet_on ),0) -
			IFNULL((select SUM(l.bet_amount) from mledger_".$cmainyear." as l 
			inner join dashboard_".$cmainyear." as dd on l.dashboard_id=dd.dashboard_id
			where l.bet_on='Home' and dd.timetableid=t.timetableid
			GROUP BY dd.timetableid,l.bet_on ),0)) as dbover,
			(IFNULL((select SUM(l.bet_amount) from mledger_".$cmainyear." as l 
			inner join dashboard_".$cmainyear." as dd on l.dashboard_id=dd.dashboard_id
			where l.bet_on='Over' and dd.timetableid=t.timetableid
			GROUP BY dd.timetableid,l.bet_on ),0)-
			IFNULL((select SUM(l.bet_amount) from mledger_".$cmainyear." as l 
			inner join dashboard_".$cmainyear." as dd on l.dashboard_id=dd.dashboard_id
			where l.bet_on='Down' and dd.timetableid=t.timetableid
			GROUP BY dd.timetableid,l.bet_on ),0)) as dgover

			FROM dashboard_".$cmainyear." as d 
			inner join timetable as t on t.timetableid=d.timetableid 
			LEFT JOIN mledger_".$cmainyear." as m on m.dashboard_id=d.dashboard_id
			inner join leagues as l on t.league_id=l.league_id 
			inner join teams as t1 on t1.team_id=t.home 
			inner join teams as t2 on t2.team_id=t.away
			LEFT join io on io.io_id=d.io_id

			WHERE d.recordstatus=1 and STR_TO_DATE(t.tdate, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y')
			GROUP BY d.dashboard_id) as alldata			                        
			order by STR_TO_DATE(tdate, '%m-%d-%Y') DESC,str_to_date(ttime, '%h:%i%p') DESC";	

			$dashres = mysqli_query($connect,$dresult)or die("Error in query".$dresult);
				if (mysqli_num_rows($dashres)<1) {
					$dashresult = "No Record";				
				}
				else{
					while ($dash = mysqli_fetch_assoc($dashres)) {
						$dashresult[] = $dash;
					}
				}
			$data = array("dashresult"=>$dashresult);
		}		
		//$data = array("mixtotal"=>$mixtotal, "dashresult"=>$dashresult);
		print json_encode($data);
	}
	elseif ($table == "tranlimit") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$limittype = mysqli_real_escape_string($connect,$data->limittype);
		if ($limittype == "transfer") {
			if ($btn == "edit") {
				$min = mysqli_real_escape_string($connect,$data->min);
				$max = mysqli_real_escape_string($connect,$data->max);
				$sql = "UPDATE tlimit set min=$min, max=$max, modifieddate='$today' WHERE limit_type='transfer'";
				mysqli_query($connect,$sql)or die("Error in query".$sql);
			}
			
			$sql1 = "SELECT * FROM tlimit WHERE limit_type='transfer'";
			$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$tlimitdata = "No Record";
			}
			else{
				while ($a = mysqli_fetch_assoc($res1)) {
					$tlimitdata[] = $a;
				}
			}
			$data = array("tlimit"=>$tlimitdata);
		}
		elseif ($limittype == "deposite") {
			if ($btn == "edit") {
				$min = mysqli_real_escape_string($connect,$data->min);
				$max = mysqli_real_escape_string($connect,$data->max);
				$sql = "UPDATE tlimit set min=$min, max=$max, modifieddate='$today' WHERE limit_type='deposit'";
				mysqli_query($connect,$sql)or die("Error in query".$sql);
			}
			
			$sql1 = "SELECT * FROM tlimit WHERE limit_type='deposit'";
			$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$tlimitdata = "No Record";
			}
			else{
				while ($a = mysqli_fetch_assoc($res1)) {
					$tlimitdata[] = $a;
				}
			}
			$data = array("tlimit"=>$tlimitdata);	
		}
		elseif ($limittype == "withdraw") {
			if ($btn == "edit") {
				$min = mysqli_real_escape_string($connect,$data->min);
				$max = mysqli_real_escape_string($connect,$data->max);
				$sql = "UPDATE tlimit set min=$min, max=$max, modifieddate='$today' WHERE limit_type='withdraw'";
				mysqli_query($connect,$sql)or die("Error in query".$sql);
			}
			
			$sql1 = "SELECT * FROM tlimit WHERE limit_type='withdraw'";
			$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$tlimitdata = "No Record";
			}
			else{
				while ($a = mysqli_fetch_assoc($res1)) {
					$tlimitdata[] = $a;
				}
			}	
			$data = array("tlimit"=>$tlimitdata);		
		}
		
		
		print json_encode($data);
	}
	elseif ($table == "checkmember") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$mid = mysqli_real_escape_string($connect,$data->mid);
		if ($btn == "member") {			
			$sql1 = "SELECT * from members WHERE member_id=$mid and recordstatus = 1";
			$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$alluser = "No Record";
			}
			else{
				$sql2 = "SELECT onoff_id FROM onoff WHERE member_id=$mid AND onofftype='loginonoff'";
				$res2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
				if (mysqli_num_rows($res2)<1) {
					$alluser = "True";
				}
				else{
					$alluser = "No Record";
				}			
			}
			
		}
		elseif ($btn == "user") {
			$roleid = mysqli_real_escape_string($connect,$data->roleid);
			$sql1 = "SELECT * from users WHERE userid=$mid and roleid = $roleid AND recordstatus = 1";
			$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$alluser = "no";
			}
			else{
				$alluser = "yes";
			}

		}
		$data = array("alluser"=>$alluser);
		print json_encode($data);
	}
	elseif ($table == "checkrunning") {
		$mid = mysqli_real_escape_string($connect,$data->mid);
		$sql = "SELECT (case when SUM(mledger_".$cmainyear.".bet_amount)>0 THEN SUM(mledger_".$cmainyear.".bet_amount) else 0 end) as runningamt FROM mledger_".$cmainyear." 
		INNER JOIN dashboard_".$cmainyear." ON mledger_".$cmainyear.".dashboard_id=dashboard_".$cmainyear.".dashboard_id
		INNER JOIN timetable ON dashboard_".$cmainyear.".timetableid=timetable.timetableid
		WHERE mledger_".$cmainyear.".member_id=$mid and mledger_".$cmainyear.".status_id=6 
		and STR_TO_DATE(timetable.tdate, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') 
		and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y')";
		$res = mysqli_query($connect,$sql)or die("Error in query".$sql);
		if (mysqli_num_rows($res)<1) {
			$allrun = 0;
		}
		else{
			while ($a = mysqli_fetch_assoc($res)) {
				$allrun = $a["runningamt"];
			}
		}

		$sql2 = "SELECT (case when SUM(bet_amount)>0 THEN SUM(bet_amount) else 0 end) as mixrunningamt FROM mixledger_".$cmainyear." 		
		WHERE member_id=$mid and status_id=6 
		and STR_TO_DATE(bet_date, '%m-%d-%Y') between STR_TO_DATE('".$yesterday."', '%m-%d-%Y') 
		and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y')";
		$res2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
		if (mysqli_num_rows($res2)<1) {
			$allrun2 = 0;
		}
		else{
			while ($a2 = mysqli_fetch_assoc($res2)) {
				$allrun2 = $a2["mixrunningamt"];
			}
		}

		$allamt = $allrun+$allrun2;

		$data = array("run"=>$allamt);
		print json_encode($data);
	}
	elseif ($table == "chformula") {
		$dashid = mysqli_real_escape_string($connect,$data->dashid);
		$btn = mysqli_real_escape_string($connect,$data->btn);		

		if ($btn == "body") {
			$sql2 = "SELECT member_id,net_amount FROM mledger_".$cmainyear." WHERE dashboard_id=$dashid AND betstateid=1 AND bet like 'Body'";
			$res2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($res2)<1) {
				$mbrlist = "0";
				
				$sql4 = "UPDATE dashboard_".$cmainyear." set accbody_id=0 WHERE dashboard_id=$dashid";
				mysqli_query($connect,$sql4)or die("Error in query".$sql4);

				$sql1 = "UPDATE mledger_".$cmainyear." set accbgid=0,result_amount=0,net_amount=0,status_id=6 WHERE dashboard_id=$dashid AND bet like 'Body' AND betstateid=1";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			}
			else{
				while ($a = mysqli_fetch_assoc($res2)) {
					$mbrlist[] = $a["member_id"];
					$amountlist[] = $a["net_amount"];
				}

				for ($i=0; $i < sizeof($mbrlist); $i++) { 
					$org = $amountlist[$i];

					$sql1 = "SELECT amount FROM members WHERE member_id =$mbrlist[$i] and recordstatus=1";
					$res1 = mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);
					while($r1 = mysqli_fetch_assoc($res1)){
						$oramt = $r1["amount"];
					}

					$sql3 = "UPDATE members set amount=amount-$org WHERE member_id=$mbrlist[$i]";
					mysqli_query($connect,$sql3)or die("Error in query".$sql3);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbrlist[$i], $oramt, $oramt-$org, $org, 'Body Change Formula', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
				}

				$sql4 = "UPDATE dashboard_".$cmainyear." set accbody_id=0 WHERE dashboard_id=$dashid";
				mysqli_query($connect,$sql4)or die("Error in query".$sql4);

				$sql1 = "UPDATE mledger_".$cmainyear." set accbgid=0,result_amount=0,net_amount=0,status_id=6 WHERE dashboard_id=$dashid AND bet like 'Body' AND betstateid=1";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			}
			/*$sql5 = "UPDATE mixledger_detail_".$cmainyear." SET accbgid=0, status_id=6,mp=0, modifieddate='$today' WHERE dashboard_id=$dashid AND bet Like 'Body' AND recordstatus=1";
			mysqli_query($connect,$sql5)or die("Error in query".$sql5);

			$sql6 = "SELECT mixledger_".$cmainyear.".mixledger_id,mixledger_".$cmainyear.".member_id,mixledger_".$cmainyear.".net_amount FROM mixledger_".$cmainyear." 
			INNER JOIN mixledger_detail_".$cmainyear." ON mixledger_".$cmainyear.".mixledger_id = mixledger_detail_".$cmainyear.".mixledger_id
			WHERE mixledger_".$cmainyear.".accbgid = 1 AND mixledger_".$cmainyear.".recordstatus = 1 AND mixledger_detail_".$cmainyear.".dashboard_id = $dashid";
			$res6 = mysqli_query($connect,$sql6)or die("Error in query".$sql6);
			if (mysqli_num_rows($res6)>0) {
				while ($a = mysqli_fetch_assoc($res6)) {
					$amountlist1[] = $a["net_amount"];
					$mbrlist1[] = $a["member_id"];
				}
				for ($i=0; $i < sizeof($mbrlist1); $i++) { 
					$org = $amountlist1[$i];

					$sql1 = "SELECT amount FROM members WHERE member_id =$mbrlist1[$i] and recordstatus=1";
					$res1 = mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);
					while($r1 = mysqli_fetch_assoc($res1)){
						$oramt = $r1["amount"];
					}

					$sql8 = "UPDATE members set amount=amount-$org WHERE member_id=$mbrlist1[$i]";
					mysqli_query($connect,$sql8)or die("Error in query".$sql8);					

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbrlist1[$i], $oramt, $oramt-$org, $org, 'Mix Change Formula', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
				}
			}

			$sql7 = "UPDATE mixledger_".$cmainyear." SET mpp = 0, accbgid = 0,status_id = 6, result_amount=0, net_amount=0, modifieddate = '$today' 
			WHERE mixledger_id IN (SELECT mixledger_id FROM mixledger_detail_".$cmainyear." WHERE dashboard_id = $dashid AND recordstatus = 1) AND recordstatus=1";
			mysqli_query($connect,$sql7)or die("Error in query".$sql7);*/
		}
		elseif ($btn == "goal") {
			$sql2 = "SELECT member_id,net_amount FROM mledger_".$cmainyear." WHERE dashboard_id=$dashid AND betstateid=1 AND bet like 'Goal%'";
			$res2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($res2)<1) {
				$mbrlist = "0";

				$sql4 = "UPDATE dashboard_".$cmainyear." set accgoal_id=0 WHERE dashboard_id=$dashid";
				mysqli_query($connect,$sql4)or die("Error in query".$sql4);

				$sql1 = "UPDATE mledger_".$cmainyear." set accbgid=0,result_amount=0,net_amount=0,status_id=6 WHERE dashboard_id=$dashid AND bet like 'Goal%' AND betstateid=1";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			}
			else{
				while ($a = mysqli_fetch_assoc($res2)) {
					$mbrlist[] = $a["member_id"];
					$amountlist[] = $a["net_amount"];
				}

				for ($i=0; $i < sizeof($mbrlist); $i++) { 
					$org = $amountlist[$i];

					$sql1 = "SELECT amount FROM members WHERE member_id =$mbrlist[$i] and recordstatus=1";
					$res1 = mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);
					while($r1 = mysqli_fetch_assoc($res1)){
						$oramt = $r1["amount"];
					}

					$sql3 = "UPDATE members set amount=amount-$org WHERE member_id=$mbrlist[$i]";
					mysqli_query($connect,$sql3)or die("Error in query".$sql3);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbrlist[$i], $oramt, $oramt-$org, $org, 'Goal Change Formula', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
				}

				$sql4 = "UPDATE dashboard_".$cmainyear." set accgoal_id=0 WHERE dashboard_id=$dashid";
				mysqli_query($connect,$sql4)or die("Error in query".$sql4);

				$sql1 = "UPDATE mledger_".$cmainyear." set accbgid=0,result_amount=0,net_amount=0,status_id=6 WHERE dashboard_id=$dashid AND bet like 'Goal%' AND betstateid=1";
				mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			}
			$sql5 = "UPDATE mixledger_detail_".$cmainyear." SET accbgid=0, status_id=6,mp=0, modifieddate='$today' WHERE dashboard_id=$dashid AND bet Like 'Goal' AND recordstatus=1";
			mysqli_query($connect,$sql5)or die("Error in query".$sql5);

			$sql6 = "SELECT mixledger_".$cmainyear.".mixledger_id,mixledger_".$cmainyear.".member_id,mixledger_".$cmainyear.".net_amount FROM mixledger_".$cmainyear." 
			INNER JOIN mixledger_detail_".$cmainyear." ON mixledger_".$cmainyear.".mixledger_id = mixledger_detail_".$cmainyear.".mixledger_id
			WHERE mixledger_".$cmainyear.".accbgid = 1 AND mixledger_".$cmainyear.".recordstatus = 1 AND mixledger_detail_".$cmainyear.".dashboard_id = $dashid";
			$res6 = mysqli_query($connect,$sql6)or die("Error in query".$sql6);
			if (mysqli_num_rows($res6)>0) {
				while ($a = mysqli_fetch_assoc($res6)) {
					$amountlist1[] = $a["net_amount"];
					$mbrlist1[] = $a["member_id"];
				}
				for ($i=0; $i < sizeof($mbrlist1); $i++) { 
					$org = $amountlist1[$i];

					$sql1 = "SELECT amount FROM members WHERE member_id =$mbrlist1[$i] and recordstatus=1";
					$res1 = mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);
					while($r1 = mysqli_fetch_assoc($res1)){
						$oramt = $r1["amount"];
					}

					$sql8 = "UPDATE members set amount=amount-$org WHERE member_id=$mbrlist1[$i]";
					mysqli_query($connect,$sql8)or die("Error in query".$sql8);

					$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
					VALUES ($mbrlist1[$i], $oramt, $oramt-$org, $org, 'Mix Change Formula', '$today', '$aatime')";
					mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
				}
			}

			$sql7 = "UPDATE mixledger_".$cmainyear." SET mpp = 0, accbgid = 0,status_id = 6, result_amount=0, net_amount=0, modifieddate = '$today' 
			WHERE mixledger_id IN (SELECT mixledger_id FROM mixledger_detail_".$cmainyear." WHERE dashboard_id = $dashid AND recordstatus = 1) AND recordstatus=1";
			mysqli_query($connect,$sql7)or die("Error in query".$sql7);
		}
		elseif ($btn == "com") {
			$sub = mysqli_real_escape_string($connect,$data->sub);
			if ($sub == "bg") {
				$sql2 = "SELECT agents.member_id,agent_commission.commission_amt 
				FROM agent_commission 
				INNER JOIN agents ON agents.agent_id=agent_commission.agent_id
				WHERE agent_commission.bet_type='bg' AND agent_commission.dash_mix=$dashid";
				$res2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
				if (mysqli_num_rows($res2)<1) {
					$mbrlist = "0";

					$sql4 = "UPDATE dashboard_".$cmainyear." set com_for=0 WHERE dashboard_id=$dashid";
					mysqli_query($connect,$sql4)or die("Error in query".$sql4);

				}
				else{
					while ($a = mysqli_fetch_assoc($res2)) {
						$mbrlist[] = $a["member_id"];
						$amountlist[] = $a["commission_amt"];
					}

					for ($i=0; $i < sizeof($mbrlist); $i++) { 
						$org = $amountlist[$i];

						$sql1 = "SELECT amount FROM members WHERE member_id =$mbrlist[$i] and recordstatus=1";
						$res1 = mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);
						while($r1 = mysqli_fetch_assoc($res1)){
							$oramt = $r1["amount"];
						}

						$sql3 = "UPDATE members set amount=amount-$org WHERE member_id=$mbrlist[$i]";
						mysqli_query($connect,$sql3)or die("Error in query".$sql3);

						$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
						VALUES ($mbrlist[$i], $oramt, $oramt-$org, $org, 'BG Commission Change Formula', '$today', '$aatime')";
						mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
					}

					$sql4 = "UPDATE dashboard_".$cmainyear." set com_for=0 WHERE dashboard_id=$dashid";
					mysqli_query($connect,$sql4)or die("Error in query".$sql4);

					$sql1 = "UPDATE agent_commission set commission_amt=0 WHERE bet_type='bg' AND dash_mix=$dashid";
					mysqli_query($connect,$sql1)or die("Error in query".$sql1);
				}
			}
			elseif ($sub == "mix") {
				$sql2 = "SELECT agents.member_id,agent_commission.commission_amt 
				FROM agent_commission 
				INNER JOIN agents ON agents.agent_id=agent_commission.agent_id
				WHERE agent_commission.bet_type='mix' AND agent_commission.dash_mix=$dashid";
				$res2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
				if (mysqli_num_rows($res2)<1) {
					$mbrlist = "0";

					$sql4 = "UPDATE mix set com_for=0 WHERE mixname=$dashid";
					mysqli_query($connect,$sql4)or die("Error in query".$sql4);

				}
				else{
					while ($a = mysqli_fetch_assoc($res2)) {
						$mbrlist[] = $a["member_id"];
						$amountlist[] = $a["commission_amt"];
					}

					for ($i=0; $i < sizeof($mbrlist); $i++) { 
						$org = $amountlist[$i];

						$sql1 = "SELECT amount FROM members WHERE member_id =$mbrlist[$i] and recordstatus=1";
						$res1 = mysqli_query($connect,$sql1, $connect)or die("Error in sql ".$sql1);
						while($r1 = mysqli_fetch_assoc($res1)){
							$oramt = $r1["amount"];
						}

						$sql3 = "UPDATE members set amount=amount-$org WHERE member_id=$mbrlist[$i]";
						mysqli_query($connect,$sql3)or die("Error in query".$sql3);

						$detail = "INSERT INTO amount_detail (member_id, old_amount, current_amount, change_amount, change_description, createddate, createdtime) 
						VALUES ($mbrlist[$i], $oramt, $oramt-$org, $org, 'Mix Commission Change Formula', '$today', '$aatime')";
						mysqli_query($connect,$detail, $connect)or die("Error in sql dep".$detail);
					}

					$sql4 = "UPDATE mix set com_for=0 WHERE mixname=$dashid";
					mysqli_query($connect,$sql4)or die("Error in query".$sql4);

					$sql1 = "UPDATE agent_commission set commission_amt=0 WHERE bet_type='mix' AND dash_mix=$dashid";
					mysqli_query($connect,$sql1)or die("Error in query".$sql1);
				}
			}	
		}			

		echo "Success Change!";		
	}
	elseif ($table == "info") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$h = mysqli_real_escape_string($connect,$data->h);
			$b = mysqli_real_escape_string($connect,$data->b);
			$f = mysqli_real_escape_string($connect,$data->f);
			$sql = "INSERT INTO info(header,body,footer,createddate,modifieddate) VALUES('$h','$b','$f','$today','$today')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$h = mysqli_real_escape_string($connect,$data->h);
			$b = mysqli_real_escape_string($connect,$data->b);
			$f = mysqli_real_escape_string($connect,$data->f);
			$infoid = mysqli_real_escape_string($connect,$data->info);
			$sql = "UPDATE info SET header='$h',body='$b',footer='$f' WHERE infoid=$infoid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql3= "SELECT * from info where recordstatus=1";
		$info = mysqli_query($connect,$sql3)or die("Error in query".$sql3);
		if (mysqli_num_rows($info)<1) {
			$infodata = "No Record";
		}
		else{
			while ($t = mysqli_fetch_assoc($info)) {
				$infodata[] = $t;
			}
		}
		$data = array("infodata"=>$infodata);
		print json_encode($data);
	}
	elseif ($table == "resetpass") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "reset") {
			$pass = mysqli_real_escape_string($connect,$data->pass);
			$mid = mysqli_real_escape_string($connect,$data->mid);
			$pa = md5($pass);
			$sql1 = "UPDATE members SET password='$pa' WHERE member_id=$mid";
			mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		}
		$sql2 = "SELECT member_id,loginid,mail,username FROM members WHERE recordstatus=1";
			$result = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			while ($a = mysqli_fetch_assoc($result)) {
				$allmembers[] = $a;
			}
		$data = array("allmembers"=>$allmembers);
		print json_encode($data);
	}
	elseif ($table == "onoff") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$mid = mysqli_real_escape_string($connect,$data->mid);
		if ($btn == "search") {
			$sql1 = "SELECT onofftype FROM onoff WHERE member_id=$mid";
			$info = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($info)<1) {
				$onoffdata = "No Record";
			}
			else{
				while ($t = mysqli_fetch_assoc($info)) {
					$onoffdata[] = $t;
				}
			}

			$sql2 = "SELECT count(*) as totaloff,onofftype FROM onoff WHERE onofftype!='creatememberoff' GROUP BY(onofftype)";
			$info2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($info2)<1) {
				$totaloff = "No Record";
			}
			else{
				while ($toff = mysqli_fetch_assoc($info2)) {
					$totaloff[] = $toff;
				}
			}

			$data = array("onoffdata"=>$onoffdata, "totaloff"=>$totaloff);
		}
		elseif ($btn == "save") {
			$sql1 = "DELETE FROM onoff WHERE member_id=$mid";
			$info = mysqli_query($connect,$sql1)or die("Error in query".$sql1);

			foreach ($data->arraydata as $rows) {
			$onofftp = mysqli_real_escape_string($connect,$rows->onoff_type);

			$sql = "INSERT INTO onoff(member_id,onofftype,createddate) VALUES($mid,'$onofftp','$today')";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
			}

			$sql2 = "SELECT count(*) as totaloff,onofftype FROM onoff WHERE onofftype!='creatememberoff' GROUP BY(onofftype)";
			$info2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($info2)<1) {
				$totaloff = "No Record";
			}
			else{
				while ($toff = mysqli_fetch_assoc($info2)) {
					$totaloff[] = $toff;
				}
			}

			$data = array("successmsg"=>"Success", "totaloff"=>$totaloff);
		}
		elseif ($btn == "check") {
			$onofftype = mysqli_real_escape_string($connect,$data->onofftype);
			if ($onofftype == "bettingonoff") {
				$sql = "SELECT onoff_id FROM onoff WHERE member_id IN($mid,0) AND onofftype='bettingonoff'";
				$info = mysqli_query($connect,$sql)or die("Error in query".$sql);
				if (mysqli_num_rows($info)<1) {
					$bettingaccept = "can";
				}
				else{
					$bettingaccept = "cannot";
				}

				$sql1 = "SELECT onoff_id FROM onoff WHERE member_id IN($mid,0) AND onofftype='mixbettingonoff'";
				$info1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
				if (mysqli_num_rows($info1)<2) {
					$mixbettingaccept = "cannot";
				}
				else{
					$mixbettingaccept = "can";
				}

				$data = array("accepttype1"=>$bettingaccept, "accepttype2"=>$mixbettingaccept);
			}
			else{
				$sql = "SELECT onoff_id FROM onoff WHERE member_id IN($mid,0) AND onofftype='$onofftype'";
				$info = mysqli_query($connect,$sql)or die("Error in query".$sql);
				if (mysqli_num_rows($info)<1) {
					$accept = "can";
				}
				else{
					$accept = "cannot";
				}

				$data = array("accepttype"=>$accept);
			}	
			
		}
		elseif ($btn == "newuseroff") {
			$onoff = mysqli_real_escape_string($connect,$data->onoff);
			$sql1 = "DELETE FROM onoff WHERE onofftype='creatememberoff'";
			mysqli_query($connect,$sql1)or die("Error in query".$sql1);

			if ($onoff == false) {
				$sql = "INSERT INTO onoff(member_id,onofftype,createddate) 
				VALUES(0,'creatememberoff','$today')";
				mysqli_query($connect,$sql)or die("Error in query".$sql);
			}

			$sql2 = "SELECT onoff_id FROM onoff WHERE onofftype='creatememberoff'";
			$info2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($info2)<1) {
				$creatembr = false;
			}
			else{
				$creatembr = true;
			}

			$data = array("successmsg"=>"Success", "creatembr"=>$creatembr);
		}
		elseif ($btn == "createuseronoff") {
			$sql2 = "SELECT onoff_id FROM onoff WHERE onofftype='creatememberoff'";
			$info2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($info2)<1) {
				$creatembr = false;
			}
			else{
				$creatembr = true;
			}

			$data = array("creatembr"=>$creatembr);
		}
		
		print json_encode($data);
	}
	elseif ($table == "detailledger") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$mid = mysqli_real_escape_string($connect,$data->mid);

		$sql1 = "SELECT *,(CASE WHEN change_amount<0 THEN 'red' ELSE '' END) as classname FROM amount_detail WHERE member_id = $mid AND recordstatus = 1 ORDER BY createddate DESC, createdtime DESC";
		$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		if (mysqli_num_rows($res1)<1) {
			$resultdata1 = "No Record";
		}
		else{
			while ($dd = mysqli_fetch_assoc($res1)) {
				$resultdata1[] = $dd;
			}
		}
		$data = array("detailledger"=>$resultdata1);
		print json_encode($data);
	}
	elseif ($table == "checkmixmatch") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		

		if ($btn == "pinall") {
			$userid = mysqli_real_escape_string($connect,$data->userid);
			
			$sqlpin = "SELECT MAX(pin_id) as pinnum FROM pin";
			$respin = mysqli_query($connect,$sqlpin)or die("Error in query ".$sqlpin);
			if (mysqli_num_rows($respin)<1) {
				$pinnum = 0;
			}
			else{
				while ($dd = mysqli_fetch_assoc($respin)) {
					$pinnum = $dd["pinnum"];
				}
				if ($pinnum == null) {
					$pinnum = 1;
				}
				else{
					$pinnum += 1;
				}
			}

			foreach ($data->arraydata as $rows) {
				$dashid = mysqli_real_escape_string($connect,$rows->dashboard_id);

				$sql1 = "INSERT INTO pin(dashboard_id,pin_id,createdtime,createddate,modifieddate,userid) 
				VALUES($dashid,$pinnum,'$aatime','$today','$today',$userid)";
				mysqli_query($connect,$sql1)or die("Error in query ".$sql1);
				
			}
			
			$data = array("success"=>$pinnum);
		}
		elseif ($btn == "check") {
			$dashid = mysqli_real_escape_string($connect,$data->dashid);
			$sql1 = "SELECT dashboard_id  FROM pin 
			WHERE pin_id = (SELECT pin_id FROM pin WHERE dashboard_id = $dashid) AND dashboard_id!=$dashid";
			$res1 = mysqli_query($connect,$sql1)or die("Error in query ".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$pinresult = "No Record";
			}
			else{
				while ($dd = mysqli_fetch_assoc($res1)) {
					$pinresult[] = $dd;
				}
			}
			$data = array("pinresult"=>$pinresult);
		}
		
		print json_encode($data);
	}
	elseif ($table == "allhistory") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$hisid = mysqli_real_escape_string($connect,$data->hisid);

		$sql1 = "SELECT IFNULL(accbodies.description,'') as abody,IFNULL(accgoal.description,'') as agoal,io.description as aio,bsgs1.description as abs,bsgs2.description as ags,gio.description as agio,bio.description as abio,d.*,b.bodyname,b.bodytype,g.goalname,g.goaltype,
				t.tdate,t.ttime,l.league_id as lid,l.leaguename,t1.teamname as Home,t2.teamname as Away
			FROM history_".$cmainyear." as d
		        LEFT join bodies as b on b.body_id=d.body_id 
		        LEFT join goalplus as g on g.goalplus_id=d.goalplus_id 
		        inner join timetable as t on t.timetableid=d.timetableid 
		        inner join leagues as l on t.league_id=l.league_id 
		        inner join teams as t1 on t1.team_id=t.home 
		        inner join teams as t2 on t2.team_id=t.away
		        LEFT join bio on bio.bio_id=d.bio_id
		        LEFT join gio on gio.gio_id=d.gio_id
		        LEFT JOIN bs_gs as bsgs1 ON bsgs1.bs_gs_id=d.bs
		        LEFT JOIN bs_gs as bsgs2 ON bsgs2.bs_gs_id=d.gs
		        LEFT join io on io.io_id=d.io_id
		        LEFT JOIN accbodies on accbodies.accbody_id=d.accbody_id
		        LEFT JOIN accgoal on accgoal.accgoal_id=d.accgoal_id
		        WHERE d.recordstatus=1 AND t.recordstatus=1 AND d.timetableid = $hisid";
		$res1 = mysqli_query($connect,$sql1)or die("Error in query ".$sql1);
		if (mysqli_num_rows($res1)<1) {
			$allhistory = "No Record";
		}
		else{
			while ($dd = mysqli_fetch_assoc($res1)) {
				$allhistory[] = $dd;
			}
		}
		$data = array("allhistory"=>$allhistory);
		print json_encode($data);
	}
	elseif ($table == "agentuserlist") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$mid = mysqli_real_escape_string($connect,$data->mid);

		$sql1 = "SELECT members.*
			FROM agent_member
            		INNER JOIN members ON members.member_id=agent_member.member_id
			INNER JOIN agents ON agents.agent_id = agent_member.agent_id
			WHERE agents.member_id=$mid AND members.recordstatus=1";
		$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		if (mysqli_num_rows($res1)<1) {
			$agentuserlist = "No Record";
		}
		else{
			while ($a = mysqli_fetch_assoc($res1)) {
				$agentuserlist[] = $a;
			}
		}

		$sql2 = "SELECT onoff_id FROM onoff WHERE member_id=$mid AND onofftype='agentonoff'";
		$res2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
		if (mysqli_num_rows($res2)<1) {
			$agentonoff = "on";
		}
		else{
			$agentonoff = "off";
		}

		$data = array("agentuserlist"=>$agentuserlist, "agentonoff"=>$agentonoff);
		print json_encode($data);
	}
	elseif ($table == "agentuserbet") {
		$btn = mysqli_real_escape_string($connect,$data->btn);
		$mbrid = mysqli_real_escape_string($connect,$data->mbrid);
		$agid = mysqli_real_escape_string($connect,$data->agid);
		$datefilter = mysqli_real_escape_string($connect,$data->datefilter);

		if ($datefilter == "") {
			$datefilter = $today;
		}

		/*$sql1 = "SELECT * FROM mledger_".$cmainyear." 		
		INNER JOIN agent_member ON agent_member.member_id = mledger_".$cmainyear.".member_id
		WHERE agent_member.member_id = $mbrid AND agent_member.agent_id = $agid 
		AND STR_TO_DATE(mledger_".$cmainyear.".bet_date, '%m-%d-%Y') between STR_TO_DATE('".$week."', '%m-%d-%Y') and STR_TO_DATE('".$tomorrow."', '%m-%d-%Y')
		ORDER BY STR_TO_DATE(mledger_".$cmainyear.".bet_time, '%h:%i:%s%p') DESC";*/
		
		if ($btn == "bg") {
			$sql1 = "SELECT a.*,agent_commission.commission_amt,
			(CASE WHEN a.bet like '%Goal+%' THEN g.goalname ELSE b.bodyname END) AS bgname, 
			(CASE WHEN a.bet like '%Goal+%' THEN his.goalplus_value ELSE his.body_value END) AS bgval, 
			(CASE a.status_id WHEN 1 THEN 'wgn' WHEN 2 THEN 'yw' WHEN 3 THEN 'rd' WHEN 4 THEN 'lrd' WHEN 6 THEN 'gn' ELSE 'df' END) as sname,
			(CASE WHEN ((a.result_amount)>=0) THEN 'p' ELSE 'minus' END) as numformat,
			 a.org_amount as oramount,
			 a.member_id,
	                       a.bet_date as dates,
	                       a.bet_time as time,
	                       m.username,
	                       a.net_amount as turnover,
	                       a.result_amount as wl,
	                       a.bet_amount as betamount,
	                       a.status_id as state_id,
	                       status.description as statusdes,
	                       bs_gs.description as betstatedes,
	                       lg.leaguename, 
	                       h.teamname as hometeam,
	                       d.score,
	                       aw.teamname as awayteam,
	                       (CASE a.bet_on WHEN 'Home' THEN his.hper WHEN 'Away' THEN his.aper WHEN 'Over' THEN his.uper WHEN 'Down' THEN his.dper END) as percent
			 from mledger_".$cmainyear." as a 
			 LEFT JOIN status on a.status_id=status.status_id
			 LEFT JOIN bs_gs on a.betstateid=bs_gs.bs_gs_id
			 LEFT JOIN dashboard_".$cmainyear." as d on a.dashboard_id=d.dashboard_id
			 INNER JOIN timetable as t on t.timetableid=d.timetableid
			 LEFT JOIN leagues as lg on t.league_id=lg.league_id
			 LEFT JOIN teams as h on t.home=h.team_id
			 LEFT JOIN teams as aw on t.away=aw.team_id
			 LEFT JOIN history_".$cmainyear." as his on a.history_id = his.history_id
			 LEFT JOIN bodies as b on his.body_id=b.body_id
			 LEFT JOIN goalplus as g on his.goalplus_id=g.goalplus_id
			 LEFT JOIN agent_commission ON agent_commission.ledger_id=a.mledger_id
			  inner join agents on agents.agent_id =agent_commission.agent_id 
			  inner join members as mbr on mbr.member_id =agents.member_id
			 INNER JOIN members as m on a.member_id=m.member_id WHERE a.member_id=$mbrid 
			AND agent_commission.agent_id = $agid AND agent_commission.bet_type='bg'
			 AND a.bet_date= '$datefilter'
			 ORDER BY STR_TO_DATE(a.bet_date, '%m-%d-%Y') DESC, STR_TO_DATE(a.bet_time, '%h:%i:%s%p') DESC";

			$res1 = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
			if (mysqli_num_rows($res1)<1) {
				$mledgerlist = "No Record";
			}
			else{
				while ($a = mysqli_fetch_assoc($res1)) {
					$mledgerlist[] = $a;
				}
			}
			$data = array("betlist"=>$mledgerlist);
		}
		elseif ($btn == "mix") {
			$sql2 = "SELECT agent_commission.commission_amt, members.username,bg.description as bgdescription, a.member_id, a.mixledger_id, a.betstateid,
		            dashboard_".$cmainyear.".score, mixledger_detail_".$cmainyear.".bet_on, a.bet_date, 
		            a.bet_time, a.mixledger_id as mid,leagues.league_id as lid, leagues.leaguename, thome.teamname as h,
		            taway.teamname as a,status.*,status1.description as ddescription, status1.status_id as bgstatusid, 
		            a.bet_amount, mix.mixname,mix.mix_id,

		            (CASE a.betstateid 
		            WHEN '2' THEN 'WAITING'
		            WHEN '1' THEN
		            CASE a.accbgid
		            WHEN '0' THEN 'RUNNING'
		            ELSE a.result_amount END
		            ELSE a.result_amount END) AS result_amount, 

		            (CASE a.betstateid 
		            WHEN '2' THEN 'WAITING' 
		            WHEN '1' THEN
		            CASE a.accbgid
		            WHEN '0' THEN 'RUNNING'
		            ELSE a.net_amount END
		            ELSE a.net_amount END) AS net_amount,

			(CASE mixledger_detail_".$cmainyear.".bet_on 
		            WHEN 'home' THEN thome.teamname
		            WHEN 'away' THEN taway.teamname
		            WHEN 'over' THEN 'Over'
		            WHEN 'down' THEN 'Down'
		            ELSE 'None' END) AS bet_on_name,

		            (CASE a.betstateid 
		            WHEN '1' THEN
		            CASE a.accbgid
		            WHEN '0' THEN 'RUNNING'
		            ELSE status.description END
		            ELSE status.description END) AS sdescription

		            FROM mixledger_detail_".$cmainyear." 
		            INNER JOIN mixledger_".$cmainyear." as a ON a.mixledger_id=mixledger_detail_".$cmainyear.".mixledger_id
		            INNER JOIN status on a.status_id=status.status_id 
		            INNER JOIN status as status1 on mixledger_detail_".$cmainyear.".status_id=status1.status_id 
		            INNER JOIN bs_gs as bg on a.betstateid = bg.bs_gs_id
		            INNER JOIN dashboard_".$cmainyear." on mixledger_detail_".$cmainyear.".dashboard_id=dashboard_".$cmainyear.".dashboard_id			
		            INNER JOIN timetable on dashboard_".$cmainyear.".timetableid=timetable.timetableid
		            INNER JOIN leagues on timetable.league_id=leagues.league_id 
		            INNER JOIN teams as thome on thome.team_id=timetable.home
		            INNER JOIN history_".$cmainyear." ON history_".$cmainyear.".history_id=mixledger_detail_".$cmainyear.".history_id
		            LEFT JOIN goalplus on goalplus.goalplus_id = dashboard_".$cmainyear.".goalplus_id 
		            LEFT JOIN bodies on bodies.body_id = dashboard_".$cmainyear.".body_id
		            INNER JOIN members on members.member_id =a.member_id 
		            INNER JOIN teams as taway on taway.team_id=timetable.away 
		            INNER JOIN mix ON mix.mixname=a.mixname
		            LEFT JOIN agent_commission ON agent_commission.ledger_id=a.mixledger_id
			  inner join agents on agents.agent_id =agent_commission.agent_id 
			  inner join members as mbr on mbr.member_id =agents.member_id
		            WHERE a.recordstatus=1 AND a.member_id = $mbrid 
		            AND agent_commission.agent_id = $agid AND agent_commission.bet_type='mix'
		            AND a.bet_date= '$datefilter'
		            ORDER BY STR_TO_DATE(a.bet_time, '%h:%i:%s%p') DESC,mixledger_detail_".$cmainyear.".mixledger_detail_id";

			$res2 = mysqli_query($connect,$sql2)or die("Error in query".$sql2);
			if (mysqli_num_rows($res2)<1) {
				$mixledgerlist = "No Record";
			}
			else{
				while ($a = mysqli_fetch_assoc($res2)) {
					$mixledgerlist[] = $a;
				}
			}
			$data = array("betlist"=>$mixledgerlist);
		}

		print json_encode($data);
	}
	elseif ($table == "usertype") {		
		$btn = mysqli_real_escape_string($connect,$data->btn);
		if ($btn == "save") {
			$tname = mysqli_real_escape_string($connect,$data->typename);
			$userid = mysqli_real_escape_string($connect,$data->userid);
			$totalamt = mysqli_real_escape_string($connect,$data->totalamt);
			$minbet = mysqli_real_escape_string($connect,$data->minbet);
			$maxbet = mysqli_real_escape_string($connect,$data->maxbet);
			$sql = "INSERT INTO usertype(typename, totalamt, minbet, maxbet, recordstatus, userid) 
			VALUES('$tname', $totalamt, $minbet, $maxbet, 1, $userid)";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "delete") {
			$tid = mysqli_real_escape_string($connect,$data->typeid);
			$sql = "UPDATE usertype SET recordstatus=2 WHERE typeid=$tid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		elseif ($btn == "edit") {
			$totalamt = mysqli_real_escape_string($connect,$data->totalamt);
			$minbet = mysqli_real_escape_string($connect,$data->minbet);
			$maxbet = mysqli_real_escape_string($connect,$data->maxbet);
			$tid = mysqli_real_escape_string($connect,$data->typeid);
			$tname = mysqli_real_escape_string($connect,$data->typename);
			$sql = "UPDATE usertype SET typename='$tname',totalamt=$totalamt, minbet=$minbet, maxbet=$maxbet 
			WHERE typeid=$tid";
			mysqli_query($connect,$sql)or die("Error in query".$sql);
		}
		$sql1 = "SELECT * FROM usertype WHERE recordstatus =1 ORDER BY typename";
		$result = mysqli_query($connect,$sql1)or die("Error in query".$sql1);
		while ($a = mysqli_fetch_assoc($result)) {
			$records[] = $a;
		}
		print json_encode($records);
	}
	elseif ($table == "yearchange") {
		$btn = mysqli_real_escape_string($connect,$data->btn);		
		$cuy=date("Y");

		$check = "SELECT currentyear FROM currentyear";
		$checkres = mysqli_query($connect,$check)or die("Error in query".$check);	
		while ($a = mysqli_fetch_assoc($checkres)) {
			$yy = $a["currentyear"];
		}

		if ($cuy == $yy) {
			$ch = true;
		}
		else{
			$ch = false;
		}
		
		if ($btn == "change") {

			$sum = "UPDATE create_table SET win_lose=(SELECT IFNULL((SUM(a.result_amount)*(-1)),0) as amount 
				FROM mledger_".$yy." as a WHERE a.betstateid=1),
			pending=(SELECT IFNULL((SUM(a.bet_amount)),0) as amount FROM mledger_".$yy." as a WHERE a.betstateid=2),
			undefined=(SELECT IFNULL((SUM(a.bet_amount)),0) as amount FROM mledger_".$yy." as a WHERE a.betstateid=1 and a.accbgid=0) 
			WHERE table_name='mledger_".$yy."' AND year=$yy";			
			mysqli_query($connect,$sum)or die("Error in query".$sum);

			$summix = "UPDATE create_table SET win_lose=(SELECT IFNULL((SUM(a.result_amount)*(-1)),0) as amount 
				FROM mixledger_".$yy." as a WHERE a.betstateid=1),
			pending=(SELECT IFNULL((SUM(a.bet_amount)),0) as amount FROM mixledger_".$yy." as a WHERE a.betstateid=2),
			undefined=(SELECT IFNULL((SUM(a.bet_amount)),0) as amount FROM mixledger_".$yy." as a WHERE a.betstateid=1 and a.status_id=6) 
			WHERE table_name='mixledger_".$yy."' AND year=$yy";			
			mysqli_query($connect,$summix)or die("Error in query".$summix);			

			$yyy = intval($yy)+1;
			$dashtbl = "dashboard_".$yyy;
			$yeardash = "CREATE TABLE $dashtbl LIKE dashboard_".$yy;
			mysqli_query($connect,$yeardash)or die("Error in query".$yeardash);

			$mixledgertbl = "mixledger_".$yyy;
			$yearmixledger = "CREATE TABLE $mixledgertbl LIKE mixledger_".$yy;
			mysqli_query($connect,$yearmixledger)or die("Error in query".$yearmixledger);

			$mixdetailtbl = "mixledger_detail_".$yyy;
			$yearmixdetail = "CREATE TABLE $mixdetailtbl LIKE mixledger_detail_".$yy;
			mysqli_query($connect,$yearmixdetail)or die("Error in query".$yearmixdetail);

			$mledgertbl = "mledger_".$yyy;
			$yearmledger = "CREATE TABLE $mledgertbl LIKE mledger_".$yy;
			mysqli_query($connect,$yearmledger)or die("Error in query".$yearmledger);

			$historytbl = "history_".$yyy;
			$yearhistory = "CREATE TABLE $historytbl LIKE history_".$yy;
			mysqli_query($connect,$yearhistory)or die("Error in query".$yearhistory);

			$yearch = "INSERT INTO create_table(table_name,year,user_id,createddate) 
			VALUES('$dashtbl',$yyy,1,'$today'),('$mledgertbl',$yyy,1,'$today'),
			('$mixledgertbl',$yyy,1,'$today'),('$mixdetailtbl',$yyy,1,'$today'),('$historytbl',$yyy,1,'$today')";
			mysqli_query($connect,$yearch)or die("Error in query".$yearch);

			$cuyear = "UPDATE currentyear SET currentyear=$yyy, userid=1, createddate='$today'";
			mysqli_query($connect,$cuyear)or die("Error in query".$cuyear);

			$ch = true;
		}
		$data = array("currentyear"=>$yyy, "change"=>$ch);
		print json_encode($data);
	}
 ?>