<div class="row container-fluid">
<div class="col-xs-12">
	<h3 id="allh3" class="col-xs-12">

	Mix Detail List
		<div class="col-sm-2 pull-right">
			<button class="btn btn-link" style="color:blue;padding:0px;" ng-click="exportToExcel('#exceldown')">
			      <span class="glyphicon glyphicon-share"></span>
			      Export to Excel
			</button>
		</div>
	</h3>
</div>
<!-- {{mixledger}} -->
<div class="col-xs-12">
	<div class="col-xs-12 pad-free">
		<div class="col-xs-10 pad-free">
			<label class="col-xs-3 pad-free" style="color:blue;">Total Mix Bet &nbsp; : &nbsp; {{totalrow}}</label>
			<label class="col-xs-3 pad-free" style="color:blue;">Total WL &nbsp; : &nbsp; {{result | number : fractionSize}}</label>
			<label class="col-xs-3 pad-free" style="color:blue;">Total Turn Over &nbsp; : &nbsp; {{turnover | number : fractionSize}}</label>
			<label class="col-xs-3 pad-free" style="color:blue;">Total Bet Amount &nbsp; : &nbsp; {{betamt | number : fractionSize}}</label>		
		</div>		
			
		<!-- <div class="col-sm-1 pad-free">
			<button class="btn btn-link" style="color:blue;padding:0px;" ng-click="exportToExcel('#exceldown')">
			      <span class="glyphicon glyphicon-share"></span>
			      Export to Excel
			</button>
		</div> -->

		<div class="col-xs-1 pad-free">
			<div class="form-group">
				<input type="button" class="form-control btn all-btn" value="Calculate" ng-click="calculatemix(mixledger,totalrow,mixid)">
			</div>
		</div>
		<div class="col-xs-1" style="padding-right:0px;">
			<div class="form-group">
				<a  href="#userlist/pagetype" class="form-control btn all-btn">All Bet</a>
			</div>
		</div>
	</div>
	<div class="col-xs-12 pad-free" style="margin-top:10px;">
	<div class="col-sm-2" style="padding-left:0px;">
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
	<div class="col-sm-6" style="padding-left:0px;">
		<div class="col-xs-8 pad-free" ng-show="between">
			<div class="col-sm-6" style="padding-left:0px;">
				<div class="form-group">
					<input type="text" class="form-control" name="fFilterDate" ng-model="fFilterDate" datepicker placeholder="From Date">
				</div>
			</div>
			<div class="col-sm-6" style="padding-left:0px;">
				<div class="form-group">
					<input type="text" class="form-control" name="tFilterDate" ng-model="tFilterDate" datepicker placeholder="To Date">
				</div>
			</div>
		</div>
		<div class="col-xs-8 pad-free" ng-show="othertype">
			<div class="col-sm-6" style="padding-left:0px;">
				<div class="form-group">
					<input type="text" class="form-control" name="otherdate" ng-model="otherdate" datepicker placeholder="Date">
				</div>
			</div>
		</div>
		<div class="col-xs-2" ng-show="searchbtn">
			<div class="form-group">
				<input type="button" class="form-control btn all-btn" name="searchdate" ng-model="searchdate" value="Search" ng-click="searchdate(chyearcombo.year)">
			</div>
		</div>		
	</div>	
	<div class="col-sm-2">
		<div class="form-group">
			<select ng-model="chyearcombo" name="chyearcombo" ng-change="changeyear(chyearcombo)" ng-options="mm.year for mm in yeararr track by mm.year" class="form-control" ng-init="chyearcombo.year=currenty">
			</select>
		</div>
	</div>
	<div class="col-sm-2 pull-right" style="padding-right:0px;">
		<div class="form-group">
			<select ng-model="comcal" ng-change="calculatecom(x)" ng-options="mm.mixname for mm in mixarray track by mm.mix_id" class="form-control">
			</select>
		</div>
	</div>	
	</div>
	<div class="col-xs-12 pad-free">
		<div class="col-xs-4 pad-free">
			<!-- <div class="col-sm-4" style="padding-left:0px;">
			<div class="form-group">
				<input type="text" class="form-control" ng-model="allfilter.filterDate" datepicker placeholder="Bet Date">
			</div>
			</div> -->
			<div class="col-sm-6" style="padding-left:0px;">
			<div class="form-group">
				<input type="text" ng-model="allfilter.usrname" class="form-control" placeholder="Member Name">
			</div>
			</div>

			<div class="col-sm-6" style="padding-left:0px;">
			<div class="form-group">
				<input type="text" ng-model="allfilter.loginid" class="form-control" placeholder="Login ID">
			</div>
			</div>
		</div>

		
		
		<div class="col-sm-2">
		<div class="form-group">
			<select ng-model="allfilter.abetstatusfilter" ng-options="abs.description for abs in abetstatusall track by abs.status_id" class="form-control" ng-init="allfilter.abetstatusfilter=abetstatusall[0]">
			</select>			
		</div>
		</div>	

		<div class="col-sm-2">
		<div class="form-group">
			<select ng-model="allfilter.betstatefilter" ng-options="bs.description for bs in betstate track by bs.bs_gs_id" class="form-control" ng-init="allfilter.betstatefilter=betstate[0]">
			</select>			
		</div>
		</div>	

		<!-- <div class="col-sm-2">
				<div class="form-group">
					<select ng-model="allfilter.chbetstatefilter" ng-options="bs.description for bs in chbetstate track by bs.bs_gs_id" class="form-control" ng-init="allfilter.chbetstatefilter=chbetstate[0]">
					</select>			
				</div>
				</div> -->	
		<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" ng-model="statusall" ng-change="statusallchange(statusall)">
				<option value="">-- Change Selected  --</option>
				<option value="1">Confirm</option>
				<option value="2">Pending</option>
				<option value="3">Reject</option>
				<option value="9">Cancel</option>
			</select>
		</div>
		</div>	
		<div class="col-sm-2" style="padding-right:0px;">
		
			<div class="form-group">
				<select ng-model="allfilter.mixfilter" ng-options="m.mixname for m in mixdata track by m.mix_id" class="form-control" ng-init="allfilter.mixfilter=mixdata[0]">
				</select>			
			</div>
		
		<!-- <div class="col-sm-5" style="padding-right:0px;">
			<div class="form-group">
				<input type="button" class="form-control btn all-btn" value="Com" ng-click="calculatemix(mixledger,totalrow,mixid)">			
			</div>
		</div> -->
		
		</div>
	</div>	

	<div class="col-xs-12 pad-free" style="overflow-x:auto; height:390px; overflow-y:auto;">
		<div style="width:2100px;" id="exceldown">			
			<table class="table table-striped" style="margin-top:0px;" id="mixbetlisttbl">
				<tr>	
					<th ng-click="selectall()" style="cursor:pointer;">All</th>
					<th>Bet&nbsp;Date</th>
					<th>Bet&nbsp;Time</th>
					<th>Status</th>
					<th>Login&nbsp;ID</th>
					<th>Member</th>
					<th>Mix</th>
					<th>BetSlipID</th>	
					<th>&nbsp;</th>
					<th>MPP</th>				
										
					<th>M%</th>
					<th>Stake</th>
					<th>Result&nbsp;Amount</th>
					<th>Turn&nbsp;Over</th>
					<th>Bet Status</th>
					<th>Agent</th>
					<th>Commission</th>
				</tr>
				<tr ng-if="mixledger == '' || mixledger.length<1">
					<td> - </td>
					<td> No Record </td>
					<td colspan="13"> - </td>
				</tr>
				<tr ng-repeat="x in mixledger | groupBy: '[mid]'">
					<td><input type="checkbox" ng-model="x[0].checked" ng-true-value="1" ng-false-value="0"></td>
					<!-- <td>{{x[0].sname}}</td> -->
					<td>{{x[0].bet_date}}</td>
					<td>{{x[0].bet_time}}</td>
					<td>{{x[0].bgdescription}}</td>
					<td>{{x[0].loginid}}</td>
					<td>{{x[0].username}}</td>								
					<td>{{x[0].mixname}} Mix Betting</td>
					<td>{{x[0].reference}}</td>
					<td>
						<table class="table table-hover" style="border:0px;margin:0px;background:none;" id="innertbl">
							<tr style="border:0px;">
								<th>Match</th>
								<th>Home</th>
								<th>Score</th>
								<th>Away</th>
								<th colspan="2">BP&nbsp;or&nbsp;GP</th>
								<th>Bet</th>
								<th>%</th>
								<th>Status</th>
								<th>MP</th>
							</tr>
							<tr ng-repeat="xx in x" style="border:0px;">
								<td style="border:0px; width:18%">{{xx.leaguename}}</td>
								<td style="border:0px; width:18%">{{xx.h}}</td>
								<td style="border:0px; width:10%">{{xx.score}}</td>
								<td style="border:0px; width:18%">{{xx.a}}</td>
								<td style="border:0px; width:8%">{{xx.bgname}}</td>
								<td style="border:0px; width:4%">{{xx.bgvalue}}</td>
								<td style="border:0px; width:14%">{{xx.bet_on_name}}</td>
								<td style="border:0px; width:4%">{{xx.bgper}}</td>
								<td style="border:0px; width:6%">{{xx.ddescription}}</td>
								<td style="border:0px; width:6%">{{xx.mp}}</td>
							</tr>
						</table>						
					</td>
					<td>{{x[0].mpp}}</td>
					
					<td>{{x[0].mmval}}</td>
					<td>{{x[0].bet_amount | number : fractionSize}}</td>
					<td class="numbers {{x[0].sname}}">{{x[0].result_amount == "RUNNING" || x[0].result_amount == "WAITING"?(x[0].result_amount):(x[0].result_amount | number : fractionSize)}}</td>
					<td class="numbers {{x[0].sname}}">{{x[0].net_amount == "RUNNING" || x[0].net_amount == "WAITING"?(x[0].net_amount):(x[0].net_amount | number : fractionSize)}}</td>
					<!-- <td>{{x[0].result_amount}}</td>
										<td>{{x[0].net_amount}}</td> -->					
					<td class="{{x[0].sname}}">{{x[0].sdescription}}</td>
					<td>{{x[0].agloginid}}</td>
					<td class="numbers">{{x[0].commission_amt}}</td>
				</tr>
			</table>
		</div>
	</div>

</div>
</div>