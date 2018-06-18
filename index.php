<?php 
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>MMWBET</title>

	 <script src="lib/jquery-1.12.4.js"></script>
	 <script src="lib/jquery.min.js"></script>
	  <script src="lib/jquery-ui.js"></script>
	  <script src="lib/jquery-ui-timepicker-addon.js"></script>   
	  <script src="lib/angular.min.js"></script>
	  <script src="lib/angular.route.js"></script>
	  <script src="lib/angular-sanitize.js"></script>   
	  <script src="lib/angular-filter.js"></script>  
	  <!-- <script src="lib/angular-messages.js"></script> -->
	  <script src="lib/angular-messages-min.js"></script>
	  <script src='lib/textAngular-sanitize.min.js'></script>
	  <script src='lib/textAngular.min.js'></script>
	  <script src="lib/bootstrap.min.js"></script>	    
	  <script src="js/side.js"></script>
	  <script src="js/app.js"></script>    
	  <script src="js/controller.js"></script>
	  <!-- <script src="js/controllernew.js"></script> -->
	  <script src='lib/textAngular-sanitize.min.js'></script>
	  <script src='lib/textAngular.min.js'></script>
	  <script src='lib/angular-md5.js'></script>
	  

	  <link rel="shortcut icon" href="images/favicon2.ico"/>
	   <link rel="stylesheet" href="css/w3.css">
	    <link rel="stylesheet" href="css/jquery-ui.css">
	    <link href="css/bootstrap.min.css" rel="stylesheet">   
	    <!-- <link href="css/bootstrap-theme.css" rel="stylesheet"> -->
	    <link href="css/font-awesome.min.css" rel="stylesheet" /> 
	    <link rel="stylesheet" href="css/style.css">
	    <link rel="stylesheet" href="css/style-onoff.css">
	    <link rel="stylesheet" href="css/jquery-ui-timepicker-addon.css">
	    <link rel="stylesheet" href="css/side.css">

</head>
<body ng-app="myApp" id="main">
 <!-- <div id="black-overlay" class="col-xs-12 pad-free"></div> -->
 <div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
<section id="bunner" class="container-fluid">			
	<h1 class="col-sm-2 col-sm-offset-5 pad-free"><img src="images/newlogo.png" alt="" style="width:40px;">&nbsp; MMWBET</h1>
</section>
<article class="wrapper" id="wrapper" >
	<!-- <a class="menu-toggle" href="#/"><span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a> -->
	
	<nav class='navbar navbar-default container-fluid' role='navigation'>
	<div id="sidebar-wrapper">
	      <ul id="adminmenu" class="sidebar-nav">
	           <li class="sidebar-brand"><a class="menu-toggle">MMWBET<span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a></li>
	          <li><a href="#accdash/" class="menu-toggle">HOME<span class="sub_icon glyphicon glyphicon-link" ></span></a></li>
	          <li><a href="#mledger/" class="menu-toggle">LEDGER<span class="sub_icon glyphicon glyphicon-link" ></span></a></li>
	          <!-- <li><a href="#commission/" class="menu-toggle">COMMISSION<span class="sub_icon glyphicon glyphicon-link" ></span></a></li> -->
	          <li><a href="#allusr/" class="menu-toggle">ALL USERS<span class="sub_icon glyphicon glyphicon-link" ></span></a></li>
	          <li><a href="#mixbetlist/" class="menu-toggle">MIX BETTING<span class="sub_icon glyphicon glyphicon-link" ></span></a></li>
	          <li><a  id="btn" data-toggle="collapse" data-target="#submenu" expended="true">SETUP<span class="sub_icon glyphicon glyphicon-link"></span></a>
		            <ul id="submenu" role="menu" aria-labelledby="btn">
			            <li><a href='#team/' class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;TEAM</a></li> 
			            <li><a href="#bank/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;BANK</a></li>
			            <li><a href="#bankhistory/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;BANK CARD</a></li>
			            <li><a href="#league/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;LEAGUE</a></li>
			            <li><a href="#goal/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;GOAL&nbsp;+</a></li>
			            <li><a href="#body/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;BODY</a></li>
			            <li><a href="#accgoal/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;GOAL FORMULA</a></li>
			            <li><a href="#accbody/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;BODY FORMULA</a></li>
			            <li><a href="#mix/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;MIX</a></li>
			            <!-- <li><a href="#member/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;MEMBER</a></li> -->
			            <li><a href="#user/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;USER</a></li>
			            <li><a href="#usertypesetup/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;USER TYPE</a></li>
			            <li><a href="#timetable/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;TIMETABLE</a></li>
			            <li><a href="#depositelimit/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;DEPOSIT LIMIT</a></li>
			            <li><a href="#withdrawlimit/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;WITHDRAW LIMIT</a></li>
			            <li><a href="#transferlimit/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;TRANSFER LIMIT</a></li>
			            <li><a href="#term/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;T and C Setup</a></li>
			            <li><a href="#infosetup/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;INFORMATION Setup</a></li>
			            <li><a href="#yearchange/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;YEAR CHANGE</a></li>
		            </ul>
	          </li>
	          <li><a href="#info/" class="menu-toggle">INFORMATION<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href="#tandc/" class="menu-toggle">TERMS & CONDITION<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href='#/' class="menu-toggle">USERS HOME<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href='#backupdata/' class="menu-toggle">BACKUP DATA<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href='#resetpass/' class="menu-toggle">RESET PASSWORD<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href='#cputest/' class="menu-toggle">SERVER INFO<span class="sub_icon glyphicon glyphicon-link"></span></a></li>            
	          <li><a href='#logout/' class="menu-toggle">LOGOUT<span class="sub_icon glyphicon glyphicon-link"></span></a></li>	          
	        </ul>

	        <ul id="accmenu" class="sidebar-nav">
	           <li class="sidebar-brand"><a class="menu-toggle">MMWBET<span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a></li>
	          <li><a href="#accdash/" class="menu-toggle">HOME<span class="sub_icon glyphicon glyphicon-link" ></span></a></li>
	          <li><a href="#mledger/" class="menu-toggle">LEDGER<span class="sub_icon glyphicon glyphicon-link" ></span></a></li>
	          <!-- <li><a href="#commission/" class="menu-toggle">COMMISSION<span class="sub_icon glyphicon glyphicon-link" ></span></a></li> -->
	          <li><a href="#allusr/" class="menu-toggle">ALL USERS<span class="sub_icon glyphicon glyphicon-link" ></span></a></li>
	          <li><a  id="btn" data-toggle="collapse" data-target="#submenu" expended="true">SETUP<span class="sub_icon glyphicon glyphicon-link"></span></a>
    		            <ul id="submenu" role="menu" aria-labelledby="btn">
    			            <li><a href='#team/' class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;TEAM</a></li> 
    			            <li><a href="#league/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;LEAGUE</a></li>
    			            <li><a href="#goal/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;GOAL&nbsp;+</a></li>
    			            <li><a href="#body/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;BODY</a></li>			          
    			            <li><a href="#timetable/" class="menu-toggle"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;TIMETABLE</a></li>
    		            </ul>
	          </li>
	          <li><a href="#info/" class="menu-toggle">INFORMATION<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href="#tandc/" class="menu-toggle">TERMS & CONDITION<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href='#/' class="menu-toggle">USERS HOME<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href='#logout/' class="menu-toggle">LOGOUT<span class="sub_icon glyphicon glyphicon-link"></span></a></li>	          
	        </ul>

	        <ul id="mmenu" class="sidebar-nav">
	           <li class="sidebar-brand"><a class="menu-toggle">MMWBET<span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a></li>
	          <li><a href="#/" class="menu-toggle">HOME<span class="sub_icon glyphicon glyphicon-link" ></span></a></li>
	          <li><a href='#profile/' class="menu-toggle">PROFILE<span class="sub_icon glyphicon glyphicon-link" ></span></a></li>
	          <li><a href='#mhome/' class="menu-toggle">ALL BET<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href="#mledger/" class="menu-toggle">YOUR LEDGERS<span class="sub_icon glyphicon glyphicon-link" ></span></a></li> 
	          <!-- <li ng-show="commenu"><a href="#commission/" class="menu-toggle">COMMISSION<span class="sub_icon glyphicon glyphicon-link" ></span></a></li>   -->
	           <li><a href="#info/" class="menu-toggle">INFORMATION<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href="#tandc/" class="menu-toggle">TERMS & CONDITION<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	          <li><a href='#logout/' class="menu-toggle">LOGOUT<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
	        </ul>
	      </div>
	  
	</nav>

	
</article>
<!-- <nav class='navbar navbar-default container-fluid visible-xs' id='nav-xs' role='navigation' id="menu">
	    <div class='row'>
	    
	    <div class='navbar-header' id="header">
	       <button type='button' class='navbar-toggle' data-target='#navbar-data1' id="mmicon">
	        <span class='sr-only'>Toggle navigation</span>
	        <span class='icon-bar'></span>
	        <span class='icon-bar'></span>
	        <span class='icon-bar'></span>
	      </button>
	      <a class='navbar-brand' id='h-color' href='#/'>FOOTBALL BET</a>
	    </div> 

	    <div class="collapse navbar-collapse pad-free" id="navbar-data1">
		<ul class="nav navbar-nav col-sm-12 pad-free adminmenu"  id="page-nav-bar">
	    	 <li><a href="#accdash/" class=" active">HOME</a></li>
	    	 <li><a href="#mledger/" class=" active">LEDGERS</a></li>
	        	<li><a class="dropdown-toggle" data-toggle="dropdown">SETUP<span class="caret"></a>
			<ul class="dropdown-menu">
		               <li><a href="#team/">&raquo;  &nbsp; TEAM</a></li>
		               <li><a href="#bank/">&raquo;  &nbsp; BANK</a></li>
		               <li><a href="#bankhistory/">&raquo;  &nbsp; BANK CARD</a></li>
		               <li><a href="#league/">&raquo;  &nbsp; LEAGUE</a></li>
		               <li><a href="#goal/">&raquo;  &nbsp; GOAL +</a></li>
		               <li><a href="#body/">&raquo;  &nbsp; BODY</a></li>
		               <li><a href="#accgoal/">&raquo;  &nbsp; GOAL FORMULA</a></li>
		               <li><a href="#accbody/">&raquo;  &nbsp; BODY FORMULA</a></li>
		               <li><a href="#user/">&raquo;  &nbsp; USER</a></li>
		               <li><a href="#timetable/">&raquo;  &nbsp; TIMETABLE</a></li>
		               <li><a href="#term/">&raquo;  &nbsp; T & C Setup</a></li>
		           </ul>
	        	</li>
		
	        	<li><a href="#tandc/">TERMS & CONDITIONS</a></li>				
		<li><a href="#/">USERS HOME</a></li>
	        	<li><a href="#logout/">LOGOUT</a></li>
		</ul>

		<ul class="nav navbar-nav col-sm-12 pad-free mmenu"  id="page-nav-bar">
			<li><a href="#/" class="phmenu-toggle">HOME</a></li>				
			<li><a href="#mledger/" class="phmenu-toggle">YOUR LEDGERS</a></li>
		        	<li><a href="#profile/" class="phmenu-toggle">PROFILE</a></li>
		        	<li><a style="#mhome/" class="phmenu-toggle">ALL BET</a></li>				
			<li><a href="#logout/" class="phmenu-toggle">LOGOUT</a></li>
		</ul>		
	</div>	
</div>
</nav> -->
	<div class="container-fluid pad-free" ng-view style="padding-left:40px; padding-right:5px;"></div>
</body>
</html>