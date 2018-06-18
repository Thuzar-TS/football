<div class="row container-fluid">

<div class="col-xs-12 col-sm-5 pull-right" style="margin-top:10px;">
	<div class="col-xs-12 col-sm-6">
		<label>Welcome </label>&nbsp;&nbsp;<label style="color:blue;">: &nbsp;{{mbrname}}</label>
	</div>
	<div class="col-xs-12 col-sm-6 pad-free" ng-if="total!='Admin'">
		<label>Your Balance : </label><label ng-repeat="x in total" style="color:blue;">&nbsp;{{x | number : fractionSize}}</label> ks
	</div>	
</div>

<div class="col-xs-12 col-sm-12">
	<table "table table-striped">
		<tr>
			<th>No.</th>
			<th>Agent Name</th>
			<th>Login ID</th>
			<th>Member Name</th>
			<th>Bet Type</th>
			<th>Amount</th>
		</tr>
		<tr ng-repeat="x in com">
			<td>$index+1</td>			
			<td>{{x.agentname}}</td>
			<td>{{x.loginid}}</td>
			<td>{{x.membername}}</td>
			<td>{{x.bet}}</td>
			<td>{{x.commission_amt}}</td>
		</tr>		
	</table>
</div>
</div>