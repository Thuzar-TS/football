<?php 
$data = json_decode(file_get_contents("php://input"));
//$aaa = mysql_real_escape_string($data->ddd);

backup_tables('localhost','thiha','triontech@01042011!','trion_football',$data->ddd);
//backup_tables('localhost','root','nyimalay','auth_testing',$db);
//print json_encode($data->ddd);
/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$db)
{
	$tables = '*';
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	$return = "";
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	

	$backupfile = $db;
	//$extension = "sql";
	$handel = fopen($backupfile,'w+');
	fwrite($handel,$return);
	fclose($handel);

	//include("download1.php");
	print json_encode($db);
}
 ?>