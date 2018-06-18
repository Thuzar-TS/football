<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Goals</h3>
	</div>
	<div class="col-xs-12 col-sm-9">
		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Goal Name</th>
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		<tr ng-repeat="x in names|filter:gtype">
			<td>{{$index+1}}</td>
			<td>{{x.goalname}}</td>			
			<td><label ng-click="editgoal(x,x.goalplus_id)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="delgoal(x.goalplus_id)" style="cursor:pointer;">Delete</label></td>
		</tr>
		</table>	
	</div>

	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row">
				
				<div class="form-group row">
					<label class="col-xs-12">Goal Name</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="gname" ng-model="gname" required>
					</div>
				</div>				
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='savegoal()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showgoal">
					</div>

					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='egoal()' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showgoal">
					</div>
				</div>

		</form>
	</div>
	</div>