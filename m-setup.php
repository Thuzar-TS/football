<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Members</h3>
	</div>
	<div class="col-xs-12 col-sm-9">

		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Member Name</th>
			<th>G-Mail</th>
			<th>Card Number</th>
			<th>Phone</th>
			<th>Date of Birth</th>
			<th>Amount</th>
			<th>City</th>
			<th colspan="2" style="text-align:center;">Action</th>
		</tr>
		<tr ng-repeat="x in names| filter:mail">
			<td>{{$index+1}}</td>
			<td>{{x.username}}</td>
			<td>{{x.mail}}</td>
			<td>{{x.cardnumber}}</td>
			<td>{{x.phone}}</td>
			<td>{{x.dob}}</td>
			<td>{{x.amount}}</td>
			<td>{{x.city}}</td>				
			<td><label ng-click="editm(x,x.member_id)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="delm(x.member_id)" style="cursor:pointer;">Delete</label></td>
		</tr>
		</table>
	</div>
	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row" name="regForm">
				<div class="form-group row">
					<label class="col-xs-12">Member Name</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="mname" ng-model="mname" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">G - Mail</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="mail" ng-model="mail" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Password</label>
					<div class="col-xs-12">
						<input type="password" ng-model="pass" name="pass" placeholder="Password" class="form-control" ng-required> 
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Confirm Password</label>
					<div class="col-xs-12">
						<input type="password" class="form-control" name="conpass" placeholder="Confrim Password" ng-model="conpass" ng-change='match()' ng-required>
						<span ng-show="IsMatch" style="color:red;">Passwords have to match!</span>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Card Number</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="card" ng-model="card">
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-xs-12">Date of Birth</label>
					<div class="col-xs-12">
					           <input class="form-control" type="text" id="date" ng-model="tdate" datepicker >
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Phone</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="ph" ng-model="ph" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">City</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="city" ng-model="city" >
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Amount</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="amount" ng-model="amount">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
						<input type="button" ng-click='save()' class="form-control btn all-btn" name="submit" value="Save" style="font-size:0.9em;" ng-show="showmember">
					</div>
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='euser(mid)'  class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showmember">
					</div>
				</div>
		</form>
	
	</div>
</div>