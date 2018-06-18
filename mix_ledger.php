<div class="container-fluid">
<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
	<!-- <div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Mix -- Body -- Goal+ (Ledger)<div class="col-xs-1 pad-free pull-right">
			<a href="#allledger/" class="btn all-btn col-xs-12">Back</a>
		</div></h3>
	</div> -->
	<div class="col-xs-12" style="margin-top:10px;">
		<div class="col-xs-1 pad-free">
			<a href="#allledger/" class="btn all-btn col-xs-12">Back</a>
		</div>
		<div class="col-sm-2" style="margin-bottom:0px;">
		<div class="form-group" style=" margin-bottom:0px;">
			<input type="text" class="form-control" ng-model="allfilter.filterDate" datepicker placeholder="Bet Date" ng-init="allfilter.filterDate=''">
		</div>
		</div>
		<div class="col-xs-3 pull-right">
			<label class="col-xs-6">Total Row :</label>
			<label class="col-xs-6" style="color:green;">{{mixtotal.length}}</label>
		</div>
	</div>
	
	<div class="col-xs-12 mixbgledger">	
		
		<div class="col-xs-12 pad-free" style="height:500px; overflow:auto; margin-top:0px;"> 
			<table class="table">
				<tr>
					<th style="width:40px;">No.</th>
					<th style="width:100px;">Date</th>
					<th colspan="4">&nbsp;</th>
				</tr>
				<tr ng-if="mixtotal == 'No Record' || mixtotal == ''">
					<td> - </td>
					<td> No Record </td>
					<td> - </td>
					<td> - </td>
					<td> - </td>
					<td> - </td>			
				</tr>
				<tr ng-repeat="x in mixtotal | groupBy: '[bet_date]'">
					<td>{{$index+1}}</td>
					<td>{{x[0].bet_date}}</td>
					<td>
						<table class="table table-hover table-condensed" style="border:0px;margin:0px;background:none;" id="innertbl">
							<tr style="border:0px;">
								<th>Mix</th>
								<th style="text-align:right;">Bet Amount</th>
								<th style="text-align:right;">Result Amount</th>			
								<th style="text-align:right;">Net Amount</th>
							</tr>
							<tr ng-repeat="xx in x" style="border:0px;">
								<td style="border:0px; border-bottom:1px solid #ddd;">{{xx.mixname}} Mix</td>
								<td style="border:0px;text-align:right; border-bottom:1px solid #ddd;" class="{{xx.betclass}}">{{xx.bet_amount | number : fractionSize}}</td>
								<td style="border:0px;text-align:right; border-bottom:1px solid #ddd;" class="{{xx.resultclass}}">{{xx.result_amount | number : fractionSize}}</td>
								<td style="border:0px;text-align:right; border-bottom:1px solid #ddd;" class="{{xx.netclass}}">{{xx.net_amount | number : fractionSize}}</td>
							</tr>
						</table>
					</td>
								
				</tr>		
			</table>
		</div>
		</div>
	
	<!-- <div class="col-xs-6" id="dashr" style="padding-right:0px;">
	<div class="col-xs-12 mixbgledger" style="border: 1px solid #ccc;">
		<div class="col-xs-12 pad-free">
			<div class="col-sm-4" style="padding-left:0px; margin-bottom:0px;">
			<div class="form-group" style="margin-bottom:0px;">
				<input type="text" class="form-control"  ng-model="allfilter1.datefilter" datepicker placeholder="Bet Date" ng-init="allfilter1.datefilter=''">
			</div>
			</div>
			<div class="col-xs-5 pull-right">
				<label class="col-xs-9">Total Row :</label>
				<label class="col-xs-3" style="color:green;">{{dashresult.length}}</label>
			</div>
		</div>
		<div class="col-xs-12 pad-free" style="height:400px; overflow-y:auto; margin-top:0px; font-size:0.8em;"> 
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
			<tr ng-if="dashresult == '' || dashresult == 'No Record' || dashresult.length<1">
				<td> - </td>
				<td> No Record </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>			
			</tr>
			<tr ng-repeat="a in dashresult">
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
	</div>
	</div> -->
</div>