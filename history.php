<div class="container-fluid">
<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
	<div class="col-xs-12 form-group pad-free" style="margin-bottom:0px;">
		<h3 id="allh3" class="col-xs-12">History</h3>
	</div>	
	<div class="col-xs-12 pad-free">
		<div class="col-xs-1 pad-free">
			<a href="#accdash/" class="btn all-btn">Back</a>
		</div>
		<div class="col-xs-2 pull-right">		
		
			<button class="btn btn-link" style="color:blue;" ng-click="exportToExcel('#exceldown')">
			      <span class="glyphicon glyphicon-share"></span>
			      Export to Excel
			</button>
		
		</div>	
	</div>
	<div class="col-xs-12" style="overflow:auto;padding-left:0px;">
		<div style="width:2000px;height:430px;" id="exceldown">
			<table class="table table-bordered table-striped">
				<tr>
					<th>&nbsp;</th>
					<th>Edit (D & T)</th>
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
				</tr>

				<tr ng-repeat="x in allhistory">
					<td>{{$index+1}}</td>
					<td>{{x.modifieddate}} ({{x.createddate}})</td>
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
					<td><a ng-click='usrlist(x.timetableid,"team")' style="cursor:pointer;text-decoration:none;"><label class="{{x.bodygoal}}">{{x.Home}}</label> & <label class="{{x.goalbody}}">{{x.Away}}</label></a></td>
					<td ng-click='selectBet(x,"scoreclick")'>{{x.score}}</td>
					<td ng-click='selectBet(x,"bodyclick")'>{{x.bodyname}}&nbsp;[{{x.body_value}}]</td>
					<td ng-click='selectBet(x,"hperclick")' class="{{x.hclassname}}">{{x.hper}}</td>
					<td ng-click='selectBet(x,"aperclick")' class="{{x.aclassname}}">{{x.aper}}</td>
					<td ng-click='selectBet(x,"goalclick")'>{{x.goalname}}&nbsp;[{{x.goalplus_value}}]</td>
					<td ng-click='selectBet(x,"uperclick")' class="{{x.uclassname}}">{{x.uper}}</td>
					<td ng-click='selectBet(x,"dperclick")' class="{{x.dclassname}}">{{x.dper}}</td>
				</tr>
			</table>
		</div>			
	</div>
</div>