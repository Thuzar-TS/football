<div class="container-fluid">
<div id="black-overlay" class="col-xs-12 pad-free" style="position:fixed;"></div>
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Acc Body</h3>
	</div>
	<div class="col-xs-12 col-sm-5">
		<table class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Description</th>
			<th>Formula</th>
			<th colspan="2" style="text-align:center;">&nbsp;</th>
		</tr>
		<tr ng-repeat="x in names|filter:btype">
			<td>{{$index+1}}</td>
			<td>{{x.description}}</td>
			<td>{{x.formula}}</td>
			<td><label ng-click="editabody(x,x.accbody_id)" style="cursor:pointer;">Edit</label></td>
			<td><label ng-click="delabody(x.accbody_id)" style="cursor:pointer;">Delete</label></td>
		</tr>
		</table>
	</div>

	<div class="col-xs-12 col-sm-6 col-sm-offset-1">
	
		<form class="form-horizontal row">
				<div class="form-group">
					<label class="col-xs-12">Description</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name="des" ng-model="des">
					</div>
				</div>
				<label id="formulalbl" ng-show="formula">Formula Setup</label>
				<label id="formulalbl" ng-show="con">Condition Setup</label>
				<label id="formulalbl" ng-show="tru">True Setup</label>
				<label id="formulalbl" ng-show="fal">False Setup</label>
				<!-- <div class="form-group">
					<button class="col-sm-3">Condition</button>
				</div> -->
				<div class="form-group" ng-init="contest='cyes'"> 
					<div class="col-xs-6">
					<label class="radio-inline">
					  <input type="radio" name="contest" ng-model="contest" value="cyes">Condition
					</label>
					</div>
					
					<div class="col-xs-6">
					<label class="radio-inline">
					  <input type="radio" name="contest" ng-model="contest" value="cno">Or Not
					</label>
					</div>
				</div>

				<div class="col-xs-12 pad-free" ng-show="contest=='cyes'" style="min-height:200px;">
				<div id="conyes" class="col-sm-4" >
					<div class="form-group">
						<label class="col-xs-8">Condition</label>
						<div class="col-xs-4">
							<button class="form-control" ng-click="fcondition()">+</button>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-8">True</label>
						<div class="col-xs-4">
							<button class="form-control" ng-click="ftrue()">+</button>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-8">False</label>
						<div class="col-xs-4">
							<button class="form-control" ng-click="ffalse()">+</button>
						</div>
					</div>
				</div>
				<div class="col-sm-8" id="conditionset" ng-show="conditionset">
					<div class="form-group formulagp">
						<div class="col-sm-5 pad-free">
							<div class="col-sm-8 pad-free" style="margin-bottom:15px;">
							<select ng-options="c as c.description for c in cvariables track by c.formulalist_id" ng-model="cvariable" class="form-control">
							</select>
							</div>
							<div class="col-sm-4">
								<img src="images/next.png" ng-click="conadd()">
							</div>

							<div class="col-sm-8 pad-free">
							<select ng-model="coperator" class="form-control">
								<option value="">Operator</option>
								<option value="+">+</option>
								<option value="-">-</option>
								<option value="/">/</option>
								<option value="*">x</option>
								<option value="<"><</option>
								<option value=">">></option>
								<option value="==">==</option>
								<option value="(">(</option>
								<option value=")">)</option>
								<option value="?">?</option>
								<option value=":">:</option>
							</select>
							</div>
							<div class="col-sm-4">
								<img src="images/next.png" ng-click="conopadd()">
							</div>

							<div class="col-sm-8 pad-free" style="margin-top:15px;">
								<input type="text" class="form-control" ng-model="cnumber" name="cnumber">
							</div>

							<div class="col-sm-4" style="margin-top:15px;">
								<img src="images/next.png" ng-click="connumadd()">
							</div>

							<div class="col-sm-6 pad-free" style="margin-top:15px;">
								<button class="form-control" ng-click="conclear()">Clear</button>
							</div>
						</div>						
						
						<div class='col-xs-7 pad-free'>
							<textarea name="txtcondition" ng-model="txtcondition" class="form-control" cols="30" rows="5" readonly="true"></textarea>
						</div>				
					</div>
				</div>

				<div class="col-sm-8" id="trueset" ng-show="trueset">
					<div class="form-group formulagp">
						<div class="col-sm-5 pad-free">
							<div class="col-sm-8 pad-free" style="margin-bottom:15px;">
							<select ng-options="t as t.description for t in tvariables track by t.formulalist_id" ng-model="tvariable" class="form-control">
							</select>
							</div>
							<div class="col-sm-4">
								<img src="images/next.png" ng-click="trueadd()">
							</div>

							<div class="col-sm-8 pad-free">
							<select ng-model="toperator" class="form-control">
								<option value="">Operator</option>
								<option value="+">+</option>
								<option value="-">-</option>
								<option value="/">/</option>
								<option value="*">x</option>
								<option value="<"><</option>
								<option value=">">></option>
								<option value="==">==</option>
								<option value="(">(</option>
								<option value=")">)</option>
								<option value="?">?</option>
								<option value=":">:</option>
							</select>
							</div>
							<div class="col-sm-4">
								<img src="images/next.png" ng-click="trueopadd()">
							</div>

							<div class="col-sm-8 pad-free" style="margin-top:15px;">
								<input type="text" class="form-control" ng-model="tnumber" name="tnumber">
							</div>

							<div class="col-sm-4" style="margin-top:15px;">
								<img src="images/next.png" ng-click="truenumadd()">
							</div>

							<div class="col-sm-6 pad-free" style="margin-top:15px;">
								<button class="form-control" ng-click="trueclear()">Clear</button>
							</div>
						</div>						
						
						<div class='col-xs-7 pad-free'>
							<textarea name="txttrue" ng-model="txttrue" class="form-control" cols="30" rows="5" readonly="true"></textarea>
						</div>				
					</div>
				</div>

				<div class="col-sm-8" id="falseset" ng-show="falseset">
					<div class="form-group formulagp">
						<div class="col-sm-5 pad-free">
							<div class="col-sm-8 pad-free" style="margin-bottom:15px;">
							<select ng-options="f as f.description for f in fvariables track by f.formulalist_id" ng-model="fvariable" class="form-control">
							</select>
							</div>
							<div class="col-sm-4">
								<img src="images/next.png" ng-click="falseadd()">
							</div>

							<div class="col-sm-8 pad-free">
							<select ng-model="foperator" class="form-control">
								<option value="">Operator</option>
								<option value="+">+</option>
								<option value="-">-</option>
								<option value="/">/</option>
								<option value="*">x</option>
								<option value="<"><</option>
								<option value=">">></option>
								<option value="==">==</option>
								<option value="(">(</option>
								<option value=")">)</option>
								<option value="?">?</option>
								<option value=":">:</option>
							</select>
							</div>
							<div class="col-sm-4">
								<img src="images/next.png" ng-click="falseopadd()">
							</div>

							<div class="col-sm-8 pad-free" style="margin-top:15px;">
								<input type="text" class="form-control" ng-model="fnumber" name="fnumber">
							</div>

							<div class="col-sm-4" style="margin-top:15px;">
								<img src="images/next.png" ng-click="falsenumadd()">
							</div>

							<div class="col-sm-6 pad-free" style="margin-top:15px;">
								<button class="form-control" ng-click="falseclear()">Clear</button>
							</div>
						</div>						
						
						<div class='col-xs-7 pad-free'>
							<textarea name="txtfalse" ng-model="txtfalse" class="form-control" cols="30" rows="5" readonly="true"></textarea>
						</div>				
					</div>
				</div>
				</div>

				<div class="col-xs-12 pad-free" ng-show="contest=='cno'" style="min-height:200px;">
				<div id="conno" class="col-sm-4">
				<div class="form-group">
					<label class="col-xs-8">Formula</label>
					<div class="col-xs-4">
						<button class="form-control" ng-click="fformula()">+</button>
					</div>
				</div>
				</div>

				<div class="col-sm-8" id="formulaset" ng-show="formulaset">
					<div class="form-group formulagp">
						<div class="col-sm-5 pad-free">
							<div class="col-sm-8 pad-free" style="margin-bottom:15px;">
							<select ng-options="fo as fo.description for fo in forvariables track by fo.formulalist_id" ng-model="forvariable" class="form-control">
							</select>
							</div>
							<div class="col-sm-4">
								<img src="images/next.png" ng-click="fadd()">
							</div>

							<div class="col-sm-8 pad-free">
							<select ng-model="foroperator" class="form-control">
								<option value="">Operator</option>
								<option value="+">+</option>
								<option value="-">-</option>
								<option value="/">/</option>
								<option value="*">x</option>
								<option value="<"><</option>
								<option value=">">></option>
								<option value="==">==</option>
								<option value="(">(</option>
								<option value=")">)</option>
								<option value="?">?</option>
								<option value=":">:</option>
							</select>
							</div>
							<div class="col-sm-4">
								<img src="images/next.png" ng-click="fopadd()">
							</div>

							<div class="col-sm-8 pad-free" style="margin-top:15px;">
								<input type="text" class="form-control" ng-model="fornumber" name="fornumber">
							</div>

							<div class="col-sm-4" style="margin-top:15px;">
								<img src="images/next.png" ng-click="fornumadd()">
							</div>

							<div class="col-sm-6 pad-free" style="margin-top:15px;">
								<button class="form-control" ng-click="fclear()">Clear</button>
							</div>
						</div>						
						
						<div class='col-xs-7 pad-free'>
							<textarea name="txtformula" ng-model="txtformula" class="form-control" cols="30" rows="5" readonly="true"></textarea>
						</div>				
					</div>
				</div>
				</div>

				<div class="col-sm-offset-4 col-sm-4">
					<div class="form-group">
						<button class="form-control btn all-btn" ng-click="finish()">Finished Setup</button>
					</div>
				</div>
				
				<div class="col-sm-12" id="formulashow">
					<div class="form-group">
						<textarea name="wholeformula" ng-model="wholeformula" class="form-control" cols="30" rows="5" readonly="true"></textarea>
					</div>
				</div>
				
				
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-4">
						<input type="submit" ng-click='saveabody()' class="form-control btn all-btn" name="submit" value="Save" ng-show="showabody">
					</div>

					<div class="col-sm-offset-4 col-sm-4">
						<input type="submit" ng-click='eabody()' class="form-control btn all-btn" name="edit" value="Edit" ng-show="!showabody">
					</div>
				</div>

		</form>
	</div>
	</div>