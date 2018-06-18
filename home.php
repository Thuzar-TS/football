<div class="container-fluid" ng-controller="HomeCtrl">
	<div class="col-xs-12 form-group">
		<h2 id="" class="col-xs-12">TimeTable</h2>
	</div>
	<div class="col-xs-12 col-sm-9">
		<table  class="w3-table-all">
		<tr>
			<th>No.</th>
			<th>Date</th>
			<th>Time</th>
			<th>League</th>
			<th>Home</th>
			<th>Away</th>
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		<tr ng-repeat="x in names">
			<td>{{$index+1}}</td>
			<td>{{x.tdate}}</td>
			<td>{{x.ttime}}</td>
			<td>{{x.leaguename}}</td>
			<td>{{x.home}}</td>
			<td>{{x.away}}</td>
			<td><label ng-click="deltable(x.id)" style="cursor:pointer;">Delete</label></td>
		</tr>
		</table>
	</div>
	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row">
				<div class="form-group row">
					<label class="col-xs-12">Date</label>
					<p class="input-group col-xs-12">
			                    <input type="date" class="form-control"   datetime-picker="mediumDate"  ng-model="tdate" is-open="popup1.opened" enable-time="false" datepicker-options="dateOptions" close-on-date-selection="false" datepicker-append-to-body="true" />
			              <span class="input-group-btn">			                   
			                  <button type="button" class="btn btn-default" ng-click="open1()"><i class="glyphicon glyphicon-calendar"></i></button>
			              </span>
				</p>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Time</label>
					<p class="input-group col-xs-12">
			                    <input type="text" class="form-control" datetime-picker="HH:mm" ng-model="ttime" is-open="popup2.opened" enable-date="false" timepicker-options="timepickerOptions" close-on-selection="true" />
			              <span class="input-group-btn">
			                  <button type="button" class="btn btn-default" ng-click="open2()"><i class="glyphicon glyphicon-time"></i></button>
			              </span>
				</p>
				</div>
				
				<div class="form-group row">
					<label class="col-xs-12">League</label>
					<select class="w3-select col-xs-12" ng-model="league" ><option ng-repeat="d in leagues track by $index" ng-value="{{d.id}}">{{d.leaguename}}</option></select>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Home</label>
					<select class="w3-select" ng-model="hteam"><option ng-repeat="t in teams track by $index" ng-value="{{t.id}}">{{t.teamname}}</option></select>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Away</label>
					<select class="w3-select col-xs-12" ng-model="ateam"><option ng-repeat="at in teams track by $index" ng-value="{{at.id}}" >{{at.teamname}}</option></select>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='saveTtable()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showbet">
					</div>

					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='eBet()' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showbet">
					</div>
				</div>
		</form>
	</div>
	</div>