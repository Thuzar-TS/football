<?php 
    session_start();
    session_destroy();
 ?>
<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" id="loginDiv">

    <h2>Login Form</h2>


    <form class="form-horizontal col-xs-10 col-xs-offset-1 pad-free" role="form" id="loginForm">      
        <div class="form-group">
            <div class="col-xs-12">
                <input type="text" ng-model="username" placeholder="User Name" class="form-control" ng-required> 
            </div>            
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input type="password" ng-model="password" placeholder="Password" class="form-control" ng-required> 
                <p style="color:red;">{{errorTxt}}</p>
            </div>   
        </div>

        <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
                <input type="submit" ng-click='login()' value="Login" class="form-control btn all-btn">
        </div>
        </div>
    </form>
</div>
