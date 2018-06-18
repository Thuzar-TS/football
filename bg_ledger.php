<div class="container-fluid">
<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>

	<div class="col-xs-12" style="margin-top:10px;">
		<div class="col-xs-1 pad-free">
			<a href="#allledger/" class="btn all-btn col-xs-12">Back</a>
		</div>
		<div class="col-sm-2" style="margin-bottom:0px;">
		<div class="form-group" style="margin-bottom:0px;">
			<input type="text" class="form-control"  ng-model="allfilter1.datefilter" datepicker placeholder="Bet Date" ng-init="allfilter1.datefilter=''">
		</div>
		</div>
		<div class="col-xs-3 pull-right">
			<label class="col-xs-6">Total Row :</label>
			<label class="col-xs-6" style="color:green;">{{dashresult.length}}</label>
		</div>
	</div>	
	
	<div class="col-xs-12 mixbgledger" id="admindiv" style="border:0px;">
		
		<div class="col-xs-12 pad-free" style="height:500px; overflow-y:auto; margin-top:0px;"> 
		<table class="table table-striped">
			<tr>
				<th style="width:90px;">Date</th>
				<th style="width:80px;">Time</th>	
				<!-- <th>League</th> -->		
				<th>I/O</th>
				<th>Body&nbsp;WL</th>
				<th>Body&nbsp;Over</th>
				<th>Goal&nbsp;WL</th>
				<th>Goal&nbsp;Over</th>
			</tr>
			<tr ng-if="dashresult == '' || dashresult == 'No Record' || dashresult.length<1">
				<td> - </td>
				<td> - </td>
				<td> - </td>
				<td> No Record </td>
				<td> - </td>
				<td> - </td>
				<td> - </td>			
			</tr>
			<tr ng-repeat="a in dashresult">
				<td>{{a.tdate}}</td>
				<td>{{a.ttime}}</td>
				<!-- <td>{{a.leaguename}}</td> -->
				<td class="adminacctd {{a.ioclassname}}">{{a.aio}}</td>
				<td class="numbers {{a.bclass}}">{{a.resultbody | number : fractionSize}}</td>
				<td>{{a.bover}}</td>	
				<td class="numbers {{a.gclass}}">{{a.resultgoal | number : fractionSize}}</td>	
				<td>{{a.gover}}</td>
			</tr>
			
		</table>
		</div>
	</div>
	</div>
</div>