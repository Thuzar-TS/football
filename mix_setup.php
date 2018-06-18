<div class="container-fluid">
<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Mix Setup</h3>
	</div>
	<div class="col-xs-12 col-sm-9">
		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Mix</th>			
			<th>Min Bet Amount</th>
			<th>Max Bet Amount</th>
			<th>Limit Max Amount</th>
			<th>MM%</th>
			<th>Commission</th>
			<th>&nbsp;</th>
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		<tr ng-repeat="x in names">
			<td>{{$index+1}}</td>
			<td>{{x.mixname}} mix</td>			
			<td>{{x.min_amount}}</td>
			<td>{{x.max_amount}}</td>
			<td>{{x.limit_amount}}</td>
			<td>{{x.mmval}}</td>
			<td style="width:250px;"><div class="col-xs-3 pad-free">
				<label class="switch">
		     		<input type="checkbox" ng-model="onoffarray[x.mix_name]">
		     		<div class="slider round" ng-click="changeStatus(x.mix_id,onoffarray[x.mix_name]);"></div>
          				</label>
			        </div>	
			        <div class="col-xs-3 pad-free">
			        	<button class="btn blu-btn" style="font-size:0.6em; padding:3px 7px;" ng-disabled="x.com_for==1?true:false" ng-click="calculatecom(x)">COM</button>
			        </div>   
			        <div class="col-xs-6 pad-free">
			        	<a ng-if="x.com_for == 1" ng-click="changeCom(x)" style="text-decoration:none;">[Change COM]</a>
				<a ng-if="x.com_for == 0" style="text-decoration:none; color:red;">[Change COM]</a>
			        </div>
			                				
                  		</td>
			<td>{{x.description}}</td>
			<td><label ng-click="editmix(x,x.mix_id)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="delmix(x.mix_id)" style="cursor:pointer;">Delete</label></td>
		</tr>		
		</table>
	</div>
	<div class="col-xs-12 col-sm-2 col-sm-offset-1" style="margin-top:10px;">
		<form class="form-horizontal row">
			<div class="col-xs-12" style="border: 2px solid #3E5315; padding-top:10px; border-radius:3px; margin-bottom:30px; background:#ccc;">
				<div class="form-group row">
					<div class="col-xs-12 pad-free">
						<label class="col-xs-5">At Least</label>
						<div class="col-xs-4 pad-free">
							<input type="text" class="form-control" name="atleast" ng-model="atleast" placeholder="0">
						</div>
						<label class="col-xs-3 pad-free">&nbsp;Mix</label>
					</div>								
				</div>
				<div class="form-group row">
					<div class="col-xs-12 pad-free">
						<label class="col-xs-5">Up To</label>
						<div class="col-xs-4 pad-free">
							<input type="text" class="form-control" name="upto" ng-model="upto" placeholder="0">
						</div>
						<label class="col-xs-3 pad-free">&nbsp;Mix</label>
					</div>								
				</div>
				<div class="col-sm-3 pull-right" style="margin-bottom:10px;">
					<img src="images/tick.png" style="width:40px; cursor:pointer;" ng-click="mixlimit()">
				</div>
			</div>			
		
		</form>
		<div class="col-sm-12">
			<button class="btn all-btn form-control" ng-click="newmix()">New Mix</button>
		</div>
	</div>

	<div id="dashedit" class="col-xs-6 col-xs-offset-3" style="position:fixed; top:50px;">
	<div class="col-xs-12" style="margin-top:20px; padding-bottom:20px;">	
	
	<form class="col-xs-12" name="myForm">

             	<div class="col-xs-12 col-sm-6" style="line-height:35px;">
         			<div class="form-group">
				<label classs="col-xs-12" >Mix</label>
				<input type="number" ng-model="mname" name="mname" class="form-control" placeholder="Only Number" min="1" value="0">	

			</div>
			<div class="form-group">
				<label classs="col-xs-12" >Min Bet Amount</label>
				<input type="text" ng-model="minval" class="form-control">
			</div>
			<div class="form-group">
				<label classs="col-xs-12" >Max Bet Amount</label>
				<input type="text" ng-model="maxval" class="form-control">
			</div>	
		</div>
		<div class="col-xs-12 col-sm-6" style="line-height:35px;">
         			<div class="form-group">
				<label classs="col-xs-12" >Limit Max Amount</label>
				<input type="text" ng-model="limitmaxval" class="form-control">
			</div>
			<div class="form-group">
				<label classs="col-xs-12" >MM%</label>
				<input type="text" ng-model="mmval" class="form-control">
			</div>
			<div class="form-group">
				<label classs="col-xs-12" >State</label>
				<select ng-model="mixstatus" ng-options="abb.description for abb in bss track by abb.bs" class="form-control"></select>
			</div>	
		</div>
		<div class="col-xs-12" style="text-align:center;">
			<span ng-show="myForm.mname.$valid==false" style="color:red;">Mix Number Invalid !</span>
		</div>
		<div class="col-sm-2 col-sm-offset-4" style="margin-top:20px;" ng-show="showmix">
              		<input type="button" ng-click='savemix()' class="form-control btn all-btn" name="submit" value="Save" ng-disabled="myForm.mname.$valid==false?true:false">
              	</div>
              	<div class="col-sm-2 col-sm-offset-4" style="margin-top:20px;" ng-show="!showmix">
              		<input type="button" ng-click='emix()' class="form-control btn all-btn" name="submit" value="Edit" ng-disabled="myForm.mname.$valid==false?true:false">
              	</div>
              	<div class="col-sm-2" style="margin-top:20px;">
              		<input type="button" value="Close" ng-click="bDone()" style="cursor:pointer;" class="form-control btn all-btn">
              	</div>
	</form>
        </div>
  
</div>
	</div>