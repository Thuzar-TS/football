<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Users</h3>
	</div>
	<div class="col-xs-12 col-sm-9">
		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Name</th>
			<th>Login ID</th>
			<th>Gmail</th>
			<th>Role</th>
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		<tr ng-repeat="x in names|filter:sname">
			<td>{{$index+1}}</td>
			<td>{{x.username}}</td>
			<td>{{x.loginid}}</td>
			<td>{{x.mail}}</td>
			<td> {{x.rolename}} </td>
			<td><label ng-click="edituser(x,x.userid)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="deluser(x.userid)" style="cursor:pointer;">Delete</label></td>
		</tr>
		</table>
	</div>	
	<div class="col-xs-12 col-sm-2 col-sm-offset-1">
		<form class="form-horizontal row" name="regForm">
				<div class="form-group row">
					<label class="col-xs-12">Name</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="username" id="username" ng-model="username" ng-required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Login ID</label>
					<div class="col-xs-12">
						<label id="lblloginid" style="color:blue;">{{loginid}}</label>
						<input type="text" class="form-control" name="loginid" id="loginid" ng-model="loginid" ng-required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Email</label>
					<div class="col-xs-12">
						<input type="email" class="form-control" name="gmail" id="gmail" ng-model="gmail" ng-required  ng-pattern="/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Role</label>
					<div class="col-xs-12">
    						<select ng-options="role as role.rolename for role in roles track by role.roleid" ng-model="selectedvalue" class="form-control" ng-required>
						</select>
					</div>
				</div>	

				<div class="form-group row">
					<label class="col-xs-12">Password</label>
					<div class="col-xs-12">
						<input type="password" ng-model="pass" name="pass" placeholder="Password" ng-change='match()' class="form-control" ng-required> 
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Confirm Password</label>
					<div class="col-xs-12">
						<input type="password" class="form-control" name="conpass" placeholder="Confrim Password" ng-model="conpass" ng-change='match()' ng-required>
						<span ng-show="IsMatch" style="color:red;">Passwords have to match!</span>
					</div>
				</div>

				
				<div class="form-group" ng-if="IsMatch==true || regForm.mail.$valid == false">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='saveuser()' class="form-control btn all-btn" disabled name="submit" value="Save" ng-show="showuser">
					</div>
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='euser()' class="form-control btn all-btn" disabled name="edit" value="Edit" ng-show="!showuser">
					</div>
				</div>	
				<div class="form-group" ng-if="IsMatch!=true && regForm.mail.$valid != false"">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='saveuser()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showuser">
					</div>
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='euser()' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showuser">
					</div>
				</div>
		</form>
	</div>
</div>