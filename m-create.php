<div class="container-fluid">
		
	<div class="col-xs-12 col-sm-8 col-sm-offset-2">
	<div class="col-xs-12 form-group pad-free">
		<h3 class="col-xs-12" style="background:#3e5315;color:white;padding:10px;text-align:center;">Members</h3>
	</div>
	<label class="col-xs-12" style="color:red;text-align:center;">{{loginerror}}</label>
		<form class="form-horizontal row" name="regForm">
			<div class="col-sm-6">
				<div class="form-group row">
					<label class="col-xs-10">Member Name</label><label class="col-xs-1" style="color:red; font-size:1.2em;">***</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" placeholder="To show your name" name="mname" ng-model="mname" required>
					</div>
					
				</div>
				<div class="form-group row">
					<label class="col-xs-10">Login ID</label><label class="col-xs-1" style="color:red; font-size:1.2em;">***</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" placeholder="Can be included letters/numbers" name="txtloginid" ng-model="txtloginid" required>
					</div>
					
				</div>
				
				<div class="form-group row">
					<label class="col-xs-10">Password</label><label class="col-xs-1" style="color:red; font-size:1.2em;">***</label>
					<div class="col-xs-12">
						<input type="password" ng-model="pass" name="pass" placeholder="Password" ng-change='match()' class="form-control" ng-required> 
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-10">Confirm Password</label><label class="col-xs-1" style="color:red; font-size:1.2em;">***</label>
					<div class="col-xs-12">
						<input type="password" class="form-control" name="conpass" placeholder="Confrim Password" ng-model="conpass" ng-change='match()' ng-required>
						<span ng-show="IsMatch" style="color:red;">Passwords have to match!</span>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				
				<div class="form-group row">
					<label class="col-xs-12">G - Mail</label>
					<div class="col-xs-12">

						<input type="email" class="form-control" name="mail" ng-model="mail" placeholder="Optional" ng-pattern="/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/" >
					
					</div>
					
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Date of Birth</label>
					<div class="col-xs-12">
					           <input class="form-control" type="text" id="date" placeholder="mm-dd-yyyy" ng-model="tdate" datepicker >
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-10">Phone</label><label class="col-xs-1" style="color:red; font-size:1.2em;">***</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="ph" ng-model="ph" required>
					</div>
					
				</div>
				<div class="form-group row">
					<div class="col-xs-6">
						<label class="radio-inline" ng-click="showagent=false"><input type="radio" name="agent" ng-model="agent" value="1" ng-init="agent=1">Member Only</label>
					</div>
					<div class="col-xs-6">
						<label class="radio-inline" ng-click="showagent=true"><input type="radio" name="agent" ng-model="agent" value="2">Agent Member</label>
					</div>	
					<div class="col-xs-12" ng-show="showagent" style="margin-top:10px;">
						<input type="text" class="form-control" name="agentfinanceid" ng-model="agentfinanceid" placeholder="Agent Finance ID">
					</div>								
				</div>

				<div class="form-group row successmsg" ng-show="loginsuccess">
					<label class="col-xs-12" style="text-align:center;">Success !</label>
					<label class="col-xs-12">You can login now. Click Back to Login.</label>
				</div>
				
			</div>
				
				<div class="col-xs-12">
					<div class="form-group" ng-if="IsMatch==true || regForm.mail.$valid == false">					
					<div class="col-sm-offset-4 col-sm-2">
						<input type="button" ng-click='save()' class="form-control btn all-btn" disabled name="submit" value="Save" style="font-size:0.9em; margin-top:20px;">
					</div>
					<div class="col-sm-2">
						<a href="#/" class="form-control btn all-btn" style="font-size:0.9em; margin-top:20px;">Back to login</a>
					</div>
					</div>

					<div class="form-group" ng-if="IsMatch!=true && regForm.mail.$valid != false">					
					<div class="col-sm-offset-4 col-sm-2">
						<input type="button" ng-click='save()' class="form-control btn all-btn" name="submit" value="Save" style="font-size:0.9em; margin-top:20px;">
					</div>
					<div class="col-sm-2">
						<a href="#/" class="form-control btn all-btn" style="font-size:0.9em; margin-top:20px;">Back to login</a>
					</div>
					</div>
				</div>
		</form>
	
	</div>
</div>