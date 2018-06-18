<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Member Type</h3>
	</div>
	<div class="col-xs-12">
		<div class="col-xs-12 col-sm-2" style="margin-bottom:10px; padding-left:0px;">
			<input type="text" class="form-control" name="filterType" ng-model="filterType" placeholder="User Type">
		</div>	
	</div>
	
	<div class="col-xs-12 col-sm-9" style="height:450px; overflow-y:auto;">
	
		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Type Name</th>
			<th>Total Bet</th>
			<th>Min Bet</th>
			<th>Max Bet</th>
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		
		<tr ng-repeat="x in nn = (names|filter:{typename:filterType})">
			<td>{{$index+1}}</td>
			<td>{{x.typename}}</td>
			<td>{{x.totalamt}}</td>
			<td>{{x.minbet}}</td>
			<td>{{x.maxbet}}</td>
			<td><label ng-click="edittype(x,x.typeid)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="deltype(x.typeid)" style="cursor:pointer;">Delete</label></td>
		</tr>

		<tr ng-if="nn.length<1 || names == 'No Record'">
			<td>-</td>
			<td>No Record</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
		</tr>
		</table>
	</div>
	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row" name="myForm">
				<div class="form-group row">
					<label class="col-xs-12">Member Type</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" ng-model="tname" name="tname" required>
					</div>
				</div>	
				<div class="form-group row">
					<label class="col-xs-12">Total Amount</label>
					<div class="col-xs-12">
						<input type="number" ng-model="totalamt" name="totalamt" class="form-control" min="0">	
						<span ng-show="myForm.totalamt.$valid==false" style="color:red;">Amount Invalid !</span>
					</div>
				</div>	
				<div class="form-group row">
					<div class="col-sm-6 pad-free">
						<label class="col-xs-12">Min</label>
						<div class="col-xs-12">
							<input type="number" ng-model="minbet" name="minbet" class="form-control" min="0">	
							<span ng-show="myForm.minbet.$valid==false" style="color:red;">Invalid !</span>
						</div>
					</div>
					<div class="col-sm-6 pad-free">
						<label class="col-xs-12">Max</label>
						<div class="col-xs-12">
							<input type="number" ng-model="maxbet" name="maxbet" class="form-control" min="0">	
							<span ng-show="myForm.maxbet.$valid==false" style="color:red;">Invalid !</span>
						</div>
					</div>
					
				</div>				
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='save()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showtype">
					</div>
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='eteam(tid)' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showtype">
					</div>
				</div>
		</form>
	</div>
</div>