<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Deposit Limit</h3>
	</div>
	<div class="col-xs-12 col-sm-9">
		<table class="table table-striped">
		<tr>
			<th>Min Limit</th>
			<th>Max Limit</th>
			<th style="text-align:center;">&nbsp;</th>
		</tr>
		<tr ng-repeat="x in names">
			<td class="numbers">{{x.min | number : fractionSize}}</td>
			<td class="numbers">{{x.max | number : fractionSize}}</td>
			<td><label ng-click="editbank(x)" style="cursor:pointer;">Edit</label></td>
			<!-- <td><label ng-click="delbank(x.bank_id)" style="cursor:pointer;">Delete</label></td> -->
		</tr>
		</table>
	</div>
	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row">
				<div class="form-group row">
					<label class="col-xs-12">Min Limit</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" ng-model="minlimit" name="minlimit" required>
					</div>
				</div>	
				<div class="form-group row">
					<label class="col-xs-12">Max Limit</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" ng-model="maxlimit" name="maxlimit" required>
					</div>
				</div>				
				<div class="form-group">
					<!-- <div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='save()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showbank">
					</div> -->
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='editlimit()' class="form-control btn all-btn" ng-disabled="tlimitedit" name="edit" value="Edit">
					</div>
				</div>
		</form>
	</div>
</div>