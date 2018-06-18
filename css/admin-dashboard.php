<?php
	@session_start();

	$eid=$_SESSION["id"];
	if(isset($_SESSION["id"]) && $_SESSION["id"]!=0){
	include("connectdb.inc");
	$sql1="SELECT employeename FROM employee WHERE employeeid=$eid";
	$res1=mysql_query($sql1, $connect)or die("Error in ".$sql1);
	while($r1=mysql_fetch_assoc($res1)){
		$empname=$r1["employeename"];
	}
}
	else{
		echo "<script>window.location.href='index.php'</script>";
	}
?>
<html>
	<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">	
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
	<script src="js/jquery-ui.js"></script>
	<script>
		$(document).ready(function(){
			$("#fdate").datepicker();
			$("#tdate").datepicker();
			$("#tdate").change(function(){
				var n=$("#ename").val();
				var fd=$("#fdate").val();				
				var td=$("#tdate").val();
				var s=$("#selectbtn").val();
				if(fd==""){
					alert("please fill date");
					$("#tdate").val("");
				}
				else{
				$.get("search.php?fd="+fd+"&&td="+td+"&&s="+s+"&&n="+n, function(retrunData){
					$("#tt").html(retrunData);
				});
				$.get("search1.php?fd="+fd+"&&td="+td+"&&v-xs="+s+"&&n="+n, function(retrunData){
					$("#dashtable-xs").html(retrunData);
					//alert(retrunData);
				});
				}
			});
			$("#fdate").change(function(){
				$("#tdate").val("");
			});
			$("#btnapply").click(function (e) {
    			window.open('data:application/vnd.ms-excel,' +'<table>' +$("#table").html()+ '</table>');
    			e.preventDefault();
			});
			$("#ename").bind('input propertychange', function(){
				var n=$("#ename").val();
				var fd=$("#fdate").val();				
				var td=$("#tdate").val();
				var s=$("#selectbtn").val();
				$.get("search.php?n="+n+"&&fd="+fd+"&&td="+td+"&&s="+s, function(retrunData){
					$("#tt").html(retrunData);
				});
				$.get("search1.php?n="+n+"&&fd="+fd+"&&td="+td+"&&v-xs="+s, function(retrunData){
					$("#dashtable-xs").html(retrunData);
				});
			});	
		});
	</script>
	</head>
	<body>
		<div class="container-fluid">
		<div class="row" style="margin-top: 20px; margin-right: 0;">
		<div class="col-xs-12">
		<a href="admin.php" id="apply2" class="visible-xs col-xs-4">Back</a>
			<a href='logout.php' class='pull-right col-xs-4' id='apply2'>Logout</a>
			</div>
		</div>
		<div class="row" style="margin-top: 20px; margin-right: 0;">
		<div class="col-xs-12 col-sm-2">
			<h5 id="enames"><?php echo $empname;?></h5>
		</div>
		<div class="col-xs-12 col-sm-10 col-md-6 col-md-offset-4 hidden-xs">
		<button class="col-sm-3" id="btnapply">Report</button>
		<a href="changepassword.php" class="col-sm-3" id="apply">Change password</a>
		<a href="leave.php" class="col-sm-3" id="apply">Apply Leave</a>
		<a href="admin.php" class="col-sm-3" id="apply">Back</a>
		</div>
		<div class="col-xs-12 visible-xs">
		<a href="changepassword.php"  id="apply2">Change password</a>
		<a href="leave.php"  id="apply2" >Apply Leave</a>
		
		</div>
		</div>
	<!--<div class="col-xs-offset-4 col-xs-8">
		<div class="pull-right col-xs-9 col-sm-5 col-md-2">
		<select name="selectbtn" class="form-control" id="selectbtn">
			<option value="3" selected>All</option>
			<option value="1">Accept</option>
			<option value="2">Reject</option>
			<option value="0">Pending</option>
		</select>
		</div>
		</div>-->
		<div class="row" style="margin-top: 20px; margin-right: 0;" >
		<div class="col-xs-12 col-md-offset-3 col-md-9">
		<div class="col-xs-12 col-sm-3">
			<label class="col-xs-12 col-sm-4">Name</label>
			<div class='col-xs-12 col-sm-8' id="mb">
			<input type='text' id="ename" name='ename' class="form-control">
			</div>
		</div>
		<div class="col-xs-12 col-sm-7">
			<label class="col-xs-12 col-sm-3 control-label" >Leave Date</label>
			<div class='col-xs-12 col-sm-4' id="mb">
			<input type='text' id="fdate" name='fdate' class="form-control">
			</div>
			<label class="col-xs-12 col-sm-1 control-label" style="margin-bottom: 10px;">To</label>
			<div class='col-xs-12 col-sm-4'>
			<input type='text' id="tdate" name='tdate' class="form-control">
			</div>
		</div>
		<div class="col-xs-12 col-sm-2">
		<select name="selectbtn" class="form-control" id="selectbtn">
			<option value="3" selected>All</option>
			<option value="1">Accept</option>
			<option value="2">Reject</option>
			<option value="0">Pending</option>
		</select>
		</div>
		</div>
		</div>
		</div>
		<section id="content" class="col-xs-12 container-fluid">
			<table id="table" class="table table-responsive hidden-xs">
				<thead>
					<td>Name</td>
					<td>Position</td>
					<td>Department</td>
					<td>Leave Type</td>
					<td>Leave Date</td>
					<td>Leave Time</td>
					<td>Description</td>
					<td>Status</td>
				</thead>
				<tbody id="tt">
				<?php
					include("connectdb.inc");
					$sql1="SELECT l.*, f.*, p.*, d.*, y.* FROM employeeleave_header as l INNER JOIN leavetypeformula as f on l.leavetypeid=f.leavetypeid INNER JOIN position as p ON p.positionid=l.positionid INNER JOIN department as d on d.departmentid=l.departmentid INNER JOIN employeeleave_details as y on y.employeeleaveid=l.employeeleaveid ORDER BY l.employeeleaveid DESC";
					$res1=mysql_query($sql1, $connect)or die("Error in sql ". $sql1);
					while($r1=mysql_fetch_assoc($res1)){
						$id=$r1["employeeleaveid"];
						$date=$r1["leavedate"];
						$date=date_create($date);				
						$date=date_format($date,"Y/m/d");
						$a=$r1["accept"];
						if($a==0){
							$sta="Pending";
						}
						elseif($a==1){
							$sta="Accept";
						}
						else{
							$sta="Reject";
						}
						echo "<tr><td>{$r1['employeename']}</td>
						<td>{$r1['positionname']}</td>
						<td>{$r1['departmentname']}</td>
						<td>{$r1['leavetype']}</td>
						<td>{$date}</td>
						<td>{$r1['leavetime']}</td>
						<td>{$r1['description']}</td>
						<td>{$sta}</td>";
					}
				?>
				</tbody>
			</table>
			<table class="table table-responsive col-xs-12 visible-xs" id="table-xs">
				<thead>
					<th style="width: 28%">Name</th>
					<th style="width: 23%">Type</th>
					<th style="width: 12%">Date</th>
					<th style="width: 3%">T</th>					
					<th style="width: 30%">Status</th>
				</thead>
				<tbody id="dashtable-xs">
				<?php
					include("connectdb.inc");
					$sql1="SELECT l.*, f.*, p.*, d.*, y.* FROM employeeleave_header as l INNER JOIN leavetypeformula as f on l.leavetypeid=f.leavetypeid INNER JOIN position as p ON p.positionid=l.positionid INNER JOIN department as d on d.departmentid=l.departmentid INNER JOIN employeeleave_details as y on y.employeeleaveid=l.employeeleaveid ORDER BY l.employeeleaveid DESC";
					$res1=mysql_query($sql1, $connect)or die("Error in sql ". $sql1);
					while($r1=mysql_fetch_assoc($res1)){
						$ltime=$r1['leavetime'];
						if($ltime=="morning"){
							$t="M";
						}
						elseif($ltime=="afternoon"){
							$t="AF";
						}
						else{
							$t="F";
						}
						$a=$r1["accept"];
						if($a==0){
							$sta="Pending";
						}
						elseif($a==1){
							$sta="Accept";
						}
						else{
							$sta="Reject";
						}
						$date=$r1["leavedate"];
						$date=date_create($date);
						$date=date_format($date,"Y/m/d");
						echo "<tr><td>{$r1['employeename']}</td>
						<td>{$r1['leavetype']}</td>
						<td>{$date}</td>
						<td>{$t}</td>
						<td>{$sta}</td>";
					}
				?>
				</tbody>
			</table>
			<div class="col-xs-12 visible-xs">
			<h3 class="col-xs-12">Note that :</h3>
			<p class="col-xs-12">T -> Time</p>
			<p class="col-xs-12">M -> Morning</p>
			<p class="col-xs-12">AF -> Afternoon</p>
			<p class="col-xs-12">F -> All Day</p>
			</div>
		</section>
	</body>
	<script type="text/javascript">
		 $(document).ready(function() { 
			$("#selectbtn").change(function(){
				var s=$("#selectbtn").val();
				var fd=$("#fdate").val();
				var td=$("#tdate").val();
				var n=$("#ename").val();
				if(td==""){
					if(fd==""){
						$.get("search.php?fd="+fd+"&&td="+td+"&&s="+s+"&&n="+n, function(retrunData){
						$("#tt").html(retrunData);
						});
						$.get("search1.php?n="+n+"&&fd="+fd+"&&td="+td+"&&v-xs="+s, function(retrunData){
						$("#dashtable-xs").html(retrunData);
						});
					}
					else{
					alert("Please fill date");
					exit();
					}
				}
				else{
				$.get("search.php?fd="+fd+"&&td="+td+"&&s="+s+"&&n="+n, function(retrunData){
					$("#tt").html(retrunData);
				});
				$.get("search1.php?n="+n+"&&fd="+fd+"&&td="+td+"&&v-xs="+s, function(retrunData){
					$("#dashtable-xs").html(retrunData);
				});
				}
			});
		});
	</script>
</html>