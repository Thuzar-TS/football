<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Bodies</h3>
	</div>
	<div class="col-xs-12 col-sm-9">
		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Body Name</th>
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		<tr ng-repeat="x in names|filter:btype">
			<td>{{$index+1}}</td>
			<td>{{x.bodyname}}</td>
			<td><label ng-click="editbody(x,x.body_id)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="delbody(x.body_id)" style="cursor:pointer;">Delete</label></td>
		</tr>
		</table>
	</div>
	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row">
				
				<div class="form-group row">
					<label class="col-xs-12">Body Name</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="bname" ng-model="bname" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='savebody()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showbody">
					</div>

					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='ebody()' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showbody">
					</div>
				</div>

		</form>
	</div>
	</div>