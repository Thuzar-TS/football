<div class="row container-fluid">

<div class="col-sm-2"  ng-if="adshow==1 || adshow==2">	
	<div class="col-sm-5" style="margin-top:10px;">
		<a href="#allusr/" class="btn all-btn">Back</a>
	</div>
	<div class="col-sm-7" style="margin-top:10px;">
		<button class="btn btn-link" style="color:blue;" ng-click="exportToExcel('#fullscrolldiv')">
		      <span class="glyphicon glyphicon-share"></span>
		      Export to Excel
		</button>
	</div>
</div>
<div class="col-xs-12 col-sm-5 pull-right" style="margin-top:10px;" ng-repeat="x in total" ng-if="total!= 'Admin'">
	<div class="col-sm-6">
		<label>Welcome </label>&nbsp;&nbsp;<label style="color:blue;">: &nbsp;{{mbrname}}</label>
	</div>
	<div class="col-sm-6 pad-free">
		<label>Your Balance : </label><label  style="color:blue;">&nbsp;{{x.amount | number : fractionSize}}</label> ks
	</div>	
</div>
<div class="col-xs-12" style="margin-top:10px;">
	<div class="col-xs-2">
		<input type="text" ng-model="filtertype" name="filtertype" class="form-control" placeholder="-- Via Filter --">
	</div>
	<div class="col-sm-2" style="padding-right:0px;">
		<div class="form-group">			
			<select ng-model="datefiltertype"  name="datefiltertype" class="form-control" ng-change="typechange()">
				<option value="">Date Filter Type</option>
				<option value="btw">Between</option>
				<option value=">">Grater Than</option>
				<option value="<">Less Than</option>
				<option value="=">Equal</option>
				<option value="all">All</option>
			</select>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="col-xs-8 pad-free" ng-show="between">
			<div class="col-sm-6">
				<div class="form-group">
					<input type="text" class="form-control" name="fFilterDate" ng-model="fFilterDate" datepicker placeholder="From Date">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<input type="text" class="form-control" name="tFilterDate" ng-model="tFilterDate" datepicker placeholder="To Date">
				</div>
			</div>
		</div>
		<div class="col-xs-8 pad-free" ng-show="othertype">
			<div class="col-sm-6">
				<div class="form-group">
					<input type="text" class="form-control" name="otherdate" ng-model="otherdate" datepicker placeholder="Date">
				</div>
			</div>
		</div>
		<div class="col-xs-4" ng-show="searchbtn">
			<div class="form-group">
				<input type="button" class="form-control btn all-btn" name="searchdate" ng-model="searchdate" value="Search" ng-click="searchdate()">
			</div>
		</div>		
	</div>	
	<div class="col-sm-2">
		<button ng-click="refreshfun()" class="refresh col-xs-9">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
	</div>	
</div>
<div class="col-xs-12 col-sm-12" ng-if="userview == false">
	<div class="col-xs-12 col-sm-8 pad-free">
		<div class="col-sm-2 pad-free" style="padding-left:0px;">
			<a href='#deposite/' class="all-btn btn col-xs-10 col-xs-offset-1" style=" margin-bottom:5px;">Deposit</a>
		</div>
		<div class="col-sm-2 pad-free">
			<a href='#withdraw/' class="all-btn btn col-xs-10 col-xs-offset-1" style=" margin-bottom:5px;">Withdraw</a>
		</div>
		<div class="col-sm-2 pad-free">
			<a href='#transfer/' class="all-btn btn col-xs-10 col-xs-offset-1" style=" margin-bottom:5px;">Transfer</a>
		</div>
		<div class="col-sm-2 pad-free">
			<a href='#mledger/' class="all-btn btn col-xs-10 col-xs-offset-1" style=" margin-bottom:5px;">All</a>
		</div>
		<div class="col-sm-2 pad-free" ng-if="adshow==1 || adshow==2">
			<a href='#userlist/pagetype' class="all-btn btn col-xs-10 col-xs-offset-1" style=" margin-bottom:5px;">All Bet</a>
		</div>
		<div class="col-sm-2 pad-free">
			<a href='#allledger/' class="all-btn btn col-xs-10  col-xs-offset-1" ng-if="total== 'Admin'" style=" margin-bottom:5px;">Main Ledger</a>
			<!-- <a href='#detailledger/' class="all-btn btn col-xs-10  col-xs-offset-1" ng-if="total!= 'Admin'" style="margin-bottom:5px;">Detail Ledger</a> -->
		</div>	
			
	</div>	
</div>

<div class="col-xs-12" ng-show="mainledger" id="fullscrolldiv">
	<table class="table table-striped" id="allledger">
		<tr>
			<th>Date</th>			
			<th>Via</th>			
			<th>Amount</th>
			<!-- <th>Balance</th> -->			
		</tr>
		<tr ng-if="aa.length<1 || allresult == 'No Record'">
			<td> - </td>
			<td> No Record </td>
			<td> - </td>
		</tr>
		<tr ng-repeat="a in aa = (allresult | filter:{dates:filterDate} | filter:{alltype:filtertype})">
			<td>{{a.dates}}({{a.time}})</td>			
			<td ng-if="a.alltype=='Betting' && userview==false"><a href="#mhome/{{a.dates}}/{{a.member_id}}">{{a.alltype}}</a></td>
			<td ng-if="a.alltype=='Mix Betting' && userview==false"><a href="#mhome/{{a.dates}}/{{a.member_id}}/mix">{{a.alltype}}</a></td>
			<td ng-if="a.alltype=='Betting' && userview==true">{{a.alltype}}</td>
			<td ng-if="a.alltype=='Mix Betting' && userview==true">{{a.alltype}}</td>

			<td ng-if="a.alltype!='Betting' && a.alltype!='Mix Betting'">{{a.alltype}}</td>			
			<td class="numbers {{a.cname}}">{{a.amount | number : fractionSize}}</td>
		</tr>
	</table>
	
</div>


</div>