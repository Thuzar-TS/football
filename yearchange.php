<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Year Change</h3>
	</div>
	<div class="col-sm-6 col-sm-offset-3" id="yearch">
	   <!-- <div class="col-sm-3" ng-repeat="x in yeararr">
	   	   <div class="form-group">
	   	   	<label style="cursor:pointer; margin-left:5px;">
	   				<input type="radio" value="{{x}}" ng-if="x == currentyear" checked="checked">
	   				<input type="radio" value="{{x}}" ng-if="x != currentyear">
	   				{{x}}
	   			</label>
	   	   </div>	   	
	   	</div> -->	
	   <label for="">Current year is : {{currentyear}}.</label> </br>
	   <label ng-if="change == false">Do you want to change year ( {{currentyear}} => {{changeyear}} ) ?</label></br>
	   <label ng-if="change == true">Already Changed for this year!</label></br>
	   <button class="btn all-btn" style="margin-top:20px;" ng-if="change == false" ng-click="chyear(currentyear,changeyear)">Change Year</button>
	</div>
</div>