<?php 

include("connectdb.inc");
include("date.php");
$data = json_decode(file_get_contents("php://input"));
$table = mysql_real_escape_string($data->type);

$numCpus = 0;
exec ("cat /proc/cpuinfo", $details);
$searchcore = "cpu cores";
$searchmodel = "model name";
  foreach ($details as $key => $v) {
    if(preg_match("/\b$searchcore\b/i", $v)) {      
      $numCpus++;
    }
    if(preg_match("/\b$searchmodel\b/i", $v)) {      
      $modelname = $v;
    }    
   }
$mm = explode(":",$modelname);

/*echo "
<table style='border:1px solid #ccc; width:70%;margin:auto;'>
<tr>
<th>Model Name</th>
<th>=></th>
<th>$mm[1]</th>
</tr>
<tr>
<th>CPU cores</th>
<th>=></th>
<th>$numCpus</th>
</tr>
</table>
";*/
//echo $numCpus;


exec('uptime', $retval); // uptime should give the CPU usage. 
foreach ($retval as $key => $v) {
  $load = $v;
 // echo "<label style='color:green; font-weight:bold; font-size:1.5em;'>CPU usage</label> => <label style='color:orange; font-weight:bold; font-size:1.5em;'>$v</label>";
}
$aa = explode(",", $load);
unset($aa[0]);
unset($aa[1]);
unset($aa[2]);
$bb = implode(",", $aa);
//print_r($retval);  

$data = array("model"=>$mm[1],"cores"=>$numCpus, "load"=>$bb);
print json_encode($data);
 ?>