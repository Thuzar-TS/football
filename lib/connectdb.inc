  <?php
  	$host="127.0.0.1";
  	$account="thiha"; 
      /*$account = "trion";
      $password = "095088114";*/
  	/*$password="mtlaeco@123!";*/
  	$dbname="trion_football"; 
     $password="triontech@01042011!";
     //$dbname="football-test";
  	$connect=@mysql_connect($host,$account,$password);  	
  	@mysql_query('SET names=utf8');
  	@mysql_query('SET character_set_client=utf8');
  	@mysql_query('SET character_set_connection=utf8');
  	@mysql_query('SET character_set_results=utf8');
  	@mysql_query('SET collation_connection=utf8_unicode_ci');
  	@mysql_select_db($dbname,$connect)or die("Cannot Find Database");
  ?>