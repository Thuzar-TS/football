<div class="row container-fluid">

<div class="col-xs-12 col-sm-5 pull-right" style="margin-top:10px;">
	<div class="col-xs-12 col-sm-6">
		<label>Welcome </label>&nbsp;&nbsp;<label style="color:blue;">: &nbsp;{{mbrname}}</label>
	</div>
	<div class="col-xs-12 col-sm-6 pad-free" ng-if="total!='Admin'">
		<label>Your Balance : </label><label ng-repeat="x in total" style="color:blue;">&nbsp;{{x | number : fractionSize}}</label> ks
	</div>	
</div>

	<!-- <table class="w3-table-all" id="mledgertable">
		<tr>
			<th>&nbsp;</th>
			<th>No.</th>
			<th>Date ( Time )</th>
			<th>League</th>
			<th>Home</th>
			<th>Away</th>
			<th>Bet</th>
			<th>Bet On</th>
			<th>Bet Amount</th>
			<th>Result Amount</th>
			<th>Net Amount</th>
			<th>Bet State</th>
		</tr>
	
		<tr ng-repeat="x in mledger">
			<td class="{{x.cname}}">{{x.description}}</td>
			<td>{{$index+1}}</td>
			<td>{{x.dates}}({{x.times}})</td>
			<td>{{x.leaguename}}</td>
			<td>{{x.h}}</td>
			<td>{{x.a}}</td>
			<td>{{x.bet}}</td>
			<td>{{x.bet_on}}</td>
	      			<td class="numbers">{{x.bet_amount | number : fractionSize}}</td>
			<td class="numbers">{{x.result_amount | number : fractionSize}}</td>
			<td class="numbers">{{x.net_amount | number : fractionSize}}</td>			
			<td>{{x.bgdescription}}</td>
		</tr>
	</table> -->
<div class="col-xs-12 col-sm-12">

	<div class="col-xs-12" style="margin-top:10px;" ng-show="!showadmin">
		<div class="col-sm-2" style="padding-left:0px;">
		<div class="form-group">
			<select ng-model="chyearcombo" name="chyearcombo" ng-change="changeyear(chyearcombo)" ng-options="mm.year for mm in yeararr track by mm.year" class="form-control" ng-init="chyearcombo.year=currenty">
			</select>
		</div>
		</div>
		<div class="col-sm-2" style="padding-left:0px;">
			<div class="form-group">
				<input type="text" class="form-control" name="datevaluefilter" ng-model="datevaluefilter" id="date" datepicker placeholder="Date">
			</div>
		</div>
		<div class="col-sm-2" ng-show="total=='Admin'">
		<div class="form-group">
			<input type="text" ng-model="usrname" class="form-control" placeholder="User Name">
		</div>
		</div>
		<div class="col-sm-2" ng-show="total=='Admin'">
			<div class="form-group">
				<input type="text" class="form-control" name="teamname" ng-model="teamname" placeholder="Home Team Name">
			</div>
		</div>	
		<div class="col-sm-2" ng-show="total=='Admin'">
			<div class="form-group">
				<input type="text" class="form-control" name="ateamname" ng-model="ateamname" placeholder="Away Team Name">
			</div>
		</div>	
		<div class="col-sm-2" ng-show="total=='Admin'">
		<div class="form-group">
			<select class="form-control" ng-model="betstatusfilter">
				<option value="">Bet Status Filter</option>
				<option value="Running">Running</option>
				<option value="Waiting">Waiting</option>
				<option value="Reject">Reject</option>
				<option value="Win">Win</option>
				<option value="Lose">Lose</option>
			</select>
		</div>
		</div>	
		<div class="col-sm-2">
			<button ng-click="refreshfun()" class="refresh col-xs-9">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
		</div>
		<div class="col-sm-2 pad-free pull-right">
			<div class="col-sm-6 pull-right" ng-if="total != 'Admin' && allbet != true">
				<div class="form-group" style="margin-top:10px; pad-free">
					<a ng-click="changemixdetail()" class="btn all-btn col-xs-12">Mix</a>
				</div>
			</div>
			<div class="col-sm-6 pull-right" ng-if="allbet == true">
				<div class="form-group" style="margin-top:10px; pad-free">
					<a href="#mledger/" class="btn all-btn col-xs-12">Back</a>
				</div>
			</div>			
		</div>
	</div>

	<div class="col-xs-12" style="margin-top:10px;" ng-show="showadmin">
		<div class="col-sm-2" style="padding-left:0px;">
		<div class="form-group">
			<select ng-model="chyearcombo" name="chyearcombo" ng-change="changeyear(chyearcombo)" ng-options="mm.year for mm in yeararr track by mm.year" class="form-control" ng-init="chyearcombo.year=currenty">
			</select>
		</div>
		</div>
		<div class="col-sm-2" style="padding-left:0px;">
		<div class="form-group">
			<input type="text" class="form-control" ng-model="allfilter.filterDate" datepicker placeholder="Bet Date" ng-init="allfilter.filterDate = datevaluefilter">
		</div>
		</div>
		<div class="col-sm-2" style="padding-left:0px;" ng-show="total=='Admin'">
		<div class="form-group">
			<input type="text" ng-model="allfilter.filtermbr" class="form-control" placeholder="User Name" ng-init="allfilter.filtermbr = ''">
		</div>
		</div>

		<div class="col-sm-2">
			<button ng-click="refreshfun()" class="refresh col-xs-9">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
		</div>
		<div class="col-sm-2 pad-free pull-right">
			<div class="col-sm-6 pad-free pull-right" ng-if="total != 'Admin' && allbet != true">
				<div class="form-group" style="margin-top:10px; pad-free">
					<a ng-click="changebgdetail()" class="btn all-btn col-xs-12">Body/Goal</a>
				</div>
			</div>
			<div class="col-sm-6 pull-right" ng-if="allbet == true">
				<div class="form-group" style="margin-top:10px; pad-free">
					<a href="#mledger/" class="btn all-btn col-xs-12">Back</a>
				</div>
			</div>			
		</div>
	</div>

	<div class="col-xs-12" style="overflow-y:auto; height:450px; overflow-x:auto;" id="mhometbl">
	<div class="mhometbl" id="mhometbl">
	<table class="w3-table-all" id="mledgertable" ng-show="!mixledgertable">
		<tr>
			<th>Status</th>
			<th style="width:40px;">No.</th>
			<th>Date</th>
			<th ng-if="total=='Admin'">Member</th>
			<th ng-if="total!='Admin'">Name</th>
			<th>League</th>
			<th>Match</th>
			<th>Score</th>

			<th>Bet</th>
			<th>Bet On</th>
			<th>Odd</th>
			<th>%</th>
			<th>Amount</th>
			<th>W/L</th>
			<th>Turnover</th>
			
			<!-- <th>Status</th> -->
		</tr>

		<tr ng-if="mledger == '' || mm.length<1">
			<td> - </td>
			<td> - </td>
			<td> No Record </td>
			<td colspan="11"> - </td>
		</tr>

		<!-- <tr style="background:blue; color:white;" ng-if="mm.length>0">
			<td colspan="11">Total</td>
			<td class="numbers">{{bettingtotal | number : fractionSize}}</td>
			<td class="numbers">{{winlosetotal | number : fractionSize}}</td>
			<td class="numbers">{{turntotal | number : fractionSize}}</td>
		</tr> -->
		<tr ng-repeat="a in mm = (mledger| filter:{dates:datevaluefilter} | filter:{username:usrname} | filter:{hometeam:teamname} | filter:{awayteam:ateamname} | filter:{statusdes:betstatusfilter})">
			<td class="{{a.sname}}">{{a.statusdes}}</td>
			<td class="numbers">{{$index+1}}.</td>
			<td>{{a.dates}}({{a.time}})</td>
			<td>{{a.username}}</td>	
			<td>{{a.leaguename}}</td>	
			<td>{{a.hometeam}}&nbsp;&amp;&nbsp;{{a.awayteam}}</td>
			<td>{{a.score}}</td>
			<td>{{a.bet}}</td>	
			<td>{{a.bet_on}}</td>
			<td>{{a.bgname}} [{{a.bgval}}]</td>
			<td>{{a.percent}}</td>
			<td class="numbers">{{a.betamount | number : fractionSize}}</td>
			<td class="numbers {{a.cname}} {{a.numformat}}">{{a.wl == "RUNNING" || a.wl == "WAITING"?(a.wl):(a.wl | number : fractionSize)}}</td>
			<td class="numbers">{{a.turnover == "RUNNING" || a.turnover == "WAITING"?(a.turnover):(a.turnover | number : fractionSize)}}</td>
					
			<!-- <td class="numbers {{a.cname}} {{a.numformat}}">{{a.wl | number : fractionSize}}</td>
			<td class="numbers">{{a.turnover | number : fractionSize}}</td> -->
			
			<!-- <td style="width:100px;" ng-if="total== 'Admin'">
				<select ng-if="a.state_id == 1" ng-model="a.state_id" ng-options="st.state_id as st.description for st in s" disabled="disabled" class="form-control"></select>
				<select ng-if="a.state_id != 1" ng-model="a.state_id" ng-options="st.state_id as st.description for st in s" ng-change="allchange(a)" class="form-control"></select>
			</td> -->

			<!-- <td style="width:100px;">
				<label>{{a.betstatedes}}</label>
			</td> -->
		</tr>
		
	</table>
	<!-- <table class="w3-table-all" id="mledgertable" ng-show="mixledgertable">
		<tr>
			<th>&nbsp;</th>
			<th style="width:40px;">No.</th>
			<th>Date</th>
			<th ng-if="total=='Admin'">Member</th>
			<th ng-if="total!='Admin'">Name</th>
			<th>Mix Name</th>
			<th>League</th>
			<th>&nbsp;</th>
			<th>Score</th>
	
			<th>Bet</th>
			<th>Bet On</th>
			<th>&nbsp;</th>
			<th>%</th>
			<th>Total Bet</th>
			<th>W/L</th>
			<th>Turnover</th>
		</tr>
		<tr style="background:blue; color:white;">
			<td colspan="11">Total</td>
			<td class="numbers">{{bettingtotal | number : fractionSize}}</td>
			<td class="numbers">{{winlosetotal | number : fractionSize}}</td>
			<td class="numbers">{{turntotal | number : fractionSize}}</td>
		</tr>
		<tr ng-repeat="a in mledger| filter:{dates:filterDate} | filter:{username:usrname} | filter:{hometeam:teamname} | filter:{awayteam:ateamname} | filter:{statusdes:betstatusfilter}">
			<td class="{{a.sname}}">{{a.statusdes}}</td>
			<td class="numbers">{{$index+1}}.</td>
			<td>{{a.dates}}({{a.time}})</td>
			<td>{{a.username}}</td>	
			<td>{{a.mixname}}</td>
			<td>{{a.leaguename}}</td>	
			<td>{{a.hometeam}}&nbsp;&amp;&nbsp;{{a.awayteam}}</td>
			<td>{{a.score}}</td>
			<td>{{a.bet}}</td>	
			<td>{{a.bet_on}}</td>
			<td>{{a.bgname}} [{{a.bgval}}]</td>
			<td>{{a.percent}}</td>
			<td class="numbers">{{a.betamount | number : fractionSize}}</td>
			<td class="numbers {{a.cname}} {{a.numformat}}">{{a.wl | number : fractionSize}}</td>
			<td class="numbers">{{a.turnover | number : fractionSize}}</td>
			
		</tr>
		
	</table> -->

	<table class="table table-striped" style="margin-top:10px;" id="mixbetlisttbl" ng-show="mixledgertable">
		<tr>	
			<th ng-if="total == 'Admin'">&nbsp;</th>
			<th>Date & Time</th>
			
			<th>Status</th>
			<th>User</th>
			<th>Mix</th>
			<th>&nbsp;</th>				
			<th>Stake</th>					
			<th>Result&nbsp;Amount</th>
			<th>Turn&nbsp;Over</th>
			<th>Bet Status</th>
		</tr>

		<tr ng-if="mledger == '' || mledger.length<1">
			<td> - </td>
			<td> No Record </td>
			<td colspan="12"> - </td>
		</tr>

		<tr ng-repeat="x in mledger | groupBy: '[mid]'">
			<td ng-if="total == 'Admin'"><input type="checkbox" ng-model="x[0].checked" ng-true-value="1" ng-false-value="0"></td>
			<td>{{x[0].bet_date}} ( {{x[0].bet_time}} )</td>
			
			<td>{{x[0].bgdescription}}</td>
			<td>{{x[0].username}}</td>								
			<td>{{x[0].mixname}} Mix Betting</td>
			<td>
				<table class="table table-hover" style="border:0px;margin:0px;background:none;" id="innertbl">
					<tr style="border:0px;">
						<th>League</th>
						<th>Match</th>
						<th>Score</th>
						<th>Odd</th>
						<th>Bet</th>
						<th>Status</th>
					</tr>
					<tr ng-repeat="xx in x" style="border:0px;">
						<td style="border:0px; width:18%">{{xx.leaguename}}</td>
						<td style="border:0px; width:18%">{{xx.h}} & {{xx.a}}</td>
						<td style="border:0px; width:10%">{{xx.score}}</td>
						<td style="border:0px; width:10%">{{xx.bgname}} [{{xx.bgval}}]</td>
						<td style="border:0px; width:14%">{{xx.bet_on_name}}</td>
						<td style="border:0px; width:6%">{{xx.ddescription}}</td>
					</tr>
				</table>						
			</td>
			<td class="numbers {{x[0].betamtclass}}">{{x[0].bet_amount | number : fractionSize}}</td>
			<td class="numbers {{x[0].resultclass}}">{{x[0].result_amount == "RUNNING" || x[0].result_amount == "WAITING"?(x[0].result_amount):(x[0].result_amount | number : fractionSize)}}</td>
			<td class="numbers {{x[0].netclass}}">{{x[0].net_amount == "RUNNING" || x[0].net_amount == "WAITING"?(x[0].net_amount):(x[0].net_amount | number : fractionSize)}}</td>
					
			<!-- <td>{{x[0].result_amount}}</td>
			<td>{{x[0].net_amount}}</td> -->					
			<td class="{{x[0].desclass}}">{{x[0].sdescription}}</td>
			
		</tr>
	</table>
	</div>
</div>
</div>
</div>