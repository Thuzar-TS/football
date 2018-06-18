<div class="row main-frame">

<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
<img class="col-xs-2 col-xs-offset-5" id="img-overlay" style="position:fixed;display:none;" src="images/loading.gif">

<div class="col-xs-4 col-xs-offset-4" style="position:fixed; border:1px solid white;" id="loginerrormsg">
	<p style="color:red; text-align:center; font-weight:bold; padding:10px; margin-bottom:15px;">{{errorTxt}}</p>
	<div class="col-xs-4 col-xs-offset-4">
		<button class="btn col-xs-12 blu-btn" ng-click="closefun()">Close</button>
	</div>
</div>

<div class="col-xs-4 col-xs-offset-4" style="position:fixed; border:1px solid white; display:none;" id="logincode">
	<p style="color:red; text-align:center; font-weight:bold; padding:10px; margin-bottom:15px;">Login Code</p>
	<div class="form-group">
	        <div class="col-xs-12" style="margin-bottom: 15px;">
			<input type="text" ng-model="logincode" placeholder="Your Code Here" class="form-control">
	        </div>
	</div>
	<div class="col-xs-3 col-xs-offset-3">
		<button class="btn col-xs-12 blu-btn" ng-click="sendcode()">Send</button>
	</div>
	<div class="col-xs-3">
		<button class="btn col-xs-12 blu-btn" ng-click="closefun()">Close</button>
	</div>
</div>

<!-- <p style="color:red; text-align:center; font-weight:bold; padding:10px; margin-bottom:15px;">{{errorTxt}}</p> -->
	<div class="col-xs-12 col-sm-4 col-md-2" id="login">

	<form class="form-horizontal col-xs-12 col-sm-10 col-sm-offset-1 pad-free" role="form" id="loginForm">      
	    <div class="form-group">
	        <div class="col-xs-12">
	            <input type="mail" ng-model="username" placeholder="Login ID" class="form-control" ng-required> 
	        </div>            
	    </div>
	    <div class="form-group">
	        <div class="col-xs-12">
	            <input type="password" ng-model="password" placeholder="Password" class="form-control" ng-required> 
	            <!-- <p style="color:red;">{{errorTxt}}</p> -->
	        </div>   
	    </div>
	
	    <div class="form-group">
	    <div class="col-xs-12 col-sm-offset-3 col-sm-6">
	            <input type="submit" ng-click='login()' value="Login" class="form-control btn all-btn">
	    </div>
	    
	    </div>
	    <div class="form-group" style="margin-top:30px;" ng-show="creatembr==false">
	    	<div class="col-xs-12" style="text-align:center;">
	    	<a href="#mcreate">Create New Member</a>
	    	</div>
	    </div>
	    
	</form>
	</div>

<div class="col-xs-12 col-sm-8 col-md-10" id="dashsection">
<div class="col-xs-12 pad-free" ng-show="roleidshow">
<div class="col-sm-2" ng-show="league != 'No Record'" style="margin-bottom:10px;">
	<select ng-model="leagueval" ng-options="aa.leaguename for aa in league track by aa.league_id" class="form-control">
		<option value="">-- Choose League --</option>
	</select>
</div>
<div class="col-sm-2" ng-if="league == 'No Record'" style="margin-bottom:10px;">
	<select ng-model="leagueval1" class="form-control">
		<option value="">-- No League --</option>
	</select>
</div>
<div class="col-sm-2" style="margin-bottom:10px;">
	<select ng-model="homestatus" class="form-control">
		<option value="">-- Betting --</option>
		<option value="1">Open</option>		
		<option value="2">Close</option>
	</select>
</div>
<div class="col-sm-3 pad-free">
	<div class="col-xs-6" ng-show="roleidshow">
		<button ng-click="refreshfun()" class="refresh">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
	</div>
	<div class="col-xs-6 pad-free"  ng-show="onlyhome1" style="margin-bottom:10px;">
		<button ng-click="changemix()" class="refresh" ng-show="changeshow">Mix &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
		<button ng-click="changebg()" class="refresh" ng-show="!changeshow">Body Goal+ &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
	</div>
</div>
</div>
<div class="col-sm-1" ng-show="admbr">
	<button class="refresh col-xs-12 pad-free" ng-click="adminmbr()">Auto &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
</div>


<div class="col-xs-12 col-sm-7 pull-right" ng-show="onlyhome">
	
	<div class="col-xs-12 col-sm-4 pad-free">
		<label>Welcome </label>&nbsp;&nbsp;<label style="color:blue;">: &nbsp;{{mbrname}}</label>
	</div>	
	<div class="col-xs-12 col-sm-4 pad-free">
		<label>Your Balance : </label><label style="color:blue;">&nbsp;{{total | number : fractionSize}}</label> ks
	</div>	
	<div class="col-xs-12 col-sm-4 pad-free">
		<label>Running </label>&nbsp;&nbsp;<label style="color:green;">: &nbsp;{{runningamt | number : fractionSize}}</label> ks
	</div>	
</div>

	<div class="col-xs-12" id="userdash">
	   <div id="homedash">
	   	<table class="table table-responsive table-bordered table-striped">
			<tr>
				<th ng-if="changeshow==true" ng-show="act">Bet on body</th>	
				<th ng-if="changeshow==true" ng-show="act">Bet on goal</th>	
				<th ng-if="changeshow==false"><div class="row">
				<label class="col-sm-5">Mix Betting</label>
				<div class="col-sm-3"><button class="btn bet-btn" ng-click="mixbet()" style="margin-bottom:3px;" ng-if="dashes != 'No Record'">BET</button></div>
				<div class="col-sm-3"><button class="btn bet-btn" ng-click="mixcancelbet()" ng-if="dashes != 'No Record'">RESET</button></div>
				</div></th>	
				<th>Date</th>
				<th>Time</th>
				<th>League</th>
				<th>Match</th>
				<th>Score</th>				
				<th>Body</th>
				<th>Goal +</th>
				<th>H%</th>
				<th>A%</th>				
				<th>O%</th>
				<th>D%</th>
							
			</tr>

			<tr ng-if="dashes == 'No Record'">
				<td> - </td>
				<td> No Record </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td ng-if="changeshow==true" ng-show="act"> - </td>
				<td ng-if="changeshow==true" ng-show="act"> - </td>
				<td ng-if="changeshow==false"> - </td>
			</tr>

			<tr ng-if="mixnorecord == true && mixhide == true">
				<td> - </td>
				<td> No Record </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td ng-if="changeshow==true" ng-show="act"> - </td>
				<td ng-if="changeshow==true" ng-show="act"> - </td>
				<td ng-if="changeshow==false"> - </td>
			</tr>

			<tr ng-if="dashes != 'No Record'" ng-repeat="x in dashes|filter:{leaguename:leagueval.leaguename}|filter:{io_id:homestatus}">
				<td  ng-show="actbetimg" ng-if="x.bio_id !=4 && changeshow==true"><img src="images/bet1.png" ng-click='actbetbody(x.dashboard_id, x)' style="cursor:pointer; width:25px;"></td>
				<td  ng-show="actbetimg" ng-if="x.bio_id ==4 && changeshow==true" style="color:red">Close Betting</td>
				<td  ng-show="actbetimg" ng-if="x.gio_id !=4 && changeshow==true"><img src="images/bet1.png" ng-click='actbetgoal(x.dashboard_id, x)' style="cursor:pointer; width:25px;"></td>
				<td  ng-show="actbetimg" ng-if="x.gio_id ==4 && changeshow==true" style="color:red">Close Betting</td>
				<!-- <td>{{x.dashboard_id}}</td> -->
				<td ng-if="x.mix_on_off ==1 && changeshow==false">
					<label style="cursor:pointer; margin-left:5px;" ng-dblclick="rmradio(x.dashboard_id)" class="{{x.dashboard_id}}">					
						<input type="radio" ng-dblclick="rmradio(x.dashboard_id)" ng-click="hhh(x.dashboard_id,x,'home')" ng-model="mixdiv[x.dashboard_id]" ng-disabled="mixdisabled[x.dashboard_id]" value="Home">&nbsp;Home
					</div>
					</label>
					<label style="cursor:pointer; margin-left:5px;" ng-dblclick="rmradio(x.dashboard_id)" class="{{x.dashboard_id}}">					
						<input type="radio" ng-dblclick="rmradio(x.dashboard_id)" ng-click="hhh(x.dashboard_id,x,'away')" ng-model="mixdiv[x.dashboard_id]" ng-disabled="mixdisabled[x.dashboard_id]" value="Away">&nbsp;Away
					</div>
					</label>
					<label style="cursor:pointer; margin-left:5px;" ng-dblclick="rmradio(x.dashboard_id)" class="{{x.dashboard_id}}">
						<input type="radio" ng-dblclick="rmradio(x.dashboard_id)" ng-click="hhh(x.dashboard_id,x,'over')" ng-model="mixdiv[x.dashboard_id]" ng-disabled="mixdisabled[x.dashboard_id]" value="Over">&nbsp;Over
					</div>
					</label>
					<label style="cursor:pointer; margin-left:5px;" ng-dblclick="rmradio(x.dashboard_id)" class="{{x.dashboard_id}}">
						<input type="radio" ng-dblclick="rmradio(x.dashboard_id)" ng-click="hhh(x.dashboard_id,x,'down')" ng-model="mixdiv[x.dashboard_id]" ng-disabled="mixdisabled[x.dashboard_id]" value="Down">&nbsp;Down
					</div>                                                                                                                  
					</label>
				</td>
				<td ng-if="x.mix_on_off ==0 && changeshow==false" style="color:red">Close Betting</td>			
	      			<td ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true">{{x.tdate}}</td>
				<td ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true">{{x.ttime}}</td>
				<td ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true">{{x.leaguename}}</td>
				<td ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true"><label class="{{x.bodygoal}}">{{x.Home}}</label> & <label class="{{x.goalbody}}">{{x.Away}}</label></td>
				<td ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true">{{x.score}}</td>				
				<td ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true">{{x.bodyname}}&nbsp;[{{x.body_value}}]</td>
				<td ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true">{{x.goalname}}&nbsp;[{{x.goalplus_value}}]</td>
				<td class="{{x.hclassname}}" ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true">{{x.hper}}</td>
				<td class="{{x.aclassname}}" ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true">{{x.aper}}</td>				
				<td class="{{x.uclassname}}" ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true">{{x.uper}}</td>
				<td class="{{x.dclassname}}" ng-show="x.mix_on_off ==2?(mixhide==true?false:true):true">{{x.dper}}</td>								
			</tr>
		</table>
	   </div>
		
	</div>
</div>

	<div id="dashedit" class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8" style="top:50px;">

		<div class="col-xs-12" style="margin-top:10px; margin-bottom: 50px;">

			<form class="col-xs-12" ng-show="betbody" name="myForm1">
				<div class="form-group">
					<h1 id="allh3" class="col-xs-12">Bet for Body</h1>
				</div>
				<div ng-if="warning!=1" class="col-xs-12" style="font-size:1.5em; font-weight:bold;text-align:center;">You can Bet only <label style="color:red;">{{warning | number : fractionSize}}</label> ks</div>
				<!-- <div ng-if="warning==1"  class="col-xs-12" style="font-size:1.5em; font-weight:bold; color:red; text-align:center;">Bet amount between : <label style="color:blue;">{{bless | number : fractionSize}}</label> ks AND <label style="color:blue;">{{blimitamt | number : fractionSize}}</label> ks</div> -->
				<div ng-if="warning==1"  class="col-sm-6 pad-free" style="font-weight:bold; color:red;">Bet Low Limit : <label style="color:blue;">{{bless | number : fractionSize}}</label> ks</div>
				<div ng-if="warning==1"  class="col-sm-6 pad-free hidden-xs" style="font-weight:bold; color:red; text-align:right;">Bet Hight Limit : <label style="color:blue;">{{blimitamt | number : fractionSize}}</label> ks</div>
				<div ng-if="warning==1"  class="col-sm-6 pad-free visible-xs" style="font-weight:bold; color:red;">Bet Hight Limit : <label style="color:blue;">{{blimitamt | number : fractionSize}}</label> ks</div>
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
					<h4 class="col-xs-6">Home(%):: </h4><h4 class="col-xs-6">{{hperold}}%</h4>
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
					<h4 class="col-xs-6">Away(%):: </h4><h4 class="col-xs-6">{{aperold}}%</h4>
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
		              		<input type="button" ng-click='betmember(betid)' class="form-control btn all-btn" name="submit" value="Bet" ng-disabled="testing" ng-disabled="myForm1.amount.$valid==false?true:false">
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
				<div class="col-xs-12" style="text-align:center;"><label style="font-size:1.1em;color:blue;margin-left:10px;">{{homename}} </label><label  style="font-size:1.6em;color:green;margin-left:10px;"> & </label><label style="font-size:1.6em;color:blue;margin-left:10px;"> {{awayname}}</label></div>
				<div ng-if="warning!=1" class="col-xs-12" style="font-size:1.4em; font-weight:bold;text-align:center;">You can Bet only <label style="color:red;">{{warning | number : fractionSize}}</label> ks</div>
				<div ng-if="warning==1" class="col-sm-6 pad-free" style="font-weight:bold; color:red;">Bet Low Limit : <label style="color:blue;">{{gless | number : fractionSize}}</label> ks</div>
				<div ng-if="warning==1" class="col-sm-6 pad-free hidden-xs" style="font-weight:bold; color:red; text-align:right;">Bet High Limit : <label style="color:blue;">{{glimitamt | number : fractionSize}}</label> ks</div>
				<div ng-if="warning==1" class="col-sm-6 pad-free visible-xs" style="font-weight:bold; color:red;">Bet High Limit : <label style="color:blue;">{{glimitamt | number : fractionSize}}</label> ks</div>

				<div class="col-sm-offset-1 col-sm-10" style="margin-top: 10px; margin-bottom: 10px;">
				<label class="col-xs-12 col-sm-6" style="margin-bottom: 15px;" id="overdiv" for="overradio" ng-mouseover="hovero()" ng-mouseleave="leaveo()" ng-show="gioOshow">
				<div class="form-group row">
					<h4 class="col-xs-6">Date:: </h4><h4 class="col-xs-6">{{tdate}}</h4>					
				</div>
				<div class="form-group row">
					<h4 class="col-xs-6">Goal Name:: </h4><h4 class="col-xs-6">{{goalname}}</h4>
				</div>
				
				<div class="form-group row">
					<h4 class="col-xs-6">Over(%):: </h4><h4 class="col-xs-6">{{operold}}%</h4>
				</div>
				<div class="form-group row">
					<div class="col-xs-offset-5 col-xs-5">
						<input type="radio" name="cteam" id="overradio" ng-model="cteam" value="Over">
					</div>
				</div>
				</label>
				
		              	
		              	<label class="col-xs-12 col-sm-6" style="margin-bottom: 15px;" for="downradio" id="downdiv" ng-mouseover="hoverd()" ng-mouseleave="leaved()" ng-show="gioDshow">
		              	<div class="form-group row">
		              		<h4 class="col-xs-6">Time:: </h4><h4 class="col-xs-6">{{ttime}}</h4>
		              	</div>
		              	<div class="form-group row">
					<h4 class="col-xs-6">Goal(%)::</h4><h4 class="col-xs-6">{{goal_value}}%</h4>
				</div>
		              	<div class="form-group row">
					<h4 class="col-xs-6">Down(%):: </h4><h4 class="col-xs-6">{{dperold}}%</h4>
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
		              		<input type="button" ng-click='betmember(betid)' class="form-control btn all-btn" name="submit" value="Bet" ng-disabled="testing" ng-disabled="myForm.amount.$valid==false?true:false">
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

	<div id="mixbetdiv" class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8" style="top:50px;">
		<form class="col-xs-12" name="myForm2">
			<div class="form-group">
				<h1 id="allh3" class="col-xs-12">Mix Betting</h1>
			</div>
			<div ng-if="mixwarning!=1" class="col-xs-12" style="font-size:1.5em; font-weight:bold;text-align:center;">
			You can Bet only <label style="color:red;">{{mixwarning | number : fractionSize}}</label> ks
			</div>
			<!-- <div ng-if="mixwarning==1"  class="col-xs-12" style="font-size:1.5em; font-weight:bold; color:red; text-align:center;">
			Bet limit amount : <label style="color:red;">{{dbmaxamt | number : fractionSize}}</label> ks
			</div> -->
			<div ng-if="mixwarning==1" class="col-sm-6 pad-free" style="font-weight:bold; color:red;">
			Bet Low Limit : 
			<label style="color:blue;">{{dbminamt | number : fractionSize}}</label> ks</div>
			<div ng-if="mixwarning==1" class="col-sm-6 pad-free hidden-xs" style="font-weight:bold; color:red; text-align:right;">
			Bet High Limit : 
			<label style="color:blue;">{{dbmaxamt | number : fractionSize}}</label> ks</div>
			<div ng-if="mixwarning==1" class="col-sm-6 pad-free visible-xs" style="font-weight:bold; color:red;">
			Bet High Limit : 
			<label style="color:blue;">{{dbmaxamt | number : fractionSize}}</label> ks</div>
			
			<div class="col-xs-12" style="margin-bottom:10px;">
			<div class="col-sm-6" ng-repeat="x in mixlength" >
			<div class="col-xs-12 pad-free"style="margin-top:10px;border:1px solid #ccc;border-radius:3px;padding:5px 10px; 5px 5px;">
			   <div class="form-group row">
	              		<label class="col-sm-12" style="font-size:1.2em;font-weight:bold; color:green;">{{x.home}} VS {{x.away}}</label>
	              	   </div>
			   	              	   
	              	   <div class="row">
	              		<span class="col-xs-6">Bet ON ::</span><span class="col-xs-6" style="color:orange;font-weight:bold;">{{mixdiv[x.dashid]}}</span>
	              	   </div>
	              	   <div class="row" ng-show="mixdiv[x.dashid] == 'Home' || mixdiv[x.dashid] == 'Away'">
	              		<span class="col-xs-6">Body ::</span><span class="col-xs-6">{{x.bodyname}} [{{x.bodyval}} %]</span>
	              	   </div>
	              	   <div class="row" ng-show="mixdiv[x.dashid] == 'Over' || mixdiv[x.dashid] == 'Down'">
	              		<span class="col-xs-6">Goal+ ::</span><span class="col-xs-6">{{x.goalname}} [{{x.goalval}} %]</span>
	              	   </div>
	              	   <div class="row" ng-show="mixdiv[x.dashid] == 'Home'">
	              		<span class="col-xs-6">H% ::</span><span class="col-xs-6">{{x.hper}} %</span>
	              	   </div>
	              	   <div class="row" ng-show="mixdiv[x.dashid] == 'Away'">
	              		<span class="col-xs-6">A% ::</span><span class="col-xs-6">{{x.aper}} %</span>
	              	   </div>
	              	   <div class="row" ng-show="mixdiv[x.dashid] == 'Over'">
	              		<span class="col-xs-6">O% ::</span><span class="col-xs-6">{{x.uper}} %</span>
	              	   </div>
	              	   <div class="row" ng-show="mixdiv[x.dashid] == 'Down'">
	              		<span class="col-xs-6">D% ::</span><span class="col-xs-6">{{x.dper}} %</span>
	              	   </div>
				<!-- <table class="table table-striped">
					<tr>
						<th>Date</th>
						<th>&nbsp;</th>
						<th>Bet On</th>
						<th>Body</th>
						<th>Goal+</th>
						<th>H%</th>
						<th>A%</th>
						
						<th>O%</th>
						<th>D%</th>
					</tr>
					<tr ng-repeat="x in mixlength">
						<td>{{x.tdate}}</td>
						<td>{{x.home}} VS {{x.away}}</td>
						<td style="color:blue; font-weight:bold;">{{mixdiv[x.dashid]}}</td>	
						<td>{{x.bodyname}}[{{x.bodyval}}]</td>
						<td>{{x.goalname}}[{{x.goalval}}]</td>
						<td>{{x.hper}}</td>	
						<td>{{x.aper}}</td>
						
						<td>{{x.uper}}</td>		
						<td>{{x.dper}}</td>					
					</tr>
				</table> -->
			</div>	
			</div>
			</div>
			

			<div class="col-sm-6 pad-free">
				<div class="form-group">
					<label class="col-sm-12" style="font-size:1.2em;font-weight:bold; color:green;"><label style="color:orange;">You are betting on &nbsp;</label>( {{mixnumber}} mix )</label>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<input type="number" ng-model="betamount" name="betamount" class="form-control" placeholder="Amount" min="0" value="0">	
					<span ng-show="myForm2.betamount.$valid==false" style="color:red;">Bet Amount Invalid !</span>
				</div>
			</div>
			
			<div class="col-sm-12" style="margin-bottom:15px;">
				<div class="col-xs-6 col-sm-2 col-sm-offset-4">
		              		<input type="button" ng-click='bettingmix()' class="form-control btn all-btn" name="submit" value="Bet" ng-disabled="testing" ng-disabled="myForm2.betamount.$valid==false?true:false">
		              	</div>
				<div class="col-xs-6 col-sm-2">
		              		<input type="button" value="Close" ng-click="bDone()" style="cursor:pointer;" class="form-control btn all-btn">
		              	</div>	
		              	<div class="col-xs-12" style="font-weight:bold; color:red; text-align:center; margin-top:10px;">{{errormsg}}</div>	              	
			</div>
		</form>		
	</div>

	<div id="successalert" class="col-xs-12 col-sm-offset-4 col-sm-4" style="top:50px;">
		<label class="col-xs-12" style="text-align:center;">{{responsedata}}</label>
		<div class="col-xs-6 col-sm-4 col-sm-offset-4" style="margin-top:20px;">
              		<input type="button" value="OK" ng-click="bDone()" style="cursor:pointer;" class="form-control btn all-btn">
              	</div>
	</div>
</div>