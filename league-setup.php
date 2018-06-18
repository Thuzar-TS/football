<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Leagues</h3>
	</div>
	<div class="col-xs-12 col-sm-9">
		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>League Name</th>
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		<tr ng-repeat="x in names">
			<td>{{$index+1}}</td>
			<td>{{x.leaguename}}</td>
			<td><label ng-click="editleague(x,x.league_id)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="delleague(x.league_id)" style="cursor:pointer;">Delete</label></td>
		</tr>		
		</table>
	</div>
	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row">
				<div class="form-group row">
					<label class="col-xs-12">League Name</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="lname" ng-model="lname" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='saveleague()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showleague">
					</div>

					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='eleague()' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showleague">
					</div>
				</div>

		</form>
	</div>
	</div>