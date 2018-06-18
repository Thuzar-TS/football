<div class="container-fluid">
	<div class="col-xs-12 form-group">
		<h3 id="allh3" class="col-xs-12">Term and Condition</h3>
	</div>
	<!-- <div class="col-xs-12 col-sm-12">
		<div ng-bind-html="hdata"></div>
	</div> -->
	<div class="col-xs-12 col-sm-12">
		 <div text-angular name="textBox" ng-model="header" required ta-toolbar="[['h1','h2','h3','h4','h5','h6','p'],
	          ['bold','italics','underline','ul','ol','redo','undo','clear'],['justifyLeft','justifyCenter','justifyRight','indent','outdent']]"></div>	
	</div>
	<div class="col-xs-12 col-sm-12">
		 <div text-angular name="bodies" ng-model="bodies" required ta-toolbar="[['h1','h2','h3','h4','h5','h6','p'],
         		 ['bold','italics','underline','ul','ol','redo','undo','clear'],['justifyLeft','justifyCenter','justifyRight','indent','outdent']]"></div>	
	</div>
	<div class="col-xs-12 col-sm-12" >
		 <div text-angular name="footer" ng-model="footer" required ta-toolbar="[['h1','h2','h3','h4','h5','h6','p'],
          		['bold','italics','underline','ul','ol','redo','undo','clear'],['justifyLeft','justifyCenter','justifyRight','indent','outdent']]"></div>	
	</div>
	<div class="col-sm-1" style="position:fixed;bottom:5px;right:5px;">
		<input type="button" class="form-control btn all-btn" name="Save" value="Save" ng-click="ttc()">
	</div>
</div>