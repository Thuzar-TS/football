<div class="row container-fluid">
<div class="col-xs-12 pad-free">
	<div class="col-xs-3">
		<h3 style="margin-top:10px;">Annual Ledger</h3>
		<table class="col-xs-12 table table-striped" id="allledger">
			<tr ng-repeat="x in annual2">
				<td>{{x.alltype}}</td>
				<td class="numbers {{x.cname}}">{{x.amount | number : fractionSize}}</td>
			</tr>
			<tr>
			<th>Total</th>
			<th class="numbers">{{Total | number : fractionSize}}</th>
			</tr>
		</table>
	</div>
	<div class="col-xs-9" ng-show="mainledger">
		<div class="col-xs-12 pad-free">
			<div class="col-sm-9 pad-free">
				<div class="col-sm-3 pad-free">
					<div class="form-group" style="margin-top:10px;">
						<input type="text" class="form-control" name="filterDate" ng-model="filterDate" datepicker placeholder="Date" value="">
					</div>
				</div>						
			</div>	
			<div class="col-xs-1">
				<div class="form-group" style="margin-top:10px;">
					<a href="#bgledger/" class="btn all-btn">BG</a>
				</div>
			</div>
			<div class="col-xs-1">
				<div class="form-group" style="margin-top:10px;">
					<a href="#mixledger/" class="btn all-btn">Mix</a>
				</div>
			</div>
			<div class="col-xs-1">
				<div class="form-group" style="margin-top:10px;">
					<a href="#mledger/" class="btn all-btn">Back</a>
				</div>
			</div>
			
		</div>
		<div class="col-xs-12 pad-free" style="height:260px; overflow-y:auto;"> 
		<table class="table table-striped" id="allledger" style="margin-top:0px;">
			<tr>
				<th>Date</th>
				<th>Via</th>	
				<th>Detail</th>		
				<th>Amount</th>
			</tr>
			<tr ng-repeat="a in allresult|filter:{dates:filterDate}">
				<td>{{a.dates}}</td>
				<td ng-if="a.page!='undefined'"><a href="#{{a.page}}/{{a.dates}}/{{a.alltype}}">{{a.alltype}}({{a.numofrow}})</a></td>
				<td ng-if="a.page=='undefined'">{{a.alltype}}({{a.numofrow}})</td>
				<td></td>			
				<td class="numbers {{a.cname}}">{{a.amount | number : fractionSize}}</td>			
			</tr>
			<tr>
				<!-- <td colspan="4" class="numbers">{{getTotal()}}</td> -->
				<td colspan="4" class="numbers">{{allTotal}}</td>
			</tr>
		</table>
	</div>
	</div>
</div>
<div class="col-xs-12 pad-free">
	<div class="col-xs-3">
		<table class="col-xs-12 table table-striped" id="allledger">
			<tr ng-repeat="x in annual">
				<td>{{x.alltype}}</td>
				<td class="numbers {{x.cname}}">{{x.amount | number : fractionSize}}</td>
			</tr>
			<tr ng-if="namt==0">
				<td>Negative Amount</td>
				<td class="numbers {{x.cname}}">{{namt| number : fractionSize}}</td>
			</tr>
			<tr style="background:red; color:white; font-weight:bold;" ng-if="namt!=0">
				<td>Negative Amount</td>
				<td class="numbers {{x.cname}}">{{namt| number : fractionSize}}</td>
			</tr>
		</table>
	</div>
	<!-- <div class="col-xs-9" id="dashr">
		<div class="col-xs-12 pad-free">
			<div class="col-sm-3" style="padding-left:0px; margin-bottom:0px;">
			<div class="form-group" style="margin-bottom:0px;">
				<input type="text" ng-model="datefilter" class="form-control" datepicker placeholder="Date">
			</div>
			</div>
			<div class="col-xs-3 pull-right">
				<label class="col-xs-9">Total Row :</label>
				<label class="col-xs-3" style="color:green;">{{dashresult.length}}</label>
			</div>
		</div>
		<div class="col-xs-12 pad-free" style="height:400px; overflow-y:auto; margin-top:0px;"> 
		<table class="table table-striped">
			<tr>
				<th style="width:90px;">Date</th>
				<th style="width:80px;">Time</th>	
				<th>League</th>		
				<th>I/O</th>
				<th>Body&nbsp;WL</th>
				<th>Body&nbsp;Over</th>
				<th>Goal&nbsp;WL</th>
				<th>Goal&nbsp;Over</th>
			</tr>
			<tr ng-repeat="a in dashresult | filter:{tdate:datefilter}">
				<td>{{a.tdate}}</td>
				<td>{{a.ttime}}</td>
				<td>{{a.leaguename}}</td>
				<td class="adminacctd {{a.ioclassname}}">{{a.aio}}</td>
				<td class="numbers {{a.bclass}}">{{a.resultbody | number : fractionSize}}</td>
				<td>{{a.bover}}</td>	
				<td class="numbers {{a.gclass}}">{{a.resultgoal | number : fractionSize}}</td>	
				<td>{{a.gover}}</td>
			</tr>
			
		</table>
	</div>
	</div> -->
</div>

</div>