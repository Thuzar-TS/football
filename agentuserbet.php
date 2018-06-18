<div class="container-fluid">
	<div class="col-xs-12" style="margin:10px;">
		<!-- <div class="col-xs-2" style="padding-left:0px;">
			<input type="text" class="form-control" name="filtername" ng-model="testfilter.filtername" placeholder="Member Name">
		</div> -->
		<div class="col-xs-2 pad-free">
			<input type="text" class="form-control" name="filterDate" ng-change="searchdate()" ng-model="filterDate" datepicker placeholder="Date">
		</div>	
		<!-- <div class="col-xs-2" ng-if="hidecard==true">
			<input type="text" class="form-control" name="searchloginid" ng-model="searchloginid" placeholder="Login ID">
		</div>	 -->
		
		<div class="col-xs-2 pull-right">
			<div class="col-xs-6">
				<button class="all-btn btn" ng-show="mixledgertable" ng-click="bgcall()">BG</button>
				<button class="all-btn btn" ng-show="!mixledgertable" ng-click="mixcall()">Mix</button>
			</div>
			<div class="col-xs-6" ng-show="hidecard">
				<a href="#agentuserlist/{{agid}}" class="all-btn btn">Back</a>
			</div>
			<div class="col-xs-6" ng-show="!hidecard">
				<a href="#agentuserlist/" class="all-btn btn">Back</a>
			</div>
		</div>		
	</div>
	<div class="col-xs-12" id="agentuserbet">			
		<table class="w3-table-all" id="mledgertable" ng-show="!mixledgertable">
			<tr>
				<th>Status</th>
				<th style="width:40px;">No.</th>
				<th>Date</th>			
				<th>Name</th>
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
				<th>Com</th>
			</tr>

			<tr ng-if="betlist == '' || mm.length<1">
				<td> - </td>
				<td> - </td>
				<td> No Record </td>
				<td colspan="12"> - </td>
			</tr>

			<!-- <tr ng-repeat="a in mm = (bgbetlist| filter:{dates:datevaluefilter} | filter:{username:usrname})">
				<td class="{{a.sname}}">{{a.statusdes}}</td>
				<td class="numbers">{{$index+1}}.</td>
				<td>{{a.bet_date}}({{a.bet_time}})</td>
				<td>{{a.username}}</td>	
				<td>{{a.leaguename}}</td>	
				<td>{{a.hometeam}}&nbsp;&amp;&nbsp;{{a.awayteam}}</td>
				<td>{{a.score}}</td>
				<td>{{a.bet}}</td>	
				<td>{{a.bet_on}}</td>
				<td>{{a.bgname}} [{{a.bgval}}]</td>
				<td>{{a.percent}}</td>
				<td class="numbers">{{a.bet_amount | number : fractionSize}}</td>
				<td class="numbers {{a.cname}} {{a.numformat}}">{{a.result_amount == "RUNNING" || a.result_amount == "WAITING"?(a.result_amount):(a.result_amount | number : fractionSize)}}</td>
				<td class="numbers">{{a.net_amount == "RUNNING" || a.net_amount == "WAITING"?(a.net_amount):(a.net_amount | number : fractionSize)}}</td>
				
			</tr> -->
			
			<tr ng-repeat="a in betlist">
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
				<td class="numbers">{{a.commission_amt | number : fractionSize}}</td>
			</tr>
		</table>

		<div style="width:1800px;">
			<table class="table table-striped" style="margin-top:10px;" ng-show="mixledgertable">
				<tr>	
					<th>Bet&nbsp;Date</th>
					<th>Bet&nbsp;Time</th>
					<th>Status</th>
					<th>User</th>
					<th>Mix</th>
					<th>&nbsp;</th>				
					<th>Stake</th>					
					<th>Result&nbsp;Amount</th>
					<th>Turn&nbsp;Over</th>
					<th>Bet Status</th>
				</tr>

				<tr ng-if="betlist == 'No Record' || betlist.length<1">
					<td> - </td>
					<td> No Record </td>
					<td colspan="13"> - </td>
				</tr>

				<tr ng-if="betlist != 'No Record' && mixledgertable==true" ng-repeat="x in betlist | groupBy: '[mid]'">
					<td>{{x[0].bet_date}}</td>
					<td>{{x[0].bet_time}}</td>
					<td>{{x[0].bgdescription}}</td>
					<td>{{x[0].username}}</td>								
					<td>{{x[0].mixname}} Mix Betting</td>
					<td>
						<table class="table table-hover" style="border:0px;margin:0px;background:none;" id="innertbl">
							<tr style="border:0px;">
								<th>Match</th>
								<th>Home</th>
								<th>Score</th>
								<th>Away</th>
								<th>Bet</th>
								<th>Status</th>
							</tr>
							<tr ng-repeat="xx in x" style="border:0px;">
								<td style="border:0px; width:18%">{{xx.leaguename}}</td>
								<td style="border:0px; width:18%">{{xx.h}}</td>
								<td style="border:0px; width:10%">{{xx.score}}</td>
								<td style="border:0px; width:18%">{{xx.a}}</td>
								<td style="border:0px; width:14%">{{xx.bet_on_name}}</td>
								<td style="border:0px; width:6%">{{xx.ddescription}}</td>
							</tr>
						</table>						
					</td>
					<td>{{x[0].bet_amount | number : fractionSize}}</td>
					<td class="numbers">{{x[0].result_amount == "RUNNING" || x[0].result_amount == "WAITING"?(x[0].result_amount):(x[0].result_amount | number : fractionSize)}}</td>
					<td class="numbers">{{x[0].net_amount == "RUNNING" || x[0].net_amount == "WAITING"?(x[0].net_amount):(x[0].net_amount | number : fractionSize)}}</td>
										
					<td>{{x[0].sdescription}}</td>
					
				</tr>
			</table>
		</div>				
	</div>
</div>