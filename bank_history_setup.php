<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Bank History</h3>
	</div>
	<div class="col-xs-12 col-sm-9">
		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Name</th>
			<th>Bank</th>
			<th>Card No.</th>
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		<tr ng-repeat="x in names|filter:sname">
			<td>{{$index+1}}</td>
			<td>{{x.username}}</td>
			<td>{{x.description}}</td>
			<td> {{x.cardnumber}} </td>
			<td><label ng-click="edithistory(x,x.bank_history_id)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="delhistory(x.bank_history_id)" style="cursor:pointer;">Delete</label></td>
		</tr>
		</table>
		{{alldata}}
	</div>	
	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row">
				<div class="form-group row">
					<label class="col-xs-12">Name</label>
					<div class="col-xs-12">
						<select ng-options="u as u.username for u in users track by u.member_id" ng-model="selecteduser" class="form-control" ng-required>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Bank</label>
					<div class="col-xs-12">
						<select ng-options="b as b.description for b in banks track by b.bank_id" ng-model="selectedbank" class="form-control" ng-required>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Card No.</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="cardnumber" ng-model="cardnumber" ng-required>
					</div>
				</div>				
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='save()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showhistory">
					</div>
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='edit()' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showhistory">
					</div>
				</div>	
		</form>
		
	</div>
</div>
