<div class="row container-fluid">
<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
<div class="col-xs-12">
	<h3 id="allh3" class="col-xs-12">Reset Password</h3>
</div>



<div class="col-xs-4 col-xs-offset-4" id="whiteoverlay" style="position:fixed; top:50px; border:1px solid white;">
	<h3 id="allh3" style="margin-top:0px; padding:10px;">RESET PASSWORD</h3>
	<div class="col-xs-12">
		<div class="col-xs-12 pad-free" style="height:290px;">
		<table class="table table-striped">
			<tr>
				<td style="border:1px solid #fff;">Member Name</td>
				<td style="border:1px solid #fff;">:</td>
				<td style="border:1px solid #fff;">{{mbrname}}</td>
			</tr>
			<tr>
				<td style="border:1px solid #fff;">Login ID</td>
				<td style="border:1px solid #fff;">:</td>
				<td style="border:1px solid #fff;">{{mbrloginid}}</td>
			</tr>
			<tr>
				<td style="border:1px solid #fff;">Mail</td>
				<td style="border:1px solid #fff;">:</td>
				<td style="border:1px solid #fff;">{{mbrmail}}</td>
			</tr>

		</table>

		<div class="form-group row">
			<!-- <label class="col-xs-10">Password</label><label class="col-xs-1" style="color:red; font-size:1.2em;">***</label> -->
			<div class="col-xs-12">
				<input type="password" ng-model="repass" name="repass" placeholder="Reset Password" ng-change='match()' class="form-control" ng-required> 
			</div>
		</div>
		<div class="form-group row">
			<!-- <label class="col-xs-10">Confirm Password</label><label class="col-xs-1" style="color:red; font-size:1.2em;">***</label> -->
			<div class="col-xs-12">
				<input type="password" class="form-control" name="conpass" placeholder="Confrim Password" ng-model="conpass" ng-change='match()' ng-required style="margin-bottom:10px;">
				<span ng-show="IsMatch" style="color:red;">Passwords have to match!</span>
			</div>
		</div>
	
	</div>	
		
	</div>
	<div class="col-xs-12  pad-free" style="border-top:1px solid #ccc; padding-top:10px;">
		<div class="col-xs-3 col-xs-offset-3">
			<input type="button" ng-click="resetfun()" value="Reset" class="btn all-btn form-control" ng-disabled="IsMatch==true">
		</div>
		<div class="col-xs-3">
			<input type="button" ng-click="cancelfun()" value="Cancel" class="btn all-btn form-control">
		</div>
	</div>
</div>

<div class="col-xs-12">
	<div class="col-xs-12 pad-free"> 
		<div class="col-xs-2" style="margin-top:10px; margin-bottom:10px;">
			<input type="text" class="form-control" name="filtername" ng-model="filtername" placeholder="Member Name">
		</div>	
		<div class="col-xs-2" style="margin-top:10px; margin-bottom:10px;">
			<input type="text" class="form-control" name="searchloginid" ng-model="searchloginid" placeholder="Login ID">
		</div>	
	</div>
	
	<div class="col-xs-12 pad-free" style="height:450px; overflow-y:auto;">
		<table class="table table-striped">
			<tr>
				<th>No.</th>
				<th>Member Name</th>
				<th>Login ID</th>
				<th>Mail</th>
				<th>&nbsp;</th>
			</tr>
			
			<tr ng-repeat="x in allmembers | filter:{username:filtername} | filter:{loginid:searchloginid}">
				<td>{{$index+1}}</td>				
				<td>{{x.username}}</td>
				<td>{{x.loginid}}</td>
				<td>{{x.mail}}</td>
				<td><a ng-click="resetpass(x)">RESET</a></td>
			</tr>
		</table>
	</div>
</div>
</div>