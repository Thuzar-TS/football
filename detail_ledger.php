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
<h3 class="col-sm-2">Detail Ledger</h3>
</div>

<div class="col-xs-12" style="margin-bottom:10px;">
	<div class="col-xs-12 col-sm-2" style="margin-top:10px;">
		<input type="text" class="form-control" ng-model="allfilter.des" placeholder="Decription" ng-init="allfilter.des=''">
	</div>
	
	<div class="col-xs-12 col-sm-2" style="margin-top:10px;">
		<input type="text" class="form-control" ng-model="allfilter.filterDate" id="date" datepicker placeholder="Date" ng-init="allfilter.filterDate=filterDate">
	</div>	
	
	<div class="col-sm-2">
		<button ng-click="refreshfun()" class="refresh col-xs-12 col-sm-9" style="margin-top:10px;">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
	</div>
	
	<div class="col-sm-2" style="margin-top:10px;" ng-if="total!= 'Admin'">
		<label class="col-xs-3">Total</label>
		<label class="col-xs-9" style="color:green;" ng-if="acolor=='green'">: {{allTotal | number : fractionSize}} ks</label>
		<label class="col-xs-9" style="color:red;" ng-if="acolor=='red'">: {{allTotal | number : fractionSize}} ks</label>
	</div>
</div>

<div class="col-xs-12">
	<div class="col-xs-12">
		<table class="table table-striped" id="allledger">
			<tr>
				<th>Date</th>
				<th>Description</th>	
				<th>Old Amount</th>		
				<th>Current Amount</th>
				<th>Changed Amount</th>
			</tr>
			<tr ng-if="detailledger.length<1 || detailledger == 'No Record'">
				<td>-</td>
				<td>No Record</td>	
				<td>-</td>		
				<td>-</td>
				<td>-</td>
			</tr>
			<tr ng-repeat="a in detailledger">
				<td>{{a.createddate}} ({{a.createdtime}})</td>
				<td>{{a.change_description}}</td>
				<td class="numbers">{{a.old_amount | number : fractionSize}}</td>
				<td class="numbers">{{a.current_amount | number : fractionSize}}</td>
				<td class="numbers {{a.classname}}">{{a.change_amount | number : fractionSize}}</td>
			</tr>
		</table>
	</div>	
</div>

</div>