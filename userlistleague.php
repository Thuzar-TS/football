<div class="row container-fluid">
<div class="col-xs-12">
	<h3 id="allh3" class="col-xs-12">Bet User List</h3>
</div>
<div class="col-xs-12">
	<form>
		<div class="col-sm-2" style="padding-left:0px;">
		<div class="form-group">
			<input type="text" ng-model="usrname" class="form-control" placeholder="User Name">
		</div>
		</div>
		<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" ng-model="fselect">
				<option value="">-- Body or Goal--</option>
				<option value="Body">Body</option>
				<option value="Goal">Goal+</option>
			</select>
		</div>
		</div>
		<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" ng-model="filtersel">
				<option value="">-- All --</option>
				<option value="Home">Home</option>
				<option value="Away">Away</option>
				<option value="Over">Over</option>
				<option value="Down">Down</option>
			</select>
		</div>
		</div>	
		<div class="col-sm-3">
		<div class="form-group">
			<select class="form-control" ng-model="statusfilter">
				<option value="">Status Filter(All)</option>
				<option value="Confirm">Confirm</option>
				<option value="Pending">Pending</option>
				<option value="Reject">Reject</option>
			</select>
		</div>
		</div>	
		<div class="col-sm-3">
		<div class="form-group">
			<select class="form-control" ng-model="statusall" ng-change="statusallchange(statusall)">
				<option value="">Select Status Change(All)</option>
				<option value="1">Confirm</option>
				<option value="2">Pending</option>
				<option value="3">Reject</option>
			</select>
		</div>
		</div>	
		
		<div class="col-sm-1">
			<a href="#accdash/" class="btn all-btn">Back Home</a>
		</div>
	</form>
	<table class="w3-table-all" id="mledgertable">
		<tr>			
			<!-- <th></th> -->
			<th>Bet Date</th>
			<th>Bet Time</th>
			<th style="cursor:pointer;" ng-click="selectall()">All</th>
			<th>Status</th>
			<th>User</th>
			<th>BetSlipID</th>
			<th>League</th>
			<th>Home</th>
			<th>Score</th>
			<th>Away</th>
			<th colspan="2">BP or GP</th>
			<th>Bet</th>
			<th>%</th>
			<th>Stake</th>
			<th>W/L</th>
			<th>Turn Over</th>
			<th>Bet Status</th>
		</tr>

		<tr ng-repeat="x in mledger|filter:{bet:fselect}| filter:{bet_on:filtersel}| filter:{bgdescription:statusfilter} | filter:{username:usrname}">
		<!-- <tr ng-repeat="x in mledger|filter:selectstatus"> -->
			<!-- <td ng-if="x.bet=='Body'">
				<select ng-model="x.accbgid" ng-options="b.accbgid as b.description for b in abody" ng-change="statuschange(x)" class="form-control"></select>
				{{x.description}}
			</td>
			<td ng-if="x.bet=='Goal+'">
				<select ng-model="x.accbgid" ng-options="g.accbgid as g.description for g in agoal" ng-change="statuschange(x)" class="form-control"></select>
				{{x.description}}
			</td> -->
			<td>{{x.bet_date}}</td>
			<td>{{x.bet_time}}</td>
			<td><input type="checkbox" ng-model="x.checked" ng-true-value="1" ng-false-value="0"></td>
			<td ng-if="x.betstateid==1"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" disabled="disabled" class="form-control"></select></td>
			<td ng-if="x.betstateid!=1"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" class="form-control"></select></td>
			<td>{{x.username}}</td>
			<td>{{x.reference}}</td>
			<td>{{x.leaguename}}</td>
			<td>{{x.h}}</td>			
			<td>{{x.score}}</td>
			<td>{{x.a}}</td>
			<td>{{x.bg_name}}</td>
			<td>{{x.bg_value}}</td>			
			<td>{{x.betname}}</td>
			<td>{{x.per}}</td>
			<td>{{x.bet_amount}}</td>
			<td>{{x.result_amount}}</td>
			<td>{{x.net_amount}}</td>
			<td>{{x.description}}</td>				
		</tr>
	</table>
</div>
</div>