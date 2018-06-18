angular.module("dashboard-controller",[])
.controller("userlistController", function($scope, $http) {
  if (window.localStorage.getItem("roleId")!=3) {
    $("#menu").css("display","block");
  }
  else{
               $("#menu").css("display","none");
                $("#mmenu").css("display","block");
                $("#login").css("display","none");
            }
                    $http.post("query.php",{"type":"ledger"})
                        .then(function (response) {
                            $scope.total = response.data.m;
                            $scope.mledger = response.data.ledger;
                    });

        })
;