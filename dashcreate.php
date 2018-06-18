<div class="row main-frame">
<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
<div class="col-xs-12">

		<div class="col-xs-12 pad-free">
		<div class="col-xs-5 pad-free">
			<div class="col-sm-4">
			<div class="form-group">
			<!-- 	<input type="text" class="form-control" name="filterLeague" ng-model="filterLeague" placeholder="League"> -->
				<select ng-model="leaguevalfilter" ng-options="aa.leaguename for aa in league track by aa.league_id" class="form-control">
					<option value="">League</option>
				</select>
			</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<input type="text" class="form-control" name="filterHome" ng-model="filterHome" placeholder="Home">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<input type="text" class="form-control" name="filterAway" ng-model="filterAway" placeholder="Away">
				</div>
			</div>
		</div>

		<div class="col-xs-7 pad-free">
			<div class="col-sm-3">
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
			<div class="col-xs-7 pad-free" ng-show="between">
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
			<div class="col-xs-7 pad-free" ng-show="othertype">
				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" class="form-control" name="otherdate" ng-model="otherdate" datepicker placeholder="Date">
					</div>
				</div>
			</div>
			<div class="col-xs-2" ng-show="searchbtn">
				<div class="form-group">
					<input type="button" class="form-control btn all-btn" name="searchdate" ng-model="searchdate" value="Search" ng-click="searchdate()">
				</div>
			</div>
			
		</div>
	</div>
	<div class="col-xs-12 pad-free">
	<div class="col-sm-6 pad-free">
		<div class="col-sm-3">
		<div class="form-group">
			<select class="form-control" ng-model="comallchange" ng-change="ioallchange('com')">
				<option value="">COM Filter</option>
				<option value="1">Open</option>
				<option value="2">Close</option>
			</select>
		</div>
		</div>
		<div class="col-sm-3">
		<div class="form-group">
			<select class="form-control" ng-model="mixallchange" ng-change="ioallchange('mix')">
				<option value="">MIX Filter</option>
				<option value="2">Hide</option>
				<option value="1">Open</option>
				<option value="0">Close</option>
			</select>
		</div>
		</div>
		<div class="col-sm-3">
		<div class="form-group">
			<select class="form-control" ng-model="iochangeall" ng-change="ioallchange('io')">
				<option value="">Select I/O Change</option>
				<option value="1">Open</option>
				<option value="2">Close</option>
				<option value="3">Hide</option>
			</select>
		</div>
		</div>	
		<div class="col-sm-3">
		<div class="form-group">
			<select class="form-control" ng-model="iofilter" name="iofilter">
				<option value="">I/O Filter</option>
				<option value="1">Open</option>
				<option value="2">Close</option>
				<option value="3">Hide</option>
			</select>
		</div>
		</div>
		
	</div>		
	<div class="col-sm-1">
		<button ng-click="pinall()" class="refresh col-xs-12">Pin</button>
	</div>
	<div class="col-sm-2">
		<button ng-click="refreshadminfun()" class="refresh col-xs-9">Refresh &nbsp;<span class="glyphicon glyphicon-refresh" style="font-size:16px;"></span></button>
	</div>
	<div class="col-xs-3 pull-right">		
		<div class="col-sm-6"  ng-if="adshow==1">
			<button class="btn btn-link" style="color:blue;" ng-click="exportToExcel('#exceldown')">
			      <span class="glyphicon glyphicon-share"></span>
			      Export to Excel
			</button>
		</div>
	</div>		
			
	</div>
	<div id="admindiv" class="col-xs-12">
		<div style="width:2700px;">
			<table class="table table-bordered table-striped">
				<tr>
					<th class="adminacc">&nbsp;</th>
					<th class="adminacc">COM</th>
					<th class="adminacc">MIX</th>
					<th class="adminacc">I/O</th>
					<th class="adminacc">BIO</th>
					<th class="adminacc">LB&nbsp;Amount</th>
					<th class="adminacc">GIO</th>
					<th class="adminacc">LG&nbsp;Amount</th>
					<th class="adminacc">BS</th>
					<th class="adminacc">GS</th>					
					<th class="adminacc">Body Less</th>
					<th class="adminacc">Goal&nbsp;+ Less</th>
					<th class="adminacc">Body Limit</th>
					<th class="adminacc">Goal&nbsp;+ Limit</th>
					<th class="adminacc">Body</th>
					<th class="adminacc">Goal&nbsp;+</th>
					<th class="adminacc" ng-if="adshow==1">&nbsp;</th>
					<th ng-click="orderByMe('tdate')">Date</th>
					<th>Time</th>
					<th>League</th>
					<th>Match</th>
					
					<th>Score</th>
					<th>Body</th>
					<th>Goal&nbsp;+</th>
					<th>H%</th>
					<th>A%</th>
					
					<th>U%</th>
					<th>D%</th>			
					<!-- <th class="adminacc">Body&nbsp;Total</th>		
					<th class="adminacc">H&nbsp;Amount</th>
					<th class="adminacc">A&nbsp;Amount</th>
					<th class="adminacc">Body&nbsp;WL</th>
					<th class="adminacc">&nbsp;</th>
					<th class="adminacc">Goal+&nbsp;Total</th>
					<th class="adminacc">O&nbsp;Amount</th>
					<th class="adminacc">D&nbsp;Amount</th>
					<th class="adminacc">Goal+&nbsp;WL</th>
					<th colspan="2" class="adminacc">&nbsp;</th> -->
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>

				<tr ng-if="dashes == 'No Record'">
					<td> - </td>
					<td> No Record </td>
					<td> - </td>
					<td colspan="27"> - </td>
				</tr>

				<tr ng-if="dashes != 'No Record'" ng-repeat="x in dashes|filter:{leaguename:leaguevalfilter.leaguename}|filter:{leaguename:filterLeague}|filter:{Home:filterHome}|filter:{Away:filterAway}|filter:{tdate:filterDate}|filter:{io_id:iofilter}|orderBy:dateOrder">
					<td class="adminacctd"><input type="checkbox" ng-model="x.checked" ng-true-value="1" ng-false-value="0"></td>
					<td class="adminacctd {{x.comclassname}}">{{x.comval}}</td>
					<td class="adminacctd {{x.mixclassname}}">{{x.mixval}}</td>
		      			<!-- <td><img src="images/e3.png" ng-click='selectBet(x)' style="cursor:pointer; width:20px;"></td> -->
		      			<td ng-click='selectBet(x,"ioclick")' class="adminacctd {{x.ioclassname}}">{{x.aio}}</td>
		      			<td ng-click='selectBet(x,"bioclick")' class="adminacctd">{{x.abio}}</td>
		      			<td class="numbers adminacctd" ng-click='selectBet(x,"lbclick")'>{{x.lbamount | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"gioclick")' class="adminacctd">{{x.agio}}</td>
		      			<td class="numbers adminacctd" ng-click='selectBet(x,"lgclick")'>{{x.lgamount | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"bsclick")' class="adminacctd">{{x.abs}}</td>
		      			<td ng-click='selectBet(x,"gsclick")' class="adminacctd">{{x.ags}}</td>
		      			
		      			<td ng-click='selectBet(x,"blessclick")' class="numbers adminacctd">{{x.bless | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"glessclick")' class="numbers adminacctd">{{x.gless | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"blimitamtclick")' class="numbers adminacctd">{{x.blimitamt | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"glimitamtclick")' class="numbers adminacctd">{{x.glimitamt | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"abodyclick")' class="adminacctd">{{x.abody}}</td>
		      			<td ng-click='selectBet(x,"agoalclick")' class="adminacctd">{{x.agoal}}</td>
		      			<td class="adminacctd">
		      			<button class="btn blu-btn" style="font-size:0.6em; padding:5px;" ng-disabled="x.com_for==1?true:false" ng-click="calculatecom(x)">COM</button>
		      			</td>
		      			<!-- <td ng-if="adshow==1">
			      			<a ng-if="x.abody != ''" ng-click="changeBodyformula(x.dashboard_id,x)" style="text-decoration:none;">[Change BF]</a>
			      			<a ng-if="x.abody == ''" style="text-decoration:none; color:red;">[Change BF]</a>
			      			<a ng-if="x.agoal != ''" ng-click="changeGoalformula(x.dashboard_id,x)" style="text-decoration:none;">&nbsp;-&nbsp;[Change GF]</a>
			      			<a ng-if="x.agoal == ''" style="text-decoration:none; color:red;">&nbsp;-&nbsp;[Change GF]</a>
		      			</td> -->
		      			
		      			<td>{{x.tdate}}</td>
					<td>{{x.ttime}}</td>
					<td><a ng-click='usrlist(x.timetableid,"league")' style="color:#000;cursor:pointer;text-decoration:none;">{{x.leaguename}}</a>
					<label class="pull-left" ng-if="adshow==1">
			      			<a ng-if="x.mixfor != 0" ng-click="changeMixFor(x.dashboard_id,x)" style="text-decoration:none;font-size:0.9em;">[Change Mix]</a>
			      			<a ng-if="x.mixfor == 0" ng-click="calculateMixFor(x.dashboard_id,x)" style="text-decoration:none; color:green;font-size:0.9em;">[Calculate Mix]</a>
			      			<a ng-if="x.com_for == 1" ng-click="changeCom(x.dashboard_id,x)" style="text-decoration:none;font-size:0.9em;">&nbsp;-&nbsp;[Change COM]</a>
			      			<a ng-if="x.com_for == 0" style="text-decoration:none; color:red;font-size:0.9em;">&nbsp;-&nbsp;[Change COM]</a>&nbsp;&nbsp;&nbsp;
		      			</label>
					</td>
					<td>						
						<a ng-click='usrlist(x.timetableid,"team")' style="cursor:pointer;text-decoration:none;">
							<label class="{{x.bodygoal}}">{{x.Home}}</label> & <label class="{{x.goalbody}}">{{x.Away}}</label>
						</a>
						<label class="pull-right" ng-if="adshow==1">
							<a ng-if="x.abody != ''" ng-click="changeBodyformula(x.dashboard_id,x)" style="text-decoration:none;font-size:0.9em;">[Change BF]</a>
				      			<a ng-if="x.abody == ''" style="text-decoration:none; color:red;font-size:0.9em;">[Change BF]</a>
				      			<a ng-if="x.agoal != ''" ng-click="changeGoalformula(x.dashboard_id,x)" style="text-decoration:none;font-size:0.9em;">&nbsp;-&nbsp;[Change GF]</a>
				      			<a ng-if="x.agoal == ''" style="text-decoration:none; color:red;font-size:0.9em;">&nbsp;-&nbsp;[Change GF]</a>
			      			</label>
					</td>
					<!-- <td><a ng-click='usrlist(x.timetableid,"team")' style="color:#000;cursor:pointer;text-decoration:none;">{{x.Home}} vs {{x.Away}}</a></td> -->
					
					<td ng-click='selectBet(x,"scoreclick")'>{{x.score}}</td>
					<td ng-click='selectBet(x,"bodyclick")'>{{x.bodyname}}&nbsp;[{{x.body_value}}]</td>
					<td ng-click='selectBet(x,"goalclick")'>{{x.goalname}}&nbsp;[{{x.goalplus_value}}]</td>
					<!-- <td ng-click='selectBet(x,"bdyvalclick")'> </td> -->
					<td ng-click='selectBet(x,"hperclick")' class="{{x.hclassname}}">{{x.hper}}</td>
					<td ng-click='selectBet(x,"aperclick")' class="{{x.aclassname}}">{{x.aper}}</td>
					
					<!-- <td ng-click='selectBet(x,"goalvalclick")'></td> -->
					<td ng-click='selectBet(x,"uperclick")' class="{{x.uclassname}}">{{x.uper}}</td>
					<td ng-click='selectBet(x,"dperclick")' class="{{x.dclassname}}">{{x.dper}}</td>

					<!-- <td class="numbers adminacctd">{{x.btotal | number : fractionSize}}</td>					
					<td class="numbers adminacctd">{{x.hamount | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.aamount | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.resultbody | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.bover}}</td>
					<td class="numbers adminacctd">{{x.gtotal | number : fractionSize}}</td>	
					<td class="numbers adminacctd">{{x.oamount | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.damount | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.resultgoal | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.gover}}</td> -->
					<td class="{{x.dclassname}}"><a href="#mixdetail/{{x.dashboard_id}}">Mix Detail</a></td>	
					<td class="{{x.dclassname}}"><a href="#viewhistory/{{x.timetableid}}">View History</a></td>					
				</tr>
			</table>			
		</div>
		<div style="width:2700px;" id="exceldown" style="display:none;">
			<table class="table table-bordered table-striped" style="display:none;">
				<tr>
					<th class="adminacc">I/O</th>
					<th class="adminacc">BIO</th>
					<th class="adminacc">LB&nbsp;Amount</th>
					<th class="adminacc">GIO</th>
					<th class="adminacc">LG&nbsp;Amount</th>
					<th class="adminacc">BS</th>
					<th class="adminacc">GS</th>
					<th class="adminacc">Body Less</th>
					<th class="adminacc">Goal&nbsp;+ Less</th>
					<th class="adminacc">Body Limit</th>
					<th class="adminacc">Goal&nbsp;+ Limit</th>
					<th class="adminacc">Body</th>
					<th class="adminacc">Goal&nbsp;+</th>
					<th ng-click="orderByMe('tdate')">Date</th>
					<th>Time</th>
					<th>League</th>
					<th>Match</th>
					<th>Score</th>
					<th>Body</th>
					<th>H%</th>
					<th>A%</th>
					<th>Goal&nbsp;+</th>
					<th>U%</th>
					<th>D%</th>			
					<th class="adminacc">Body&nbsp;Total</th>		
					<th class="adminacc">H&nbsp;Amount</th>
					<th class="adminacc">A&nbsp;Amount</th>
					<th class="adminacc">Body&nbsp;WL</th>
					<th class="adminacc">&nbsp;</th>
					<th class="adminacc">Goal+&nbsp;Total</th>
					<th class="adminacc">O&nbsp;Amount</th>
					<th class="adminacc">D&nbsp;Amount</th>
					<th class="adminacc">Goal+&nbsp;WL</th>
					<th colspan="2" class="adminacc">&nbsp;</th>
				</tr>

				<tr ng-repeat="x in dashes|filter:{leaguename:leaguevalfilter.leaguename}|filter:{leaguename:filterLeague}|filter:{Home:filterHome}|filter:{Away:filterAway}|filter:{tdate:filterDate}|orderBy:dateOrder">
		      			<td ng-click='selectBet(x,"ioclick")' class="adminacctd {{x.ioclassname}}">{{x.aio}}</td>
		      			<td ng-click='selectBet(x,"bioclick")' class="adminacctd">{{x.abio}}</td>
		      			<td class="numbers adminacctd" ng-click='selectBet(x,"lbclick")'>{{x.lbamount | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"gioclick")' class="adminacctd">{{x.agio}}</td>
		      			<td class="numbers adminacctd" ng-click='selectBet(x,"lgclick")'>{{x.lgamount | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"bsclick")' class="adminacctd">{{x.abs}}</td>
		      			<td ng-click='selectBet(x,"gsclick")' class="adminacctd">{{x.ags}}</td>
		      			
		      			<td ng-click='selectBet(x,"blessclick")' class="numbers adminacctd">{{x.bless | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"glessclick")' class="numbers adminacctd">{{x.gless | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"blimitamtclick")' class="numbers adminacctd">{{x.blimitamt | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"glimitamtclick")' class="numbers adminacctd">{{x.glimitamt | number : fractionSize}}</td>
		      			<td ng-click='selectBet(x,"abodyclick")' class="adminacctd">{{x.abody}}</td>
		      			<td ng-click='selectBet(x,"agoalclick")' class="adminacctd">{{x.agoal}}</td>
		      			<td>{{x.tdate}}</td>
					<td>{{x.ttime}}</td>
					<td><a ng-click='usrlist(x.timetableid,"league")' style="color:#000;cursor:pointer;text-decoration:none;">{{x.leaguename}}</a></td>
					<td><a ng-click='usrlist(x.timetableid,"team")' style="cursor:pointer;text-decoration:none;"><label class="{{x.bodygoal}}">{{x.Home}}</label> & <label class="{{x.goalbody}}">{{x.Away}}</label></a>&nbsp;<a ng-click="formulaedit(x.dashboard_id)" class="pull-right" style="text-decoration:none;">[ Edit ]</a></td>
					<!-- <td><a ng-click='usrlist(x.timetableid,"team")' style="color:#000;cursor:pointer;text-decoration:none;">{{x.Home}} vs {{x.Away}}</a></td> -->
					
					<td ng-click='selectBet(x,"scoreclick")'>{{x.score}}</td>
					<td ng-click='selectBet(x,"bodyclick")'>{{x.bodyname}}&nbsp;[{{x.body_value}}]</td>
					<!-- <td ng-click='selectBet(x,"bdyvalclick")'> </td> -->
					<td ng-click='selectBet(x,"hperclick")' class="{{x.hclassname}}">{{x.hper}}</td>
					<td ng-click='selectBet(x,"aperclick")' class="{{x.aclassname}}">{{x.aper}}</td>
					<td ng-click='selectBet(x,"goalclick")'>{{x.goalname}}&nbsp;[{{x.goalplus_value}}]</td>
					<!-- <td ng-click='selectBet(x,"goalvalclick")'></td> -->
					<td ng-click='selectBet(x,"uperclick")' class="{{x.uclassname}}">{{x.uper}}</td>
					<td ng-click='selectBet(x,"dperclick")' class="{{x.dclassname}}">{{x.dper}}</td>

					<td class="numbers adminacctd">{{x.btotal | number : fractionSize}}</td>					
					<td class="numbers adminacctd">{{x.hamount | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.aamount | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.resultbody | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.bover}}</td>
					<td class="numbers adminacctd">{{x.gtotal | number : fractionSize}}</td>	
					<td class="numbers adminacctd">{{x.oamount | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.damount | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.resultgoal | number : fractionSize}}</td>
					<td class="numbers adminacctd">{{x.gover}}</td>					
				</tr>
			</table>
			
		</div>
	</div>
	
<!-- 	<div id="accdiv" class="col-xs-12" ng-show="!adminshow">
	<div style="width:2500px;">
		<table class="table table-bordered table-striped">
			<tr>
				<th>&nbsp;</th>
				<th>I/O</th>
				<th>BIO</th>
				<th>LB&nbsp;Amount</th>
				<th>GIO</th>
				<th>LG&nbsp;Amount</th>
				<th>BS</th>
				<th>GS</th>
				<th>Body</th>
				<th>Goal&nbsp;+</th>
				<th>Body Limit</th>
				<th>Goal&nbsp;+ Limit</th>
				<th ng-click="orderByMe('tdate')">Date</th>
				<th>Time</th>
				<th>League</th>
				<th>&nbsp;</th>
				<th>Score</th>
				<th colspan="2">Body</th>
				<th>H%</th>
				<th>A%</th>
				<th colspan="2">Goal&nbsp;+</th>
				<th>U%</th>
				<th>D%</th>
			</tr>

			<tr ng-repeat="x in dashes|filter:{leaguename:filterLeague}|filter:{Home:filterHome}|filter:{Away:filterAway}|filter:{tdate:filterDate}|orderBy:dateOrder">
	      			<td><img src="images/e3.png" ng-click='selectBet(x)' style="cursor:pointer; width:20px;"></td>
	      			<td ng-click='selectBet(x,"ioclick")'>{{x.aio}}</td>
	      			<td ng-click='selectBet(x,"bioclick")'>{{x.abio}}</td>
	      			<td class="numbers" ng-click='selectBet(x,"lbclick")'>{{x.lbamount | number : fractionSize}}</td>
	      			<td ng-click='selectBet(x,"gioclick")'>{{x.agio}}</td>
	      			<td class="numbers" ng-click='selectBet(x,"lgclick")'>{{x.lgamount | number : fractionSize}}</td>
	      			<td ng-click='selectBet(x,"bsclick")'>{{x.abs}}</td>
	      			<td ng-click='selectBet(x,"gsclick")'>{{x.ags}}</td>
	      			<td ng-click='selectBet(x,"abodyclick")'>{{x.abody}}</td>
	      			<td ng-click='selectBet(x,"agoalclick")'>{{x.agoal}}</td>
	      			<td ng-click='selectBet(x,"blimitamtclick")'>{{x.blimitamt}}</td>
	      			<td ng-click='selectBet(x,"glimitamtclick")'>{{x.glimitamt}}</td>
	      			<td>{{x.tdate}}</td>
				<td>{{x.ttime}}</td>
				<td><a ng-click='usrlist(x.timetableid,"league")' style="color:#000;cursor:pointer;text-decoration:none;">{{x.leaguename}}</a></td>
				<td><a ng-click='usrlist(x.timetableid,"team")' style="color:#000;cursor:pointer;text-decoration:none;">{{x.Home}} vs {{x.Away}}</a></td>
				<td ng-click='selectBet(x,"scoreclick")'>{{x.score}}</td>
				<td ng-click='selectBet(x,"bodyclick")'>{{x.bodyname}}</td>
				<td ng-click='selectBet(x,"bdyvalclick")'> {{x.body_value}}
				<td ng-click='selectBet(x,"hperclick")' class="{{x.hclassname}}">{{x.hper}}</td>
				<td ng-click='selectBet(x,"aperclick")' class="{{x.aclassname}}">{{x.aper}}</td>
				<td ng-click='selectBet(x,"goalclick")'>{{x.goalname}}</td>
				<td ng-click='selectBet(x,"goalvalclick")'>{{x.goalplus_value}}</td>
				<td ng-click='selectBet(x,"uperclick")' class="{{x.uclassname}}">{{x.uper}}</td>
				<td ng-click='selectBet(x,"dperclick")' class="{{x.dclassname}}">{{x.dper}}</td>
			</tr>
		</table>
	</div>
</div> -->
</div>


<div id="dashedit" class="col-xs-10 col-xs-offset-1" style="position:fixed; top:50px;">
<img src="images/closex.png" ng-click="bDone()" style="width:13px;position:absolute;top:7px;right:7px; cursor:pointer;">
	<div class="col-xs-12" style="margin-top:20px;">	
	<form class="col-xs-12" name="myForm">
		<div class="col-xs-12 col-sm-4" style="line-height:30px;">
			<div class="form-group">
				<label classs="col-xs-12" >Date</label>
				<input type="text" name='tdateval' ng-model="tdateval" class="form-control" ng-disabled="true">
			</div>
			<div class="form-group">
				<label classs="col-xs-12" >Time</label>
				<input type="text" name='ttimeval' ng-model="ttimeval" class="form-control" ng-disabled="true">
			</div>
			<div class="form-group">
				<label classs="col-xs-12" >League</label>
				<input type="text" name='leagueval' ng-model="leagueval" class="form-control" ng-disabled="true">
			</div>
			<div class="form-group">
				<label classs="col-xs-12" >Home</label>
				<input type='text' name='homeval' ng-model='homeval' class="form-control" ng-disabled="true">
			</div>
			<div class="form-group">
				<label classs="col-xs-12" >Away</label>
				<input type="text" name='awayval' ng-model="awayval" class="form-control" ng-disabled="true">
			</div>
			<span class="error col-xs-12" ng-show="myForm.bodytxt.$valid!=true" style="color:red; font-weight:bold;">Not valid Body Margin %</span>
			<span class="error col-xs-12" ng-show="myForm.goaltxt.$valid!=true" style="color:red; font-weight:bold;">Not valid Goal+ Margin %</span>	

			<span class="error col-xs-12" ng-show="myForm.uperval.$valid!=true" style="color:red; font-weight:bold;">Not valid U %</span>
			<span class="error col-xs-12" ng-show="myForm.dperval.$valid!=true" style="color:red; font-weight:bold;">Not valid D %</span>	
			<span class="error col-xs-12" ng-show="myForm.hperval.$valid!=true" style="color:red; font-weight:bold;">Not valid H %</span>
			<span class="error col-xs-12" ng-show="myForm.aperval.$valid!=true" style="color:red; font-weight:bold;">Not valid A %</span>
			<!-- <div class="col-sm-5 pad-free" style="margin-top:20px;">
					              		<input type="button" ng-click='savedash()' class="form-control btn all-btn" name="submit" value="Save" ng-disabled="myForm.goaltxt.$valid==false || myForm.bodytxt.$valid==false || myForm.aperval.$valid==false || myForm.dperval.$valid==false || myForm.uperval.$valid==false || myForm.hperval.$valid==false?true:false">
					              	</div>
					              	<div class="col-sm-5 col-sm-offset-2 pad-free" style="margin-top:20px;">
					              		<input type="button" value="Close" ng-click="bDone()" style="cursor:pointer;" class="form-control btn all-btn">
					              	</div>	 -->	
		</div>

             	<div class="col-xs-12 col-sm-4" style="line-height:35px;">
         			<div class="form-group">
				<label classs="col-xs-12" >Score</label>
				<input type="text" ng-model="scoreval" id="scoreclick" class="form-control">
			</div>
			<div class="col-xs-6 pad-free">
				<div class="form-group">
					<div classs="col-xs-12" >
						<label>Body</label>
					</div>
						<select ng-model="bodyval" id="bodyclick" ng-disabled="(bodyval.body_id==0?false:true)" ng-options="b.bodyname for b in bodies track by b.body_id" class="form-control"></select>
				</div>
			</div>
			
			<div class='col-xs-offset-1 col-xs-5 pad-free'>					
				<div class="form-group">
				<div classs="col-xs-12">
					<label>Body Margin %</label>
				</div>
					<input type="number" name='bodytxt' id="bdyvalclick" class="form-control" min="0" max="100" ng-model="bodytxt">
					<!--  ng-class="{errormsg:(myForm.bodytxt.$valid!=true)}" -->
					<!-- <input type="text" name='bodytxt' id="bdyvalclick" ng-model="bodytxt" class="form-control"> -->
				</div>
				
			</div>

			<div class="col-sm-6 pad-free">
				<div class="form-group">
				<div classs="col-xs-12">
					<label>H%</label>
				</div>
					<!-- <input type="text" name='hperval' id="hperclick" ng-model="hperval" class="form-control"> -->
					<input type="number" name='hperval' id="hperclick" class="form-control" min="-1" max="1" ng-model="hperval">
				</div>
			</div>
			<div class="col-sm-5 col-sm-offset-1 pad-free">
				<div class="form-group">
				<div classs="col-xs-12">
					<label>A%</label>
				</div>
					<!-- <input type="text" name='aperval' id="aperclick" ng-model="aperval" class="form-control"> -->
					<input type="number" name='aperval' id="aperclick" class="form-control" min="-1" max="1" ng-model="aperval">
				</div>
			</div>

			<div class="col-xs-6 pad-free">
				<div class="form-group">
					<div classs="col-xs-12">
						<label>Goal +</label>
					</div>
						<select ng-model="goalval" id="goalclick" ng-disabled="(goalval.goalplus_id==0?false:true)" ng-options="g.goalname for g in goals track by g.goalplus_id" class="form-control"></select>
				</div>
			</div>			

			<div class='col-xs-offset-1 col-xs-5 pad-free'>					
				<div class="form-group">
				<div classs="col-xs-12">
					<label>Goal+ Margin %</label>
				</div>
					<input type="number" name='goaltxt' id="goalvalclick" class="form-control" min="0" max="100" ng-model="goaltxt">
					<!-- <input type="text" name='goaltxt' id="goalvalclick" ng-model="goaltxt" class="form-control"> -->
				</div>
			</div>
			
			<div class="col-sm-6 pad-free">
				<div class="form-group">
				<div classs="col-xs-12">
					<label>U%</label>
				</div>
					<!-- <input type="text" name='uperval' id="uperclick" ng-model="uperval" class="form-control"> -->
					<input type="number" name='uperval' id="uperclick" ng-class="[true == true?'errormsg':'','form-control']" min="-1" max="1" ng-model="uperval">
				</div>
			</div>
			<div class="col-sm-5 col-sm-offset-1 pad-free">
				<div class="form-group">
				<div classs="col-xs-12">
					<label>D%</label>
				</div>
					<input type="number" name='dperval' id="dperclick" class="form-control" min="-1" max="1" ng-model="dperval">
				</div>
			</div>
			<div class="col-sm-6 pad-free">
				<div class="form-group">
				<div classs="col-xs-12">
					<label>Body Limit Amount</label>
				</div>
					<input type="text" name='blimitamt' id="blimitamtclick" ng-model="blimitamt" class="form-control">
				</div>
			</div>
			<div class="col-sm-5 col-sm-offset-1 pad-free">
				<div class="form-group">
				<div classs="col-xs-12">
					<label>Goal Limit Amount</label>
				</div>
					<input type="text" name='glimitamt' id="glimitamtclick" ng-model="glimitamt" class="form-control">
				</div>
			</div>
			
		</div>
		<div class="col-xs-12 col-sm-4" style="line-height:35px;">
				<div class="col-sm-6 pad-free">
					<div class="form-group">
						<label classs="col-xs-12" >I/O</label>
						<select ng-model="ioval" id="ioclick" ng-options="ii.description for ii in ios track by ii.io_id" class="form-control"></select>
					</div>
				</div>
				<div class="col-sm-5 col-sm-offset-1 pad-free">
					<div class="form-group">
						<label classs="col-xs-12" >&nbsp;</label>
			              		<input type="button" ng-click='savedash()' class="form-control btn all-btn" name="submit" value="Save" ng-disabled="myForm.goaltxt.$valid==false || myForm.bodytxt.$valid==false || myForm.aperval.$valid==false || myForm.dperval.$valid==false || myForm.uperval.$valid==false || myForm.hperval.$valid==false?true:false">
			              	</div>
				</div>
				
				<div class="col-sm-6 pad-free">
					<div class="form-group">
					<div classs="col-xs-12">
						<label>BIO</label>
					</div>
						<select ng-model="bioval" id="bioclick" ng-options="bb.description for bb in bios track by bb.bio_id" class="form-control"></select>
					</div>
				</div>
				<div class="col-sm-5 col-sm-offset-1 pad-free">
					<div class="form-group">
					<div classs="col-xs-12">
						<label>LB Amount</label>
					</div>
						<input type="text" id="lbclick" name='lbamt' ng-model="lbamt" class="form-control">
					</div>
				</div>

				<div class="col-sm-6 pad-free">
					<div class="form-group">
					<div classs="col-xs-12">
						<label>GIO</label>
					</div>
						<select ng-model="gioval" id="gioclick" ng-options="gg.description for gg in gios track by gg.gio_id" class="form-control"></select>
					</div>
				</div>
				<div class="col-sm-5 col-sm-offset-1 pad-free">
					<div class="form-group">
					<div classs="col-xs-12">
						<label>LG Amount</label>
					</div>
						<input type="text" id="lgclick" name='lgamt' ng-model="lgamt" class="form-control">
					</div>
				</div>
				
				
								
				<div class="col-sm-6 pad-free">
					<div class="form-group">
					<div classs="col-xs-12">
						<label>BS</label>
					</div>
						<select ng-model="bsval" id="bsclick" ng-options="abb.description for abb in bss track by abb.bs" class="form-control"></select>
					</div>
				</div>
				<div class="col-sm-5 col-sm-offset-1 pad-free">
					<div class="form-group">
					<div classs="col-xs-12">
						<label>GS</label>
					</div>
						<select ng-model="gsval" id="gsclick" ng-options="agg.description for agg in gss track by agg.gs" class="form-control"></select>
					</div> 					
				</div>
				<div class="col-sm-6 pad-free">
					<div class="form-group">
					<div classs="col-xs-12">
						<label>Body</label>
					</div>
						<!-- <select ng-model="accbodyval" ng-if="accbodyval.accbody_id!=0" id="abodyclick" ng-change="formulachange()" ng-options="ab.description for ab in abody track by ab.accbody_id" disabled class="form-control"></select>
						<select ng-model="accbodyval" ng-if="accbodyval.accbody_id==0" id="abodyclick" ng-change="formulachange()" ng-options="ab.description for ab in abody track by ab.accbody_id" class="form-control"></select> -->
						<select ng-model="accbodyval" ng-disabled="(accbodyval.accbody_id==0?false:true)" id="abodyclick" ng-change="formulachange(0,accbodyval.description)" ng-options="ab.description for ab in abody track by ab.accbody_id" class="form-control"></select>
					
					</div>
				</div>
				<div class="col-sm-5 col-sm-offset-1 pad-free">
					<div class="form-group">
					<div classs="col-xs-12">
						<label>Goal +</label>
					</div>						
						<select ng-model="accgoalval"  ng-disabled="(accgoalval.accgoal_id==0?false:true)" id="agoalclick" ng-change="formulachange(1,accgoalval.description)" ng-options="ag.description for ag in agoals track by ag.accgoal_id" class="form-control"></select>
					</div>
				</div>
				<div class="col-sm-6 pad-free">
					<div class="form-group">
					<div classs="col-xs-12">
						<label>Body Less Amount</label>
					</div>
						<input type="text" name='bless' id="blessclick" ng-model="bless" class="form-control">
					</div>
				</div>
				<div class="col-sm-5 col-sm-offset-1 pad-free">
					<div class="form-group">
					<div classs="col-xs-12">
						<label>Goal Less Amount</label>
					</div>
						<input type="text" name='gless' id="glessclick" ng-model="gless" class="form-control">
					</div>
				</div>
			</div>
	              <!-- <div class="col-xs-12 pad-free" style="margin-top:20px; margin-bottom:20px;">
	              	<div class="col-sm-2 col-sm-offset-8">
	              		<input type="button" ng-click='savedash()' class="form-control btn all-btn" name="submit" value="Save">
	              	</div>
	              	<div class="col-sm-2">
	              		<input type="button" value="Close" ng-click="bDone()" style="cursor:pointer;" class="form-control btn all-btn">
	              	</div>	              	
	              </div> -->
	</form>
        </div>  
</div>

 </div>
