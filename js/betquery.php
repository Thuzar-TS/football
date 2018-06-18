<?php 
	session_start();
	include("../connectdb.inc");
	$data = json_decode(file_get_contents("php://input"));
	$btn = mysql_real_escape_string($data->btn);
	if ($btn == "tsave") {
			$tdate = mysql_real_escape_string($data->tdate);		
			$ttime = mysql_real_escape_string($data->ttime);
			$league = mysql_real_escape_string($data->league);
			$hteam = mysql_real_escape_string($data->hteam);
			$ateam = mysql_real_escape_string($data->ateam);

			$sql = "INSERT INTO timetable(tdate,ttime,league,home,away,userid) VALUES('$tdate','$ttime','$league','$hteam','$ateam',1)";
			mysql_query($sql,$connect)or die("Error in query".$sql);
			$sql2 = "SELECT MAX(id) as mid from timetable";
			$res2 = mysql_query($sql2, $connect) or die("Error in query ".$sql2);
			while($r2=mysql_fetch_assoc($res2)){
				$tid = $r2["mid"];
			}
			$sql3 = "INSERT INTO dashboard(timetableid) VALUES($tid)";
			mysql_query($sql3,$connect)or die("Error in query".$sql3);
			//echo "Success";
		}

		elseif ($btn == "betsave") {
			$tid = mysql_real_escape_string($data->tid);		
			$score = mysql_real_escape_string($data->score);
			$bodysl = mysql_real_escape_string($data->bodysl);
			$bodytxt = mysql_real_escape_string($data->bodytxt);
			$hper = mysql_real_escape_string($data->hper);
			$aper = mysql_real_escape_string($data->aper);		
			$goal = mysql_real_escape_string($data->goal);
			$goaltxt = mysql_real_escape_string($data->goaltxt);
			$uper = mysql_real_escape_string($data->uper);
			$dper = mysql_real_escape_string($data->dper);

			$sql1 = "INSERT INTO history(timetableid, score, body, body_value, hper, aper, goalplus, goalplus_value, uper, dper, userid) VALUES($tid, $score, $bodysl, $bodytxt, $hper, $aper, $goal, $goaltxt, $uper, $dper,1)";
			mysql_query($sql1,$connect)or die("Error in query".$sql1);

			$sql1 = "INSERT INTO dashboard(timetableid, score, body, body_value, hper, aper, goalplus, goalplus_value, uper, dper, userid) VALUES($tid, $score, $bodysl, $bodytxt, $hper, $aper, $goal, $goaltxt, $uper, $dper,1)";
			mysql_query($sql1,$connect)or die("Error in query".$sql1);
			//echo "Success";
		}
		$sql1 = "SELECT t.tdate, t.ttime, t.league, t.home as hteam, t.away as ateam, t.id, l.leaguename, t1.teamname as home, t2.teamname as away FROM timetable as t inner join leagues as l on t.league=l.id inner join teams as t1 on t.home=t1.id inner join teams as t2 on t.away=t2.id";
		$result = mysql_query($sql1,$connect)or die("Error in query".$sql1);
		while ($a = mysql_fetch_assoc($result)) {
			$records[] = $a;
		}
		
		print json_encode($records);
?>