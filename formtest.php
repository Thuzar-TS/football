<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Example - example-email-input-directive-production</title>
  <script src="js/angular.min.js"></script>  
  <script src="js/protect.js"></script>  
</head>
<body ng-app="">
  <script>
  function Ctrl($scope) {
    $scope.text = 'me@example.com';
  }
</script>
  <form name="myForm" ng-controller="Ctrl">
    Email: <input type="email" name="input" ng-model="text" ng-pattern="/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/" required>
    <span class="error" ng-show="myForm.input.$error.required">
      Required!</span>
    <span class="error" ng-show="myForm.input.$error.email">
      Not valid email!</span>
    <tt>text = {{text}}</tt><br/>
    <tt>myForm.input.$valid = {{myForm.input.$valid}}</tt><br/>
    <tt>myForm.input.$error = {{myForm.input.$error}}</tt><br/>
    <tt>myForm.$valid = {{myForm.$valid}}</tt><br/>
    <tt>myForm.$error.required = {{!!myForm.$error.required}}</tt><br/>
    <tt>myForm.$error.email = {{!!myForm.$error.email}}</tt><br/>
  </form>
</body>
</html>