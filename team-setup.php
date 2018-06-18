<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Teams</h3>
	</div>
	<div class="col-xs-12">
		<div class="col-xs-12 col-sm-2" style="margin-bottom:10px; padding-left:0px;">
			<input type="text" class="form-control" name="filterTeam" ng-model="filterTeam" placeholder="Team Name">
		</div>	
	</div>
	
	<div class="col-xs-12 col-sm-9" style="height:450px; overflow-y:auto;">
	
		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Team Name</th>
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		
		<tr ng-repeat="x in nn = (names|filter:{teamname:filterTeam})">
			<td>{{$index+1}}</td>
			<td>{{x.teamname}}</td>
			<td><label ng-click="editteam(x,x.team_id)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="delteam(x.team_id)" style="cursor:pointer;">Delete</label></td>
		</tr>
		</table>
	</div>
	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row">
				<div class="form-group row">
					<label class="col-xs-12">Team Name</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" ng-model="tname" name="tname" required>
					</div>
				</div>				
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='save()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showteam">
					</div>
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='eteam(tid)' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showteam">
					</div>
				</div>
		</form>
	</div>
</div>