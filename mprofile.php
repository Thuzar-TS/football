<div class="container-fluid">
<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
	<div class="col-xs-12 form-group">
		<h3 class="col-xs-12 col-sm-1">Profile</h3>
		<div class="col-xs-2">
			<div class="list-group col-xs-12 pad-free" style="margin-bottom:5px; margin-top:17px;" ng-show="!aaa">
				<div class="list-group-item list-group-item-success col-xs-12" style="padding:5px 15px;background:transparent; border:0px;"> 
				  	<label class="switch col-xs-6 pad-free" style="margin-bottom:0px;">
				     		<input type="checkbox" ng-model="agentval" ng-click="agenton()" ng-disabled="agentdisable">
				     		<div class="slider round"></div>
                  				</label>
                  				<label class="col-xs-6">Agent</label>
				 </div>
			</div>	
			<label class="col-xs-6" ng-if="agentval==true && aaa==true && onoffagent==false" style="margin-top:20px; color:green; ">( Agent )</label>	
		</div>
		<div class="col-xs-3" ng-show="agentdisable">
			<div class="col-xs-6" ng-if="onoffagent==false || aaa==false">
				<a href="#agentuserlist/{{mid}}" class="all-btn btn" style=" margin-top:17px;">Agent User List</a>				
			</div>
			<div class="col-xs-6">
				<button class="all-btn btn" ng-if="aaa==false" style=" margin-top:17px;" ng-click="editagent(mid)">
					Edit Agent
				</button>
			</div>
		</div>
		<div class="col-xs-4 pull-right">
			<div class="col-xs-5" ng-show="!aaa">
				<a href="#mledger/{{mid}}" class="all-btn btn" style=" margin-top:17px;">
					User All Ledger
				</a>
			</div>
			<h3 class="col-xs-12 col-sm-7" ng-repeat="x in mp" style="font-weight:bold; font-size:1em;">BALANCE : <label style="color:blue;">{{x.amount | number : fractionSize}}</label> ks</h3>
		
		</div>
	</div>

	<div class="col-xs-12">

		<div class="col-xs-12 col-sm-6" ng-repeat="x in mp" id="mprofile">
		<div class="col-xs-12" ng-show="!aaa" style="margin-bottom:10px;">
			<label class="col-xs-3">Member Type</label>
			<div class="col-xs-1">:</div>
			<div class="col-xs-8">
				<label style="color:blue;" class="col-sm-6 pad-free">{{x.typename}}</label>
				<div class="col-sm-6">
					<select ng-options="b.typename for b in usertype track by b.typeid" ng-change="changemembertype(membertype,x.member_id)" ng-model="membertype" class="form-control" style="padding-bottom:1px;padding-top:1px;height:24px;font-size:0.8em;">
						
					</select>

				</div>						
			</div>
		</div>
		<table class="table table-striped">
			
			<tr>
				<td>LoginID</td>
				<td>:</td>
				<td>{{x.loginid}}</td>
			</tr>
			<tr>
				<td>Name</td>
				<td>:</td>
				<td>{{x.username}}</td>
			</tr>
			<tr>
				<td>Finance ID</td>
				<td>:</td>
				<td>{{fid}}</td>
			</tr>
			<tr>
				<td>G-Mail</td>
				<td>:</td>
				<td>{{x.mail}}</td>
			</tr>
			<tr>
				<td>Phone</td>
				<td>:</td>
				<td>{{x.phone}}</td>
			</tr>
			<tr>
				<td>Date of Birth</td>
				<td>:</td>
				<td>{{x.dob}}</td>
			</tr>
			<tr>
				<td>Amount</td>
				<td>:</td>
				<td><label style="color:blue;">{{x.amount | number : fractionSize}}</label> ks</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr ng-show="x.agentid != 0 && x.youragent == '-'">
				<td>BG win %</td>
				<td>:</td>
				<td>{{x.winper}} %</td>
			</tr>
			<tr ng-show="x.agentid != 0 && x.youragent == '-'">
				<td>BG lose %</td>
				<td>:</td>
				<td>{{x.loseper}} %</td>
			</tr>
			<tr ng-show="x.agentid != 0 && x.youragent == '-'">
				<td>MIX win %</td>
				<td>:</td>
				<td>{{x.mixwinper}} %</td>
			</tr>
			<tr ng-show="x.agentid != 0 && x.youragent == '-'">
				<td>MIX lose %</td>
				<td>:</td>
				<td>{{x.mixloseper}} %</td>
			</tr>
			<tr ng-show="x.agentid == 0 && x.youragent != '-'">
				<td>Your Agent</td>
				<td>:</td>
				<td>{{x.youragent}}</td>
			</tr>
			<tr ng-show="x.membertype != 0">
				<td>Your user type</td>
				<td>:</td>
				<td>{{x.typename}}</td>
			</tr>
			<tr ng-show="x.membertype != 0">
				<td>Your Bet Total Limit</td>
				<td>:</td>
				<td><label style="color:blue;">{{x.totalamt | number : fractionSize}}</label> ks</td>
			</tr>
			<tr ng-show="x.membertype != 0">
				<td>Your minimun Bet</td>
				<td>:</td>
				<td><label style="color:blue;">{{x.minbet | number : fractionSize}}</label> ks</td>
			</tr>
			<tr ng-show="x.membertype != 0">
				<td>Your maximum Bet</td>
				<td>:</td>
				<td><label style="color:blue;">{{x.maxbet | number : fractionSize}}</label> ks</td>
			</tr>
		</table>
		
		<!-- <div class=" col-xs-12 col-sm-2 pad-free" ng-show="aaa">
			<button class="all-btn btn" ng-click="editprofile(x)">Change Password</button>
		</div> -->
			
		</div>
		<div class="col-xs-12 col-sm-6" id="mcard">
		<div>
			<h3 class="heading">Your Cards</h3>
		</div>
		<div class="col-xs-12 pad-free" id="cardinsert">
			<form class="form-horizontal">
				<div class="form-group row">
				<div class="col-xs-12 col-sm-4" style="margin-bottom:5px;">
					<select ng-options="b.description for b in bks track by b.bank_id" ng-model="bankselect" class="form-control">
						<option value="">-- Choose --</option>
					</select>
				</div>
				<div class="col-xs-12 col-sm-6" style="margin-bottom:5px;">
					<input type="text" class="form-control" name="cardnum" ng-model="cardnum" placeholder="Card Number">
				</div>
				<div class="col-xs-12 col-sm-2">
					<input type="button" ng-click='addcard()'  class="form-control btn all-btn" name="add" value="Add" ng-show="cardbtn" style="margin-bottom:5px;">
					<input type="button" ng-click='ecard()'  class="form-control btn all-btn" name="add" value="Edit" ng-show="!cardbtn" style="margin-bottom:5px;">
				</div>
				</div>					
			</form>
		</div>
		<div class="col-xs-12 pad-free" ng-repeat="x in mp">			
			
			<table class="table table-striped">
				<tr>
					<th>No.</th>
					<th>Bank</th>
					<th>Card</th>
					<th colspan="2">Action</th>
				</tr>
				<tr ng-repeat="b in bkcard">
					<td>{{$index+1}}</td>
					<td>{{b.description}}</td>
					<td>{{b.cardnumber}}</td>
					<td><label ng-click="editcard(b)" style="cursor:pointer;">Edit</label></td>
					<td><label ng-click="delcard(b.bank_history_id)" style="cursor:pointer;">Delete</label></td>
				</tr>
			</table>						
		</div>
		<div class="col-xs-12">
			<a ng-click="changepass()">Change Password</a>
		</div>
		<div class="col-xs-12" style="margin-top:10px;">
		<form class="form-horizontal row" name="regForm">			
		
		<div class="col-xs-12" style="display:none;" id="cpassword">
			<div class="col-xs-12 pad-free">
				<div class="form-group row">
					<label class="col-xs-12">Current Password</label>
					<div class="col-xs-12">
						<input type="password" ng-model="oldpass" name="oldpass" placeholder="Password" class="form-control" ng-required> 
					</div>					
				</div>
				
				<div class="form-group row">					
					<label class="col-xs-12">New Password</label>
					<div class="col-xs-12">
						<input type="password" ng-model="pass" name="pass" placeholder="Password" class="form-control" ng-required> 
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12">Confirm Password</label>
					<div class="col-xs-12">
						<input type="password" class="form-control" name="conpass" placeholder="Confrim Password" ng-model="conpass" ng-change='match()' ng-required>
						<span ng-show="IsMatch" style="color:red;">Passwords have to match!</span>
					</div>
				</div>
			</div>
		<div class="col-xs-12">
		<div class="col-xs-12 col-sm-10">
				<label style="color:red;">{{errorprofile}}</label>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				<div class="col-xs-12 col-sm-6">
					<input type="button" ng-click='eprofile()'  class="form-control btn all-btn" name="edit" value="Save">
				</div>
				<div class="col-xs-12 col-sm-6">
					<input type="button" ng-click='editshow=false'  class="form-control btn all-btn" name="cancle" value="Cancel">
				</div>
			</div>
		</div>
			
		</div>
		</div>						
		</form>	
	</div>
		</div>

	</div>
	
	
	<div class=" col-xs-12" ng-show="!aaa">
		
		<div class="col-sm-1">
			<a href="#allusr/" class="all-btn btn col-xs-12">Back</a>
			<!-- <a class="all-btn btn col-sm-5 col-sm-offset-1" ng-click="profilebetlist(mp[0].member_id)">Bet List</a> -->
		</div>
		<!-- <div class="col-xs-2">
			<div class="list-group col-xs-12 pad-free" style="margin-bottom:5px;">
				<div class="list-group-item list-group-item-success col-xs-12" style="padding:5px 15px;"><label class="col-xs-8 pad-free">Agent</label> 
				  	<label class="switch col-xs-4 pad-free" style="margin-bottom:0px;">
				     		<input type="checkbox" ng-model="agent">
				     		<div class="slider round"></div>
		                  				</label>
				 </div>
			</div>			
		</div> -->
		<div class="col-xs-9">
			<div class="col-sm-3">
				<div class="form-group">			
					<select ng-model="datefiltertype"  name="datefiltertype" class="form-control" ng-change="typechange()">
						<option value="">Choose Date for Bet List</option>
						<option value="btw">Between</option>
						<option value=">">Grater Than</option>
						<option value="<">Less Than</option>
						<option value="=">Equal</option>
						<option value="all">All</option>
					</select>
				</div>
			</div>
			<div class="col-xs-7" ng-show="between">
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
			<div class="col-xs-7" ng-show="othertype">
				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" class="form-control" name="otherdate" ng-model="otherdate" datepicker placeholder="Date">
					</div>
				</div>
			</div>
			<div class="col-xs-1 pad-free">
				<div class="form-group">
					<a class="all-btn btn col-xs-12" ng-click="searchdate(mp[0].member_id)">Bet List</a>
				</div>
			</div>
			
		</div>
	</div>

	<div class="col-xs-12" ng-show="betlistshow">
	<div class="col-sm-12 pad-free">
		<h5 class="col-sm-2" style="color:#3e5315; font-weight:bold;">Body / Goal+</h5>
		<div class="col-sm-2 pull-right">
			<button class="btn btn-link" style="color:blue;padding:0px;" ng-click="exportToExcel('#bgexceldown')">
			      <span class="glyphicon glyphicon-share"></span>
			      Export to Excel
			</button>
		</div>
	</div>
	   <div class="col-xs-12 pad-free" style="overflow-y:auto; height:300px;" id="bgexceldown">
		<table class="w3-table-all" id="mledgertable" ng-show="!mixledgertable" style="margin-top:0px;">
		<tr>
			<th>Status</th>
			<th style="width:40px;">No.</th>
			<th>Date</th>
			<th ng-if="total=='Admin'">Member</th>
			<th ng-if="total!='Admin'">Name</th>
			<th>League</th>
			<th>Match</th>
			<th>Score</th>

			<th>Bet</th>
			<th>Bet On</th>
			<th>Odd</th>
			<th>%</th>
			<th>Amount</th>
			<th>W/L</th>
			<th>Turnover</th>
			
		</tr>

		<tr ng-if="allbetlist == '' || mm.length<1">
			<td> - </td>
			<td> - </td>
			<td> No Record </td>
			<td colspan="11"> - </td>
		</tr>

		<tr ng-repeat="a in mm = (allbetlist| filter:{dates:datevaluefilter} | filter:{username:usrname} | filter:{hometeam:teamname} | filter:{awayteam:ateamname} | filter:{statusdes:betstatusfilter})">
			<td class="{{a.sname}}">{{a.statusdes}}</td>
			<td class="numbers">{{$index+1}}.</td>
			<td>{{a.dates}}({{a.time}})</td>
			<td>{{a.username}}</td>	
			<td>{{a.leaguename}}</td>	
			<td>{{a.hometeam}}&nbsp;&amp;&nbsp;{{a.awayteam}}</td>
			<td>{{a.score}}</td>
			<td>{{a.bet}}</td>	
			<td>{{a.bet_on}}</td>
			<td>{{a.bgname}} [{{a.bgval}}]</td>
			<td>{{a.percent}}</td>
			<td class="numbers">{{a.betamount | number : fractionSize}}</td>
			<td class="numbers {{a.cname}} {{a.numformat}}">{{a.wl == "RUNNING" || a.wl == "WAITING"?(a.wl):(a.wl | number : fractionSize)}}</td>
			<td class="numbers">{{a.turnover == "RUNNING" || a.turnover == "WAITING"?(a.turnover):(a.turnover | number : fractionSize)}}</td>
			
		</tr>
		
		</table>
	   </div>
	<div class="col-sm-12 pad-free" style="margin-top:10px;">
		<h5 class="col-sm-2" style="color:#3e5315; font-weight:bold;">Mix</h5>
		<div class="col-sm-2 pull-right">
			<button class="btn btn-link" style="color:blue;padding:0px;" ng-click="exportToExcel('#exceldown')">
			      <span class="glyphicon glyphicon-share"></span>
			      Export to Excel
			</button>
		</div>
	</div>
	   <div class="col-xs-12 pad-free" style="overflow-x:auto; height:300px; overflow-y:auto;">
		<div style="width:2100px;" id="exceldown">			
			<table class="table table-striped" style="margin-top:0px;" id="mixbetlisttbl">
				<tr>	
					<th>Bet&nbsp;Date</th>
					<th>Bet&nbsp;Time</th>
					<th>Status</th>
					<th>Login&nbsp;ID</th>
					<th>Member</th>
					<th>Mix</th>
					<th>&nbsp;</th>
					<th>MPP</th>				
										
					<th>M%</th>
					<th>Stake</th>
					<th>Result&nbsp;Amount</th>
					<th>Turn&nbsp;Over</th>
					<th>Bet Status</th>
				</tr>
				<tr ng-if="mixledger == '' || mixledger.length<1">
					<td> - </td>
					<td> No Record </td>
					<td colspan="12"> - </td>
				</tr>
				<tr ng-repeat="x in mixledger | groupBy: '[mid]'">
					<td>{{x[0].bet_date}}</td>
					<td>{{x[0].bet_time}}</td>
					<td>{{x[0].bgdescription}}</td>
					<td>{{x[0].loginid}}</td>
					<td>{{x[0].username}}</td>								
					<td>{{x[0].mixname}} Mix Betting</td>
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
					<td class="{{x[0].sname}}">{{x[0].sdescription}}</td>					
				</tr>
			</table>
		</div>
	   </div>		
	</div>


	
	<div class="col-xs-4 col-offset-4" id="editagentdiv" ng-show="editagentdiv">
		<h2 style="background:#eee; border-radius:5px 5px 0px 0px;">Agent Data</h2>
		<form name="myForm">
		<div class="col-xs-12">
			<div class="form-group row">
				<div class="list-group col-xs-12 pad-free" style="margin-bottom:5px;">
					<div class="list-group-item col-xs-12" style="border:0px;"><label class="col-xs-10 pad-free">Commission OFF</label> 
					  <label class="switch col-xs-2 pad-free">
				     		<input type="checkbox" ng-model="onoffagentcom">
				     		<div class="slider round"></div>
                  				   </label>
					 </div>
					<div class="list-group-item col-xs-12" style="margin-bottom:10px; border:0px;"><label class="col-xs-10 pad-free">Agent OFF</label> 
					  <label class="switch col-xs-2 pad-free">
				     		<input type="checkbox" ng-model="onoffagent">
				     		<div class="slider round"></div>
                  				   </label>
					 </div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-xs-12">BG Win %</label>
				<div class="col-xs-12">
					<input type="number" ng-model="winper" name="winper" class="form-control" min="0" max="1">	
					<span ng-show="myForm.winper.$valid==false" style="color:red;">Amount Invalid !</span>
				</div>
			</div>
			<div class="form-group row" style="margin-top:10px;">
				<label class="col-xs-12">BG Lose %</label>
				<div class="col-xs-12">
					<input type="number" ng-model="loseper" name="loseper" class="form-control" min="0" max="1">	
					<span ng-show="myForm.loseper.$valid==false" style="color:red;">Amount Invalid !</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-xs-12">Mix Win %</label>
				<div class="col-xs-12">
					<input type="number" ng-model="mixwinper" name="mixwinper" class="form-control" min="0" max="1">	
					<span ng-show="myForm.mixwinper.$valid==false" style="color:red;">Amount Invalid !</span>
				</div>
			</div>
			<div class="form-group row" style="margin-top:10px;">
				<label class="col-xs-12">Mix Lose %</label>
				<div class="col-xs-12">
					<input type="number" ng-model="mixloseper" name="mixloseper" class="form-control" min="0" max="1">	
					<span ng-show="myForm.mixloseper.$valid==false" style="color:red;">Amount Invalid !</span>
				</div>
			</div>
			<div class="form-group">				
				<div class="col-sm-offset-3 col-sm-3" style="margin-bottom:15px;">
					<input type="button" ng-click='editagentval(mid)'  class="form-control btn all-btn" name="edit" value="Edit">
				</div>
				<div class="col-sm-3" style="margin-bottom:15px;">
					<input type="button" ng-click='cancelagentval()'  class="form-control btn all-btn" name="cancel" value="Cancel">
				</div>
			</div>
		</div>
		</form>
	</div>
</div>