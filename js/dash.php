<div class="row main-frame">

<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
	<div class="col-xs-12 col-sm-4 col-md-2" id="login">
	
	<form class="form-horizontal col-xs-12 col-sm-10 col-sm-offset-1 pad-free" role="form" id="loginForm">      
	    <div class="form-group">
	        <div class="col-xs-12">
	            <input type="mail" ng-model="username" placeholder="UserID" class="form-control" ng-required> 
	        </div>            
	    </div>
	    <div class="form-group">
	        <div class="col-xs-12">
	            <input type="password" ng-model="password" placeholder="Password" class="form-control" ng-required> 
	            <p style="color:red;">{{errorTxt}}</p>
	        </div>   
	    </div>
	
	    <div class="form-group">
	    <div class="col-xs-12 col-sm-offset-3 col-sm-6">
	            <input type="submit" ng-click='login()' value="Login" class="form-control btn all-btn">
	    </div>
	    
	    </div>
	    <div class="form-group" style="margin-top:30px;">
	    	<div class="col-xs-12" style="text-align:center;">
	    	<a href="#mcreate">Create New Member</a>
	    	</div>
	    </div>
	    
	</form>
	</div>

<div class="col-xs-12 col-sm-8 col-md-10" id="dashsection">

<div class="col-xs-12 col-sm-5 pull-right" ng-show="onlyhome">
	<div class="col-xs-12 col-sm-6">
		<label>Welcome </label>&nbsp;&nbsp;<label style="color:blue;">: &nbsp;{{mbrname}}</label>
	</div>
	<div class="col-xs-12 col-sm-6 pad-free">
		<label>Your Balance : </label><label style="color:blue;">&nbsp;{{total | number : fractionSize}}</label> ks
	</div>	
</div>

	<div class="col-xs-12">
		<table class="table table-responsive table-bordered table-striped">
			<tr>
				<th ng-show="act">Bet on body</th>	
				<th ng-show="act">Bet on goal</th>	
				<th>Date</th>
				<th>Time</th>
				<th>League</th>
				<th>Match</th>
				<th>Score</th>
				
				<th>Body</th>
				<th>H%</th>
				<th>A%</th>
				<th>Goal +</th>
				<th>U%</th>
				<th>D%</th>
							
			</tr>

			<tr ng-repeat="x in dashes">
				<td  ng-show="actbetimg" ng-if="x.bio_id !=4"><img src="images/bet1.png" ng-click='actbetbody(x.dashboard_id, x)' style="cursor:pointer; width:25px;"></td>
				<td  ng-show="actbetimg" ng-if="x.bio_id ==4" style="color:red">Close Betting</td>
				<td  ng-show="actbetimg" ng-if="x.gio_id !=4"><img src="images/bet1.png" ng-click='actbetgoal(x.dashboard_id, x)' style="cursor:pointer; width:25px;"></td>
				<td  ng-show="actbetimg" ng-if="x.gio_id ==4" style="color:red">Close Betting</td>
	      			<td>{{x.tdate}}</td>
				<td>{{x.ttime}}</td>
				<td>{{x.leaguename}}</td>
				<td><label class="{{x.bodygoal}}">{{x.Home}}</label> & <label class="{{x.goalbody}}">{{x.Away}}</label></td>
				<td>{{x.score}}</td>
				
				<td>{{x.bodyname}}&nbsp;[{{x.body_value}}]</td>
				
				<td class="{{x.hclassname}}">{{x.hper}}</td>
				<td class="{{x.aclassname}}">{{x.aper}}</td>
				<td>{{x.goalname}}&nbsp;[{{x.goalplus_value}}]</td>
				
				<td class="{{x.uclassname}}">{{x.uper}}</td>
				<td class="{{x.dclassname}}">{{x.dper}}</td>
								
			</tr>
		</table>

	</div>

</div>
<div id="dashedit" class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8" style="top:50px;">
<div class="col-xs-12" style="margin-top:10px; margin-bottom: 50px;">

		<form class="col-xs-12" ng-show="betbody" name="myForm1">
			<div class="form-group">
				<h1 id="allh3" class="col-xs-12">Bet for Body</h1>
			</div>
			<div ng-if="warning!=1" class="col-xs-12" style="font-size:1.5em; font-weight:bold;text-align:center;">You can Bet only <label style="color:red;">{{warning | number : fractionSize}}</label> ks</div>
			<div ng-if="warning==1"  class="col-xs-12" style="font-size:1.5em; font-weight:bold; color:red; text-align:center;">Bet limit amount : <label style="color:red;">{{blimitamt | number : fractionSize}}</label> ks</div>
			<div class="col-sm-offset-1 col-sm-10" style="margin-top: 10px; margin-bottom: 10px;">
			<label class="col-xs-12 col-sm-6" style="margin-bottom: 15px;" id="homediv" for="homeradio" ng-mouseover="hoverh()" ng-mouseleave="leaveh()" ng-show="biohshow">

			<div class="form-group row">
				<h4 class="col-xs-6">Date:: </h4><h4 class="col-xs-6">{{tdate}}</h4>				
			</div>
			<div class="form-group row">
				<h4 class="col-xs-6">Body Name:: </h4><h4 class="col-xs-6">{{bodyname}}</h4>
			</div>
			<div class="form-group row">
				<h4 class="col-xs-6">Home:: </h4><h4 class="col-xs-6">{{Home}}</h4>
			</div>
			<div class="form-group row">
				<h4 class="col-xs-6">Home(%):: </h4><h4 class="col-xs-6">{{hper}}%</h4>
			</div>
			<div class="form-group">
				<div class="col-xs-offset-5 col-xs-5">
					<input type="radio" name="cteam" id="homeradio" ng-model="cteam" value="Home">
				</div>
			</div>
			</label>
			
	              	
	              	<label class="col-xs-12 col-sm-6" style="margin-bottom: 15px;" for="awayradio" id="awaydiv" ng-mouseover="hovera()" ng-mouseleave="leavea()" ng-show="bioashow">
	              	<div class="form-group row">
	              		<h4 class="col-xs-6">Time:: </h4><h4 class="col-xs-6">{{ttime}}</h4>
	              	</div>
	              	<div class="form-group row">
				<h4 class="col-xs-6">Body(%)::</h4><h4 class="col-xs-6">{{body_value}}%</h4>
			</div>
	              	<div class="form-group row">
	              		<h4 class="col-xs-6">Away:: </h4><h4 class="col-xs-6">{{Away}}</h4>
	              	</div>
	              	<div class="form-group row">
				<h4 class="col-xs-6">Away(%):: </h4><h4 class="col-xs-6">{{aper}}%</h4>
			</div>
			<div class="form-group">
				<div class="col-xs-offset-5 col-xs-5">
					<input type="radio" name="cteam" id="awayradio" ng-model="cteam" value="Away">
				</div>
			</div>
	              	</label>
	              	<div class="col-xs-12 col-sm-6">
	              	<div class="form-group">			
			
				<input type="number" ng-model="amount" name="amount" class="form-control" placeholder="Amount" min="0" value="0">	
				<span ng-show="myForm1.amount.$valid==false" style="color:red;">Bet Amount Invalid !</span>
			</div>
			</div>
			<div class="col-xs-6 col-sm-2 col-sm-offset-2">
	              		<input type="button" ng-click='betmember(betid)' class="form-control btn all-btn" name="submit" value="Bet" ng-disabled="myForm1.amount.$valid==false?true:false">
	              		<!-- <span style="color:red;">Double Click</span> -->
	              	</div>
	              	<div class="col-xs-6 col-sm-2">
	              		<input type="button" value="Close" ng-click="bDone()" style="cursor:pointer;" class="form-control btn all-btn">
	              	</div>
	              	</div>
	              	<div class="col-xs-12" style="font-weight:bold; color:red; text-align:center;">{{errormsg}}</div>
	              	
		</form>
		<form class="col-xs-12" ng-show="betgoal" name="myForm">
			<div class="form-group">
				<h1 id="allh3" class="col-xs-12">Bet for Goal</h1>
			</div>
			<div ng-if="warning!=1" class="col-xs-12" style="font-size:1.5em; font-weight:bold;text-align:center;">You can Bet only <label style="color:red;">{{warning | number : fractionSize}}</label> ks</div>
			<div ng-if="warning==1" class="col-xs-12" style="font-size:1.5em; font-weight:bold; color:red; text-align:center;">Bet limit amount : <label style="color:red;">{{glimitamt | number : fractionSize}}</label> ks</div>
			<div class="col-sm-offset-1 col-sm-10" style="margin-top: 10px; margin-bottom: 10px;">
			<label class="col-xs-12 col-sm-6" style="margin-bottom: 15px;" id="overdiv" for="overradio" ng-mouseover="hovero()" ng-mouseleave="leaveo()" ng-show="gioOshow">
			<div class="form-group row">
				<h4 class="col-xs-6">Date:: </h4><h4 class="col-xs-6">{{tdate}}</h4>
				
			</div>
			<div class="form-group row">
				<h4 class="col-xs-6">Goal Name:: </h4><h4 class="col-xs-6">{{goalname}}</h4>
			</div>
			
			<div class="form-group row">
				<h4 class="col-xs-6">Over(%):: </h4><h4 class="col-xs-6">{{oper}}%</h4>
			</div>
			<div class="form-group row">
				<div class="col-xs-offset-5 col-xs-5">
					<input type="radio" name="cteam" id="overradio" ng-model="cteam" value="Over">
				</div>
			</div>
			</label>
			
	              	
	              	<label class="col-xs-12 col-xs-6" style="margin-bottom: 15px;" for="downradio" id="downdiv" ng-mouseover="hoverd()" ng-mouseleave="leaved()" ng-show="gioDshow">
	              	<div class="form-group row">
	              		<h4 class="col-xs-6">Time:: </h4><h4 class="col-xs-6">{{ttime}}</h4>
	              	</div>
	              	<div class="form-group row">
				<h4 class="col-xs-6">Goal(%)::</h4><h4 class="col-xs-6">{{goal_value}}%</h4>
			</div>
	              	<div class="form-group row">
				<h4 class="col-xs-6">Down(%):: </h4><h4 class="col-xs-6">{{dper}}%</h4>
			</div>
			<div class="form-group row">
				<div class="col-xs-offset-5 col-xs-5">
					<input type="radio" name="cteam" id="downradio" ng-model="cteam" value="Down">
				</div>
			</div>
	              	</label>
	              	<div class="col-xs-12 col-sm-6">
	              	<div class="form-group">				
				<input type="number" ng-model="amount" name="amount" class="form-control" placeholder="Amount" min="0" value="0">	
				<span ng-show="myForm.amount.$valid==false" style="color:red;">Bet Amount Invalid !</span>
			</div>
			</div>
			<div class="col-xs-6 col-sm-2 col-sm-offset-2">
	              		<input type="button" ng-click='betmember(betid)' class="form-control btn all-btn" name="submit" value="Bet" ng-disabled="myForm.amount.$valid==false?true:false">
	              		<!-- <span style="color:red;">Double Click</span> -->
	              	</div>
	              	<div class="col-xs-6 col-sm-2">
	              		<input type="button" value="Close" ng-click="bDone()" style="cursor:pointer;" class="form-control btn all-btn">
	              	</div>
	              	</div>
	              	<div class="col-xs-12" style="font-weight:bold; color:red; text-align:center;">{{errormsg}}</div>
	              	
		</form>
	</div>	
	</div>
</div>