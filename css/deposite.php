<div class="row container-fluid">
<div class="col-xs-12 col-sm-5 pull-right" style="margin-top:10px;" ng-repeat="x in total" ng-if="total!= 'Admin'">
	<div class="col-sm-6">
		<label>Welcome </label>&nbsp;&nbsp;<label style="color:blue;">: &nbsp;{{mbrname}}</label>
	</div>
	<div class="col-sm-6 pad-free">
		<label>Your Balance : </label><label  style="color:blue;">&nbsp;{{x.amount | number : fractionSize}}</label> ks
	</div>	
</div>
<div class="col-xs-12" style="margin-top:10px;">
<h3 class="col-sm-2">Deposit</h3>
</div>
<div class="col-xs-12" style="margin-bottom:10px;">
	
	<div class="col-sm-2">
		<a href='#deposite/' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;">Deposit</a>
	</div>
	<div class="col-sm-2">
		<a href='#withdraw/' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;">Withdraw</a>
	</div>
	<div class="col-sm-2">
		<a href='#transfer/' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;">Transfer</a>
	</div>
		
	<div class="col-sm-2">
		<a href='#mledger/' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;">All Ledger</a>
	</div>
	<div class="col-sm-2 pad-free" ng-if="adshow==1 || adshow==2">
			<a href='#userlist/pagetype' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;">All Bet</a>
		</div>
	<div class="col-sm-2">
		<a href='#allledger/' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;" ng-if="adshow==1">Main Ledger</a>
	</div>	
	<div class="col-sm-2"  ng-if="adshow==1">
		<button class="btn btn-link" style="color:blue;" ng-click="exportToExcel('#exceldown')">
		      <span class="glyphicon glyphicon-share"></span>
		      Export to Excel
		</button>
	</div>	
</div>
<div class="col-xs-12">
	<form name="myForm" class="col-xs-12">
	<div class="col-xs-12 col-sm-4" id="mcard" ng-show="deporeq">
		<div class="col-xs-12 pad-free" style="margin-bottom:10px;">
			<h3 class="heading col-xs-12 col-sm-6 pad-free">Deposit Request</h3>
			<div class="col-xs-12 col-sm-3" style="margin-top:10px;">
				<input type="button" name="self" value="Self" class="btn all-btn col-xs-12" ng-click="depoself('s')">
			</div>
			<div class="col-xs-12 col-sm-3" style="margin-top:10px;">
				<input type="button" name="profile" value="Profile" class="btn all-btn col-xs-12" ng-click="depoself('p')">
			</div>			
		</div>
		
		<div ng-show="muself">		
			<div class="form-group row">
				<div class="col-xs-10 col-sm-4">
					<label class="control-label">Bank</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-7">
					<select ng-options="b.bname for b in bank track by b.bank_history_id" ng-model="bankselect" ng-init="bankselect=bank[2]"  class="form-control" ng-change="cardselect(bankselect)">
						<option value="">-- Choose Bank --</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xs-10 col-sm-4">
					<label class="control-label">Card Number</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-7">
					<label>
						{{card}}
					</label>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-10 col-sm-4">
					<label class="control-label">Bank</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-7">
					<label>
						{{bname}}
					</label>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xs-10 col-sm-4">
					<label class="control-label">Name</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-7">
					<input type="text" name="usrname" ng-model="usrname" class="form-control">
				</div>
			</div>
			
		</div>
		<div ng-show="mprofile">
			<div class="form-group row">
				<div class="col-xs-10 col-sm-4">
					<label class="control-label">Bank</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-7">
				
				<select ng-options="b as b.bname for b in bank track by b.bank_history_id" ng-model="bankselect" class="form-control" ng-change="cardselect(bankselect)">
					<option value="">-- Choose Bank --</option>
				</select>
					<!-- <select ng-options="b.description for b in bank track by b.bank_id" ng-model="bankselect" class="form-control" ng-change="cardselect(bankselect)"></select> -->
				</div>
			</div>
			<div ng-repeat="x in total">
				
				<div class="form-group row">
					<div class="col-xs-10 col-sm-4">
						<label class="control-label">Card Number</label>
					</div>
					<div class="col-xs-1">
						:
					</div>
					<div class="col-xs-12 col-sm-7">
						<label>
							{{card}}
						</label>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-xs-10 col-sm-4">
						<label class="control-label">Bank</label>
					</div>
					<div class="col-xs-1">
						:
					</div>
					<div class="col-xs-12 col-sm-7">
						<label>
							{{bname}}
						</label>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-xs-10 col-sm-4">
						<label class="control-label">Name</label>
					</div>
					<div class="col-xs-1">
						:
					</div>
					<div class="col-xs-12 col-sm-7">
						{{usrname}}
					</div>
				</div>

			</div>			
		</div>
		<div class="col-xs-12 pad-free" ng-show="allreq">
			<div class="form-group row">
				<div class="col-xs-10 col-sm-4">
					<label class="control-label">Acc Number /NRC</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-7">
					<input type="text" ng-model="cdnum" name="cdnum" class="form-control">	
					<span style="color:red;">{{nrc}}</span>				
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xs-10 col-sm-4">
					<label class="control-label">Phone</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-7">
					<input type="text" ng-model="phone" name="phone" class="form-control">					
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xs-10 col-sm-4">
					<label class="control-label">City</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-7">
					<input type="text" ng-model="city" name="city" class="form-control">					
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xs-10 col-sm-4">
					<label class="control-label">Branch</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-7">
					<input type="text" ng-model="branch" name="branch" class="form-control">					
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xs-10 col-sm-4">
					<label class="control-label">Amount</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-7">
					<input type="number" ng-model="amt" name="amt" class="form-control" min="0">	
					<span ng-show="myForm.amt.$valid==false" style="color:red;">Amount Invalid !</span>				
				</div>
			</div>
			<div class="col-xs-12 col-sm-7 col-sm-offset-5 pad-free">
				<div class="col-xs-12 col-sm-6">
					<input type="button" ng-click='depoself("savedepo")'  class="form-control btn all-btn" name="Request" value="Request" ng-disabled="myForm.amt.$valid==false?true:false" style="margin-bottom:5px;">
				</div>
				<div class="col-xs-12 col-sm-6">
					<input type="button" ng-click='closedepo()'  class="form-control btn all-btn" name="Close" value="Close" style="margin-bottom:5px;">	
				</div>
				
				
			</div>
		</div>
			
	</div>
	</form>
</div>

<div class="col-xs-12" style="margin-bottom:10px;">
	<div class="col-xs-12 col-sm-2" style="margin-top:10px;" ng-show="statusname">
		<input type="text" class="form-control" ng-model="allfilter.filtermbr" placeholder="Member Name" ng-init="allfilter.filtermbr=''">
	</div>	
	
	<div class="col-xs-12 col-sm-2" style="margin-top:10px;">
		<input type="text" class="form-control" ng-model="allfilter.filterDate" id="date" datepicker placeholder="Date" ng-init="allfilter.filterDate=filterDate">
	</div>	
	<div class="col-xs-12 col-sm-2" style="margin-top:10px;" ng-show="bkname">
		<!-- <input type="text" class="form-control" name="filterBank" ng-model="filterBank" placeholder="Bank Name"> -->
		<select ng-options="b.bname for b in bank track by b.bank_history_id" ng-model="allfilter.filterBank" class="form-control" ng-init="allfilter.filterBank=''">
		</select>
	</div>	
	<div class="col-xs-12 col-sm-2" style="margin-top:10px;" ng-show="statusname">
		<select class="form-control" ng-model="allfilter.statusfilter" ng-options="s.status_name for s in statusall track by s.state_id" ng-init="allfilter.statusfilter=statusall[0]">				
		</select>
	</div>	
	<div class="col-xs-2">
		<button ng-click="refreshfun()" class="refresh col-xs-9" style="margin-top:10px;">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
	</div>
	<div class="col-xs-2" style="margin-top:10px;">
		<label class="col-xs-3">Total</label><label class="col-xs-9" style="color:green;">: {{allTotal | number : fractionSize}} ks</label>
	</div>
</div>
<div class="col-xs-12" ng-show="depositeshow">
	<div class="col-xs-12" id="depoadmin">		
		<div class="col-xs-12 pad-free" id="scrolldiv">		
			<table class="table table-striped" id="allledger">
			<tr>
				<th>No.</th>
				<th>Date</th>
				<th>Time</th>
				<th ng-if="total=='Admin'">LoginID</th>
				<th ng-show="statusname">Member Name</th>
				<th>Name</th>
				<th>Bank</th>
				<th>Acc Number</th>
				<th>City</th>
				<th>Phone</th>
				<th>Branch</th>
				<th>Amount</th>
				<th>&nbsp;</th>
			</tr>
			<tr ng-repeat="x in wdt">
				<td class="numbers">{{$index+1}}.</td>
				<td>{{x.action_date}}</td>
				<td>{{x.action_time}}</td>
				<td ng-if="total=='Admin'">{{x.loginid}}</td>
				<td ng-show="statusname">{{x.mname}}</td>
				<td>{{x.username}}</td>
				<td>{{x.description}}</td>
				<td>{{x.acc_nrc}}</td>
				<td>{{x.city}}</td>
				<td>{{x.ph}}</td>
				<td>{{x.branch}}</td>

				<td class="numbers">{{x.amount | number : fractionSize}}</td>
				<td style="width:100px;" ng-if="total== 'Admin'">
					<!-- <select ng-if="x.state_id == 1 || x.state_id == 3" ng-model="x.state_id" ng-options="st.state_id as st.description for st in s" disabled="disabled" class="form-control"></select> -->
					<select ng-model="x.state_id" ng-options="st.state_id as st.description for st in s" ng-change="allchange(x)" class="form-control"></select>
				</td>
				<td style="width:100px;" ng-if="total!= 'Admin'">
					<label ng-if="x.state_id==1">Confirmed</label>
					<label ng-if="x.state_id==2">Pending</label>
					<label ng-if="x.state_id==3">Reject</label>
				</td>
			</tr>
		</table>
		</div>
		<div class="col-xs-12 pad-free" id="exceldown" style="display:none;">
		
			<table class="table table-striped" id="allledger">
			<tr>
				<th>No.</th>
				<th>Date</th>
				<th>Time</th>
				<th>Loginid</th>
				<th>Member Name</th>
				<th>Name</th>
				<th>Bank</th>
				<th>Acc Number</th>
				<th>City</th>
				<th>Phone</th>
				<th>Branch</th>
				<th>Amount</th>
				<th>&nbsp;</th>
			</tr>
			<tr ng-repeat="x in wdt">
				<td class="numbers">{{$index+1}}.</td>
				<td>{{x.action_date}}</td>
				<td>{{x.action_time}}</td>
				<td>{{x.loginid}}</td>
				<td>{{x.mname}}</td>
				<td>{{x.username}}</td>
				<td>{{x.description}}</td>
				<td>{{x.acc_nrc}}</td>
				<td>{{x.city}}</td>
				<td>{{x.ph}}</td>
				<td>{{x.branch}}</td>
				<td class="numbers">{{x.amount | number : fractionSize}}</td>
				<td style="width:100px;">
					<label ng-if="x.state_id==1">Confirmed</label>
					<label ng-if="x.state_id==2">Pending</label>
					<label ng-if="x.state_id==3">Reject</label>
				</td>
			</tr>
		</table>
		</div>
	</div>
	
</div>


</div>