<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Time Table</h3>
	</div>
	<div class="col-xs-12">
		<div class="col-sm-2 pad-free">
			<div class="form-group">
				<input type="text" class="form-control" name="filterDate" ng-model="filterDate" datepicker placeholder="Date">
			</div>
		</div>		
	</div>
	<div class="col-xs-12 col-sm-9" style="height:450px; overflow-y:auto;">
		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Date</th>
			<th>Time</th>
			<th>League</th>
			<th>Home</th>			
			<th>Away</th>			
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		<tr ng-if="timetables =='No Record' || aa.length==0">
			<td>-</td>
			<td>No Record</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
		</tr>

		<tr ng-if="timetables != 'No Record'" ng-repeat="x in aa=(timetables|filter:sname | filter:{tdate:filterDate})">
			<td>{{$index+1}}</td>
			<td>{{x.tdate}}</td>
			<td> {{x.ttime}} </td>
			<td> {{x.leaguename}} </td>
			<td> {{x.hname}} </td>
			<td> {{x.aname}} </td>
			<td><label ng-click="edittt(x,x.timetableid)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="deltt(x)" style="cursor:pointer;">Delete</label></td>
		</tr>
		</table>		
	</div>	
	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row">
				<div class="form-group row">
					<label class="col-xs-12">Date</label>
					<div class="col-xs-12">
						<input class="form-control dp" type="text" id="date" ng-model="tdate" datepicker placeholder="Date">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Time</label>
					<div class="col-xs-12">
						<input type="text" id="time" ng-model="ttime" timepicker class="form-control " placeholder="Time">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">League</label>
					<div class="col-xs-12">
    						<select ng-options="l as l.leaguename for l in leagues track by l.league_id" ng-model="selectedleague" class="form-control">
    							<option value="">-- Choose League --</option>
						</select>
					</div>
				</div>				
				<div class="form-group row">
					<label class="col-xs-12">Home</label>
					<div class="col-xs-12">
    						<select ng-options="h as h.hname  for h in homes track by h.home" ng-model="selectedhome" class="form-control">
    							<option value="">-- Choose Home --</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Away</label>
					<div class="col-xs-12">
    						<select ng-options="a as a.aname for a  in aways track by a.away" ng-model="selectedaway" class="form-control">
    							<option value="">-- Choose Away --</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-6">
						<input type="button" ng-click='savett()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showtt">
						<input type="button" ng-click='ett()' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showtt">
					</div>
					<div class="col-sm-6">
						<input type="button" ng-click='canceltime()' class="form-control btn all-btn" name="cancel" value="Cancel">
					</div>
				</div>	
		</form>		
	</div>
</div>
