<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Terms & Conditions Setup</h3>
	</div>


	<div class="col-xs-12">
		<form class="form-horizontal row">				
				<div class="form-group row">
					<label class="col-xs-12">Title</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="title" ng-model="title" required>
					</div>
				</div>				
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='savegoal()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showgoal">
					</div>

					<div class="col-sm-offset-3 col-sm-6">
						<input type="button" ng-click='egoal()' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showgoal">
					</div>
				</div>
		</form>
	</div>
	</div>