<div class="container-fluid">
<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">
		Mix Detail
		<div class="col-sm-2 pull-right">
			<button class="btn btn-link" style="color:blue;padding:0px;" ng-click="exportToExcel('#exceldown')">
			      <span class="glyphicon glyphicon-share"></span>
			      Export to Excel
			</button>
		</div>
		</h3>
	</div>
	<div class="col-xs-12">
		<div class="col-sm-2" style="padding-left:0px;">
		<div class="form-group">
			<input type="text" class="form-control" ng-model="allfilter.filterDate" datepicker placeholder="Bet Date">
		</div>
		</div>

		<div class="col-sm-2">
		<div class="form-group">
			<input type="text" ng-model="allfilter.usrname" class="form-control" placeholder="Member Name">
		</div>
		</div>

		<div class="col-sm-2">
		<div class="form-group">
			<input type="text" ng-model="allfilter.loginid" class="form-control" placeholder="Login ID">
		</div>
		</div>
				
		<div class="col-sm-2">
		<div class="form-group">
			<select ng-model="allfilter.abetstatusfilter" ng-options="abs.description for abs in abetstatusall track by abs.status_id" class="form-control" ng-init="allfilter.abetstatusfilter=abetstatusall[0]">
			</select>			
		</div>
		</div>	

		<div class="col-sm-2">
		<div class="form-group">
			<select ng-model="allfilter.abetstate" ng-options="abs.bet_on for abs in bodyhome track by abs.bet_on" class="form-control" ng-init="allfilter.abetstate=bodyhome[0]">
			</select>			
		</div>
		</div>	

		<!-- <div class="col-sm-2">
			<div class="form-group">
				<select class="form-control" ng-model="bodygoal" ng-change="bodygoalch(bodygoal)">
					<option value="">-- Body / Goal+  --</option>
					<option value="1">Home</option>
					<option value="2">Away</option>
					<option value="3">Over</option>
					<option value="4">Down</option>
				</select>			
			</div>
			</div>	 -->	

		<div class="col-xs-1 pad-free pull-right">
			<a href="#accdash/" class="btn all-btn col-xs-12">Back</a>
		</div>	
	</div>	
	
	<div class="col-xs-12" id="exceldown">
		<table class="table table-striped" id="mixbetlisttbl">
		<tr>
			<th>No.</th>
			<th>Date</th>
			<th>League</th>
			<th>Member</th>
			<th>Login ID</th>
			
			<th>Home</th>
			<th>Score</th>
			<th>Away</th>

			<th colspan="2">BP or GP</th>
			<th>%</th>
			<th>Bet On</th>
			<th>Status</th>
			<th>MP</th>
		</tr>
		<tr ng-if="mixdetail == 'No Record' || mixdetail == ''">
			<td> - </td>
			<td> No Record </td>
			<td colspan="12"> - </td>
			
		</tr>
		<tr ng-repeat="x in mixdetail">
			<td>{{$index+1}}</td>
			<td>{{x.bet_date}} ({{x.bet_time}})</td>
			<td>{{x.leaguename}}</td>
			<td>{{x.username}}</td>
			<td>{{x.loginid}}</td>

			<td>{{x.home}}</td>
			<td>{{x.score}}</td>
			<td>{{x.away}}</td>

			<td>{{x.bgvalue}}</td>	
			<td>{{x.bgname}}</td>
			<td>{{x.bgper}}</td>	
			<td>{{x.bet_on_name}}</td>	
			<td class="{{x.sname}}">{{x.description}}</td>
			<td>{{x.mp}}</td>
		</tr>		
		</table>
	</div>	
</div>