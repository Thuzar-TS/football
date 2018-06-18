<div class="container-fluid">
	<div class="col-xs-12" style="margin:10px;">
		<div class="col-xs-2" style="padding-left:0px;">
			<input type="text" class="form-control" name="filtername" ng-model="filtername" placeholder="Member Name">
		</div>	
		<div class="col-xs-2" ng-if="hidecard==true">
			<input type="text" class="form-control" name="searchloginid" ng-model="searchloginid" placeholder="Login ID">
		</div>	
		<div class="col-xs-1 pull-right" ng-show="hidecard">
			<a href="#profile/{{mid}}" class="all-btn btn">Back</a>
		</div>
		<div class="col-xs-1 pull-right" ng-show="!hidecard">
			<a href="#profile/" class="all-btn btn">Back</a>
		</div>
	</div>
	<div class="col-xs-12">			
		<table class="table table-striped">
			<tr>
				<th>No.</th>					
				<th>Member Name</th>	
				<th ng-if="hidecard==true">Login ID</th>								
				<th>Finance ID</th>
				<th ng-if="hidecard==true">Mail</th>
				<th>Phone</th>
				<th ng-if="hidecard==true">DOB</th>					
				<th>Balance</th>	
				<th>&nbsp;</th>								
			</tr>
			<tr ng-if="auser.length<1 || auser == '' || alluser == 'No Record'">
				<td> - </td>
				<td> No Record </td>
				<td colspan="6"> - </td>
			</tr>
			<tr ng-repeat="x in auser | filter:{username:filtername} | filter:{loginid:searchloginid}">
				<td>{{$index+1}}</td>					
				<td>{{x.username}}</td>
				<td ng-if="hidecard==true">{{x.loginid}}</td>
				<td>'{{x.financeid}}'</td>
				<td ng-if="hidecard==true">{{x.mail}}</td>
				<td>{{x.phone}}</td>
				<td ng-if="hidecard==true">{{x.dob}}</td>				
				<td class="numbers">{{x.amount | number : fractionSize}}</td>	
				<td><a href="#agentuserbet/{{x.member_id}}/{{mid}}">Betting List</a></td>				
			</tr>
		</table>		
	</div>
</div>