  <?php
  	$host="127.0.0.1";
  	//$account="root"; 
      /*$account = "trion";
      $password = "095088114";*/
  	/*$password="mtlaeco@123!";*/
  	//$dbname="trion_football"; 
     //$password="triontech@01042011!";
     //$dbname="football-test";

    $account = "root";
     $password = "nyimalay";
     $dbname = "footballonline";
     
  	$connect=@mysqli_connect($host,$account,$password);    
    @mysqli_query('SET names=utf8');
    @mysqli_query('SET character_set_client=utf8');
    @mysqli_query('SET character_set_connection=utf8');
    @mysqli_query('SET character_set_results=utf8');
    @mysqli_query('SET collation_connection=utf8_unicode_ci');
    @mysqli_select_db($connect,$dbname)or die("Cannot Find Database");
  ?>