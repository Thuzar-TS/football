<div class="row container-fluid">
<div class="col-xs-12">
	<h3 id="allh3" class="col-xs-12">Body / Goal+ Bet User List</h3>
</div>

<div class="col-xs-12">
<div class="col-xs-12 pad-free">

<div class="col-xs-10 pad-free" ng-show="!alldayfilter">
	<label class="col-xs-3 pad-free" style="color:blue;">Total Rows &nbsp; : &nbsp; {{betusr}}</label>
	<label class="col-xs-3 pad-free" style="color:blue;">Total WL &nbsp; : &nbsp; {{wltotal | number : fractionSize}}</label>
	<label class="col-xs-3 pad-free" style="color:blue;">Total Turn Over &nbsp; : &nbsp; {{turntotal | number : fractionSize}}</label>
	<label class="col-xs-3 pad-free" style="color:blue;">Total Bet Amount &nbsp; : &nbsp; {{staketotal | number : fractionSize}}</label>
</div>
<div class="col-xs-10 pad-free" ng-show="alldayfilter">
	<label class="col-xs-3 pad-free" style="color:blue;">Total Rows &nbsp; : &nbsp; {{totalrows}}</label>
	<label class="col-xs-3 pad-free" style="color:blue;">Total WL &nbsp; : &nbsp; {{allTotalwl | number : fractionSize}}</label>
	<label class="col-xs-3 pad-free" style="color:blue;">Total Turn Over &nbsp; : &nbsp; {{allTotalto | number : fractionSize}}</label>
	<label class="col-xs-3 pad-free" style="color:blue;">Total Bet Amount &nbsp; : &nbsp; {{allTotalba | number : fractionSize}}</label>		
</div>
	
	<div class="col-sm-2 pull-right">
		<button class="btn btn-link" style="color:blue;" ng-click="exportToExcel('#exceldown')">
		      <span class="glyphicon glyphicon-share"></span>
		      Export to Excel
		</button>
	</div>	
</div>

<div class="col-xs-12 pad-free" style="margin-top:10px;" ng-show="page">
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
<div class="col-sm-8">
	<div class="col-xs-6" ng-show="between" style="padding-left:0px;">
		<div class="col-sm-6" style="padding-left:0px;">
			<div class="form-group">
				<input type="text" class="form-control" name="fFilterDate" ng-model="fFilterDate" datepicker placeholder="From Date">
			</div>
		</div>
		<div class="col-sm-6" style="padding-right:0px;">
			<div class="form-group">
				<input type="text" class="form-control" name="tFilterDate" ng-model="tFilterDate" datepicker placeholder="To Date">
			</div>
		</div>
	</div>
	<div class="col-xs-6 pad-free" ng-show="othertype">
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
</div>

	<form class="col-xs-12 pad-free" ng-show="!alldayfilter">
	<div class="col-xs-12 pad-free">		
		<div class="col-sm-2" style="padding-left:0px;">
		<div class="form-group">
			<select class="form-control" ng-model="fselect">
				<option value="">-- Body or Goal --</option>
				<option value="Body">Body</option>
				<option value="Goal">Goal+</option>
			</select>
		</div>
		</div>
		<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" ng-model="filtersel">
				<option value="">-- Bet On --</option>
				<option value="Home">Home</option>
				<option value="Away">Away</option>
				<option value="Over">Over</option>
				<option value="Down">Down</option>
			</select>
		</div>
		</div>	
		<div class="col-sm-2">
		<div class="form-group">			
			<select class="form-control" ng-model="statusfilter">
				<option value="">Status Filter(All)</option>
				<option value="Confirm">Confirm</option>
				<option value="Pending">Pending</option>
				<option value="Reject">Reject</option>
			</select>
		</div>
		</div>	
		<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" ng-model="statusall" ng-change="statusallchange(statusall)">
				<option value="">Select Status Change(All)</option>
				<option value="1">Confirm</option>
				<option value="2">Pending</option>
				<option value="3">Reject</option>
			</select>
		</div>
		</div>		
		
	</div>
	<div class="col-xs-12 pad-free">
		<div class="col-sm-2" style="padding-left:0px;">
			<div class="form-group">
				<input type="text" class="form-control" name="filterDate" ng-model="filterDate" datepicker placeholder="Date">
			</div>
		</div>
		<div class="col-sm-2">
		<div class="form-group">
			<input type="text" ng-model="usrname" class="form-control" placeholder="User Name">
		</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<input type="text" class="form-control" name="teamname" ng-model="teamname" placeholder="Team Name">
			</div>
		</div>	
		<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" ng-model="betstatusfilter">
				<option value="">Bet Status Filter</option>
				<option value="Running">Running</option>
				<option value="Waiting">Waiting</option>
				<option value="Reject">Reject</option>
				<option value="Win">Win</option>
				<option value="Lose">Lose</option>
			</select>
		</div>
		</div>	
		<!-- <div class="col-sm-1" ng-show="changeshow==true">
			<a href="#mixbetlist/" class="btn all-btn">Mix Bet</a>
		</div>
		<div class="col-sm-1" ng-show="changeshow==false">
			<a ng-click="changebg()" class="btn all-btn">Body Goal+</a>
		</div> -->
		<div class="col-sm-3 pull-right">
			<div class="col-xs-6 col-xs-offset-2" ng-show="showrefresh">
				<button ng-click="refreshuserlistfun()" class="refresh col-xs-12">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
			</div>
			<div class="col-xs-4 pull-right">
				<a href="#accdash/" class="btn all-btn">Back Home</a>
			</div>			
		</div>
	</div>	
	</form>
	<form class="col-xs-12 pad-free" ng-show="alldayfilter">
	<div class="col-xs-12 pad-free">		
		<div class="col-sm-2" style="padding-left:0px;">
		<div class="form-group">
			<select ng-model="allfilter.afilterbg" ng-options="ab.abg_name for ab in abgall track by ab.abg_id" class="form-control" ng-init="allfilter.afilterbg=abgall[0]">
			</select>
		</div>
		</div>
		<div class="col-sm-2">
		<div class="form-group">
			<select ng-model="allfilter.afilterbeton" ng-options="bb.beton_name for bb in abetonall track by bb.beton_id" class="form-control" ng-init="allfilter.afilterbeton=abetonall[0]">
			</select>			
		</div>
		</div>
		<div class="col-sm-2">
		<div class="form-group">
			<select ng-model="allfilter.astatusfilter" ng-options="aa.status_name for aa in astatusall track by aa.state_id" class="form-control" ng-init="allfilter.astatusfilter=astatusall[0]">
			</select>			
		</div>
		</div>	
		<div class="col-sm-2">
		<div class="form-group">
			<select ng-model="allfilter.abetstatusfilter" ng-options="abs.abs_name for abs in abetstatusall track by abs.abs_id" class="form-control" ng-init="allfilter.abetstatusfilter=abetstatusall[0]">
			</select>			
		</div>
		</div>	
		<div class="col-xs-2 pull-right">
			<div class="col-xs-11 pull-right" style="padding-right:0px;">
				<div class="form-group" ng-show="showrefresh">
					<button ng-click="refreshuserlistfun()" class="refresh col-xs-12">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
				</div>
			</div>
			
		</div>	
	</div>
	<div class="col-xs-12 pad-free">
		<div class="col-sm-2" style="padding-left:0px;">
			<div class="form-group">
				<input type="text" class="form-control" ng-model="allfilter.allfilterDate" datepicker placeholder="Match Date">
			</div>
		</div>
		<div class="col-sm-2">
		<div class="form-group">
			<input type="text" ng-model="allfilter.allusrname" class="form-control" placeholder="User Name">
		</div>
		</div>
		<div class="col-sm-2">
		<div class="form-group">
			<input type="text" ng-model="allfilter.allloginid" class="form-control" placeholder="LoginID">
		</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<input type="text" class="form-control" ng-model="allfilter.allteamname" placeholder="Home Team Name">
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<input type="text" class="form-control" ng-model="allfilter.allteamnamea" placeholder="Away Team Name">
			</div>
		</div>		
					
		<div class="col-sm-2" style="padding-right:0px;">
			<!-- <div class="col-xs-8" ng-show="showrefresh">
				<button ng-click="refreshuserlistfun()" class="refresh col-xs-12">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
			</div> -->
			<div class="col-xs-6">
				<div class="form-group">
					<a  href="#mixbetlist/" class="form-control btn all-btn">Mix</a>
				</div>
			</div>	
			<div class="col-xs-6">
				<a href="#accdash/" class="form-control btn all-btn" ng-show="!alldayfilter">Back Home</a>
				<a href="#mledger/" class="form-control btn all-btn" ng-show="alldayfilter">Back</a>
			</div>	
					
		</div>
	</div>	
	</form>

	<div class="col-xs-12 pad-free bgbettingshow">
		<div class="col-xs-12 pad-free" ng-show="!alldayfilter" style="overflow-x:auto; height:350px; overflow-y:auto;">
			<div style="width:2100px;">			
			<table class="w3-table-all" id="mledgertable">
			<tr>			
				<!-- <th></th> -->
				<th>Bet&nbsp;Date</th>
				<th>Bet Time</th>
				<th ng-if="adshow!=3" style="cursor:pointer;" ng-click="selectall()">All</th>
				<th>Status</th>
				<th>User</th>
				<th>LoginID</th>
				<th>BetSlipID</th>
				<th>League</th>
				<th>Home</th>
				<th>Score</th>
				<th>Away</th>
				<th colspan="2">BP or GP</th>
				<th>Bet</th>
				<th>%</th>
				
				<th>Stake</th>
				<th>W/L</th>
				<th>Turn Over</th>
				<th>Bet Status</th>
				<th>Agent</th>
				<th>Commission</th>
			</tr>

			<tr ng-if="mm.length<1 || mledger == 'No Record'">
				<td> - </td>
				<td> No Record</td>
				<td  ng-if="adshow!=3"></td>
				<td colspan="16"> - </td>
			</tr>

			<tr ng-if="mm.length>0 || mledger != 'No Record'" ng-repeat="x in mm = (mledger|filter:{bet:fselect}| filter:{bet_on:filtersel}| filter:{username:usrname} | filter:{bet_date:filterDate} | filter:{h:teamname} | filter:{a:teamname} | filter:{sdescription:betstatusfilter})">
				
				<td>{{x.bet_date}}</td>
				<td>{{x.bet_time}}</td>
				<td ng-if="x.betstateid!=1 && x.betstateid!=3"><input type="checkbox" ng-model="x.checked" ng-true-value="1" ng-false-value="0"></td>
				<td ng-if="(x.betstateid==1 || x.betstateid==3)&& adshow!=3">&nbsp;</td>
				<!-- <td ng-if="x.betstateid==1 || x.betstateid==3"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" disabled="disabled" class="form-control"></select></td> -->
				<td ng-if="adshow==1"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" class="form-control"></select></td>
				<td ng-if="adshow!=1 && adshow!=3"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" disabled="disabled" class="form-control"></select></td>
				<td style="width:100px;" ng-if="adshow==3">
					<label ng-if="x.betstateid==1">Confirmed</label>
					<label ng-if="x.betstateid==2">Pending</label>
					<label ng-if="x.betstateid==3">Reject</label>
				</td>
				<td>{{x.username}}</td>
				<td>{{x.loginid}}</td>
				<td>{{x.reference}}</td>
				<td>{{x.leaguename}}</td>
				<td>{{x.h}}</td>			
				<td>{{x.score}}</td>
				<td>{{x.a}}</td>
				<td>{{x.bg_name}}</td>
				<td>{{x.bg_value}}</td>			
				<td>{{x.betname}}</td>
				<td>{{x.per}}</td>
				
				<td class="numbers">{{x.bet_amount == "RUNNING" || x.bet_amount == "WAITING"?(x.bet_amount):(x.bet_amount | number : fractionSize)}}</td>
				<td class="numbers">{{x.result_amount == "RUNNING" || x.result_amount == "WAITING"?(x.result_amount):(x.result_amount | number : fractionSize)}}</td>
				<td class="numbers">{{x.net_amount == "RUNNING" || x.net_amount == "WAITING"?(x.net_amount):(x.net_amount | number : fractionSize)}}</td>
				<td style="text-align:right;">{{x.sdescription}}</td>
				<td>{{x.agloginid}}</td>
				<td class="numbers">{{x.commission_amt | number : fractionSize}}</td>				
			</tr>
		</table>
		</div>
		</div>

		<div class="col-xs-12 pad-free" ng-show="alldayfilter" style="overflow-x:auto; height:350px; overflow-y:auto;">
			<div style="width:2100px;">			
			<table class="w3-table-all" id="mledgertable">
			<tr>			
				<th>Bet&nbsp;Date</th>
				<th>Bet Time</th>
				<th ng-if="adshow!=3" style="cursor:pointer;" ng-click="selectall()">All</th>
				<th>Status</th>
				<th>User</th>
				<th>LoginID</th>
				
				<th>BetSlipID</th>
				<th>League</th>
				<th>Home</th>
				<th>Score</th>
				<th>Away</th>
				<th colspan="2">BP or GP</th>
				<th>Bet</th>
				<th>%</th>
				<th>Stake</th>
				<th>W/L</th>
				<th>Turn Over</th>
				<th>Bet Status</th>
				<th>Agent</th>
				<th>Commission</th>
				
			</tr>
			<tr ng-if="mledger == 'No Record' || mledger == ''">
				<td> - </td>
				<td> No Record</td>
				<td  ng-if="adshow!=3"></td>
				<td colspan="16"> - </td>
			</tr>
			<tr ng-repeat="x in mledger" ng-if="mledger != 'No Record' || mledger != ''">
						
				<td>{{x.bet_date}}</td>
				<td>{{x.bet_time}}</td>
				<td ng-if="x.betstateid!=1 && x.betstateid!=3"><input type="checkbox" ng-model="x.checked" ng-true-value="1" ng-false-value="0"></td>
				<td ng-if="(x.betstateid==1 || x.betstateid==3)&& adshow!=3">&nbsp;</td>
				<!-- <td ng-if="x.betstateid==1 || x.betstateid==3"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" disabled="disabled" class="form-control"></select></td> -->
				<td ng-if="adshow==1"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" class="form-control"></select></td>
				<td ng-if="adshow!=1 && adshow!=3"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" disabled="disabled" class="form-control"></select></td>
				<td style="width:100px;" ng-if="adshow==3">
					<label ng-if="x.betstateid==1">Confirmed</label>
					<label ng-if="x.betstateid==2">Pending</label>
					<label ng-if="x.betstateid==3">Reject</label>
				</td>
				<td>{{x.username}}</td>
				<td>{{x.loginid}}</td>
				
				<td>{{x.reference}}</td>
				<td>{{x.leaguename}}</td>
				<td>{{x.h}}</td>			
				<td>{{x.score}}</td>
				<td>{{x.a}}</td>
				<td>{{x.bg_name}}</td>
				<td>{{x.bg_value}}</td>			
				<td>{{x.betname}}</td>
				<td>{{x.per}}</td>
				<td class="numbers">{{x.bet_amount == "RUNNING" || x.bet_amount == "WAITING"?(x.bet_amount):(x.bet_amount | number : fractionSize)}}</td>
				<td class="numbers">{{x.result_amount == "RUNNING" || x.result_amount == "WAITING"?(x.result_amount):(x.result_amount | number : fractionSize)}}</td>
				<td class="numbers">{{x.net_amount == "RUNNING" || x.net_amount == "WAITING"?(x.net_amount):(x.net_amount | number : fractionSize)}}</td>
				<td style="text-align:right;">{{x.sdescription}}</td>
				<td>{{x.agloginid}}</td>
				<td class="numbers">{{x.commission_amt | number : fractionSize}}</td>
								
			</tr>
			</table>
		</div>
		</div>
	</div>	

	<!-- <div class="col-xs-12 pad-free mixbettingshow">
		<div class="col-xs-12 pad-free" ng-show="!alldayfilter" style="overflow-x:auto; height:350px; overflow-y:auto;">
			<div style="width:1600px;">			
			<table class="w3-table-all" id="mledgertable">
			<tr>			
				<th></th>
				<th>Bet Date</th>
				<th>Bet Time</th>
				<th ng-if="adshow!=3" style="cursor:pointer;" ng-click="selectall()">All</th>
				<th>Status</th>
				<th>User</th>
				<th>LoginID</th>
				<th>BetSlipID</th>
				<th>League</th>
				<th>Home</th>
				<th>Score</th>
				<th>Away</th>
				<th colspan="2">BP or GP</th>
				<th>Bet</th>
				<th>%</th>
				<th>Stake</th>
				<th>W/L</th>
				<th>Turn Over</th>
				<th>Bet Status</th>
				<th>Agent</th>
				<th>Commission</th>
			</tr>
	
			<tr ng-if="mm.length<1 || mledger == 'No Record'">
				<td> - </td>
				<td> No Record</td>
				<td  ng-if="adshow!=3"></td>
				<td colspan="16"> - </td>
			</tr>
	
			<tr ng-if="mm.length>0 || mledger != 'No Record'" ng-repeat="x in mm = (mledger|filter:{bet:fselect}| filter:{bet_on:filtersel}| filter:{username:usrname} | filter:{bet_date:filterDate} | filter:{h:teamname} | filter:{a:teamname} | filter:{sdescription:betstatusfilter})">
				<td ng-if="x.bet=='Body'">
					<select ng-model="x.accbgid" ng-options="b.accbgid as b.description for b in abody" ng-change="statuschange(x)" class="form-control"></select>
					{{x.description}}
				</td>
				<td ng-if="x.bet=='Goal+'">
					<select ng-model="x.accbgid" ng-options="g.accbgid as g.description for g in agoal" ng-change="statuschange(x)" class="form-control"></select>
					{{x.description}}
				</td>
				<td>{{x.bet_date}}</td>
				<td>{{x.bet_time}}</td>
				<td ng-if="x.betstateid!=1 && x.betstateid!=3"><input type="checkbox" ng-model="x.checked" ng-true-value="1" ng-false-value="0"></td>
				<td ng-if="(x.betstateid==1 || x.betstateid==3)&& adshow!=3">&nbsp;</td>
				<td ng-if="x.betstateid==1 || x.betstateid==3"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" disabled="disabled" class="form-control"></select></td>
				<td ng-if="adshow==1"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" class="form-control"></select></td>
				<td ng-if="adshow!=1 && adshow!=3"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" disabled="disabled" class="form-control"></select></td>
				<td style="width:100px;" ng-if="adshow==3">
					<label ng-if="x.betstateid==1">Confirmed</label>
					<label ng-if="x.betstateid==2">Pending</label>
					<label ng-if="x.betstateid==3">Reject</label>
				</td>
				<td>{{x.username}}</td>
				<td>{{x.loginid}}</td>
				<td>{{x.reference}}</td>
				<td>{{x.leaguename}}</td>
				<td>{{x.h}}</td>			
				<td>{{x.score}}</td>
				<td>{{x.a}}</td>
				<td>{{x.bg_name}}</td>
				<td>{{x.bg_value}}</td>			
				<td>{{x.betname}}</td>
				<td>{{x.per}}</td>
				<td class="numbers">{{x.bet_amount == "RUNNING" || x.bet_amount == "WAITING"?(x.bet_amount):(x.bet_amount | number : fractionSize)}}</td>
				<td class="numbers">{{x.result_amount == "RUNNING" || x.result_amount == "WAITING"?(x.result_amount):(x.result_amount | number : fractionSize)}}</td>
				<td class="numbers">{{x.net_amount == "RUNNING" || x.net_amount == "WAITING"?(x.net_amount):(x.net_amount | number : fractionSize)}}</td>
				<td style="text-align:right;">{{x.sdescription}}</td>	
				<td>{{x.agloginid}}</td>
				<td class="numbers">{{x.commission_amt | number : fractionSize}}</td>			
			</tr>
		</table>
		</div>
		</div>
	</div> -->
	
	<div class="col-xs-12 pad-free" id="exceldown" style="display:none;">
		<table class="w3-table-all" id="mledgertable">
			<tr>			
				<!-- <th></th> -->
				<th>Bet Date</th>
				<th>Bet Time</th>
				<!-- <th style="cursor:pointer;" ng-click="selectall()">All</th> -->
				<th>Status</th>
				<th>User</th>
				<th>Loginid</th>
				<th>BetSlipID</th>
				<th>League</th>
				<th>Home</th>
				<th>Score</th>
				<th>Away</th>
				<th colspan="2">BP or GP</th>
				<th>Bet</th>
				<th>%</th>
				<th>Stake</th>
				<th>W/L</th>
				<th>Turn Over</th>
				<th>Bet Status</th>
				<th>Agent</th>
				<th>Commission</th>
			</tr>

			<tr ng-repeat="x in mledger|filter:{bet:fselect}| filter:{bet_on:filtersel}| filter:{bgdescription:statusfilter}">
				
				<td>{{x.bet_date}}</td>
				<td>{{x.bet_time}}</td>
				<td style="width:100px;">
					<label ng-if="x.betstateid==1">Confirmed</label>
					<label ng-if="x.betstateid==2">Pending</label>
					<label ng-if="x.betstateid==3">Reject</label>
				</td>
				<td>{{x.username}}</td>
				<td>{{x.loginid}}</td>
				<td>{{x.reference}}</td>
				<td>{{x.leaguename}}</td>
				<td>{{x.h}}</td>			
				<td>{{x.score}}</td>
				<td>{{x.a}}</td>
				<td>{{x.bg_name}}</td>
				<td>{{x.bg_value}}</td>			
				<td>{{x.betname}}</td>
				<td>{{x.per}}</td>
				<td class="numbers">{{x.bet_amount == "RUNNING" || x.bet_amount == "WAITING"?(x.bet_amount):(x.bet_amount | number : fractionSize)}}</td>
				<td class="numbers">{{x.result_amount == "RUNNING" || x.result_amount == "WAITING"?(x.result_amount):(x.result_amount | number : fractionSize)}}</td>
				<td class="numbers">{{x.net_amount == "RUNNING" || x.net_amount == "WAITING"?(x.net_amount):(x.net_amount | number : fractionSize)}}</td>
				<td>{{x.sdescription}}</td>
				<td>{{x.agloginid}}</td>
				<td class="numbers">{{x.commission_amt | number : fractionSize}}</td>				
			</tr>
		</table>
	</div>
	
	<!-- <div class="col-xs-12 pad-free mixbettingshow" style="display:none;">
		<div class="col-xs-12 pad-free" ng-show="!alldayfilter" style="overflow-x:auto; height:350px; overflow-y:auto;">
			<div style="width:1600px;" id="exceldownmix">			
			<table class="w3-table-all" id="mledgertable">
			<tr>			
				<th></th>
				<th>Bet Date</th>
				<th>Bet Time</th>
				<th ng-if="adshow!=3" style="cursor:pointer;" ng-click="selectall()">All</th>
				<th>Status</th>
				<th>User</th>
				<th>LoginID</th>
				<th>BetSlipID</th>
				<th>League</th>
				<th>Home</th>
				<th>Score</th>
				<th>Away</th>
				<th colspan="2">BP or GP</th>
				<th>Bet</th>
				<th>%</th>
				<th>Stake</th>
				<th>W/L</th>
				<th>Turn Over</th>
				<th>Bet Status</th>
				<th>Agent</th>
				<th>Commission</th>
			</tr>
	
			<tr ng-if="mm.length<1 || mledger == 'No Record'">
				<td> - </td>
				<td> No Record</td>
				<td  ng-if="adshow!=3"></td>
				<td colspan="16"> - </td>
			</tr>
	
			<tr ng-if="mm.length>0 || mledger != 'No Record'" ng-repeat="x in mm = (mledger|filter:{bet:fselect}| filter:{bet_on:filtersel}| filter:{username:usrname} | filter:{bet_date:filterDate} | filter:{h:teamname} | filter:{a:teamname} | filter:{sdescription:betstatusfilter})">
				<td ng-if="x.bet=='Body'">
					<select ng-model="x.accbgid" ng-options="b.accbgid as b.description for b in abody" ng-change="statuschange(x)" class="form-control"></select>
					{{x.description}}
				</td>
				<td ng-if="x.bet=='Goal+'">
					<select ng-model="x.accbgid" ng-options="g.accbgid as g.description for g in agoal" ng-change="statuschange(x)" class="form-control"></select>
					{{x.description}}
				</td>
				<td>{{x.bet_date}}</td>
				<td>{{x.bet_time}}</td>
				<td ng-if="x.betstateid!=1 && x.betstateid!=3"><input type="checkbox" ng-model="x.checked" ng-true-value="1" ng-false-value="0"></td>
				<td ng-if="(x.betstateid==1 || x.betstateid==3)&& adshow!=3">&nbsp;</td>
				<td ng-if="x.betstateid==1 || x.betstateid==3"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" disabled="disabled" class="form-control"></select></td>
				<td ng-if="adshow==1"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" class="form-control"></select></td>
				<td ng-if="adshow!=1 && adshow!=3"><select ng-model="x.betstateid" ng-options="bg.betstateid as bg.description for bg in bg" ng-change="statuschange(x)" disabled="disabled" class="form-control"></select></td>
				<td style="width:100px;" ng-if="adshow==3">
					<label ng-if="x.betstateid==1">Confirmed</label>
					<label ng-if="x.betstateid==2">Pending</label>
					<label ng-if="x.betstateid==3">Reject</label>
				</td>
				<td>{{x.username}}</td>
				<td>{{x.loginid}}</td>
				<td>{{x.reference}}</td>
				<td>{{x.leaguename}}</td>
				<td>{{x.h}}</td>			
				<td>{{x.score}}</td>
				<td>{{x.a}}</td>
				<td>{{x.bg_name}}</td>
				<td>{{x.bg_value}}</td>			
				<td>{{x.betname}}</td>
				<td>{{x.per}}</td>
				<td class="numbers">{{x.bet_amount == "RUNNING" || x.bet_amount == "WAITING"?(x.bet_amount):(x.bet_amount | number : fractionSize)}}</td>
				<td class="numbers">{{x.result_amount == "RUNNING" || x.result_amount == "WAITING"?(x.result_amount):(x.result_amount | number : fractionSize)}}</td>
				<td class="numbers">{{x.net_amount == "RUNNING" || x.net_amount == "WAITING"?(x.net_amount):(x.net_amount | number : fractionSize)}}</td>
				<td style="text-align:right;">{{x.sdescription}}</td>	
				<td>{{x.agloginid}}</td>
				<td class="numbers">{{x.commission_amt | number : fractionSize}}</td>				
			</tr>
		</table>
		</div>
		</div>
	</div> -->
</div>
</div>