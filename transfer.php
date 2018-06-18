<div class="row container-fluid">

<div class="col-xs-4 col-xs-offset-4" style="position:fixed; border:1px solid white; display:none;" id="logincode">
	<p style="color:red; text-align:center; font-weight:bold; padding:10px; margin-bottom:15px;" ng-if="total!= 'Admin'">Please Enter Your Password</p>
	<p style="color:red; text-align:center; font-weight:bold; padding:10px; margin-bottom:15px;" ng-if="total== 'Admin'">Please Enter Your Code</p>
	<div class="form-group">
	        <div class="col-xs-12" style="margin-bottom: 15px;">
			<input type="password" ng-model="trancode" placeholder="Your Password Here" class="form-control">
	        </div>
	</div>
	<div class="col-xs-3 col-xs-offset-3">
		<button class="btn col-xs-12 blu-btn" ng-click="sendcode('mbr')" ng-if="total!= 'Admin'">Send</button>
		<button class="btn col-xs-12 blu-btn" ng-click="sendcode('admin')" ng-if="total== 'Admin'">Send</button>
	</div>
	<div class="col-xs-3">
		<button class="btn col-xs-12 blu-btn" ng-click="closefun()">Close</button>
	</div>
</div>

<div class="col-xs-12 col-sm-5 pull-right" style="margin-top:10px;" ng-repeat="x in total" ng-if="total!= 'Admin'">
	<div class="col-xs-12 col-sm-6">
		<label>Welcome </label>&nbsp;&nbsp;<label style="color:blue;">: &nbsp;{{mbrname}}</label>
	</div>
	<div class="col-xs-12 col-sm-6 pad-free">
		<label>Your Balance : </label><label  style="color:blue;">&nbsp;{{x.amount | number : fractionSize}}</label> ks
	</div>	
</div>

<div class="col-xs-12" style="margin-top:10px;">
<h3 class="col-xs-12 col-sm-2">Transfer</h3>
</div>

<div class="col-xs-12" style="margin-bottom:10px;">	
	<div class="col-xs-12 col-sm-2">
		<a href='#deposite/' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;">Deposit</a>
	</div>
	<div class="col-xs-12 col-sm-2">
		<a href='#withdraw/' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;">Withdraw</a>
	</div>
	<div class="col-xs-12 col-sm-2">
		<a href='#transfer/' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;">Transfer</a>
	</div>
		
	<div class="col-xs-12 col-sm-2">
		<a href='#mledger/' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;">All Ledger</a>
	</div>
	<div class="col-sm-2 pad-free" ng-if="adshow==1 || adshow==2">
		<a href='#userlist/pagetype' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;">All Bet</a>
	</div>
	<div class="col-xs-12 col-sm-2">
		<a href='#allledger/' class="all-btn btn col-xs-10 col-xs-offset-1" style="margin-top:10px;" ng-if="adshow==1">Main Ledger</a>
	</div>	
	<div class="col-sm-2" ng-if="adshow==1">
		<button class="btn btn-link" style="color:blue;" ng-click="exportToExcel('#scrolldiv')">
		      <span class="glyphicon glyphicon-share"></span>
		      Export to Excel
		</button>
	</div>	
</div>
<div class="col-xs-12">
	<form name="myForm" class="col-xs-12">
	<div class="col-xs-12 col-sm-4" id="mcard" ng-show="deporeq">
	
	<h3 class="heading" style="margin-bottom:20px;">Transfer Request</h3>
		<div class="form-group row">
			<div class="col-xs-10 col-sm-5">
				<label class="control-label">Transfer Finance ID</label>
			</div>
			<div class="col-xs-1">
				:
			</div>
			<div class="col-xs-12 col-sm-6">
				<input type="text" ng-model="transferid" name="transferid" class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-xs-10 col-sm-5">
				<label class="control-label">Amount</label>
			</div>
			<div class="col-xs-1">
				:
			</div>
			<div class="col-xs-12 col-sm-6">
				<input type="number" ng-model="amt" name="amt" class="form-control" min="0">	
				<span ng-show="myForm.amt.$valid==false" style="color:red;">Amount Invalid !</span>					
			</div>
		</div>
		<div class="form-group row">
			<div class="col-xs-10 col-sm-5">
				<label class="control-label">Message</label>
			</div>
			<div class="col-xs-1">
				:
			</div>
			<div class="col-xs-12 col-sm-6">
				<input type="text" ng-model="transfertext" name="transfertext" class="form-control">
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-sm-offset-6 pad-free">
			<div class="col-xs-12 col-sm-7">
				<input type="button" ng-click='depoself("savetran")'  class="form-control btn all-btn" name="Request" value="Request" ng-disabled="depodisable" ng-disabled="myForm.amt.$valid==false?true:false">
			</div>				
		</div>		
	</div>
	<div class="col-xs-12" id="mcard" ng-show="admindeporeq">
	<div class="col-xs-12">
		<h3 class="col-xs-6 heading" style="margin-bottom:20px;">ADMIN TRANSFER</h3>
		<div class="col-xs-6">
			<div class="col-xs-12 col-sm-6 col-sm-offset-6 pad-free">
				<div class="col-xs-12 col-sm-7 pull-right" style="margin-top:10px;">
					<input type="button" ng-click='admindepoself()'  class="form-control btn all-btn" name="Transfer" value="Transfer" ng-disabled="depodisable" ng-disabled="myForm.amt.$valid==false?true:false">
				</div>				
			</div>
		</div>
	</div>
	
		<div class="col-xs-6">
			<div class="form-group row">
				<div class="col-xs-10 col-sm-5">
					<label class="control-label">Transfer FROM ID</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-6">
					<input type="text" ng-model="transferfromid" name="transferfromid" class="form-control">
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group row">
				<div class="col-xs-10 col-sm-5">
					<label class="control-label">Amount</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-6">
					<input type="number" ng-model="adminamt" name="adminamt" class="form-control" min="0">	
					<span ng-show="myForm.adminamt.$valid==false" style="color:red;">Amount Invalid !</span>					
				</div>
			</div>			
		</div>
		
		<div class="col-xs-6">
			<div class="form-group row">
				<div class="col-xs-10 col-sm-5">
					<label class="control-label">Transfer TO ID</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-6">
					<input type="text" ng-model="transfertoid" name="transfertoid" class="form-control">
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group row">
				<div class="col-xs-10 col-sm-5">
					<label class="control-label">Message</label>
				</div>
				<div class="col-xs-1">
					:
				</div>
				<div class="col-xs-12 col-sm-6">
					<input type="text" ng-model="transfertext" name="transfertext" class="form-control">
				</div>
			</div>
		</div>
		
				
	</div>
	</form>
</div>

<div class="col-xs-12" style="margin-bottom:10px;">
	<div class="col-xs-12 col-sm-2" style="margin-top:10px;" ng-show="total== 'Admin'">
		<input type="text" class="form-control" ng-model="allfilter.filterfmbr" placeholder="From Member Name" ng-init="allfilter.filterfmbr=''">
	</div>	
	<div class="col-xs-12 col-sm-2" style="margin-top:10px;" ng-show="total== 'Admin'">
		<input type="text" class="form-control" name="filtertmbr" ng-model="allfilter.filtertmbr" placeholder="To Member Name" ng-init="allfilter.filtertmbr=''">
	</div>	
	<div class="col-xs-12 col-sm-2" style="margin-top:10px;" ng-show="total== 'Admin'">
		<input type="text" class="form-control" name="filterbk" ng-model="allfilter.filterbk" placeholder="Bank Name" ng-init="allfilter.filterbk=''">
	</div>	
	<div class="col-xs-12 col-sm-2" style="margin-top:10px;">
		<input type="text" class="form-control" name="filterDate" ng-model="allfilter.filterDate" id="date" datepicker placeholder="Date" ng-init="allfilter.filterDate=filterDate">
	</div>		
	<div class="col-sm-2">
		<button ng-click="refreshfun()" class="refresh col-xs-12 col-sm-9" style="margin-top:10px;">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
	</div>	
	<div class="col-sm-2" style="margin-top:10px;" ng-if="adshow==1 || adshow==2">
		<label class="col-xs-3">Total</label><label class="col-xs-9" style="color:green;">: {{allTotal | number : fractionSize}} ks</label>
	</div>
	<div class="col-sm-4" style="margin-top:10px;" ng-if="total!= 'Admin'">
		<label class="col-xs-5">Confirmed Total</label><label class="col-xs-7" style="color:green;">: {{allTotal1 | number : fractionSize}} ks</label>
	</div>
</div>

<div class="col-xs-12" ng-show="transfershow">
	<div class="col-xs-12" id="tranadmin">
		
		<div class="col-xs-12 pad-free" id="scrolldiv">
			<table class="table table-striped" id="allledger">
			<tr>
				<th style="width:40px;">No.</th>
				<th>Date</th>
				<th>Time</th>
				<th ng-if="total== 'Admin'">Login ID</th>
				<th>From ID</th>
				<th>To ID</th>
				<th>&nbsp;</th>
				<th>Amount</th>
			</tr>
			<tr ng-if="wdt == 'No Record' || wdt == ''">
				<td> - </td>
				<td> No Record </td>
				<td ng-if="total=='Admin'"> - </td>
				<td colspan="5"> - </td>
			</tr>
			<tr ng-repeat="x in wdt" ng-if="wdt != 'No Record' || wdt != ''">
				<td class="numbers">{{$index+1}}.</td>
				<td>{{x.action_date}}</td>
				<td>{{x.action_time}}</td>
				<td ng-if="total== 'Admin'">{{x.loginid}}</td>
				<td>{{x.fuser}}&nbsp;( {{x.fromid}} )</td>
				<td>{{x.touser}}&nbsp;( {{x.toid}} )</td>
				<td>{{x.transfertext}}</td>
				<td class="{{x.classname}} numbers" ng-if="total!='Admin'">{{x.ttamount | number : fractionSize}}</td>
				<td class="{{x.classname}} numbers" ng-if="total=='Admin'">{{x.ttamount | number : fractionSize}}</td>
			</tr>
		</table>
		</div>
		
	</div>

</div>

</div>