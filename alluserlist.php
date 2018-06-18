<div class="container-fluid">
<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
	<div class="col-xs-12 form-group pad-free" style="margin-bottom:0px;">
		<h3 id="allh3" class="col-xs-12">All Users List</h3>
	</div>	
	
	<div class="col-xs-12 pad-free" style="margin-bottom:10px;">
		<div class="list-group col-xs-2 pad-free" style="margin-bottom:5px;">
			<div class="list-group-item list-group-item-success col-xs-12" style="margin-bottom:10px;background:none;border:0px;">
			  <label class="col-xs-9 pad-free" style="font-size:0.8em;">Create Member Off</label> 
			  <label class="switch col-xs-3 pad-free">
	     			<input type="checkbox" ng-model="creatememberoff">
	     			<div class="slider round" ng-click="creatembroff(creatememberoff);"></div>
      				   </label>
			 </div>
		</div>
		<div class="col-xs-2 col-xs-offset-2">
			<input type="text" class="form-control" name="filtername" ng-model="filtername" placeholder="Member Name">
		</div>	
		<div class="col-xs-2">
			<input type="text" class="form-control" name="searchloginid" ng-model="searchloginid" placeholder="Login ID">
		</div>	
		<div class="col-xs-2">
			<input type="text" class="form-control" name="filteramt" ng-model="filteramt" placeholder="Amount">
		</div>
		<div class="col-xs-2">
			<input type="text" class="form-control" name="agloginid" ng-model="agloginid" placeholder="Agent ID">
		</div>
			
	</div>
	
	<div class="col-xs-12 pad-free" style="text-transform: capitalize;">
		<div class="col-xs-1" style="padding-left:0px;">
			<button ng-click="allfunonoff()" class="form-control blu-btn" style="font-size:0.8em; border:1px solid #a0a0a0; border-radius:52px; height:88px;">ON / OFF</button>
		</div>
		<div class="col-xs-4" style="line-height:25px;">
			<div class="col-xs-12" ng-repeat="x in totaloff" ng-if="totaloff!='No Record'">
				<div class="col-xs-6" ng-if="x.onofftype != 'commissiononoff' && x.onofftype != 'mixbettingonoff'">
					{{x.onofftype}}
				</div>
				<div class="col-xs-6" ng-if="x.onofftype == 'commissiononoff'">
					Commission ON
				</div>
				<div class="col-xs-6" ng-if="x.onofftype == 'mixbettingonoff'">
					Mix Betting ON
				</div>
				<div class="col-xs-2">
					:
				</div>
				<div class="col-xs-4" style="color:red;">
					{{x.totaloff}}
				</div>
			</div>
		</div>
		<div class="col-xs-5 pull-right">
		   <div class="col-sm-5">
		   	<div class="form-group">
			<select ng-model="agentfilter" class="form-control">
				<option value="">-- Agent / Member --</option>
				<option value="0">Member</option>
				<option value="!0">Agent</option>
			</select>
			</div>		
			<div class="form-group">			
				<select ng-options="onf as onf.onoff_name for onf in onoffarray track by onf.onoff_type" ng-change="onofffilter(filteronoff)" ng-model="filteronoff" class="form-control">
					<option value="">-- On / Off Filter --</option>
				</select>
			</div>	
		   </div>
		   <div class="col-sm-7 pad-free" style="border:1px solid #ccc; border-radius:3px; padding-top:10px;">
		   	<div class="col-xs-12">
				 <label style="color:blue; font-size:1.2em;">Total Amount &nbsp; : &nbsp; {{amounttotal | number : fractionSize}}</label>
			</div>
			<div class="col-xs-12" ng-if="adshow==1">
				<label style="color:blue; font-size:1.2em;">Total Members &nbsp; : &nbsp; {{mbrtotal}}</label>
				<label style="color:blue; font-size:1.2em;">Total Agents &nbsp; : &nbsp; {{agenttotal}}</label>				
			</div>
			<div class="col-xs-12 pad-free">
				<button class="btn btn-link" style="color:blue;" ng-click="exportToExcel('#exceldown')">
				      <span class="glyphicon glyphicon-share"></span>
				      Export to Excel
				</button>
			</div>
		   </div>
			
		</div>
		
		<!-- <table class="table table-striped" style="border:0px; font-size:0.8em; margin-top:0px; margin-bottom:0px;  ">
			<tr ng-repeat="x in totaloff" style="">
				<td style="border:0px; text-transform: capitalize;">{{x.onofftype}}</td><td style="border:0px;">:</td><td style="border:0px;">{{x.totaloff}}</td>
			</tr>
		</table> -->
	</div>
		<div class="col-xs-12 pad-free" style="height:350px; overflow:auto;margin-top:5px;">
		<div style="width:1400px;">
		<table class="table table-striped">
			<tr>
				<th ng-if="adshow==1">&nbsp;</th>
				<th>No.</th>
				<th>Date</th>
				<th ng-if="adshow==1">Login ID</th>
				<th>Member Name</th>				
				<th>Finance ID</th>
				<th>Mail</th>
				<th>Phone</th>
				<th>Agent</th>				
				<th>Balance</th>
				<th>View</th>
				<th ng-if="adshow==1">&nbsp;</th>				
			</tr>

			<tr ng-if="auser.length<1 || auser == '' || alluser == 'No Record'">
				<td> - </td>
				<td> No Record </td>
				<td ng-if="adshow==1" colspan="3"> - </td>
				<td colspan="7"> - </td>
			</tr>
			
			<tr ng-repeat="x in auser = (alluser | filter:{agentloginid:agloginid} | filter:{username:filtername} | filter:{loginid:searchloginid} | filter:{amount:filteramt} | filter:{agentid:agentfilter})">
				<td style="font-size:0.8em;" ng-if="adshow==1">
				       <a ng-click="funonoff(x.member_id,x.username)">ON/OFF</a>
				</td>
				<!-- <td ng-if="adshow==1"><input type="checkbox" ng-true-value="1" ng-false-value="0" ng-change="transferOff(junjun[x.loginid],x.member_id)" ng-model="junjun[x.loginid]"/></td> -->
				<td>{{$index+1}}</td>
				<td>{{x.cdate}}</td>
				<td ng-if="adshow==1">{{x.loginid}}</td>
				<td>{{x.username}}</td>
				<td>'{{x.financeid}}'</td>
				<td>{{x.mail}}</td>
				<td>{{x.phone}}</td>
				<td style="text-align:center;">{{x.agentloginid}}</td>				
				<td class="numbers">{{x.amount | number : fractionSize}}</td>
				<td><a href="#profile/{{x.member_id}}">Profile</a></td>
				<td ng-if="adshow==1"><a ng-click="alluserdel(x)">Delete</a></td>				
			</tr>
		</table>
		</div>
		</div>

		<div class="col-xs-12 pad-free" id="exceldown" style="display:none;">
			<table class="table table-striped">
				<tr>
					<th>No.</th>
					<th>Created Date</th>
					<th>Member Name</th>
					<th>Login ID</th>
					<th>Finance ID</th>
					<th>Mail</th>
					<th>Phone</th>							
					<th>Balance</th>				
				</tr>
				
				<tr ng-repeat="x in alluser | filter:{username:filtername}">
					<td>{{$index+1}}</td>
					<td>{{x.cdate}}</td>
					<td>{{x.username}}</td>
					<td>{{x.loginid}}</td>
					<td>'{{x.financeid}}'</td>
					<td>{{x.mail}}</td>
					<td>'{{x.phone}}'</td>							
					<td class="numbers">{{x.amount | number : fractionSize}}</td>				
				</tr>
			</table>
		</div>
	
	<div class="col-xs-4 col-xs-offset-4" style="position:fixed; top:50px; border:1px solid white;" id="whiteoverlay">
		<h3 id="allh3" style="margin-top:0px;">OFF <label style="color:blue; font-size:0.5em;">[ {{thismembername}} ]</label></h3>
		<div class="col-xs-12">
			<div class="list-group col-xs-12 pad-free" ng-repeat="x in onoffarray" style="margin-bottom:5px;">
				<div class="list-group-item list-group-item-success col-xs-12" style="margin-bottom:10px;"><label class="col-xs-10 pad-free">{{x.onoff_name}}</label> 
				  <label class="switch col-xs-2 pad-free">
				     		<input type="checkbox" ng-model="onoffarr[x.onoff_type]">
				     		<div class="slider round" ng-click="changeStatus(x.onoff_type);"></div>
                  				   </label>
				 </div>
			</div>			
		</div>
		<div class="col-xs-12">
			<div class="col-xs-3 col-xs-offset-6">
				<button class="btn col-xs-12 all-btn" style="background:#2e7d32;" ng-click="changeonoff()">Change</button>
			</div>
			<div class="col-xs-3">
				<button class="btn col-xs-12 all-btn" ng-click="closefun()" style="background:#2e7d32;">Close</button>
			</div>
		</div>		
	</div>

	<div class="col-xs-4 col-xs-offset-4" style="position:fixed; top:50px; border:1px solid white;" id="whiteoverlayall">
		<h3 id="allh3" style="margin-top:0px;">OFF ALL</h3>
		<div class="col-xs-12">
			<div class="list-group col-xs-12 pad-free" ng-repeat="x in onoffarray" style="margin-bottom:5px;">
				<div class="list-group-item list-group-item-success col-xs-12" style="margin-bottom:10px;">
				  <label class="col-xs-10 pad-free">{{x.onoff_name}}</label> 
				  <label class="switch col-xs-2 pad-free">
		     			<input type="checkbox" ng-model="onoffarr[x.onoff_type]">
		     			<div class="slider round" ng-click="changeStatus(x.onoff_type);"></div>
          				   </label>
				 </div>
			</div>						
		</div>
		<div class="col-xs-12">
			<div class="col-xs-3 col-xs-offset-6">
				<button class="btn col-xs-12 all-btn" style="background:#2e7d32;" ng-click="changeonoff()">Change</button>
			</div>
			<div class="col-xs-3">
				<button class="btn col-xs-12 all-btn" ng-click="closefun()" style="background:#2e7d32;">Close</button>
			</div>
		</div>		
	</div>
</div>