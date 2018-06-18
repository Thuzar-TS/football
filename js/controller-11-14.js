angular.module('controller', [])
.value('scoreid', 0)
.value('leagueid', 0)
.value('mixid', 0)
.value('goalid',0)
.value('bodyid',0)
.value('userid',0)
.value('timetableid',0)
.value('stid',0)
.value('turnval',0)
.value('resultval',0)
.value('formula','')
.value('forname',[])
.value('larray',[])
.value('bcheck',0)
.value('gcheck',0)

.controller("logoutController", function($location) {
      window.localStorage.removeItem("roleId");
      window.localStorage.removeItem("userId");
      if (window.localStorage.getItem("agentId")) {
        window.localStorage.removeItem("agentId");
      }
      $("#wrapper").css("display","none");  
      $("#adminmenu").css("display","none");  
      $("#accmenu").css("display","none"); 
      $("#mmenu").css("display","none");  
      $("#navbar-data1 .adminmenu").css("display","none");  
      $("#navbar-data1 .mmenu").css("display","none"); 
      $location.path('/');         
        })

.controller("memberController", function($scope, $http, $location) {
    if (window.localStorage.getItem("roleId")) {
      $("#wrapper").css("display","block");
           if (window.localStorage.getItem("roleId")!=3) {
                if (window.localStorage.getItem("roleId")==2) {
                    $("#accmenu").css("display","block");
                  }
                  else if (window.localStorage.getItem("roleId")==1) {
                    $("#adminmenu").css("display","block");
                    $("#navbar-data1 .adminmenu").css("display","block");
                  }
              $("#mmenu").css("display","none");
            //  $("#navbar-data1 .adminmenu").css("display","block");
              $("#navbar-data1 .mmenu").css("display","none");
              $("#login").css("display","none");
            }
            else{
              $("#header").css("display","block");
                $("#adminmenu").css("display","none");
                $("#accmenu").css("display","none");
                $("#mmenu").css("display","block");
                $("#navbar-data1 .adminmenu").css("display","none");
                $("#navbar-data1 .mmenu").css("display","block");
                $("#login").css("display","none");
                $("#action").css("display","block");
                $(".actbetimg").css("display","block");                              
            }

            $http.post("query.php",{"type":"member", "btn":""})
                    .then(function (response) {
                        $scope.names = response.data;
                    });
            $scope.showmember = true;

            $scope.match=function(){
                if ($scope.pass==$scope.conpass) {
                        $scope.IsMatch=false;
                        return false;
                }
                else   
                {
                    $scope.IsMatch=true;
                }
            }
            

            $scope.save = function(){
              if ($scope.mname==null || $scope.loginid==null || $scope.pass==null) {
                    $scope.loginerror="Please Fill Completely.";                  
              } else{
                $http.post("query.php",{"username":$scope.mname,"loginid":$scope.loginid, "pass":$scope.pass,"mail":$scope.mail,"dob":$scope.tdate,"ph":$scope.ph,"type":"member","btn":"save"})
                        .then(function (response) {
                            $scope.names = response.data;
                            alert("Successful ADded");
                        });
                        $scope.mname = null;
                        $scope.pass = null;
                        $scope.conpass = null;
                        $scope.mail = null;
                        $scope.card = null;
                        $scope.dob = null;
                        $scope.ph = null;
                        $scope.city = null;
                        $scope.amount = null;
              };
                    
            }

           $scope.delm = function(a){
                    var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"mid":a, "type":"member", "btn":"delete"})
                            .then(function (response) {
                                $scope.names = response.data;
                                alert("Successful Deleted");
                            });
                    }
           }

           $scope.editm = function(a,b){
                    $scope.mname = a.username;
                    $scope.mail = a.mail;
                    $scope.card = a.cardnumber;
                    $scope.tdate = a.dob;
                    $scope.ph = a.phone;
                    $scope.city = a.city;
                    $scope.amount = a.amount;
                    $scope.mid = b;
                    $scope.showmember = false;
           }

           $scope.euser = function(){
                   $http.post("query.php",{"username":$scope.mname,"mid":$scope.mid,"pass":$scope.pass,"mail":$scope.mail,"card":$scope.card,"dob":$scope.tdate,"ph":$scope.ph,"city":$scope.city,"amount":$scope.amount, "type":"member", "btn":"edit"})
                    .then(function (response) {
                        $scope.names = response.data;
                        alert("Successful Edited");
                    });
                    //alert($scope.amount);
                    $scope.mname = null;
                    $scope.pass = null;
                    $scope.conpass = null;
                    $scope.mail = null;
                    $scope.card = null;
                    $scope.dob = null;
                    $scope.ph = null;
                    $scope.city = null;
                    $scope.amount = null;
                    $scope.showmember = true;
           } 
    }
    else{
      $location.path("/");
    }           
})
.controller("teamController", function($scope, $http, $location) {
  if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
   if (window.localStorage.getItem("roleId")!=3) {
     if (window.localStorage.getItem("roleId")==2) {
                    $("#accmenu").css("display","block");
                  }
                  else if (window.localStorage.getItem("roleId")==1) {
                    $("#adminmenu").css("display","block");
                    $("#navbar-data1 .adminmenu").css("display","block");
                  }
       
            $http.post("query.php",{"type":"team", "btn":""})
                    .then(function (response) {
                        $scope.names = response.data;
                    });
             $scope.showteam=true;
            $scope.save = function(){
              if ($scope.tname == null) {
                  alert("Please Fill Team Name");
              } else{
                  $http.post("query.php",{"teamname":$scope.tname, "type":"team", "btn":"save"})
                        .then(function (response) {
                            $scope.names = response.data;
                            alert("Successful Added");
                        });
                        $scope.tname = null;
              }
                    
            }

           $scope.delteam = function(a){
                    var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"teamid":a, "type":"team", "btn":"delete"})
                            .then(function (response) {
                                $scope.names = response.data;
                                alert("Successful Deleted");
                            });
                    }
           }

           $scope.editteam = function(a,b){
                    $scope.tname = a.teamname;
                    $scope.tid = b;
                    $scope.showteam=false;
           }

           $scope.eteam = function(b){
                    $http.post("query.php",{"teamname":$scope.tname,"teamid":b, "type":"team", "btn":"edit"})
                    .then(function (response) {
                        $scope.names = response.data;
                        alert("Successful Edited");
                    });
                    $scope.tname = null;
                    $scope.showteam=true;
           } 
         }
         else{
          $location.path("/");
         }
       }
})
.controller("leagueController", function($scope,$http, $location) {
  if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
   if (window.localStorage.getItem("roleId")!=3) {
     if (window.localStorage.getItem("roleId")==2) {
                    $("#accmenu").css("display","block");
                  }
                  else if (window.localStorage.getItem("roleId")==1) {
                    $("#adminmenu").css("display","block");
                    $("#navbar-data1 .adminmenu").css("display","block");
                  }
     
           $scope.showleague=true;
           $http.post("query.php",{"type":"league", "btn":""})
                    .then(function (response) {
                        $scope.names = response.data;
                    });   
           $scope.saveleague= function(){
            if ($scope.lname == null) {
              alert("Please Fill League Name");
            } else{
                $http.post("query.php",{"leaguename":$scope.lname, "type":"league", "btn":"save"})
                        .then(function (response) {
                            $scope.names = response.data;
                             alert("Successful Added");
                        });
                        $scope.lname= null;
            }
                    
            }
           $scope.delleague = function(a){
                    var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"leagueid":a, "type":"league", "btn":"delete"})
                            .then(function (response) {
                                $scope.names = response.data;
                                 alert("Successful Deleted");
                            });
                    }
           }
           $scope.editleague = function(a,b){
                    $scope.lname = a.leaguename;
                    leagueid = b;
                    $scope.showleague=false;
           }
           $scope.eleague = function(){
                    $http.post("query.php",{"leaguename":$scope.lname,"leagueid":leagueid, "type":"league", "btn":"edit"})
                    .then(function (response) {
                        $scope.names = response.data;
                         alert("Successful Edited");
                    });
                    $scope.showleague=true;
                    $scope.lname= null;
                    $scope.showleague=true;
           } 
         }
         else{
          $location.path("/");
         }
       }
})
.controller("mixController", function($scope,$http, $location) {
  if (window.localStorage.getItem("roleId")) {
   
   $("#wrapper").css("display","block");
   if (window.localStorage.getItem("roleId")!=3) {
     if (window.localStorage.getItem("roleId")==2) {
        $("#accmenu").css("display","block");
      }
      else if (window.localStorage.getItem("roleId")==1) {                                             
        $("#adminmenu").css("display","block");
        $("#navbar-data1 .adminmenu").css("display","block");
      }
           /* $scope.onoffarray=[{onoff_id:"1",onoff_name:"Login OFF",onoff_type:"loginonoff"},
                  {onoff_id:"2",onoff_name:"BG Betting OFF",onoff_type:"bettingonoff"},
                  {onoff_id:"3",onoff_name:"Mix OFF",onoff_type:"mixbettingonoff"},
                  {onoff_id:"4",onoff_name:"Deposit OFF",onoff_type:"depositonoff"},
                  {onoff_id:"5",onoff_name:"Withdraw OFF",onoff_type:"withdrawonoff"},
                  {onoff_id:"6",onoff_name:"Transfer OFF",onoff_type:"transferonoff"},
                  {onoff_id:"7",onoff_name:"Commission OFF",onoff_type:"commissiononoff"}];*/
           $scope.onoffarray = [];
           $scope.showmix=true;
           //$scope.mixid=0;
           $http.post("query.php",{"type":"mix", "btn":""})
                .then(function (response) {
                console.log(response.data);
                $scope.names = response.data.names;
                $scope.onoffarr = response.data.onoffarr;
                $scope.minmax = response.data.minmax;
                $scope.bss = response.data.bs;
                $scope.mixstatus=$scope.bss[1];
                $scope.atleast = $scope.minmax[0]["min_limit"];
                $scope.upto = $scope.minmax[0]["max_limit"];

                for (var i = $scope.onoffarr.length - 1; i >= 0; i--) {
                    //$scope.onoffarr[$scope.names[i].mix_name] = $scope.names[i].comval;
                    $scope.onoffarray.push({mix_name:$scope.onoffarr[i]});
                  }

                if ($scope.names != "No Record") {
                  for (var i = $scope.names.length - 1; i >= 0; i--) {
                    if ($scope.names[i].comval == 1) {
                      $scope.onoffarray[$scope.names[i].mix_name] = true;
                    }
                    else{
                      $scope.onoffarray[$scope.names[i].mix_name] = false;
                    }
                  };
                };
                console.log($scope.onoffarray);
            });

          $scope.changeStatus = function(a,b){
           // console.log(b);
            if (b == false) {
               b = "1";
            }
            else if (b == true) {
               b = "0";
            }
            //console.log(b);
            var con = confirm("Are you sure to change commission status?");
            if (con == true) {
                $http.post("query.php",{"mixid":a, "statusval":b, "type":"mix", "btn":"editstatus"})
                .then(function (response) {
                  console.log(response.data);
                    $scope.names = response.data.names;
                    $scope.onoffarr = response.data.onoffarr;
                    $scope.minmax = response.data.minmax;
                    $scope.bss = response.data.bs;
                    $scope.mixstatus=$scope.bss[1];
                    $scope.atleast = $scope.minmax[0]["min_limit"];
                    $scope.upto = $scope.minmax[0]["max_limit"];

                    for (var i = $scope.onoffarr.length - 1; i >= 0; i--) {
                        //$scope.onoffarr[$scope.names[i].mix_name] = $scope.names[i].comval;
                        $scope.onoffarray.push({mix_name:$scope.onoffarr[i]});
                      }

                    if ($scope.names != "No Record") {
                      for (var i = $scope.names.length - 1; i >= 0; i--) {
                        if ($scope.names[i].comval == 1) {
                          $scope.onoffarray[$scope.names[i].mix_name] = true;
                        }
                        else{
                          $scope.onoffarray[$scope.names[i].mix_name] = false;
                        }
                      };
                    };
                })
            }
          }

           $scope.savemix= function(){
              if ($scope.mname == null) {
                alert("Please Fill Mix Type");
              } else{
                  $http.post("query.php",{"mixname":$scope.mname, "minamt":$scope.minval, "maxamt":$scope.maxval, "limitval":$scope.limitmaxval, "mmval":$scope.mmval, "bs":$scope.mixstatus.bs, "type":"mix", "btn":"save"})
                  .then(function (response) {
                      $scope.names = response.data.names;
                      $scope.minmax = response.data.minmax;
                      $scope.atleast = $scope.minmax[0]["min_limit"];
                      $scope.upto = $scope.minmax[0]["max_limit"];
                        alert("Successful Added");
                  });
                  $scope.mname= null;
                  $scope.bDone();
                }                    
           }

           $scope.bDone = function(){
              $("#dashedit").css("display","none");
              $("#black-overlay").css("display","none");
              $scope.mname = "";
              $scope.minval = 0;
              $scope.maxval = 0;
              $scope.limitmaxval = 0;
              $scope.mmval = 0;
              $scope.mixstatus.bs=0;
           }

           $scope.mixlimit = function(){
              if ($scope.atleast == null || $scope.upto == null || $scope.atleast == undefined || $scope.upto == undefined) {
                alert("Please set mix min-max.");
              }
              else{
                $http.post("query.php",{"min":$scope.atleast, "max":$scope.upto, "type":"mix", "btn":"setmix"})
                  .then(function (response) {
                      $scope.names = response.data.names;
                      $scope.minmax = response.data.minmax;
                      $scope.atleast = $scope.minmax[0]["min_limit"];
                      $scope.upto = $scope.minmax[0]["max_limit"];
                      alert("Successfully Set");
                  });
                }                  
           }

           $scope.delmix = function(a){
                  var deleted = confirm("Are you sure to delete?");
                  if ( deleted == true) {
                        $http.post("query.php",{"mixid":a, "type":"mix", "btn":"delete"})
                        .then(function (response) {
                            $scope.names = response.data.names;
                            $scope.minmax = response.data.minmax;
                            $scope.atleast = $scope.minmax[0]["min_limit"];
                            $scope.upto = $scope.minmax[0]["max_limit"];
                             alert("Successful Deleted");
                        });
                  }
           }

           $scope.editmix = function(a,b){
              $("#dashedit").css("display","block");
              $("#black-overlay").css("display","block");
              $scope.mname = parseInt(a.mixname);
              $scope.minval = a.min_amount;
              $scope.maxval = a.max_amount;
              $scope.limitmaxval = a.limit_amount;
              $scope.mmval = a.mmval;
              $scope.mixstatus=a;
              mixid = b;
              $scope.showmix=false;
           }

           $scope.newmix = function(){
              $("#dashedit").css("display","block");
              $("#black-overlay").css("display","block");              
              $scope.showmix=true;
           }

           $scope.emix = function(){
                $http.post("query.php",{"mixname":$scope.mname, "minamt":$scope.minval, "maxamt":$scope.maxval, "limitval":$scope.limitmaxval, "mmval":$scope.mmval, "bs":$scope.mixstatus.bs, "mixid":mixid, "type":"mix", "btn":"edit"})
                .then(function (response) {
                  console.log(response.data);
                    $scope.names = response.data.names;
                    $scope.minmax = response.data.minmax;
                    $scope.atleast = $scope.minmax[0]["min_limit"];
                    $scope.upto = $scope.minmax[0]["max_limit"];
                     alert("Successful Edited");
                });
                $scope.showmix=true;
                $scope.mname= null;
                $scope.showmix=true;
                $scope.bDone();
           }            
       }
       else{
        $location.path("/");
       }
    }
})
.controller("goalController", function($scope,$http, $location) {
  if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
   if (window.localStorage.getItem("roleId")!=3) {
          if (window.localStorage.getItem("roleId")==2) {
            $("#accmenu").css("display","block");
          }
          else if (window.localStorage.getItem("roleId")==1) {
            $("#adminmenu").css("display","block");
            $("#navbar-data1 .adminmenu").css("display","block");
          }
     
           $scope.showgoal=true;
           $http.post("query.php",{"type":"goal", "btn":""})
                    .then(function (response) {
                        $scope.names = response.data;
                    });   
           $scope.savegoal= function(){
            if ($scope.gname == null) {
                alert("Please Fill Goal+ Name");
            }
            else{
                $http.post("query.php",{"goalname":$scope.gname, "type":"goal", "btn":"save"})
                        .then(function (response) {
                            $scope.names = response.data;
                            alert("Successful Added");
                        });
                        $scope.gname=null;
            }
                    
            }
           $scope.delgoal = function(a){
                    var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"gid":a, "type":"goal", "btn":"delete"})
                            .then(function (response) {
                                $scope.names = response.data;
                                 alert("Successful Deleted");
                            });
                    }
           }
           $scope.editgoal = function(a,b){
                    $scope.gname = a.goalname;
                    goalid = b;
                    $scope.showgoal=false;
           }
           $scope.egoal = function(){
                    $http.post("query.php",{"goalname":$scope.gname,"gid":goalid, "type":"goal", "btn":"edit"})
                    .then(function (response) {
                        $scope.names = response.data;
                         alert("Successful Edited");
                    });
                    $scope.showgoal=true;
                    $scope.gname=null;
                    $scope.gtype=null;
           } 
         }
         else{
          $location.path("/");
         }
       }
})
.controller("bodyController", function($scope,$http, $location) {
  if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
    if (window.localStorage.getItem("roleId")!=3) {
       if (window.localStorage.getItem("roleId")==2) {
          $("#accmenu").css("display","block");
        }
        else if (window.localStorage.getItem("roleId")==1) {
          $("#adminmenu").css("display","block");
          $("#navbar-data1 .adminmenu").css("display","block");
        }
       
           $scope.showbody=true;
           $http.post("query.php",{"type":"body", "btn":""})
                    .then(function (response) {
                        $scope.names = response.data;
                    });   
           $scope.savebody= function(){
            if ($scope.bname == null) {
              alert("Please fill Body Name");
            } else{
              $http.post("query.php",{"bname":$scope.bname,"type":"body", "btn":"save"})
                        .then(function (response) {
                            $scope.names = response.data;
                             alert("Successful Added");
                        });
                        $scope.bname=null;
                }                    
            }
           $scope.delbody = function(a){
                    var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"bid":a, "type":"body", "btn":"delete"})
                            .then(function (response) {
                                $scope.names = response.data;
                                 alert("Successful Deleted");
                            });
                    }
           }
           $scope.editbody = function(a,b){
                    $scope.bname = a.bodyname;
                    bodyid = b;
                    $scope.showbody=false;
           }
           $scope.ebody = function(){
                    $http.post("query.php",{"bname":$scope.bname, "bid":bodyid, "type":"body", "btn":"edit"})
                    .then(function (response) {
                        $scope.names = response.data;
                         alert("Successful Edited");
                    });
                    $scope.showbody=true;
                    $scope.bname=null;
           } 
         }
         else{
          $location.path("/");
         }
       }
})
.controller("userController", function($scope,$http,$location) {
  if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
    if (window.localStorage.getItem("roleId")==3) {
    $location.path("/");
  }   
  else if(window.localStorage.getItem("roleId")==1 || window.localStorage.getItem("roleId")==2){
    if (window.localStorage.getItem("roleId")==2) {
      $("#accmenu").css("display","block");
    }
    else if (window.localStorage.getItem("roleId")==1) {
      $("#adminmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","block");
    }
           $scope.showuser=true;
           $http.post("query.php",{"type":"user", "btn":""})
                    .then(function (response) {
                        $scope.roles = response.data.roles;
                         $scope.names = response.data.users;   
                         $scope.selectedvalue=$scope.roles[0];
                    });   
            $scope.match=function(){
                if ($scope.pass==$scope.conpass) {
                        $scope.IsMatch=false;
                        return false;
                }
                else   
                {
                    $scope.IsMatch=true;
                }
            }
           $scope.saveuser= function(){

            if ($scope.loginid == null || $scope.username == null || $scope.pass == null) {
                alert("Please Fill All Data");
            } else{
              if ($scope.gmail == null) {
                $scope.gmail = "";
              }
                $http.post("query.php",{"loginid":$scope.loginid,"username":$scope.username, "gmail":$scope.gmail, "roleid":$scope.selectedvalue.roleid,"pass":$scope.pass, "type":"user", "btn":"save"})
                        .then(function (response) {
                           // $scope.names = response.data;
                           alert("Successful Added");
                         $scope.roles = response.data.roles;
                         $scope.names = response.data.users;   
                         $scope.selectedvalue=$scope.roles[0];
                        });
                     $scope.username=null;
                     $scope.gmail=null;
                     $scope.selectedvalue=$scope.roles[0];
                     $scope.password=null;
                     $scope.loginid=null;
                    $scope.conpass=null;
            }
                    
            }
           $scope.deluser = function(a){
                    var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"uid":a, "type":"user", "btn":"delete"})
                            .then(function (response) {
                              //  $scope.names = response.data;
                               $scope.roles = response.data.roles;
                         $scope.names = response.data.users;   
                         $scope.selectedvalue=$scope.roles[0];
                                alert("Successful Deleted");
                            });
                    }
           }
            $scope.edituser=function(auser,aid){
              $scope.username=auser.username;
              $scope.gmail = auser.mail;
              $scope.selectedvalue=auser;
              $scope.loginid = auser.loginid;
              $scope.showuser=false;
               $scope.userid=aid;      
               $("#loginid").css("display","none");
                $("#lblloginid").css("display","block");          
            }
           $scope.euser = function(){
                    if ($scope.username == null || $scope.pass == null || $scope.conpass == null) {
                      alert($scope.username+"/"+$scope.pass);
                 alert("Fill Completely.");
            }else{
                $http.post("query.php",{"username":$scope.username, "gmail":$scope.gmail, "roleid":$scope.selectedvalue.roleid,"pass":$scope.pass,"uid":$scope.userid, "type":"user", "btn":"edit"})
                    .then(function (response) {
                      $scope.alldata = response.data;
                      $scope.names = response.data.users; 
                         $scope.roles = response.data.roles;
                         $scope.names = response.data.users;   
                         $scope.selectedvalue=$scope.roles[0];
                    });
                    $scope.showuser=true;
                    $scope.username=null;
                     $scope.gmail=null;
                     $scope.selectedvalue=$scope.roles[0];
                    $scope.pass=null;
                    $scope.conpass=null;
                    $scope.loginid=null;
                    $("#loginid").css("display","block");
                $("#lblloginid").css("display","none");    
            }
           } 
      }
    }
})
.controller("mhomeController", function($scope, $filter, $http, $routeParams, $location, $interval) {
   $scope.d = new Date();
   var month=$scope.d.getMonth()+1;
    if (month<10){
    month="0" + month;
    };
    var dday = $scope.d.getDate();
    if (dday<10){
    dday="0" + dday;
    };
    $scope.todayval = month+"-"+dday+"-"+$scope.d.getFullYear();
    if (window.localStorage.getItem("roleId")) {
    $("#wrapper").css("display","block");
    if (window.localStorage.getItem("roleId")!=3) {
       if (window.localStorage.getItem("roleId")==2) {
        $("#accmenu").css("display","block");
      }
      else if (window.localStorage.getItem("roleId")==1) {
        $("#adminmenu").css("display","block");
        $("#navbar-data1 .adminmenu").css("display","block");
      }
      }
      else{

        $("#header").css("display","block");
           $("#adminmenu").css("display","none");
           $("#accmenu").css("display","none");
            $("#mmenu").css("display","block");
            $("#navbar-data1 .adminmenu").css("display","none");
            $("#navbar-data1 .mmenu").css("display","block");
            $("#login").css("display","none");
        }
        $scope.rid = window.localStorage.getItem("roleId");

                if ($scope.rid == 3) {
                      $scope.m = window.localStorage.getItem("userId");
                      $scope.mid = "and a.member_id="+window.localStorage.getItem("userId");
                      if ($routeParams.datevalue) {   
                                  $scope.allbet = true;                                  
                                  $scope.datevalue = $routeParams.datevalue;   
                                  $scope.datevaluefilter = $routeParams.datevalue;
                            }
                            else{
                                 $scope.datevalue = "";
                                 $scope.datevaluefilter = $scope.todayval;
                            }

                        if ($routeParams.mbrid) {
                                $scope.mbrid = " and a.member_id="+$routeParams.mbrid; 
                            }
                            else{
                                $scope.mbrid = " and a.member_id="+window.localStorage.getItem("userId");
                            }

                        if ($routeParams.mix) {
                                $scope.mix = $routeParams.mix; 
                                $scope.mixledgertable = true;
                                $scope.showadmin = true;
                            }
                            else{
                                $scope.mix = "no";
                                $scope.mixledgertable = false;
                            }                 
                            console.log($scope.mix);               
                }
                else{                      
                  $scope.mid = "and a.member_id=0";     

                  if ($routeParams.datevalue) {    
                        $scope.allbet = true;                              
                       // $scope.allfilter.filterDate = $routeParams.datevalue; 
                        $scope.datevalue = $routeParams.datevalue;
                        $scope.datevaluefilter = $routeParams.datevalue;
                  } else{
                        //$scope.allfilter.filterDate = $scope.todayval;
                        $scope.datevalue = $scope.todayval;
                        $scope.datevaluefilter = $scope.todayval;
                        
                  }                             

                  if ($routeParams.mix) {
                                $scope.mix = $routeParams.mix; 
                                $scope.mixledgertable = true;
                                $scope.showadmin = true;
                                

                            }
                            else{
                                $scope.mix = "no";
                                $scope.mixledgertable = false;
                                
                            }

                             $scope.mbrid = "";
                }
              mhomecall();
               $scope.refreshfun = function(){
                mhomecall();
              }  

              

           //  if ($scope.mix == "mix") {
                  $scope.$watchCollection('allfilter', function(newValue, oldValue) {
                    filterallfun();
                  })
           //   }  

           // if ($scope.mix == "no") {
                  $scope.$watch('datevalue', function(newValue, oldValue) {
                    mhomecall();                    
                  })
            //  }

              $scope.changemixdetail = function(){
                $scope.mixledgertable = true;
                $scope.showadmin = true;
                $scope.mix = "mix";
                $scope.datevaluefilter = $scope.todayval;
                mhomecall();
              }

              $scope.changebgdetail = function(){
                $scope.mixledgertable = false;
                $scope.showadmin = false;
                $scope.mix = "no";
                $scope.datevaluefilter = $scope.todayval;
                mhomecall();
              }              

              function filterallfun(){
                var expression = {};
                var expression2 = {};

                        if($scope.allfilter.filterDate!=undefined)
                        {
                          expression2.bet_date = $scope.allfilter.filterDate || !!$scope.allfilter.filterDate || undefined;                      
                        }

                        if($scope.allfilter.filtermbr!=undefined)
                        {
                          expression2.username = $scope.allfilter.filtermbr || !!$scope.allfilter.filtermbr || undefined;                      
                        }
                      
                         $scope.filtered = $filter('filter')($scope.mledger1,expression2);
                         $scope.mledger = $scope.filtered;

                          var total = 0;
                          var total1 = 0;
                          if ($scope.mledger) {
                            for (var i = $scope.mledger.length - 1; i >= 0; i--) {
                              total += parseInt($scope.mledger[i].amount);

                              if($scope.mledger[i].state_id == 1){
                                total1 += parseInt($scope.mledger[i].amount);
                              } 
                            }   
                            $scope.allTotal = total;
                            $scope.allTotal1 = total1;
                          }
              }   
                
            }
            else{
              $location.path("/");
            }

            function mhomecall(){
                $http.post("query.php",{"type":"mpage","mid":$scope.mid,"btn":"ledger","sub":"","datevalue":$scope.datevalue,"mbrid":$scope.mbrid, "mix":$scope.mix})
                .then(function (response) {
                  console.log(response.data);
                        $scope.alldata = response.data;
                        $scope.total = response.data.m;
                        $scope.mbrname = response.data.mname;
                        $scope.mledger = response.data.ledger; 
                        $scope.mledger1 = response.data.ledger; 
                       // alert("MEmber Total amount is "+$scope.total);
                       var bettotal = 0;
                       var wltotal = 0;
                       var turnovertotal = 0;
                        for (var i = $scope.mledger.length - 1; i >= 0; i--) {
                          bettotal += parseInt($scope.mledger[i].betamount);
                          wltotal += parseInt($scope.mledger[i].wl);
                          turnovertotal += parseInt($scope.mledger[i].turnover);
                        }
                        $scope.bettingtotal = bettotal;
                        $scope.winlosetotal = wltotal;
                        $scope.turntotal = turnovertotal;
                        console.log($scope.mix);
                        if ($scope.mix == "mix") {
                          console.log($scope.mix);
                          filterallfun();
                        }                            
                });
              }
})

/*.controller("mmixController", function($scope, $filter, $http, $routeParams, $location, $interval) {
   $scope.d = new Date();
   var month=$scope.d.getMonth()+1;
    if (month<10){
    month="0" + month;
    };
    var dday = $scope.d.getDate();
    if (dday<10){
    dday="0" + dday;
    };
    $scope.todayval = month+"-"+dday+"-"+$scope.d.getFullYear();
    if (window.localStorage.getItem("roleId")) {
    $("#wrapper").css("display","block");
    if (window.localStorage.getItem("roleId")!=3) {
       if (window.localStorage.getItem("roleId")==2) {
        $("#accmenu").css("display","block");
      }
      else if (window.localStorage.getItem("roleId")==1) {
        $("#adminmenu").css("display","block");
        $("#navbar-data1 .adminmenu").css("display","block");
      }
      }
      else{

        $("#header").css("display","block");
           $("#adminmenu").css("display","none");
           $("#accmenu").css("display","none");
            $("#mmenu").css("display","block");
            $("#navbar-data1 .adminmenu").css("display","none");
            $("#navbar-data1 .mmenu").css("display","block");
            $("#login").css("display","none");
        }
        $scope.rid = window.localStorage.getItem("roleId");

                if ($scope.rid == 3) {
                      $scope.m = window.localStorage.getItem("userId");
                      $scope.mid = "and a.member_id="+window.localStorage.getItem("userId");
                      if ($routeParams.datevalue) {   
                                  $scope.allbet = true;                                  
                                  $scope.datevalue = $routeParams.datevalue;   
                            }
                            else{
                                 $scope.datevalue = "";
                            }

                        if ($routeParams.mbrid) {
                                $scope.mbrid = " and a.member_id="+$routeParams.mbrid; 
                            }
                            else{
                                $scope.mbrid = " and a.member_id="+window.localStorage.getItem("userId");
                            }

                        if ($routeParams.mix) {
                                $scope.mix = $routeParams.mix; 
                                $scope.mixledgertable = true;
                                $scope.showadmin = true;
                            }
                            else{
                                $scope.mix = "no";
                                $scope.mixledgertable = false;
                            }                 
                            console.log($scope.mix);               
                }
                else{                      
                  $scope.mid = "and a.member_id=0";     

                  if ($routeParams.datevalue) {    
                        $scope.allbet = true;                              
                       // $scope.allfilter.filterDate = $routeParams.datevalue; 
                        $scope.datevalue = $routeParams.datevalue;
                  } else{
                        //$scope.allfilter.filterDate = $scope.todayval;
                        $scope.datevalue = $scope.todayval;
                  }                             

                  if ($routeParams.mix) {
                                $scope.mix = $routeParams.mix; 
                                $scope.mixledgertable = true;
                                $scope.showadmin = true;                           
                            }
                            else{
                                $scope.mix = "no";
                                $scope.mixledgertable = false;                                
                            }
                             $scope.mbrid = "";
                }
              mhomecall();
               $scope.refreshfun = function(){
                mhomecall();
              }  

                  $scope.$watchCollection('allfilter', function(newValue, oldValue) {
                    filterallfun();
                  })
   
              $scope.changemixdetail = function(){
                $scope.mixledgertable = true;
                $scope.showadmin = true;
                $scope.mix = "mix";
                $scope.datevalue = "";
                mhomecall();
              }

              $scope.changebgdetail = function(){
                $scope.mixledgertable = false;
                $scope.showadmin = false;
                $scope.mix = "no";
                $scope.datevalue = "";
                mhomecall();
              }              

              function filterallfun(){
                var expression = {};
                var expression2 = {};

                        if($scope.allfilter.filterDate!=undefined)
                        {
                          expression2.bet_date = $scope.allfilter.filterDate || !!$scope.allfilter.filterDate || undefined;                      
                        }

                        if($scope.allfilter.filtermbr!=undefined)
                        {
                          expression2.username = $scope.allfilter.filtermbr || !!$scope.allfilter.filtermbr || undefined;                      
                        }
                      
                         $scope.filtered = $filter('filter')($scope.mledger1,expression2);
                         $scope.mledger = $scope.filtered;

                          var total = 0;
                          var total1 = 0;
                          if ($scope.mledger) {
                            for (var i = $scope.mledger.length - 1; i >= 0; i--) {
                              total += parseInt($scope.mledger[i].amount);

                              if($scope.mledger[i].state_id == 1){
                                total1 += parseInt($scope.mledger[i].amount);
                              } 
                            }   
                            $scope.allTotal = total;
                            $scope.allTotal1 = total1;
                          }
              }   
                
            }
            else{
              $location.path("/");
            }

            function mhomecall(){
                $http.post("query.php",{"type":"mpage","mid":$scope.mid,"btn":"ledger","sub":"","datevalue":$scope.datevalue,"mbrid":$scope.mbrid, "mix":$scope.mix})
                .then(function (response) {
                  console.log(response.data);
                        $scope.alldata = response.data;
                        $scope.total = response.data.m;
                        $scope.mbrname = response.data.mname;
                        $scope.mledger = response.data.ledger; 
                        $scope.mledger1 = response.data.ledger; 
                       // alert("MEmber Total amount is "+$scope.total);
                       var bettotal = 0;
                       var wltotal = 0;
                       var turnovertotal = 0;
                        for (var i = $scope.mledger.length - 1; i >= 0; i--) {
                          bettotal += parseInt($scope.mledger[i].betamount);
                          wltotal += parseInt($scope.mledger[i].wl);
                          turnovertotal += parseInt($scope.mledger[i].turnover);
                        }
                        $scope.bettingtotal = bettotal;
                        $scope.winlosetotal = wltotal;
                        $scope.turntotal = turnovertotal;
                       
                          filterallfun();
                                                  
                });
              }
})*/

.controller("detailledgerController", function($scope, $filter, $http, $routeParams, $location, Excel,$timeout) {
 if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
  $scope.filterDate = $filter('date')(Date.now(), 'MM-dd-yyyy');

      if (window.localStorage.getItem("roleId")!=3) {  
          $location.path("/");
        }
        else{
            $("#header").css("display","block");
            $("#adminmenu").css("display","none");
            $("#accmenu").css("display","none");
            $("#mmenu").css("display","block");
            $("#navbar-data1 .adminmenu").css("display","none");
            $("#navbar-data1 .mmenu").css("display","block");
            $("#login").css("display","none");   

            $scope.$watchCollection('allfilter', function(newValue, oldValue) {
              filterallfun();
            })

            function filterallfun(){
              //var expression = {};
              var expression2 = {};
              
                      if($scope.allfilter.filterDate!=undefined)
                      {
                        expression2.createddate = $scope.allfilter.filterDate || !!$scope.allfilter.filterDate || undefined;                      
                      }

                      if($scope.allfilter.des!=undefined)
                      {
                        expression2.change_description = $scope.allfilter.des || !!$scope.allfilter.des || undefined;                      
                      }           
                    
                       $scope.filtered2 = $filter('filter')($scope.detailledger1,expression2);
                       $scope.detailledger = $scope.filtered2;

                        var total = 0;
                        
                        if ($scope.detailledger) {
                          for (var i = $scope.detailledger.length - 1; i >= 0; i--) {
                           
                              total += parseInt($scope.detailledger[i].change_amount);
                                               
                          }   
                          $scope.allTotal = total;
                          if ($scope.allTotal < 0) {
                            $scope.acolor = "red";
                          }
                          else{
                            $scope.acolor = "green";
                          }
                        }
            }

            $http.post("query.php",{"type":"detailledger","btn":"","mid":window.localStorage.getItem("userId")})
            .then(function (response) {
              console.log(response.data);
              $scope.detailledger = response.data.detailledger;
              $scope.detailledger1 = response.data.detailledger;
               filterallfun();
            })
        }
}
else{
  $location.path("/");
}    
})

.controller("depositeController", function($scope, $filter, $http, $routeParams, $location, Excel,$timeout) {
 if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
  $scope.filterDate = $filter('date')(Date.now(), 'MM-dd-yyyy');
  $scope.bank = [];
  //$scope.statusall = [];
  $scope.statusall=[{state_id:"0",status_name:"-- Status Filter(All) --"},{state_id:"1",status_name:"Confirm"},{state_id:"2",status_name:"Pending"},{state_id:"3",status_name:"Reject"}];

  if (window.localStorage.getItem("roleId")!=3) {
    
    $scope.statusname = true;
    $scope.bkname = true;
    $("#header").css("display","block");
     if (window.localStorage.getItem("roleId")==2) {
        $("#accmenu").css("display","block");
        $scope.adshow = 2;
      }
      else if (window.localStorage.getItem("roleId")==1) {
        $("#adminmenu").css("display","block");
        $("#navbar-data1 .adminmenu").css("display","block");
        $scope.adshow = 1;
      }
    $scope.deporeq = false;
    /*$("#depoadmin").removeClass("col-xs-8");  
    $("#depoadmin").addClass("col-xs-12");*/
  }
  else{
    $("#header").css("display","block");
         $("#adminmenu").css("display","none");
          $("#accmenu").css("display","none");
          $("#mmenu").css("display","block");
          $("#navbar-data1 .adminmenu").css("display","none");
          $("#navbar-data1 .mmenu").css("display","block");
          $("#login").css("display","none");
          $http.post("query.php",{"mid":window.localStorage.getItem("userId"),"type":"onoff","onofftype":"depositonoff","btn":"check"})
            .then(function (response) {
              if (response.data.accepttype == "can") {
                $scope.deporeq = true;
              }
              else{
                $scope.deporeq = false;
              }

            })
          
      }

      
      
      $scope.depositeshow = true;
      $scope.rid = window.localStorage.getItem("roleId");
                    if ($scope.rid == 3) {
                      $scope.m = window.localStorage.getItem("userId");
                      $scope.mid = "and a.member_id="+$scope.m;
                       if ($routeParams.datevalue) {                                  
                                  //$scope.datevalue = $routeParams.datevalue.replace(/-/g,"/");   
                                  $scope.datevalue = $routeParams.datevalue;   
                            } else{
                                  $scope.datevalue = "f";
                            }
                            if ($routeParams.typevalue) {
                                  $scope.typevalue = $routeParams.typevalue;
                                  var res = $scope.typevalue.split(" "); 
                                  if (res[1]=="Pending") {
                                      $scope.typevalue = "and a.state_id=2";
                                  } 
                                  else if(res[1]=="Reject"){
                                      $scope.typevalue = "and a.state_id=3";
                                  }
                                  else{
                                      $scope.typevalue = "and 2=2";
                                  }
                            } else{
                                  $scope.typevalue = "and 2=2";
                            }
                    }
                    else{
                      $scope.mid = "and 1=1";
                            if ($routeParams.datevalue) {                                  
                                  //$scope.datevalue = $routeParams.datevalue.replace(/-/g,"/");   
                                  $scope.datevalue = $routeParams.datevalue;   
                            } else{
                                  $scope.datevalue = "f";
                            }
                            if ($routeParams.typevalue) {
                                  $scope.typevalue = $routeParams.typevalue;
                                  var res = $scope.typevalue.split(" "); 
                                  if (res[1]=="Pending") {
                                      $scope.typevalue = "and a.state_id=2";
                                  } 
                                  else if(res[1]=="Reject"){
                                      $scope.typevalue = "and a.state_id=3";
                                  }
                                  else{
                                      $scope.typevalue = "and 2=2";
                                  }
                            } else{
                                  $scope.typevalue = "and 2=2";
                            }
                    }

                alldatacall();

                $scope.exportToExcel=function(tableId){ // ex: '#my-table'
                    var exportHref=Excel.tableToExcel(tableId,'WireWorkbenchDataExport');
                    $timeout(function(){location.href=exportHref;},100); // trigger download
                }

                $scope.refreshfun = function(){
                  alldatacall();
                }                    

                     if (window.localStorage.getItem("roleId")!=3) {
                        $scope.deporeq = false;
                        $("#depoadmin").removeClass("col-xs-8");  
                        $("#depoadmin").addClass("col-xs-12");
                      }

    $scope.$watchCollection('allfilter', function(newValue, oldValue) {
      filterallfun();
    })

    function filterallfun(){
      var expression = {};
      var expression2 = {};
      console.log($scope.allfilter.filterDate);
      console.log($scope.allfilter.filtermbr);
      //console.log($scope.allfilter.filterBank.bank_history_id);
      console.log($scope.allfilter.statusfilter.state_id);

              if($scope.allfilter.filterDate!=undefined)
              {
                expression2.action_date = $scope.allfilter.filterDate || !!$scope.allfilter.filterDate || undefined;                      
              }

              if($scope.allfilter.filtermbr!=undefined)
              {
                expression2.mname = $scope.allfilter.filtermbr || !!$scope.allfilter.filtermbr || undefined;                      
              }
            
             if($scope.allfilter.filterBank!=undefined)
             {
               if ($scope.allfilter.filterBank.bank_history_id!="0") 
                {
                   expression.bank_history_id =$scope.allfilter.filterBank.bank_history_id || !!$scope.allfilter.filterBank.bank_history_id|| undefined;
                }                     
             }

             if($scope.allfilter.statusfilter!=undefined)
                   {
                     if ($scope.allfilter.statusfilter.state_id!="0") 
                      {
                         expression.state_id =$scope.allfilter.statusfilter.state_id || !!$scope.allfilter.statusfilter.state_id || undefined;         
                      }                     
                   }
             
               $scope.filtered = $filter('filter')($scope.wdtt,expression,true);
               $scope.first = $scope.filtered;
               //console.log($scope.first);
               $scope.filtered2 = $filter('filter')($scope.first,expression2);
               $scope.wdt = $scope.filtered2;
               //console.log($scope.filtered2);

                var total = 0;
                var total1 = 0;
                if ($scope.wdt) {
                  for (var i = $scope.wdt.length - 1; i >= 0; i--) {
                    total += parseInt($scope.wdt[i].amount);

                    if($scope.wdt[i].state_id == 1){
                      total1 += parseInt($scope.wdt[i].amount);
                    } 
                  }   
                  $scope.allTotal = total;
                  $scope.allTotal1 = total1;
                }
    }

                      
                  $scope.allchange = function(a){
                    //alert(a.amount+"/"+a.mbrid+"/"+a.state_id+"/"+a.allid+"/"+a.alltype);

                      $http.post("query.php",{"type":"mpage","btn":"allwdt","mid":$scope.mid,"inner":"alltype","sub":"deposite","amt":a.amount,"mm":a.mbrid,"state":a.state_id,"allid":a.allid,"datevalue":"","typevalue":""})
                      .then(function (response) {
                          $scope.alldata = response.data;
                          $scope.allresult = response.data.allresult;
                          $scope.mbrname = response.data.mname;
                          $scope.s = response.data.sta; 
                          $scope.total = response.data.m;
                          $scope.bank = response.data.bks;
                          $scope.mbank = response.data.mbks;
                          $scope.bank.splice(0,0, {bank_history_id:0,cardnumber:"",bname:"-- Choose Bank --"});
                          $scope.allfilter.filterBank = $scope.bank[0];
                          $scope.bankselect = "";
                          //$scope.filterBank = "";
                          //$scope.statusfilter = "";
                          alert("Changed");
                      }); 
                  }
                  $scope.cardselect = function(a){
                        $http.post("query.php",{"type":"bankselect","bid":a.bank_history_id,"btn":"bankselect","mid":$scope.m})
                        .then(function (response) {
                                $scope.mc = response.data.mbrcard;
                                $scope.uc = response.data.ucard;
                                $scope.card = $scope.uc[0].cardnumber;
                                $scope.bname = $scope.uc[0].bname;
                                $scope.usrname = $scope.total[0].username;
                                if ($scope.mc[0].cardnumber) {
                                      $scope.cdnum = $scope.mc[0].cardnumber;
                                      $scope.nrc = null;
                                } else{
                                      $scope.nrc = "If no Bank Acc, insert Your NRC";
                                      $scope.cdnum = null;
                                };
                                
                    });
                  }
                  $scope.mcardselect = function(a){
                    $http.post("query.php",{"type":"bankselect","bid":a.bank_history_id,"btn":"mbankselect","mid":$scope.m})
                        .then(function (response) {
                                $scope.mc = response.data.mbrcard;
                                //$scope.bname = $scope.mc[0].bname;
                                $scope.usrname = $scope.total[0].username;
                                if ($scope.mc[0].cardnumber) {
                                      $scope.cdnum = $scope.mc[0].cardnumber;
                                      $scope.nrc = null;
                                } else{
                                      $scope.nrc = "If no Bank Acc, insert Your NRC";
                                      $scope.cdnum = null;
                                };
                                
                    });
                  }
                $scope.closedepo = function(){
                    $scope.mprofile=false;    
                        $scope.muself=false;
                        $scope.allreq=false;
                        $scope.depodisable = false;
                  }
                  $scope.depoself = function(a){
                    
                    if (a == "s") {
                        $scope.mprofile=false;    
                        $scope.muself=true;
                        $scope.allreq=true;
                        $scope.cdnum = null;
                        $scope.card = null;
                        $scope.usrname = null;
                        $scope.bname = null;
                        $scope.bankselect = $scope.bank[0];
                    } else if(a == "p"){
                        $scope.muself=false;  
                        $scope.allreq=true; 
                        $scope.mprofile=true;       
                        $scope.usrname = $scope.total[0].username;    
                    } 
                    else if(a == "savedepo"){
                      $scope.depodisable = true;
                      //alert($scope.amt+"/"+$scope.cdnum+"/"+$scope.card+"/"+$scope.usrname+"/"+$scope.bname+"/"+$scope.bankselect+"/"+$scope.bankselect+"/"+$scope.phone+"/"+$scope.city+"/"+$scope.branch);
                      /*alert($scope.bankselect);
                      if ($scope.bankselect == undefined) {
                        alert("undefined");
                      };*/
                      if ($scope.amt == null || $scope.amt == "" || $scope.cdnum == null || $scope.cdnum == "" || $scope.card == null || $scope.card == "" || $scope.usrname == null || $scope.usrname == "" || $scope.bname == null || $scope.bname == "" || $scope.bankselect == null || $scope.bankselect == undefined || $scope.phone == null || $scope.phone == "" || $scope.city == null || $scope.city == "" || $scope.branch == null || $scope.branch == "") {
                        alert("Please Fill All Data");
                      } else{
                        $scope.reqdeposite();
                      }                      
                    }
                    
                  }

                  $scope.reqdeposite = function(){
                    var depoconfirm = confirm("Your Deposite Amount is "+$scope.amt);
                    if (depoconfirm == true) {
                      //$scope.newdata = $scope.mid+"/"+$scope.amt+"/"+$scope.bankselect.bank_history_id+"/"+$scope.cdnum+"/"+$scope.card+"/"+$scope.usrname+"/"+$scope.phone+"/"+$scope.city+"/"+$scope.branch+"/"+$scope.m;
                    //alert($scope.mid+"/"+$scope.amt+"/"+$scope.bankselect.bank_history_id+"/"+$scope.cdnum+"/"+$scope.card+"/"+$scope.usrname+"/"+$scope.phone+"/"+$scope.city+"/"+$scope.branch+"/"+$scope.m);
                        $http.post("query.php",{"type":"mpage", "amt":$scope.amt, "bid":$scope.bankselect.bank_history_id, "mid":$scope.mid, "mbrid":$scope.m,"cardnrc":$scope.cdnum, "usrname":$scope.usrname, "phone":$scope.phone, "city":$scope.city, "branch":$scope.branch, "btn":"allwdt","inner":"reqdeposite","sub":"deposite","datevalue":"","typevalue":""})
                        .then(function (response) {
                          console.log(response.data);
                              $scope.alldata = response.data;
                              $scope.wdt = response.data.wdt;
                              $scope.wdtt = $scope.wdt;
                              $scope.mbrname = response.data.mname;
                              $scope.s = response.data.sta; 
                              $scope.total = response.data.m;
                              $scope.bank = response.data.bks;
                              //$scope.bank.splice(0,0, {bank_history_id:0,cardnumber:"",bname:"-- Choose --"});
                              $scope.bankselect = "";
                              $scope.allfilter.filterBank = $scope.bank[0];
                              //$scope.filterBank = "";
                              //$scope.statusfilter = "";
                              $scope.mbank = response.data.mbks;
                              
                              $scope.cdnum = null;
                              $scope.card = null;
                              $scope.phone = null;
                              $scope.city = null;
                              $scope.branch = null;
                              $scope.usrname = null;
                              $scope.bname = null;
                              $scope.amt = null;
                              $scope.bankselect = undefined;
                              $scope.depodisable = false;
                              alert("Request Sent");
                          });
                    }
                    else{
                      $scope.depodisable = false;
                    }
                  }
            }
            else{
              $location.path("/");
            }    
            function alldatacall(){
                  $http.post("query.php",{"type":"mpage","mid":$scope.mid,"btn":"allwdt","sub":"deposite","inner":"","datevalue":$scope.datevalue,"typevalue":$scope.typevalue})
                        .then(function (response) {
                          
                          $scope.alldata = response.data;
                          $scope.wdt = response.data.wdt;      
                          $scope.wdtt = $scope.wdt;                    
                          $scope.s = response.data.sta;    
                          $scope.total = response.data.m;      
                          $scope.mbrname = response.data.mname;     

                          $scope.bank = response.data.bks;
                          $scope.mbank = response.data.mbks;  
                          if ($scope.bank != "No Record") {
                            $scope.bank.splice(0,0, {bank_history_id:0,cardnumber:"",bname:"-- Choose Bank --"});
                            $scope.bankselect = "";
                            $scope.allfilter.filterBank = $scope.bank[0];
                            //$scope.filterBank = "";
                            //$scope.statusfilter = "";
                          }
                          filterallfun();
                          /*$scope.bank.push({"bank_history_id":0,"bname":"-- Choose --"});    
                          $scope.mbank.push({"bank_history_id":0,"bname":"-- Choose --"}); */

                          /*$scope.alldata = $scope.bank;
                          $scope.bankselect =0;
                           $scope.mbankselect = 0;*/
                           /*$scope.bankselect = $scope.bank[0];
                           $scope.mbankselect = $scope.mbank[0];*/
                    });
                }       
})
.controller("withdrawController", function($scope, $filter, $http, $routeParams, Excel, $timeout) {
  if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
  $scope.filterDate = $filter('date')(Date.now(), 'MM-dd-yyyy');
  $scope.bank = [];
  $scope.statusall=[{state_id:"0",status_name:"-- Status Filter(All) --"},{state_id:"1",status_name:"Confirm"},{state_id:"2",status_name:"Pending"},{state_id:"3",status_name:"Reject"}];
  if (window.localStorage.getItem("roleId")!=3) {    
    $scope.statusname = true;
    $scope.bkname = true;
    $("#header").css("display","block");
   if (window.localStorage.getItem("roleId")==2) {
        $("#accmenu").css("display","block");
        $scope.adshow = 2;
      }
      else if (window.localStorage.getItem("roleId")==1) {
        $("#adminmenu").css("display","block");
        $("#navbar-data1 .adminmenu").css("display","block");
        $scope.adshow = 1;
      }
    $scope.deporeq = false;
  
  }
  else{
    $("#header").css("display","block");
         $("#adminmenu").css("display","none");
         $("#accmenu").css("display","none");
          $("#mmenu").css("display","block");
          $("#navbar-data1 .adminmenu").css("display","none");
          $("#navbar-data1 .mmenu").css("display","block");
          $("#login").css("display","none");
          $http.post("query.php",{"mid":window.localStorage.getItem("userId"),"type":"onoff","onofftype":"withdrawonoff","btn":"check"})
            .then(function (response) {
              if (response.data.accepttype == "can") {
                $scope.deporeq = true;
              }
              else{
                $scope.deporeq = false;
              }

            })
       
      }
      $scope.withdrawshow = true;
      $scope.rid = window.localStorage.getItem("roleId");
                    if ($scope.rid == 3) {
                      $scope.m = window.localStorage.getItem("userId");
                      $scope.mid = "and a.member_id="+$scope.m;
                      if ($routeParams.datevalue) {                                  
                                  //$scope.datevalue = $routeParams.datevalue.replace(/-/g,"/");   
                                  $scope.datevalue = $routeParams.datevalue;   
                            } else{
                                  $scope.datevalue = "f";
                            }
                            if ($routeParams.typevalue) {
                                  $scope.typevalue = $routeParams.typevalue;
                                  var res = $scope.typevalue.split(" "); 
                                  if (res[1]=="Pending") {
                                      $scope.typevalue = "and a.state_id=2";
                                  } 
                                  else if(res[1]=="Reject"){
                                      $scope.typevalue = "and a.state_id=3";
                                  }
                                  else{
                                      $scope.typevalue = "and 2=2";
                                  }
                            } else{
                                  $scope.typevalue = "and 2=2";
                            }
                    }
                    else{
                      $scope.mid = "and 1=1";
                      if ($routeParams.datevalue) {                                  
                                  //$scope.datevalue = $routeParams.datevalue.replace(/-/g,"/");   
                                  $scope.datevalue = $routeParams.datevalue;   
                            } else{
                                  $scope.datevalue = "f";
                            }
                            if ($routeParams.typevalue) {
                                  $scope.typevalue = $routeParams.typevalue;
                                  var res = $scope.typevalue.split(" "); 
                                  if (res[1]=="Pending") {
                                      $scope.typevalue = "and a.state_id=2";
                                  } 
                                  else if(res[1]=="Reject"){
                                      $scope.typevalue = "and a.state_id=3";
                                  }
                                  else{
                                      $scope.typevalue = "and 2=2";
                                  }
                            } else{
                                  $scope.typevalue = "and 2=2";
                            }
                    }

                maindatacall();
                $scope.exportToExcel=function(tableId){ // ex: '#my-table'
                    var exportHref=Excel.tableToExcel(tableId,'Alluser');
                    $timeout(function(){location.href=exportHref;},100); // trigger download
                }

                    $scope.refreshfun = function(){
                      maindatacall();
                    }

                     

                     if (window.localStorage.getItem("roleId")!=3) {
                        $scope.deporeq = false;
                        $("#withadmin").removeClass("col-xs-8");  
                        $("#withadmin").addClass("col-xs-12");
                      }

$scope.$watchCollection('allfilter', function(newValue, oldValue) {
      filterallfun();
    })

    function filterallfun(){
      var expression = {};
      var expression2 = {};
      console.log($scope.allfilter.filterDate);
      console.log($scope.allfilter.filtermbr);
      console.log($scope.allfilter.filterBank.bank_history_id);
      console.log($scope.allfilter.statusfilter.state_id);

              if($scope.allfilter.filterDate!=undefined)
              {
                expression2.action_date = $scope.allfilter.filterDate || !!$scope.allfilter.filterDate || undefined;                      
              }

              if($scope.allfilter.filtermbr!=undefined)
              {
                expression2.mname = $scope.allfilter.filtermbr || !!$scope.allfilter.filtermbr || undefined;                      
              }
            
             if($scope.allfilter.filterBank!=undefined)
             {
               if ($scope.allfilter.filterBank.bname!="-- Choose --") 
                {
                   expression.bank =$scope.allfilter.filterBank.bname || !!$scope.allfilter.filterBank.bname|| undefined;
                }                     
             }

             if($scope.allfilter.statusfilter!=undefined)
                   {
                     if ($scope.allfilter.statusfilter.state_id!="0") 
                      {
                         expression.state_id =$scope.allfilter.statusfilter.state_id || !!$scope.allfilter.statusfilter.state_id || undefined;         
                      }                     
                   }
             
               $scope.filtered = $filter('filter')($scope.wdtt,expression,true);
               $scope.first = $scope.filtered;
               console.log($scope.first);
               $scope.filtered2 = $filter('filter')($scope.first,expression2);
               $scope.wdt = $scope.filtered2;
               console.log($scope.filtered2);

                var total = 0;
                var total1 = 0;
                
                if ($scope.wdt) {
                  for (var i = $scope.wdt.length - 1; i >= 0; i--) {
                   
                      total += parseInt($scope.wdt[i].amount);
                    
                    if($scope.wdt[i].state_id == 1){
                      total1 += parseInt($scope.wdt[i].amount);
                    }                   
                  }   
                  $scope.allTotal = total;
                  $scope.allTotal1 = total1;
                 // console.log($scope.allTotal1);
                }
    }

                      $scope.allchange = function(a){
                    //alert(a.amount+"/"+a.member_id+"/"+a.state_id+"/"+a.allid+"/"+a.alltype);
                      $http.post("query.php",{"type":"mpage","btn":"allwdt","sub":"withdraw","mid":$scope.mid,"inner":"alltype","amt":a.amount,"mm":a.member_id,"state":a.state_id,"allid":a.allid,"datevalue":"","typevalue":""})
                      .then(function (response) {
                          $scope.alldata = response.data;
                          $scope.allresult = response.data.allresult;
                          $scope.mbrname = response.data.mname;
                          $scope.s = response.data.sta; 
                          $scope.total = response.data.m;
                          $scope.bank = response.data.bks;
                          $scope.bank.splice(0,0, {bank_history_id:0,cardnumber:"",bname:"-- Choose --"});
                          $scope.allfilter.filterBank = $scope.bank[0];
                          $scope.mbank = response.data.mbks;
                          alert("Changed");
                      }); 
                  }
                  $scope.cardselect = function(a){
                        $http.post("query.php",{"type":"bankselect","bid":a.bank_history_id,"btn":"bankselect","mid":$scope.m})
                        .then(function (response) {
                                $scope.mc = response.data.mbrcard;
                                $scope.uc = response.data.ucard;
                                $scope.card = $scope.uc[0].cardnumber;
                                $scope.bname = $scope.uc[0].bname;
                                $scope.usrname = $scope.total[0].username;
                                if ($scope.mc[0].cardnumber) {
                                      $scope.cdnum = $scope.mc[0].cardnumber;
                                      $scope.nrc = null;
                                } else{
                                      $scope.nrc = "If no Bank Acc, insert Your NRC";
                                      $scope.cdnum = null;
                                };
                                
                    });
                  }
                  $scope.mcardselect = function(a){
                    $http.post("query.php",{"type":"bankselect","bid":a.bank_history_id,"btn":"mbankselect","mid":$scope.m})
                        .then(function (response) {
                                $scope.mc = response.data.mbrcard;
                                //$scope.bname = $scope.mc[0].bname;
                                $scope.usrname = $scope.total[0].username;
                                if ($scope.mc[0].cardnumber) {
                                      $scope.cdnum = $scope.mc[0].cardnumber;
                                      $scope.nrc = null;
                                } else{
                                      $scope.nrc = "If no Bank Acc, insert Your NRC";
                                      $scope.cdnum = null;
                                };
                                
                    });
                  }
                  $scope.closewith = function(){
                    $scope.mprofile=false;    
                        $scope.muself=false;
                        $scope.allreq=false;
                  }
                  $scope.depoself = function(a){
                    if (a == "s") {
                     //   $scope.usrname = $scope.total[0].username;
                        $scope.mprofile=false;    
                        $scope.muself=true;
                        $scope.allreq=true;
                       
                        $scope.bankselect = undefined;
                        $scope.mbankselect = undefined;
                        $scope.mbankval = undefined;
                        
                    } else if(a == "p"){
                      //alert("profile");
                        $scope.muself=false;   
                        $scope.allreq=true;
                        $scope.mprofile=true;       
                        $scope.usrname = $scope.total[0].username;    
                      
                        $scope.bankselect = undefined;
                        $scope.mbankselect = undefined;
                        $scope.mbankval = undefined;
                        $scope.realbname = undefined;
                    } 
                    else if(a == "savewith"){
                      $scope.depodisable = true;
                       if ($scope.mbankselect != undefined) {
                                    $scope.realbname = $scope.mbankselect.bname;                                   

                              } else if($scope.mbankval != undefined){                       
                                    $scope.realbname = $scope.mbankval.bname;
                              }
                              else{
                                 $scope.realbname = undefined;
                              }
                      if ($scope.amt == null || $scope.amt == "" || $scope.cdnum == null || $scope.cdnum == " " || $scope.cdnum == "" || $scope.usrname == null || $scope.usrname == "" || $scope.realbname == null || $scope.realbname == undefined || $scope.phone == null || $scope.phone == "" || $scope.city == null || $scope.city == "" || $scope.branch == null || $scope.branch == "") {
                        alert("Please Fill All Data");
                      } else{
                        //alert($scope.cdnum);
                        $scope.reqwithdraw();
                      } 
                     // $scope.reqwithdraw();
                    }     
                  }

                      $scope.reqwithdraw = function(){

                        if (parseInt($scope.amt)<parseInt($scope.total[0].amount)==false) {
                            alert("Please Check Your withdraw amount.");
                        } else{
                                var withconfirm = confirm("Your withdraw Amount is "+$scope.amt);
                                if (withconfirm == true) {
                                //  $scope.newdata = $scope.mid+"/"+$scope.amt+"/"+$scope.mbankselect.bname+"/"+$scope.cdnum+"/"+$scope.usrname+"/"+$scope.phone+"/"+$scope.city+"/"+$scope.branch+"/"+$scope.m;
                            //alert($scope.mid+"/"+$scope.amt+"/"+$scope.realbname+"/"+$scope.cdnum+"/"+$scope.card+"/"+$scope.usrname+"/"+$scope.phone+"/"+$scope.city+"/"+$scope.branch+"/"+$scope.m);
                            $http.post("query.php",{"type":"mpage", "amt":$scope.amt, "bid":$scope.realbname, "mid":$scope.mid, "mbrid":$scope.m,"cardnrc":$scope.cdnum, "usrname":$scope.usrname, "phone":$scope.phone, "city":$scope.city, "branch":$scope.branch, "btn":"allwdt","inner":"reqwithdraw","sub":"withdraw","datevalue":"","typevalue":""})
                            .then(function (response) {
                                  $scope.alldata = response.data;
                                  $scope.allresult = response.data.allresult;
                                  $scope.wdt = response.data.wdt;
                                  $scope.wdtt = $scope.wdt; 
                                  $scope.mbrname = response.data.mname;
                                  $scope.s = response.data.sta; 
                                  $scope.total = response.data.m;
                                  $scope.bank = response.data.bks;
                                  $scope.bank.splice(0,0, {bank_history_id:0,cardnumber:"",bname:"-- Choose --"});
                                  $scope.allfilter.filterBank = $scope.bank[0];
                                  $scope.mbank = response.data.mbks;
                                  $scope.cdnum = null;
                                  $scope.amt = null;
                                  $scope.phone = null;
                                  $scope.city = null;
                                  $scope.branch = null;
                                  $scope.card = null;
                                  $scope.usrname = null;
                                  $scope.bname = null;
                                  $scope.bankselect = undefined;
                                  $scope.mbankselect = undefined;
                                  $scope.mbankval = null;
                                  $scope.depodisable = false;
                                  alert("Request Sent");
                                  });
                                }                                         
                                else{
                                  $scope.depodisable = false;
                                }
                        }                    
                          
                  }
                }
                else{
                  $location.path("/");
                }

                function maindatacall(){
                  $http.post("query.php",{"type":"mpage","mid":$scope.mid,"btn":"allwdt","sub":"withdraw","inner":"","datevalue":$scope.datevalue,"typevalue":$scope.typevalue})
                        .then(function (response) {
                          $scope.alldata = response.data;
                          $scope.wdt = response.data.wdt;
                          $scope.wdtt = $scope.wdt; 
                          $scope.mbrname = response.data.mname;
                          $scope.s = response.data.sta;    
                          $scope.total = response.data.m;      
                          $scope.bank = response.data.bks;  
                          $scope.bank.splice(0,0, {bank_history_id:0,cardnumber:"",bname:"-- Choose --"});
                          $scope.allfilter.filterBank = $scope.bank[0];
                          $scope.mbank = response.data.mbks;   
                          console.log(response.data.mbks);   

                          filterallfun();         
                    });
                }
})
.controller("transferController", function($scope, $filter, $http, $location, Excel, $timeout) {
 if (window.localStorage.getItem("roleId")) {
  $scope.transfertext = "";
  $("#wrapper").css("display","block");
  $scope.filterDate = $filter('date')(Date.now(), 'MM-dd-yyyy');
  if (window.localStorage.getItem("roleId")!=3) {
    
    $("#header").css("display","block");
    if (window.localStorage.getItem("roleId")==2) {
        $("#accmenu").css("display","block");
        $scope.adshow = 2;
        $scope.admindeporeq = false;
      }
      else if (window.localStorage.getItem("roleId")==1) {
        $("#adminmenu").css("display","block");
        $("#navbar-data1 .adminmenu").css("display","block");
        $scope.adshow = 1;
        $scope.admindeporeq = true;
      }
    $scope.deporeq = false;
    /*$("#tranadmin").removeClass("col-xs-8");  
    $("#tranadmin").addClass("col-xs-12");*/
  }
  else{
    $("#header").css("display","block");
         $("#adminmenu").css("display","none");
         $("#accmenu").css("display","none");
          $("#mmenu").css("display","block");
          $("#navbar-data1 .adminmenu").css("display","none");
          $("#navbar-data1 .mmenu").css("display","block");
          $("#login").css("display","none");
           $http.post("query.php",{"mid":window.localStorage.getItem("userId"),"type":"onoff","onofftype":"transferonoff","btn":"check"})
            .then(function (response) {
              console.log(response.data);
              //console.log(response.data.accept);

              if (response.data.accepttype == "can") {
                $scope.deporeq = true;
              }
              else{
                $scope.deporeq = false;
              }
            })
          
          $scope.admindeporeq = false;
      }
      $scope.transfershow = true;
      $scope.rid = window.localStorage.getItem("roleId");
                    if ($scope.rid == 3) {
                      $scope.m = window.localStorage.getItem("userId");
                      $scope.mid = "and a.member_id="+$scope.m;
                    }
                    else{
                      $scope.mid = "and 1=1";
                    }

                maindatacall();
                $scope.exportToExcel=function(tableId){ // ex: '#my-table'
                    var exportHref=Excel.tableToExcel(tableId,'Alluser');
                    $timeout(function(){location.href=exportHref;},100); // trigger download
                }

                $scope.refreshfun = function(){
                  maindatacall();
                }

                    

                     if (window.localStorage.getItem("roleId")!=3) {
                        $scope.deporeq = false;
                        $("#tranadmin").removeClass("col-xs-8");  
                        $("#tranadmin").addClass("col-xs-12");
                      }

 $scope.$watchCollection('allfilter', function(newValue, oldValue) {
      filterallfun();
    })

    function filterallfun(){
      var expression = {};

              if($scope.allfilter.filterDate!=undefined)
              {
                expression.action_date = $scope.allfilter.filterDate || !!$scope.allfilter.filterDate || undefined;                      
              }

              if($scope.allfilter.filtertmbr!=undefined)
              {
                expression.touser = $scope.allfilter.filtertmbr || !!$scope.allfilter.filtertmbr || undefined;                      
              }

              if($scope.allfilter.filterfmbr!=undefined)
              {
                expression.fuser = $scope.allfilter.filterfmbr || !!$scope.allfilter.filterfmbr || undefined;                      
              }

              if($scope.allfilter.filterbk!=undefined)
              {
                expression.transfertext = $scope.allfilter.filterbk || !!$scope.allfilter.filterbk || undefined;                      
              }
            
            
             
               $scope.filtered = $filter('filter')($scope.wdtt,expression);
               $scope.wdt = $scope.filtered;

                var total = 0;
                var total1 = 0;
                if ($scope.wdt) {
                  for (var i = $scope.wdt.length - 1; i >= 0; i--) {
                    total += parseInt($scope.wdt[i].amount);
                    if($scope.wdt[i].state_id == 1){
                      total1 += parseInt($scope.wdt[i].amount);
                    } 
                  }   
                  $scope.allTotal = total;
                  $scope.allTotal1 = total1;
                  //console.log($scope.Total);
                }
    }

                      $scope.allchange = function(a){
                    //alert(a.amount+"/"+a.member_id+"/"+a.state_id+"/"+a.allid+"/"+a.alltype);
                      $http.post("query.php",{"type":"mpage","btn":"allwdt","mid":$scope.mid,"inner":"alltype","amt":a.amount,"mm":a.member_id,"state":a.state_id,"allid":a.allid})
                      .then(function (response) {
                          $scope.alldata = response.data;
                          $scope.allresult = response.data.allresult;
                          $scope.mbrname = response.data.mname;
                          $scope.s = response.data.sta; 
                          $scope.total = response.data.m;
                          $scope.bank = response.data.bks;
                          $scope.bank.splice(0,0, {bank_history_id:0,cardnumber:"",bname:"-- Choose --"});
                          $scope.allfilter.filterbk = $scope.bank[0];
                          $scope.mbank = response.data.mbks;
                          $scope.translimit = response.data.tlimit;      
                          filterallfun();
                      }); 
                  }
                                   
              
                  $scope.depoself = function(a){
                    if (a == "s") {
                        $scope.usrname = $scope.total[0].username;
                        $scope.mprofile=false;    
                        $scope.muself=true;
                        $scope.cdnum = null;
                        $scope.card = null;
                        $scope.usrname = null;
                        $scope.bname = null;
                        $scope.bankselect = null;
                    } else if(a == "p"){
                      //alert("profile");
                        $scope.muself=false;   
                        $scope.mprofile=true;       
                        $scope.usrname = $scope.total[0].username;    
                    } 
                    else if(a == "savetran"){
                      $scope.depodisable = true;
                      if ($scope.amt == null || $scope.amt == "" || $scope.transferid == null || $scope.transferid == "") {
                        alert("Please Fill Completely");
                      }
                      else{
                         testfinanceid();
                      }
                     
                    }        
                  }

                  $scope.admindepoself = function(){
                    if ($scope.adminamt == null || $scope.adminamt == "" || $scope.transfertoid == null || $scope.transfertoid == "" || $scope.transferfromid == null || $scope.transferfromid == "") {
                        alert("Please Fill Completely");
                      }
                      else{
                         testadminfinanceid();
                      }
                  }

                  function testadminfinanceid(){
                    $scope.transfertoid = $scope.transfertoid.replace(/[\s]/g, '');
                    $scope.transferfromid = $scope.transferfromid.replace(/[\s]/g, '');
                    $http.post("query.php",{"testtoid":$scope.transfertoid,"testfromid":$scope.transferfromid,"type":"testing","btn":"admintransfer"})
                      .then(function (response) {
                        if (response.data.todata == 1) {
                          alert("Please Check Transfer TO ID");
                        }
                        if (response.data.fromdata == 1) {
                          alert("Please Check Transfer FROM ID");
                        }
                         if (response.data.fromdata != 1 && response.data.todata != 1){
                          console.log("from"+response.data.fromdata.username+"to"+response.data.todata.username);
                          $scope.fusername = response.data.fromdata.username;  
                          $scope.famount = response.data.fromdata.amount;  
                          $scope.tusername = response.data.todata.username;    
                           $scope.fmbrid = response.data.fromdata.member_id;  
                          $scope.tmbrid = response.data.todata.member_id;                         
                          $scope.reqadmintransfer();   
                        };
                      })
              }
    
               $scope.reqadmintransfer = function(){
                        $scope.transfertoid = $scope.transfertoid.replace(/[\s]/g, '');
                        $scope.transferfromid = $scope.transferfromid.replace(/[\s]/g, '');

                      if (parseInt($scope.adminamt)<parseInt($scope.famount)==false) {
                            alert("Please Check FROM ID Amount.");
                        } else{

                                var tranconfirm = confirm("You want to transfer "+$scope.adminamt+"\n from ID "+$scope.transferfromid+"["+$scope.fusername+"]\n to ID "+$scope.transfertoid+"\n["+$scope.tusername+"]");
                                if (tranconfirm == true) {
                                  $http.post("query.php",{"type":"mpage", "fmbrid":$scope.fmbrid, "tmbrid":$scope.tmbrid, "amt":$scope.adminamt, "transfertoid":$scope.transfertoid, "transferfromid":$scope.transferfromid, "mid":$scope.mid, "transfertext":$scope.transfertext, "btn":"allwdt","inner":"reqadtransfer","sub":"transfer"})
                                    .then(function (response) {
                                      console.log($scope.alldata);
                                       $scope.alldata = response.data;
                                        $scope.wdt = response.data.wdt;
                                        $scope.wdtt = $scope.wdt; 
                                        $scope.mbrname = response.data.mname;
                                        $scope.s = response.data.sta;    
                                        $scope.total = response.data.m;      
                                        $scope.bank = response.data.bks;  
                                        
                                        $scope.mbank = response.data.mbks;               
                                        $scope.translimit = response.data.tlimit;  
                                        $scope.adminamt = null;
                                        $scope.transfertoid = null;
                                        $scope.transferfromid = null;
                                        filterallfun();
                                        alert("Success");
                                    });
                                }                                     
                              
                        }
                  }

                   function testfinanceid(){
                    $scope.transferid = $scope.transferid.replace(/[\s]/g, '');
                    $http.post("query.php",{"testfinid":$scope.transferid,"type":"testing","btn":"finuniqueid"})
                      .then(function (response) {
                        if (response.data == 1) {
                          alert("Please Check Transfer ID");
                        } else{
                          $scope.tranusername = response.data.username;                         
                          $scope.reqtransfer();   
                        };
                      })
              }


                      $scope.reqtransfer = function(){
                        $scope.transferid = $scope.transferid.replace(/[\s]/g, '');
                      if (parseInt($scope.amt)<parseInt($scope.total[0].amount)==false) {
                            alert("Please Check Your Amount.");
                        } else{
                              if (parseInt($scope.amt)<=$scope.translimit ==false){
                                    alert("Maximun Transfer Amount is "+$scope.translimit);
                              }
                              else{
                                var tranconfirm = confirm("You want to transfer "+$scope.amt+"\n to ID "+$scope.transferid+"\n["+$scope.tranusername+"]");
                                if (tranconfirm == true) {
                                  $http.post("query.php",{"type":"mpage", "amt":$scope.amt, "transferid":$scope.transferid, "oramt":$scope.total[0].amount, "mid":$scope.mid, "mbrid":$scope.m, "transfertext":$scope.transfertext, "btn":"allwdt","inner":"reqtransfer","sub":"transfer"})
                                    .then(function (response) {
                                      console.log(response.data);
                                        $scope.alldata = response.data;
                                        $scope.allresult = response.data.allresult;
                                        $scope.wdt = response.data.wdt;
                                        $scope.wdtt = $scope.wdt; 
                                        $scope.mbrname = response.data.mname;
                                        $scope.s = response.data.sta; 
                                        $scope.total = response.data.m;
                                        $scope.bank = response.data.bks;
                                        
                                        $scope.mbank = response.data.mbks;

                                        $scope.amt = null;
                                        $scope.transferid = null;
                                        $scope.depodisable = false;
                                        filterallfun();
                                        alert("Success");
                                    });
                                }
                               else{
                                  $scope.depodisable = false;
                                }      
                              }
                        }
                  }
                }
                else{
                  $location.path("/");
                }
                function maindatacall(){
                  $http.post("query.php",{"type":"mpage","mid":$scope.mid,"btn":"allwdt","sub":"transfer","inner":""})
                        .then(function (response) {
                          console.log(response.data);
                          $scope.alldata = response.data;
                          $scope.wdt = response.data.wdt;
                          $scope.wdtt = $scope.wdt; 
                          $scope.mbrname = response.data.mname;
                          $scope.s = response.data.sta;    
                          $scope.total = response.data.m;      
                          $scope.bank = response.data.bks; 
                          
                          $scope.mbank = response.data.mbks;               
                          $scope.translimit = response.data.tlimit;     

                          filterallfun();   
                    });
                }
})
.controller("mledgerController", function($scope, $filter, $http, $location) {

if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
  //$scope.filterDate = $filter('date')(Date.now(), 'MM-dd-yyyy');

  if (window.localStorage.getItem("roleId")!=3) {
 
    $("#header").css("display","block");   
    if (window.localStorage.getItem("roleId")==2) {
        $("#accmenu").css("display","block");
        $scope.adshow=2;
      }
      else if (window.localStorage.getItem("roleId")==1) {
        $scope.adminright = true;
        $("#adminmenu").css("display","block");
        $("#navbar-data1 .adminmenu").css("display","block");
        $scope.adshow=1;
      }
    $scope.deporeq = false;

    $("#depoadmin").removeClass("col-xs-8");  
    $("#depoadmin").addClass("col-xs-12");
  }
  else{
    checkmbr();
    $("#header").css("display","block");
               $("#adminmenu").css("display","none");
                 $("#accmenu").css("display","none");
                $("#mmenu").css("display","block");
                 $("#navbar-data1 .adminmenu").css("display","none");
                $("#navbar-data1 .mmenu").css("display","block");
                $("#login").css("display","none");
                $scope.adminright = false;
                $scope.deporeq = true;
            }

        
                    $scope.mainledger = true;
                    $scope.rid = window.localStorage.getItem("roleId");
                    if ($scope.rid == 3) {
                      $scope.m = window.localStorage.getItem("userId");
                      $scope.mid = "and a.member_id="+$scope.m;
                    }
                    else{
                      $scope.mid = "and 1=1";
                    }

                    $scope.fromD = "";
                    $scope.toD = "";
                    $scope.otherD = "";
                    $scope.datesign = "";      
                    datacall();
                    /*$http.post("query.php",{"type":"mpage","mid":$scope.m,"btn":"ledger"})
                        .then(function (response) {
                            $scope.total = response.data.m;
                            $scope.mledger = response.data.ledger;
                    });*/
                    
                   /* $http.post("query.php",{"type":"mpage","mid":$scope.mid,"btn":"wdt","sub":""})
                        .then(function (response) {
                          $scope.alldata = response.data;
                          $scope.allresult = response.data.allresult;
                          $scope.mbrname = response.data.mname;
                          $scope.s = response.data.sta;    
                          $scope.total = response.data.m;  
                          window.localStorage.setItem("adminright",response.data.m);    
                          $scope.bank = response.data.bks;  
                          $scope.mbank = response.data.mbks;               
                    });*/

                        $scope.refreshfun = function(){
                          datacall();
                        }

                        
                  $scope.depo = function(){
                    $location.path("/deposite");
                      /*$scope.mainledger = false;
                      $scope.depositeshow = true;
                      $scope.withdrawshow = false;
                      $scope.transfershow = false;
                      $scope.muself=false;
                      $scope.mprofile=false;
                     if (window.localStorage.getItem("roleId")!=3) {
                        $scope.deporeq = false;
                        $("#depoadmin").removeClass("col-xs-8");  
                        $("#depoadmin").addClass("col-xs-12");
                      }*/
                  }
                  $scope.wdraw = function(){
                    $location.path("/withdraw");
                      /*$scope.mainledger = false;
                      $scope.depositeshow = false;
                      $scope.withdrawshow = true;
                      $scope.transfershow = false;
                      if (window.localStorage.getItem("roleId")!=3) {
                        $scope.deporeq = false;
                        $("#withadmin").removeClass("col-xs-8");  
                        $("#withadmin").addClass("col-xs-12");
                      }*/
                  }
                  $scope.transf = function(){
                    $location.path("/transfer");
                      /*$scope.mainledger = false;
                      $scope.depositeshow = false;
                      $scope.withdrawshow = false;
                      $scope.transfershow = true;
                      if (window.localStorage.getItem("roleId")!=3) {
                        $scope.deporeq = false;
                        $("#tranadmin").removeClass("col-xs-8");  
                        $("#tranadmin").addClass("col-xs-12");
                      }*/
                  }
                  $scope.allchange = function(a){
                    $scope.tabletype = a.alltype.toLowerCase(); 
                    //alert($scope.tabletype);
                    //alert(a.amount+"/"+a.mbrid+"/"+a.state_id+"/"+a.allid+"/"+a.alltype);
                      $http.post("query.php",{"type":"mpage","btn":"allwdt","mid":$scope.mid,"inner":"alltype","sub":$scope.tabletype,"amt":a.amount,"mm":a.member_id,"state":a.state_id,"allid":a.allid,"datevalue":"","typevalue":""})
                      .then(function (response) {
                        datacall();                      
                      }); 
                  }

                  $scope.typechange = function(){
                      if ($scope.datefiltertype == "btw") {
                        $scope.otherdate = null;
                        $scope.between = true;
                        $scope.othertype = false;      
                        $scope.searchbtn = true;      
                      }
                      else if ($scope.datefiltertype == ">" || $scope.datefiltertype == "<" || $scope.datefiltertype == "=") {
                        $scope.fFilterDate = null;
                        $scope.tFilterDate = null;
                        $scope.between = false;
                        $scope.othertype = true; 
                        $scope.searchbtn = true;
                      }
                      else if ($scope.datefiltertype == "all") {
                        $scope.between = false;
                        $scope.othertype = false; 
                        $scope.searchbtn = true;
                        $scope.fFilterDate = null;
                        $scope.tFilterDate = null;
                        $scope.otherdate = null;
                      }
                      else{
                        $scope.between = false;
                        $scope.othertype = false; 
                        $scope.searchbtn = false;
                        $scope.fFilterDate = null;
                        $scope.tFilterDate = null;
                        $scope.otherdate = null;
                      }
                    }

                    $scope.searchdate = function(){

                        if ($scope.datefiltertype != null || $scope.datefiltertype != undefined) {
                           $scope.datesign = $scope.datefiltertype;

                        if ($scope.datefiltertype == "btw") {

                              if ($scope.tFilterDate == undefined || $scope.tFilterDate == null || $scope.fFilterDate == undefined || $scope.fFilterDate == null) {
                                alert("Please Fill From Date & To Date");
                              }
                              else if (($scope.tFilterDate != undefined || $scope.tFilterDate != null) && ($scope.fFilterDate != undefined || $scope.fFilterDate != null)) {
                                $scope.fromD = $scope.fFilterDate;
                                $scope.toD = $scope.tFilterDate;
                              }
                              else{
                                $scope.fromD = "";
                                $scope.toD = "";
                              }
                        }
                        else if($scope.datefiltertype == ">" || $scope.datefiltertype == "<" || $scope.datefiltertype == "="){
                            if ($scope.otherdate == undefined || $scope.otherdate == null) {
                                alert("Please Fill Date");
                            }
                            else if ($scope.otherdate != undefined && $scope.otherdate != null) {
                                $scope.otherD = $scope.otherdate;
                            }
                            else{
                              $scope.otherD = "";          
                            }
                        }
                        else if ($scope.datefiltertype == "all") {
                          $scope.otherD = "";    
                          $scope.fromD = "";
                          $scope.toD = "";
                        }
                        datacall();
                        }   
                        
                      }
    }
  else{
    $location.path("/");
  }

  function datacall(){
      $http.post("query.php",{"type":"mpage","mid":$scope.mid,"btn":"wdt","sub":"","fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD,"datesign":$scope.datesign})
          .then(function (response) {
            $scope.alldata = response.data;
            console.log(response.data);

            $scope.allresult = response.data.allresult;
           $scope.mbrname = response.data.mname;
            $scope.s = response.data.sta;    
            $scope.total = response.data.m;  
            window.localStorage.setItem("adminright",response.data.m);    
            $scope.bank = response.data.bks;  
            $scope.mbank = response.data.mbks;               
      });
    }

        function checkmbr(){
              $http.post("query.php",{"type":"checkmember","btn":"","mid":window.localStorage.getItem("userId")})
                .then(function (response) {
                
                     if (response.data.alluser == "No Record") {
                      window.localStorage.removeItem("roleId");
                      window.localStorage.removeItem("userId");
                      $("#wrapper").css("display","none");  
                      $("#adminmenu").css("display","none");  
                      $("#mmenu").css("display","none");  
                      $("#navbar-data1 .adminmenu").css("display","none");  
                      $("#navbar-data1 .mmenu").css("display","none"); 
                      $("#login").css("display","block");   
                      $("#header").css("display","none");  
                       $scope.mid = "and 1=1";
                       $scope.onlyhome = false;
                       $scope.onlyhome1 = false;
                       $("#dashsection").removeClass("col-md-12");  
                       $("#dashsection").addClass("col-md-10");
                       $location.path("/");
                     }
                      
                })
            }   
})
.controller("allledgerController", function($scope, $http, $filter, $log, $location) {
   if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
  if (window.localStorage.getItem("roleId")==1 || window.localStorage.getItem("roleId")==2) {
    if (window.localStorage.getItem("roleId")==2) {
      $("#accmenu").css("display","block");
    }
    else if (window.localStorage.getItem("roleId")==1) {
      $("#adminmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","block");
    }
    $("#header").css("display","block");
    

     $scope.mainledger = true;
           $scope.filterDate = $filter('date')(Date.now(), 'MM-dd-yyyy');
                    $http.post("query.php",{"type":"allledger","btn":"all","d":$scope.filterDate})
                        .then(function (response) {
                            //$scope.dashresult = response.data.dashresult;
                            $scope.total = response.data.num;
                            $scope.allresult = response.data.allresult;
                            $scope.alldata = response.data;
                            $scope.annual = response.data.annual;
                            $scope.annual2 = response.data.annual2;
                            $scope.namt = response.data.namt;
                            console.log($scope.namt);
                                                  /* $scope.filterDate = $scope.aa[0].dates.replace(/\//g,"-");
                                                    for (var i = $scope.aa.length - 1; i >= 0; i--) {
                                                      $scope.aa[i].dates = $scope.aa[i].dates.replace(/\//g,"-");         
                                                     //alert($scope.allresult[i].dates);
                                                    }
                                                    $scope.allresult = $scope.aa;*/
                            var total = 0;
                            for (var i = $scope.annual2.length - 1; i >= 0; i--) {
                              total += parseInt($scope.annual2[i].amount);
                            }
                            $scope.Total = total;
                    });

            $scope.$watch('filterDate', function(newValue, oldValue) {
              $http.post("query.php",{"type":"allledger","btn":"all","d":$scope.filterDate})
                        .then(function (response) {
                            //$scope.dashresult = response.data.dashresult;
                            $scope.total = response.data.num;
                            $scope.allresult = response.data.allresult;
                            $scope.alldata = response.data;
                            $scope.annual = response.data.annual;
                            $scope.annual2 = response.data.annual2;
                            $scope.namt = response.data.namt;
                                               /* $scope.filterDate = $scope.aa[0].dates.replace(/\//g,"-");
                                                for (var i = $scope.aa.length - 1; i >= 0; i--) {
                                                  $scope.aa[i].dates = $scope.aa[i].dates.replace(/\//g,"-");         
                                                 //alert($scope.allresult[i].dates);
                                                }
                                                $scope.allresult = $scope.aa;
                                                //alert(typeof($scope.allresult[0].dates));*/
                            var total = 0;
                            for (var i = $scope.annual2.length - 1; i >= 0; i--) {
                              total += parseInt($scope.annual2[i].amount);
                            }
                            $scope.Total = total;

                             /*if ($scope.allresult != "No Record") {
                              //alert($scope.allresult);
                               var x = $filter('filter')($scope.allresult, $scope.filterDate);
                               var total = 0;
                                  for (var i = x.length - 1; i >= 0; i--) {
                                    total += parseInt(x[i].amount);
                                    console.log(total);
                                  }
                                 $scope.allTotal = total;
                            }*/
                          
                    });

                   
            });
  }
  else{
               $("#header").css("display","block");
               $("#adminmenu").css("display","none");
                $("#mmenu").css("display","block");
                $("#navbar-data1 .adminmenu").css("display","none");
                $("#navbar-data1 .mmenu").css("display","block");
                $("#login").css("display","none");
                $location.path("/");
            }          
 }
 else{
  $location.path("/");
 }
})
    .filter('getTotal', function() {
        return function(data, key) {
            if (typeof(data) === 'undefined' || typeof(key) === 'undefined') {
                return 0;
            }

            var sum = 0;
            for (var i = data.length - 1; i >= 0; i--) {
                sum += parseInt(data[i][key]);
            }

            return sum;
          };
        })
.controller("timeController", function($scope,$http, $location, $filter) {
 if (window.localStorage.getItem("roleId")) { 
  $("#wrapper").css("display","block");
    if (window.localStorage.getItem("roleId")==1 || window.localStorage.getItem("roleId")==2) {
      $scope.tdate = $filter('date')(Date.now(), 'MM-dd-yyyy');
      $scope.ttime="12:00 am";
      $("#header").css("display","block");
    
    if (window.localStorage.getItem("roleId")==2) {
      $("#accmenu").css("display","block");
    }
    else if (window.localStorage.getItem("roleId")==1) {
      $("#adminmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","block");
    }
     
            $scope.showtt=true;
            $http.post("query.php",{"type":"time", "btn":""})
                    .then(function (response) {
                      $scope.alldata = response.data;
                        $scope.timetables = response.data.timetables;
                         $scope.leagues = response.data.leagues;   
                         $scope.homes = response.data.teams1;
                         $scope.aways = response.data.teams2;  
                         //$scope.selectedleague=$scope.leagues[0];
                         //$scope.selectedhome=$scope.homes[0];
                         //$scope.selectedaway=$scope.aways[0];
                      });  

          $scope.canceltime = function(){
            $scope.selectedleague="";
            $scope.selectedaway="";
            $scope.selectedhome="";
            $scope.tdate = $filter('date')(Date.now(), 'MM-dd-yyyy');
            $scope.ttime="12:00 am";
            $scope.showtt=true;
          }

          $scope.edittt=function(att,aid){
            $scope.showtt=false;
            timetableid=aid; 
            $scope.selectedleague=att;
            $scope.selectedaway=att;
            $scope.selectedhome=att;
            $scope.tdate=att.tdate;
            $scope.ttime=att.ttime;
          }                
           $scope.savett= function(){
            //console.log($scope.selectedleague.league_id);
            if ($scope.selectedleague == undefined || $scope.selectedhome == undefined || $scope.selectedaway == undefined || $scope.tdate == "" || $scope.ttime == "" || $scope.tdate == null || $scope.ttime == null || $scope.selectedleague.league_id == null || $scope.selectedhome.home == null || $scope.selectedaway.away == null) {
              alert("Please Fill Completely");
            } else{
              $http.post("query.php",{"tdate":$scope.tdate,"ttime":$scope.ttime,"league":$scope.selectedleague.league_id,"home":$scope.selectedhome.home,"away":$scope.selectedaway.away,"type":"time", "btn":"save"})
                     .then(function (response) {
                          $scope.timetables = response.data.timetables;
                         $scope.leagues = response.data.leagues;   
                         $scope.homes = response.data.teams1;
                         $scope.aways = response.data.teams2;  
                         //$scope.selectedleague=$scope.leagues[0];
                         //$scope.selectedhome=$scope.homes[0];
                         //$scope.selectedaway=$scope.aways[0];
                          alert("Successful Added");
                     });
                     $scope.canceltime();
            }                
            }

           $scope.deltt = function(a){
                var deleted = confirm("Are you sure to delete?");
                if ( deleted == true) {
                             $http.post("query.php",{"tid":a.timetableid, "type":"time", "btn":"delete"})
                            .then(function (response) {
                              $scope.alldata = response.data;
                            $scope.timetables = response.data.timetables;
                            $scope.leagues = response.data.leagues;   
                            $scope.homes = response.data.teams1;
                            $scope.aways = response.data.teams2;  
                            $scope.delstatus = response.data.delstatus;
                            
                            if (response.data.delstatus == 0) {
                                alert("Can't Delete This Timetable.")
                            } else{
                                alert("Successful Deleted");
                            }
                             
                            });
                            $scope.canceltime();
                    }
           }

           $scope.ett = function(){
                    $http.post("query.php",{"tdate":$scope.tdate,"ttime":$scope.ttime,"league":$scope.selectedleague.league_id,"home":$scope.selectedhome.home,"away":$scope.selectedaway.away,"tid":timetableid, "type":"time", "btn":"edit"})
                    .then(function (response) {
                         $scope.timetables = response.data.timetables;
                         $scope.leagues = response.data.leagues;   
                         $scope.homes = response.data.teams1;
                         $scope.aways = response.data.teams2;  
                         
                          alert("Successful Edited");
                    });
                    $scope.canceltime();
           }
      }
      else{
        $location.path("/");
      }
    }
    else{
      $location.path("/");
    }
})
.controller("accdashController", function($scope, $rootScope, $http, $location, $log, $route,$interval, Excel,$timeout){
  $scope.mixresult = 0;
  $scope.mixturnover = 0;
  $scope.mixstid = 0;
  $scope.mixbetarr = [];
  $scope.newarr = [];
  $scope.realarr = [];
  $scope.forname = [];
  //console.log($scope.mixbetarr.length);

   if (window.localStorage.getItem("roleId")) {
    
       if (window.localStorage.getItem("roleId")==1 || window.localStorage.getItem("roleId")==2) {

        if (window.localStorage.getItem("roleId")==2) {
          $scope.adshow=2;
          $("#accmenu").css("display","block");
        }
        else if (window.localStorage.getItem("roleId")==1) {
          $scope.adshow=1;
          $("#adminmenu").css("display","block");
          $("#navbar-data1 .adminmenu").css("display","block");
        }
      /*  

        if (window.localStorage.getItem("roleId")==1) {
              $scope.adminshow=true; 
        }
        else if(window.localStorage.getItem("roleId")==2){
             $scope.adminshow=false;
        }*/

        $("#wrapper").css("display","block");
        $scope.fromD = "";
        $scope.toD = "";
        $scope.otherD = "";
        $scope.datesign = "";      
         getdata();         
}
else{
  $location.path("/");
}
}
else{
$location.path("/");
}     
 /*  $interval(function(){                  
    getdata();
    },1000);  */

                $scope.exportToExcel=function(tableId){ // ex: '#my-table'
                    var exportHref=Excel.tableToExcel(tableId,'WireWorkbenchDataExport');
                    $timeout(function(){location.href=exportHref;},100); // trigger download
                }

                $scope.calculatecom = function(a){
                  var com = confirm("Are you sure to calculate Commission?");
                  if (com == true) {
                    $http.post("query.php",{"type":"comformula","btn":""})
                        .then(function (response) {
                          console.log(response.data);
                          $scope.forname = response.data.forname;
                          
                        })
                  }
                }

                $scope.changeGoalformula = function(a,b){
                  var ch = confirm("Are you sure to change goal formula to normal state ?\nMatch => "+b.Home+" & "+b.Away);
                  if (ch == true) {
                    $http.post("query.php",{"type":"chformula","btn":"goal", "dashid":a, "userid":window.localStorage.getItem("userId")})
                        .then(function (response) {
                          console.log(response.data);
                          alert(response.data);
                          getdata();
                        })
                  }
                }

                /*$scope.allbetlist = function(){
                  window.localStorage.removeItem("pagetype");
                  window.localStorage.setItem("pagetype",  "all");
                  $location.path("/userlist");
                }*/

                $scope.changeBodyformula = function(a,b){
                  var ch = confirm("Are you sure to change body formula to normal state ?\nMatch => "+b.Home+" & "+b.Away);
                  if (ch == true) {                    
                    $http.post("query.php",{"type":"chformula","btn":"body", "dashid":a, "userid":window.localStorage.getItem("userId")})
                        .then(function (response) {
                          console.log(response.data);
                          alert(response.data);
                          getdata();
                        })
                  }
                }

      function getdata(){
        $http.post("query.php",{"type":"accdash","btn":"","fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign, "userid":window.localStorage.getItem("userId")})
         //$http.post("query.php",{"type":"accdash","btn":""})
                        .then(function (response) {
                          console.log(response.data);
                            $scope.alldata=response.data;
                            $scope.dashes = response.data.dashboard;
                            $scope.forname = response.data.forname;
                            $scope.league = response.data.leag;                            
                            $scope.bodies = response.data.bodies;
                            $scope.goals = response.data.goalplus;
                            $scope.bios = response.data.bio;
                            $scope.ios = response.data.io;
                            $scope.gss = response.data.gs;
                            $scope.bss = response.data.bs;
                            $scope.gios = response.data.gio;
                            $scope.agoals = response.data.ag;
                            $scope.abody = response.data.ab;                        
                            $scope.abody.splice(0,0, { accbody_id: "0", description: "Choose", formula: "", recordstatus: "", createddate: "", modifieddate: "" });     
                            $scope.agoals.splice(0,0, { accgoal_id: "0", description: "Choose", formula: "", recordstatus: "", createddate: "", modifieddate: "" });  
                            $scope.bodyval=$scope.bodies[0];
                            $scope.goalval=$scope.goals[0];
                            $scope.bioval=$scope.bios[1];
                            $scope.ioval=$scope.ios[2];
                            $scope.bsval=$scope.bss[1];
                            $scope.gsval=$scope.gss[1];
                            $scope.gioval=$scope.gios[1];
                            $scope.accgoalval=$scope.agoals[0];
                            $scope.accbodyval=$scope.abody[0];                        
                        });
      }

      $scope.refreshadminfun = function(){
        getdata();
      }

      $scope.pinall = function(){
        var pinarr = [];
        var c = confirm("Are you sure to PIN selected matches !");
        if (c == true) {
            var ar = $scope.dashes.filter(
            function (value) {
              if (value.checked == 1) {
                return true;
              } else {
                return false;
              }
            }
            );
          /* for (var i =ar.length - 1; i >= 0; i--) {            
            pinarr[i].dashboard_id= ar[i].dashboard_id;                        
           }*/

           $http.post("query.php",{"type":"checkmixmatch","btn":"pinall", "arraydata":ar, "userid":window.localStorage.getItem("userId")})            
            .then(function(response){ 
              console.log(response.data);
            })
        }
      }

      $scope.ioallchange = function(a){
                var c = confirm("Change all selected rows !");
                if (c == true) {                

                       if (a == 'io') {
                          var ar = $scope.dashes.filter(
                            function (value) {
                              if (value.checked == 1) {
                                return true;
                              } else {
                                return false;
                              }
                            }
                            );
                         for (var i =ar.length - 1; i >= 0; i--) {            
                          ar[i].io_id=$scope.iochangeall;                        
                         }

                          $http.post("query.php",{"type":"accdash","fromdate":"","todate":"","otherdate":"", "datesign":"","btn":"ioallchange", "arraydata":ar, "userid":window.localStorage.getItem("userId")})            
                          .then(function(response){ 

                            $scope.iochangealldata = response.data;
                            $scope.dashes = response.data.dashboard;
                            $scope.bodies = response.data.bodies;
                            $scope.goals = response.data.goalplus;
                            $scope.bios = response.data.bio;
                            $scope.ios = response.data.io;
                            $scope.gss = response.data.gs;
                            $scope.bss = response.data.bs;
                            $scope.gios = response.data.gio;
                            $scope.iochangeall = "";
                  
                            if ($scope.fromD !="" || $scope.toD != "" || $scope.otherD != "") {
                              $scope.searchdate();
                            };
                             alert("Success");                             
                          });
                       }
                       else if (a == "mix") {
                        var ar = $scope.dashes.filter(
                            function (value) {
                              if (value.checked == 1) {
                                return true;
                              } else {
                                return false;
                              }
                            }
                            );
                         for (var i =ar.length - 1; i >= 0; i--) {            
                          ar[i].mix_on_off=$scope.mixallchange;                        
                         }
                        console.log(ar);
                        $http.post("query.php",{"type":"accdash","fromdate":"","todate":"","otherdate":"", "datesign":"","btn":"mixchange", "arraydata":ar, "userid":window.localStorage.getItem("userId")})            
                          .then(function(response){      
                          console.log(response.data);    
                            $scope.iochangealldata = response.data;
                            $scope.dashes = response.data.dashboard;
                            $scope.bodies = response.data.bodies;
                            $scope.goals = response.data.goalplus;
                            $scope.bios = response.data.bio;
                            $scope.ios = response.data.io;
                            $scope.gss = response.data.gs;
                            $scope.bss = response.data.bs;
                            $scope.gios = response.data.gio;
                            $scope.mixallchange = "";
                            if ($scope.fromD !="" || $scope.toD != "" || $scope.otherD != "") {
                              $scope.searchdate();
                            };
                             alert("Success");                             
                          });
                       }   
                       else if(a == "com"){
                        var ar = $scope.dashes.filter(
                            function (value) {
                              if (value.checked == 1) {
                                return true;
                              } else {
                                return false;
                              }
                            }
                            );
                         for (var i =ar.length - 1; i >= 0; i--) {            
                          ar[i].com_on_off=$scope.comallchange;                        
                         }
                        console.log(ar);
                        $http.post("query.php",{"type":"accdash","fromdate":"","todate":"","otherdate":"", "datesign":"","btn":"comchange", "arraydata":ar, "userid":window.localStorage.getItem("userId")})            
                          .then(function(response){      
                          console.log(response.data);    
                            $scope.iochangealldata = response.data;
                            $scope.dashes = response.data.dashboard;
                            $scope.bodies = response.data.bodies;
                            $scope.goals = response.data.goalplus;
                            $scope.bios = response.data.bio;
                            $scope.ios = response.data.io;
                            $scope.gss = response.data.gs;
                            $scope.bss = response.data.bs;
                            $scope.gios = response.data.gio;
                            $scope.mixallchange = "";
                            if ($scope.fromD !="" || $scope.toD != "" || $scope.otherD != "") {
                              $scope.searchdate();
                            };
                             alert("Success");                             
                          });
                       }                   
                  }
                  else{
                    $scope.iochangeall = "";                  
                  }                
              }

      $scope.formulaedit = function(a,b,c){
        if (b == "b") {
          var forbconfirm = confirm("Are You Sure To Edit Body?\n"+c.Home+" & "+c.Away+" ?");
          if (forbconfirm == true) {
              $http.post("query.php",{"type":"editformula","btn":"body","dashid":a})
              .then(function (response) {
                alert(response.data);
              })
          }
        }
        else if (b == "g") {
          var forgconfirm = confirm("Are You Sure To Edit Goal?\n"+c.Home+" & "+c.Away+" ?");
          if (forgconfirm == true) {
              $http.post("query.php",{"type":"editformula","btn":"goal","dashid":a})
              .then(function (response) {
                alert(response.data);
              })
          }
        }
        
      }

      $scope.searchdate = function(){
        if ($scope.datefiltertype != null || $scope.datefiltertype != undefined) {
           $scope.datesign = $scope.datefiltertype;

        if ($scope.datefiltertype == "btw") {

              if ($scope.tFilterDate == undefined || $scope.tFilterDate == null || $scope.fFilterDate == undefined || $scope.fFilterDate == null) {
                alert("Please Fill From Date & To Date");
              }
              else if (($scope.tFilterDate != undefined || $scope.tFilterDate != null) && ($scope.fFilterDate != undefined || $scope.fFilterDate != null)) {
                $scope.fromD = $scope.fFilterDate;
                $scope.toD = $scope.tFilterDate;
              }
              else{
                $scope.fromD = "";
                $scope.toD = "";
              }
        }
        else if($scope.datefiltertype == ">" || $scope.datefiltertype == "<" || $scope.datefiltertype == "="){
            if ($scope.otherdate == undefined || $scope.otherdate == null) {
                alert("Please Fill Date");
            }
            else if ($scope.otherdate != undefined && $scope.otherdate != null) {
                $scope.otherD = $scope.otherdate;
            }
            else{
              $scope.otherD = "";          
            }
        }
        else if ($scope.datefiltertype == "all") {
          $scope.otherD = "";    
          $scope.fromD = "";
          $scope.toD = "";
        }
       
        $http.post("query.php",{"type":"accdash","btn":"","fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign, "userid":window.localStorage.getItem("userId")})
                        .then(function (response) {
                            $scope.alldata=response.data;
                            $scope.dashes = response.data.dashboard;
                            $scope.bodies = response.data.bodies;
                            $scope.goals = response.data.goalplus;
                            $scope.bios = response.data.bio;
                            $scope.ios = response.data.io;
                            $scope.gss = response.data.gs;
                            $scope.bss = response.data.bs;
                            $scope.gios = response.data.gio;
                            $scope.agoals = response.data.ag;
                            $scope.abody = response.data.ab;                   
                            $scope.abody.splice(0,0, { accbody_id: "0", description: "Choose", formula: "", recordstatus: "", createddate: "", modifieddate: "" });   
                            $scope.agoals.splice(0,0, { accgoal_id: "0", description: "Choose", formula: "", recordstatus: "", createddate: "", modifieddate: "" });  
                            /*$scope.bodyval=$scope.bodies[0];
                            $scope.goalval=$scope.goals[0];
                            $scope.bioval=$scope.bios[0];
                            $scope.ioval=$scope.ios[0];
                            $scope.bsval=$scope.bss[0];
                            $scope.gsval=$scope.gss[0];
                            $scope.gioval=$scope.gios[0];*/
                            $scope.accgoalval=$scope.agoals[0];
                            $scope.accbodyval=$scope.abody[0];                        
                        });
        }   

      }

      $scope.typechange = function(){
        if ($scope.datefiltertype == "btw") {
          $scope.otherdate = null;
          $scope.between = true;
          $scope.othertype = false;      
          $scope.searchbtn = true;      
        }
        else if ($scope.datefiltertype == ">" || $scope.datefiltertype == "<" || $scope.datefiltertype == "=") {
          $scope.fFilterDate = null;
          $scope.tFilterDate = null;
          $scope.between = false;
          $scope.othertype = true; 
          $scope.searchbtn = true;
        }
        else if ($scope.datefiltertype == "all") {
          $scope.between = false;
          $scope.othertype = false; 
          $scope.searchbtn = true;
          $scope.fFilterDate = null;
          $scope.tFilterDate = null;
          $scope.otherdate = null;
        }
        else{
          $scope.between = false;
          $scope.othertype = false; 
          $scope.searchbtn = false;
          $scope.fFilterDate = null;
          $scope.tFilterDate = null;
          $scope.otherdate = null;
        }
      }
      $scope.selectBet= function(a,b){
        console.log(a);
        console.log(b);
        $(".form-control").css("border","1px solid #ccc");
        $(".form-control").css("background","#fff");
        $(".all-btn").css("border","0px");
        $(".all-btn").css("background","#3e5315");

        $("#"+b).css("border","1px solid 3e5315");
        $("#"+b).css("background","#c5e1a5");

       $("#dashedit").css("display","block");
       $("#black-overlay").css("display","block");
       $scope.dashid = a.dashboard_id;
       $scope.tid = a.timetableid;
        $scope.tdateval = a.tdate;
        $scope.ttimeval = a.ttime;
        $scope.awayval = a.Away;
        $scope.homeval = a.Home;
        $scope.leagueval = a.leaguename;
        $scope.bodytxt = parseInt(a.body_value);
        $scope.goaltxt = parseInt(a.goalplus_value);
        $scope.scoreval = a.score;
        $scope.bodyval=a;
        $scope.goalval=a;
        $scope.hperval = parseFloat(a.hper);
        $scope.aperval = parseFloat(a.aper);
        $scope.uperval = parseFloat(a.uper);
        $scope.dperval = parseFloat(a.dper);
        $scope.ioval=a;
        $scope.iobackupval=$scope.ioval.io_id;
        $scope.gioval=a;
        $scope.bioval=a;
        $scope.gsval=a;
        $scope.bsval=a;
        $scope.accbodyval=a;
        $scope.accgoalval=a;
        $scope.lbamt=a.lbamount;
        $scope.lgamt=a.lgamount;
        $scope.blimitamt=a.blimitamt;
        $scope.glimitamt=a.glimitamt;
        $scope.bless = a.bless;
        $scope.gless = a.gless;
      }

      /*$scope.checkio =function(){
        if ($scope.ioval.io_id == 3) {
       //   alert($scope.accgoalval.accgoal_id+"/"+$scope.gsval.gs);
          if (($scope.bsval.bs == 1 && $scope.accbodyval.accbody_id ==0)||($scope.accgoalval.accgoal_id ==0 && $scope.gsval.gs == 1)) {
            alert("This can't be Hide");
            $scope.ioval.io_id = $scope.iobackupval;
            alert("backup"+$scope.ioval.io_id);
          }
         }     
      }*/
      
      $scope.usrlist = function(a,b){
      window.localStorage.removeItem("timetableid");
      window.localStorage.setItem("timetableid",  a);
      
      if (b == "league") {
            window.localStorage.removeItem("pagetype");
            window.localStorage.setItem("pagetype",  "league");
            $location.path("/userlist");   
      } else if(b == "team"){
            window.localStorage.removeItem("pagetype");
            window.localStorage.setItem("pagetype",  "team");
            $location.path("/userlist");    
      }
           
      }

    $scope.formulachange = function(a,b){
      
      var con = confirm("Are you sure to change formula ?\n"+b+"?");
      if (con == true) {
        if ($scope.accgoalval.accgoal_id != 0 || $scope.accbodyval.accbody_id != 0) {
        //  alert($scope.accbodyval.accbody_id);
        
          window.localStorage.removeItem("timetableid");
          window.localStorage.setItem("timetableid",  $scope.tid);
        //alert("Start if"+$scope.accgoalval.accgoal_id+"/"+$scope.accbodyval.accbody_id);
            $http.post("query.php", {"type":"checkformula", "dashid":$scope.dashid, "bid":$scope.accbodyval.accbody_id, "gid":$scope.accgoalval.accgoal_id})
            .then(function(response){
              console.log(response.data);
              $scope.newall = response.data;
              $scope.arr = response.data.arr;
              $scope.bformula = response.data.abody;
              $scope.gformula = response.data.agoal;
              $scope.forname = response.data.forname;
              $scope.mixbody = response.data.mixbody;
              $scope.mixgoal = response.data.mixgoal;
              $scope.mixarr = response.data.mixarr;

            //  console.log("http data = "+$scope.arr);
         //     alert($scope.arr);
              if ($scope.arr != "No Record") {
                    for (var i =$scope.arr.length - 1; i >= 0; i--) {   
                  if ($scope.arr[i].bet == "Body") {
               //     alert($scope.arr[i].bet);
               //console.log("Bet on = "+$scope.arr[i].bet);
                      $scope.arr[i].accbgid = $scope.accbodyval.accbody_id;
                  //    alert("For"+$scope.arr[i].accbgid+"/"+$scope.accbodyval.accbody_id);
                      if ($scope.bformula != "No Record") {
                //        alert("bformula = "+$scope.bformula);
                //console.log("bformula = "+$scope.bformula);
                        cboselectchangefor($scope.arr[i],$scope.bformula,$scope.forname);
                      }
                      
                  }
                  else if($scope.arr[i].bet == "Goal+"){
                      $scope.arr[i].accbgid = $scope.accgoalval.accgoal_id;
                   //   alert("For"+$scope.arr[i].accbgid+"/"+$scope.accgoalval.accgoal_id);
                      if ($scope.gformula != "No Record") {
                      //  alert("gformula = "+$scope.gformula);
                        cboselectchangefor($scope.arr[i],$scope.gformula,$scope.forname);
                      }                  
                  }       
                    
                }
              }
//console.log($scope.mixarr);
              if ($scope.mixarr != "No Record") {
                console.log($scope.mixarr);
                mixbgformula($scope.mixarr,$scope.mixbody,$scope.mixgoal,$scope.forname);
              }
              else{
                console.log($scope.mixarr);
              }
            
            })
          
         }
      }
      else{
        if (a == 0) {    
          //$scope.accbodyval.accbody_id = 0;
          $scope.accbodyval=$scope.abody[0];  
          
        }
        else if (a == 1) {    
          $scope.accgoalval = $scope.agoals[0];
        }
      }
      
    }

$scope.savedash = function(){
console.log($scope.newarr.length);
     if ($scope.accgoalval.accgoal_id != 0 || $scope.accbodyval.accbody_id != 0) {
      if ($scope.mixbetarr.length == 0) {
        $scope.mixbetarr = "No Record";
      }
      if ($scope.newarr.length == 0) {
        $scope.newarr = "No Record";
      }
      
     $http.post("query.php", {"type":"addmledger", "arraydata":$scope.newarr, "mixarrdata":$scope.mixbetarr})
        .then(function(response){
          console.log(response.data);
          $scope.alldataall = response.data;
          $scope.realarr = $scope.newarr;
        }) 
    //newhttpd($scope.newarr);   
     }
     
      $("#dashedit").css("display","none");
      $("#black-overlay").css("display","none");

    if ($scope.ioval.io_id==2) { 
      $scope.bioval.bio_id = 4;
      $scope.gioval.gio_id = 4;
    }
              $http.post("query.php",{"type":"accdash","fromdate":"","todate":"","otherdate":"", "datesign":"", "bless":$scope.bless, "gless":$scope.gless, "blimitamt":$scope.blimitamt, 
                "glimitamt":$scope.glimitamt, "tid":$scope.tid,"bodysl":$scope.bodyval.body_id,"bodytxt":$scope.bodytxt, "hper":$scope.hperval,
                "aper":$scope.aperval,"goal":$scope.goalval.goalplus_id,"goaltxt":$scope.goaltxt, "uper":$scope.uperval, "dper":$scope.dperval, 
                "io":$scope.ioval.io_id, "bio":$scope.bioval.bio_id, "gio":$scope.gioval.gio_id, "lb":$scope.lbamt, "lg":$scope.lgamt, 
                "agoal":$scope.accgoalval.accgoal_id, "abody":$scope.accbodyval.accbody_id, "bss":$scope.bsval.bs, "gss":$scope.gsval.gs,
                "score":$scope.scoreval,"btn":"save" , "userid":window.localStorage.getItem("userId")})
            
                      .then(function(response){

                        $scope.newdata = response.data;
                        $scope.dashes = response.data.dashboard;
                        $scope.bodies = response.data.bodies;
                        $scope.goals = response.data.goalplus;
                        $scope.bios = response.data.bio;
                        $scope.ios = response.data.io;
                        $scope.gss = response.data.gs;
                        $scope.bss = response.data.bs;
                        $scope.gios = response.data.gio;
                        $scope.agoals = response.data.ag;
                        $scope.abody = response.data.ab;
                        
                        $scope.abody.splice(0,0, { accbody_id: "0", description: "Choose", formula: "", recordstatus: "", createddate: "", modifieddate: "" });  
                        $scope.agoals.splice(0,0, { accgoal_id: "0", description: "Choose", formula: "", recordstatus: "", createddate: "", modifieddate: "" });  

                        /*$scope.bodyval=$scope.bodies[0];
                        $scope.goalval=$scope.goals[0];
                        $scope.bioval=$scope.bios[0];
                        $scope.ioval=$scope.ios[0];
                        $scope.bsval=$scope.bss[0];
                        $scope.gsval=$scope.gss[0];
                        $scope.gioval=$scope.gios[0];*/
                        $scope.accgoalval=$scope.agoals[0];
                        $scope.accbodyval=$scope.abody[0];

                         alert("Success");
                         
                      });
                        $scope.hperval = null;
                        $scope.aperval = null;
                        $scope.uperval = null;
                        $scope.dperval = null;
    }

    function mixbgformula(dd,bb,gg,fn){
      
      if (bb != "No Record") {
        var bddyformula =String(bb[0].formula);
      }
      if (gg != "No Record") {
        var gppformula =String(gg[0].formula);
      }
   
        for (var j =dd.length - 1; j >= 0; j--) {   
          if (dd[j].bet_on == "Over" || dd[j].bet_on == "Down") {
                  if (gppformula) {
                    gpformula = gppformula;
                    gpformula = gpformula.replace(/Beton/g,dd[j].bet_on);

                      for (var i =fn.length - 1; i >= 0; i--) {
                          var ff = fn[i];
                          if (ff == "U%") {
                              gpformula = gpformula.replace(/U%/g,dd[j].uper);
                          } 
                          else if (ff == "D%") {
                              gpformula = gpformula.replace(/D%/g,dd[j].dper);
                          }
                          else if (ff == "Goal%") {
                              gpformula = gpformula.replace(/Goal%/g,dd[j].goalplus_value/100);
                          }
                      }
                      var forname = gg[0].fname;
                      var accbgid = gg[0].formulatype;
                      $scope.mixresult = $scope.$eval(gpformula);
                      gpformula = "";
                      
                  }      
                  else{
                    accbgid = undefined;
                  }        
            }
            else if (dd[j].bet_on == "Home" || dd[j].bet_on == "Away") {
                  if (bddyformula) {
                    bdyformula = bddyformula;
                    bdyformula = bdyformula.replace(/Beton/g,dd[j].bet_on);

                    for (var i =fn.length - 1; i >= 0; i--) {
                        var ff = fn[i];
                        if (ff == "H%") {
                            bdyformula = bdyformula.replace(/H%/g,dd[j].hper);
                        } 
                        else if(ff == "A%"){
                            bdyformula = bdyformula.replace(/A%/g,dd[j].aper);
                        }                
                        else if (ff == "Body%") {
                            bdyformula = bdyformula.replace(/Body%/g,dd[j].body_value/100);
                        }
                    }
                    var forname = bb[0].fname;
                    var accbgid = bb[0].formulatype;
                    $scope.mixresult = $scope.$eval(bdyformula);
                    bdyformula = "";
                  
                  }   
                  else{
                    accbgid = undefined;
                  }                 
            }                    

             if (accbgid != undefined) {             
                if ($scope.mixresult>1) {
                      if (forname.includes("%")) {
                        $scope.mixstid = 7;
                      }
                      else{
                        $scope.mixstid = 1;
                      }
                 } else if($scope.mixresult>0 && $scope.mixresult<1){
                      $scope.mixstid = 8;
                 }else if($scope.mixresult == 0){
                      $scope.mixstid = 4;
                 }else if ($scope.mixresult == 1) {
                      $scope.mixstid = 5;
                 }
                 $scope.mixbetarr.push({beton:dd[j].bet_on, accbgid:accbgid, mixledger_detail_id: dd[j].mixledger_detail_id, result:$scope.mixresult, status:$scope.mixstid});   
             }                      
        }        
      }

     function cboselectchangefor(a,b,c){
      console.log(b);
                    var hper = a.hper;
                    var aper = a.aper;                              
                    var bdy = a.body_value;                              
                    var bamt = a.bet_amount;                
                    var uper = a.uper;
                    var dper = a.dper;
                    var gol = a.goalplus_value;
                    var s = a.betstateid;
                  //  $scope.userid = a.member_id;     
                  
              var str =String(b);
              if(s==1){
                    if (a.accbgid == 0) {
                          turnval = 0;
                          resultval = 0;
                          stid = 6;
                        }
                        else if (a.accbgid == 5) {
                          turnval = bamt;
                          resultval = 0;
                          stid = 5;
                        }
                        else{  
                       str = str.replace(/Beton/g,a.bet_on);
                       console.log(str);
                                    for (var i =c.length - 1; i >= 0; i--) {
                                      var ff = c[i];
                                      if (ff == "H%") {
                                          str = str.replace(/H%/g,hper);
                                      } 
                                      else if(ff == "A%"){
                                          str = str.replace(/A%/g,aper);
                                      }
                                      else if (ff == "U%") {
                                        str = str.replace(/U%/g,uper);
                                      } 
                                      else if (ff == "D%") {
                                        str = str.replace(/D%/g,dper);
                                      }
                                      else if (ff == "Body%") {
                                        str = str.replace(/Body%/g,bdy/100);
                                      }
                                      else if (ff == "Goal%") {
                                        str = str.replace(/Goal%/g,gol/100);
                                      }
                                      else if (ff == "Stake") {
                                        str = str.replace(/Stake/g,bamt);
                                      }
                                      
                                     // alert(str);
                          }
                      console.log("Last"+str);
                      resultval = $scope.$eval(str);
                         if (resultval>0) {
                              stid = 1;
                         } else if(resultval<0){
                              stid = 4;
                         }else if(resultval == 0){
                              stid = 5;
                         }
                         turnval =  parseInt(resultval)+parseInt(bamt);        
                            console.log("result = "+resultval);
                    }
              }else if(s==2){
                            turnval = a.net_amount;
                            resultval = a.result_amount;
                            stid = 2;
                        }
                        else if(s==3){
                            turnval = a.bet_amount;
                            resultval = 0;
                            stid = 3;
                        }
                   
       $scope.newarr.push({accbgid: a.accbgid, net:turnval, result:resultval, status:stid, mid:a.mledger_id, memberid:a.member_id});    

    }

     $scope.bDone = function(){
              $("#dashedit").css("display","none");
              $("#black-overlay").css("display","none");
              $scope.amount = null;
     } 
 
})

.controller("bgledgerController", function($scope, $http, $filter, $location,$interval, $log, $routeParams){
if (window.localStorage.getItem("roleId")) {    
     if (window.localStorage.getItem("roleId")==1 || window.localStorage.getItem("roleId")==2) {
        if (window.localStorage.getItem("roleId")==2) {
          $scope.adshow=2;
          $("#accmenu").css("display","block");
        }
        else if (window.localStorage.getItem("roleId")==1) {
          $scope.adshow=1;
          $("#adminmenu").css("display","block");
          $("#navbar-data1 .adminmenu").css("display","block");
        }
        $("#wrapper").css("display","block");       

            $http.post("query.php", {"type":"mixbgledger", "btn":"bg"})
            .then(function(response){
              console.log(response.data);
            // $scope.mixtotal = response.data.mixtotal;
           //  $scope.mixtotal1 = response.data.mixtotal;
             $scope.dashresult = response.data.dashresult;
             $scope.dashresult1 = response.data.dashresult;
             filterallfun1();
           //  filterallfun();
            }) 

           /* $scope.$watchCollection('allfilter', function(newValue, oldValue) {
              filterallfun();
            })*/

            $scope.$watchCollection('allfilter1', function(newValue, oldValue) {
              filterallfun1();
            })

          /*function filterallfun(){
            var expression = {};            
                    if($scope.allfilter.filterDate!=undefined)
                    {
                      expression.bet_date = $scope.allfilter.filterDate || !!$scope.allfilter.filterDate || undefined;                      
                    }                        

                     $scope.filtered = $filter('filter')($scope.mixtotal1,expression);
                     $scope.mixtotal = $scope.filtered;
          }*/

          function filterallfun1(){
            var expression = {};            
                    if($scope.allfilter1.datefilter!=undefined)
                    {
                      expression.tdate = $scope.allfilter1.datefilter || !!$scope.allfilter1.datefilter || undefined;                      
                    }                        

                     $scope.filtered = $filter('filter')($scope.dashresult1,expression);
                     $scope.dashresult = $scope.filtered;
          }
              
      }
        else{
          $location.path("/");
      }
  }
  else{
    $location.path("/");
  }  
})

.controller("mixledgerController", function($scope, $http, $filter, $location,$interval, $log, $routeParams){
if (window.localStorage.getItem("roleId")) {    
     if (window.localStorage.getItem("roleId")==1 || window.localStorage.getItem("roleId")==2) {
        if (window.localStorage.getItem("roleId")==2) {
          $scope.adshow=2;
          $("#accmenu").css("display","block");
        }
        else if (window.localStorage.getItem("roleId")==1) {
          $scope.adshow=1;
          $("#adminmenu").css("display","block");
          $("#navbar-data1 .adminmenu").css("display","block");
        }
        $("#wrapper").css("display","block");       

            $http.post("query.php", {"type":"mixbgledger", "btn":"mix"})
            .then(function(response){
              console.log(response.data);
             $scope.mixtotal = response.data.mixtotal;
             $scope.mixtotal1 = response.data.mixtotal;
            // $scope.dashresult = response.data.dashresult;
            // $scope.dashresult1 = response.data.dashresult;
            // filterallfun1();
             filterallfun();
            }) 

            $scope.$watchCollection('allfilter', function(newValue, oldValue) {
              filterallfun();
            })

            /*$scope.$watchCollection('allfilter1', function(newValue, oldValue) {
              filterallfun1();
            })*/

          function filterallfun(){
            var expression = {};            
                    if($scope.allfilter.filterDate!=undefined)
                    {
                      expression.bet_date = $scope.allfilter.filterDate || !!$scope.allfilter.filterDate || undefined;                      
                    }                        

                     $scope.filtered = $filter('filter')($scope.mixtotal1,expression);
                     $scope.mixtotal = $scope.filtered;
          }

         /* function filterallfun1(){
            var expression = {};            
                    if($scope.allfilter1.datefilter!=undefined)
                    {
                      expression.tdate = $scope.allfilter1.datefilter || !!$scope.allfilter1.datefilter || undefined;                      
                    }                        

                     $scope.filtered = $filter('filter')($scope.dashresult1,expression);
                     $scope.dashresult = $scope.filtered;
          }*/
              
      }
        else{
          $location.path("/");
      }
  }
  else{
    $location.path("/");
  }  
})

.controller("mixdetailController", function($scope, $http, $filter, $location,$interval, $log, $routeParams){
  if (window.localStorage.getItem("roleId")) {    
    $scope.bodyhome = [];
     if (window.localStorage.getItem("roleId")==1 || window.localStorage.getItem("roleId")==2) {
        if (window.localStorage.getItem("roleId")==2) {
          $scope.adshow=2;
          $("#accmenu").css("display","block");
        }
        else if (window.localStorage.getItem("roleId")==1) {
          $scope.adshow=1;
          $("#adminmenu").css("display","block");
          $("#navbar-data1 .adminmenu").css("display","block");
        }
        $("#wrapper").css("display","block");        

         if ($routeParams.dashid) {
            $scope.bodyhome.push({"bet_on":"-- Body / Goal+  --"},{"bet_on":"Home"},{"bet_on":"Away"},{"bet_on":"Over"},{"bet_on":"Down"}); 
            $http.post("query.php", {"type":"mixdetail", "btn":"", "dashid":$routeParams.dashid})
            .then(function(response){
              console.log(response.data);
              $scope.mixdetail = response.data.mixdetail;
              $scope.mixdetail1 = response.data.mixdetail;
              $scope.abetstatusall = response.data.statusdata;
              $scope.allfilter.abetstate = $scope.bodyhome[0];              
              $scope.allfilter.abetstatusfilter = $scope.abetstatusall[0];
              filterallfun();
            }) 

            $scope.$watchCollection('allfilter', function(newValue, oldValue) {
              filterallfun();
            })

              function filterallfun(){
                var expression = {};
                var expression2 = {};
                
                        if($scope.allfilter.filterDate!=undefined)
                        {
                          expression2.bet_date = $scope.allfilter.filterDate || !!$scope.allfilter.filterDate || undefined;                      
                        }                        

                        if($scope.allfilter.usrname!=undefined)
                        {
                          expression2.username = $scope.allfilter.usrname || !!$scope.allfilter.usrname || undefined;                      
                        }

                        if($scope.allfilter.loginid!=undefined)
                        {
                          expression2.loginid = $scope.allfilter.loginid || !!$scope.allfilter.loginid || undefined;                      
                        }
                        
                          if($scope.allfilter.abetstate!=undefined)
                             {
                               if ($scope.allfilter.abetstate.bet_on!="-- Body / Goal+  --") 
                                {
                                   expression.bet_on =$scope.allfilter.abetstate.bet_on || !!$scope.allfilter.abetstate.bet_on || undefined;         
                                }                     
                           }       

                          if($scope.allfilter.abetstatusfilter!=undefined)
                             {
                               if ($scope.allfilter.abetstatusfilter.status_id!="0") 
                                {
                                   expression.status_id =$scope.allfilter.abetstatusfilter.status_id || !!$scope.allfilter.abetstatusfilter.status_id || undefined;         
                                }                     
                           }
                         $scope.filtered = $filter('filter')($scope.mixdetail1,expression,true);
                         $scope.first = $scope.filtered;
                         $scope.filtered2 = $filter('filter')($scope.first,expression2);
                         $scope.mixdetail = $scope.filtered2;
              }
        }
        else{
          $location.path("/");
        }         
    }
      else{
        $location.path("/");
    }
}
else{
  $location.path("/");
}  
})

.controller("DashCtrl", function($scope, $http, $location,$interval, $log){  
  $scope.aa = false;
  $scope.changeshow = true;
  $scope.mixdiv = [];
  $scope.mixdisabled = [];
  $scope.mixlength = [];
  $scope.betamount = 0;
  $scope.min = 0;
  $scope.m = 0;
  $scope.max = 0;    
  $scope.changebet = "bg";
  $scope.bgbetonoff = null;
  $scope.pinresult = [];
  $scope.mixhide = false;
  $scope.mixnorecord = false;

            if (window.localStorage.getItem("roleId")) {
                   if (window.localStorage.getItem("roleId")!=3) {
                          if (window.localStorage.getItem("roleId")==2) {
                            $("#accmenu").css("display","block");
                          }
                          else if (window.localStorage.getItem("roleId")==1) {
                            $("#adminmenu").css("display","block");
                            $("#navbar-data1 .adminmenu").css("display","block");
                          }

                        $("#header").css("display","block");
                        $("#wrapper").css("display","block");                      
                        $("#mmenu").css("display","none");                      
                        $("#navbar-data1 .mmenu").css("display","none");

                        $("#login").css("display","none");
                        $("#dashsection").removeClass("col-md-10");  
                        $("#dashsection").addClass("col-md-12");
                        $scope.mid = "and 1=1";
                        $scope.onlyhome = false;
                        $scope.onlyhome1 = false;
                  }
                    else if(window.localStorage.getItem("roleId")==3){
                      $scope.changeshow = true;
                      checkmbr();
                        $("#header").css("display","block");
                        $("#wrapper").css("display","block");
                        $("#adminmenu").css("display","none");
                        $("#accmenu").css("display","none");
                        $("#mmenu").css("display","block");
                        $("#navbar-data1 .adminmenu").css("display","none");
                        $("#navbar-data1 .mmenu").css("display","block");

                        $("#login").css("display","none");
                        $scope.onlyhome = true;
                        //$scope.onlyhome1 = true;

                        $http.post("query.php",{"mid":window.localStorage.getItem("userId"),"type":"onoff","onofftype":"bettingonoff","btn":"check"})
                        .then(function (response) {
                          if (response.data.accepttype1 == "can") {
                            $scope.act = true;
                            $scope.actbetimg = true;
                            $scope.changeshow = true;
                            $scope.bgbetonoff = null;
                          }
                          else{
                            $scope.act = false;
                            $scope.actbetimg = false;
                            $scope.bgbetonoff = false;
                          }

                          if (response.data.accepttype2 == "can") {
                            $scope.onlyhome1 = true;                          
                          }
                          else{
                            $scope.onlyhome1 = false;          
                            console.log($scope.onlyhome1);                
                          }

                        })

                        /*if (window.localStorage.getItem("betonoff") == "can") {
                          $scope.act = true;
                          $scope.actbetimg = true; 
                        }
                        else{
                          $scope.act = false;
                          $scope.actbetimg = false; 
                        }*/
                        
                        $("#dashsection").removeClass("col-md-10");  
                        $("#dashsection").addClass("col-md-12");  
                        $scope.m = window.localStorage.getItem("userId");
                        console.log(window.localStorage.getItem("userId"));
                        $scope.mid = "and a.member_id="+window.localStorage.getItem("userId");     
                        checkrunning();
                    }
                       getdata() ;
                       if ($scope.m == 1) {
                          $scope.admbr = true;
                       }
                       else{
                          $scope.admbr = false;
                       }
                  }
                    else{
                      $scope.mid = "and 1=1";
                      $scope.onlyhome = false;
                      $scope.onlyhome1 = false;
                      $("#header").css("display","none");
                      $("#menu .adminmenu").css("display","none");
                      $("#menu .mmenu").css("display","none");  
                      $("#login").css("display","block");       
                    }
    function checkmbr(){
      $http.post("query.php",{"type":"checkmember","btn":"","mid":window.localStorage.getItem("userId")})
                      .then(function (response) {
                      /*    $scope.alldata = response.data;*/
                           if (response.data.alluser == "No Record") {
                            window.localStorage.removeItem("roleId");
                            window.localStorage.removeItem("userId");
                            $("#wrapper").css("display","none");  
                            $("#adminmenu").css("display","none");  

                            $("#accmenu").css("display","none");
                       
                            $("#mmenu").css("display","none");  
                            $("#navbar-data1 .adminmenu").css("display","none");  
                            $("#navbar-data1 .mmenu").css("display","none"); 
                            $("#login").css("display","block");   
                            $("#header").css("display","none");  
                             $scope.mid = "and 1=1";
                             $scope.onlyhome = false;
                             $scope.onlyhome1 = false;
                             $("#dashsection").removeClass("col-md-12");  
                             $("#dashsection").addClass("col-md-10");
                           $location.path("/");
                           }
                            
                      })
    }   

    $scope.changemix = function(){
      $scope.changebet = "mix";
      $scope.changeshow = false;
      $scope.mixhide = true;
    } 

    $scope.changebg = function(){
      $scope.mixhide = false;
      $scope.changebet = "bg";
      $scope.changeshow = true;
      if (window.localStorage.getItem("roleId")==3) {
        if ($scope.bgbetonoff == false) {
          $scope.act = false;
        }
        else{
          $scope.act = true;
        }
        
      };      
    }     

    function checkrunning(){
        $http.post("query.php",{"type":"checkrunning","btn":"","mid":window.localStorage.getItem("userId")})
        .then(function (response) {
       //   alert(response.data);
       $scope.runningamt = response.data.run;
         // console.log(response.data.run);
        })
    } 

  Array.prototype.contains = function(v) {
    for(var i = 0; i < this.length; i++) {
        if(this[i].dashid === v) return true;
    }
    return false;
  };

 Array.prototype.unique = function() {
    var arr = [];
    for(var i = 0; i < this.length; i++) {
        if(!arr.contains(this[i].dashid)) {
            arr.push(this[i]);
        }
    }
    return arr; 
  }     

  $scope.hhh = function(a,b){
/*console.log($scope.mixlength);
    if ($scope.mixlength.includes("440")) {
      $scope.rmradio("440");
      console.log("rem");
    }
    else{
      console.log("set");*/
      $scope.mixlength.push({dashid:a,home:b.Home,away:b.Away,tdate:b.tdate,hper:b.hper,aper:b.aper,uper:b.uper,dper:b.dper,bodyval:b.body_value,
      goalval:b.goalplus_value,bodyname:b.bodyname,goalname:b.goalname,mix:b.mix_on_off, beton:'a'});
      $scope.mixlength = $scope.mixlength.unique();

      $http.post("query.php",{"type":"checkmixmatch","btn":"check","dashid":a})
      .then(function (response) {
       // console.log(response.data);
        $scope.pinresult = response.data.pinresult;
        for(var i = 0; i < response.data.pinresult.length; i++) {
          //console.log(response.data.pinresult[i].dashboard_id);
            if (response.data.pinresult[i].dashboard_id != a) {
              $scope.mixdisabled[response.data.pinresult[i].dashboard_id] = true;
             // $("."+response.data.pinresult[i].dashboard_id).css("color","#bbb");
            }
        }
        //console.log($scope.mixdisabled);
      })
   // }
  }   

  $scope.rmradio = function(a){
//    console.log($scope.mixdiv[a]);
    $scope.mixdiv[a] = "";
    for(var i = 0; i<$scope.mixlength.length; i++){

      if ($scope.mixlength[i].dashid == a) {
        console.log($scope.mixlength[i].dashid);
        console.log(a);
        $scope.mixlength.splice(i, 1);
        i = $scope.mixlength;
      }
    }

    $http.post("query.php",{"type":"checkmixmatch","btn":"check","dashid":a})
    .then(function (response) {
      console.log(response.data);
      for(var i = 0; i < response.data.pinresult.length; i++) {
        console.log(response.data.pinresult[i].dashboard_id);
          if (response.data.pinresult[i].dashboard_id != a) {
            $scope.mixdisabled[response.data.pinresult[i].dashboard_id] = false;
           // $("."+response.data.pinresult[i].dashboard_id).css("color","blue");
          }
      }
      console.log($scope.mixdisabled);
    })
    //$scope.mixdiv.splice(a, 1);
  //  var index = $scope.mixlength.indexOf(a);
 //   console.log(index);    

    console.log($scope.mixlength);
    console.log($scope.mixdiv);
  }

  $scope.mixcancelbet = function(){
    //$scope.mixdiv.splice(-1,1);
    //$scope.mixlength.splice(-1,1);
    console.log($scope.mixlength);
    console.log($scope.mixdiv);
    $scope.mixdiv = [];
    $scope.mixlength = [];

    for(var i = 0; i < $scope.dashes.length; i++) {
        
            $scope.mixdisabled[$scope.dashes[i].dashboard_id] = false;
         
      }
  }

  $scope.mixbet = function(){
    console.log($scope.mixlength.length);
      $scope.mixnumber = $scope.mixlength.length;
      if ($scope.mixnumber<=$scope.max && $scope.mixnumber>=$scope.min) {        
        $("#mixbetdiv").css("display","block");  
        $("#black-overlay").css("display","block");     
        $http.post("query.php",{"type":"testing", "btn":"betmix", "sub":"check", "mixnum":$scope.mixnumber})
        .then(function (response) {
          console.log(response.data);
          $scope.mixwarning = response.data.records;
          $scope.dbminamt = response.data.minamt;
          $scope.dbmaxamt = response.data.maxamt;
          $scope.dblimitamt = response.data.limitamt;
        })  
      }
      else{
        alert("Total mix should be between "+$scope.min+" mix and "+$scope.max+" mix");
      }

      /*$http.post("query.php",{"type":"testing", "btn":"betmix", "dashid":$scope.betid, "lbamt":b.lbamount, "blimitamt":b.blimitamt})
      .then(function (response) {
        $scope.warning = response.data;
      })*/
  }  

  $scope.bettingmix = function(){
    //console.log("mem"+window.localStorage.getItem("userId"));
    for (var i = $scope.mixlength.length - 1; i >= 0; i--) {
      $scope.mixlength[i].beton = $scope.mixdiv[$scope.mixlength[i].dashid];
    };
      if ($scope.betamount == null || $scope.betamount == "" || $scope.betamount == 0) {
          $scope.errormsg = "Please Add Amount"; 
          $scope.testing = false;
      }
      else{
         // var conbet = confirm("Are you sure this betting?");
        //  if (conbet == true) {
              if ($scope.mixwarning !=1 && $scope.mixwarning !=2) {
                  if (parseInt($scope.betamount)>parseInt($scope.mixwarning)) {
                      $scope.errormsg = "Please Check Your amount. You can bet only "+$scope.mixwarning+" ks";        
                      $scope.testing = false;
                  }
                  else{
                      if (parseInt($scope.total)<parseInt($scope.betamount)) {
                            $scope.errormsg = "Please Check Your amount.";
                            $scope.testing = false;
                      }
                      else{
                            var conbet = confirm("Are you sure this betting?");
                            if (conbet == true) {
                              $http.post("query.php",{"type":"bettingmix","amount":$scope.betamount, "mid":window.localStorage.getItem("userId"), "mix":$scope.mixnumber, "arraydata":$scope.mixlength})
                              .then(function (response) {
                                console.log(response.data);
                                alert(response.data.msg);
                                $scope.errormsg = null;
                                $scope.betamount = null;                            
                                $scope.testing = false;
                                $scope.mixdiv = [];
                                $scope.mixlength = [];
                                $("#mixbetdiv").css("display","none");  
                                $("#black-overlay").css("display","none");
                        
                              });  
                            }                                                      
                      }
                  }
              } 
              else if($scope.mixwarning ==1){
                  if (parseInt($scope.betamount)>parseInt($scope.dbmaxamt)) {
                      $scope.errormsg = "Your Amount's beyond Bet Limit.";
                      $scope.testing = false;
                  }
                  else if (parseInt($scope.betamount)<parseInt($scope.dbminamt)) {
                      $scope.errormsg = "Please Bet at least : "+$scope.dbminamt+" ks.";
                      $scope.testing = false;
                  }
                  else{
                      if (parseInt($scope.total)<parseInt($scope.betamount)) {
                              $scope.errormsg = "Please Check Your amount.";   
                              $scope.testing = false;                   
                        }
                      else{
                            var conbet = confirm("Are you sure this betting?");
                            if (conbet == true) {
                              $http.post("query.php",{"type":"bettingmix","amount":$scope.betamount, "mid":window.localStorage.getItem("userId"), "mix":$scope.mixnumber, "arraydata":$scope.mixlength})
                              .then(function (response) {
                              console.log(response.data);
                              alert(response.data.msg);
                              $scope.errormsg = null;
                              $scope.betamount = null;                            
                              $scope.testing = false;
                              $scope.mixdiv = [];
                              $scope.mixlength = [];
                              $("#mixbetdiv").css("display","none");  
                              $("#black-overlay").css("display","none");
                           
                              }); 
                            }                                                         
                        }
                  }
              }
              getdata();
      }      
  }

  function getdata(){
    if (window.localStorage.getItem("userId") == 1) {
        $scope.admbr = true;
     }
     else{
        $scope.admbr = false;
     }
     $http.post("query.php",{"type":"dash","btn":"","mid":$scope.mid})
          .then(function (response) {
            console.log(response.data);
              $scope.alldata = response.data;
              $scope.league = response.data.leag;
              /*if ($scope.league != "No Record") {
                //$scope.league = [{league_id:0,leaguename:"No League"}];
                $scope.league.splice(0,0, {league_id:"0",leaguename:"-- Choose League --"});  
                $scope.leagueval = $scope.league[0];
              }*/
              
              //console.log($scope.league);
              $scope.dashes = response.data.dash;
              $scope.total = response.data.m;
              $scope.min = response.data.min;
              $scope.max = response.data.max;
              $scope.mbrname =response.data.mname;

              /*if ($scope.pinresult.length >0) {
                for(var i = 0; i < $scope.pinresult.length; i++) {
                  $("."+$scope.pinresult[i].dashboard_id).css("color","#bbb");
                }
              } */    
              if ($scope.dashes.length >0) {
                var mixonoff = 0;
                for(var i = 0; i < $scope.dashes.length; i++) {
                  if ($scope.dashes[i].mix_on_off == 2) {
                    mixonoff += 1;
                  };
                }
                if (mixonoff == $scope.dashes.length) {
                  $scope.mixnorecord = true;
                }
                else{
                  $scope.mixnorecord = false;
                }
              }         
          })         
          checkrunning();          
      }

getdata();
    $interval(function(){
      console.log($scope.mid);
      getdata();
      },60000);      

$scope.adminmbr = function(){
  $interval(function(){
    console.log($scope.mid);
    getdata();
    },1000); 
}

$scope.refreshfun = function(){
  getdata();
}

$scope.closefun = function(){
  $("#black-overlay").css("display","none");                      
  $("#loginerrormsg").css("display","none");
  $scope.errorTxt = "";
  $scope.username = null;
  $scope.password = null;
  getdata();
}

$scope.login = function(){
      if ($scope.username==null && $scope.password==null) {
            $location.path('/');
      }
      else{
          $http.post("query.php", {"username":$scope.username, "pass":$scope.password, "type":"login"})
          .then(function(response){
               $scope.alldata = response.data;
               $scope.roleId=response.data.roleid;
               $scope.dashes = response.data.dash;
               $scope.userId =response.data.userid;
               $scope.total =response.data.total;
               $scope.mbrname =response.data.mname;
               if($scope.roleId!=null){
                $("#header").css("display","block");
                  if ($scope.roleId!=3) {
                     if (window.localStorage.getItem("roleId")==2) {
                      $scope.adshow=2;
                          $("#accmenu").css("display","block");
                        }
                        else if (window.localStorage.getItem("roleId")==1) {
                          $scope.adshow=1;
                          $("#adminmenu").css("display","block");
                          $("#navbar-data1 .adminmenu").css("display","block");
                        }

                    $("#wrapper").css("display","block");
                    $("#header").css("display","block");                       
                    $("#mmenu").css("display","none");                    
                    $("#navbar-data1 .mmenu").css("display","none");

                        if ($scope.roleId.trim()==1) {
                                $scope.adminshow=true;
                          }
                          else{
                               $scope.adminshow=false;
                          }
                        
                      $location.path('/accdash');
                      window.localStorage.setItem("roleId",  $scope.roleId);
                       window.localStorage.setItem("userId",  $scope.userId);  
                       $scope.mid = "and 1=1";                
                  }
                  else if($scope.roleId==3){                    
                    $scope.agentid =response.data.agentid;
                    if (response.data.agentid != 0) {
                      window.localStorage.setItem("agentId",  response.data.agentid);
                    }
                   // window.localStorage.setItem("betonoff",  response.data.betonoff);
                    $scope.betonoff = response.data.betonoff;
                    $scope.mixbetonoff = response.data.mixbetonoff;
                  //  $scope.total =response.data.total;
                   // $scope.mbrname =response.data.mname;
                    $("#wrapper").css("display","block");
                    $("#header").css("display","block");
                      $("#adminmenu").css("display","none");       
                      $("#accmenu").css("display","none");                                
                      $("#mmenu").css("display","block");
                      $("#navbar-data1 .adminmenu").css("display","none");                      
                      $("#navbar-data1 .mmenu").css("display","block");
                      $("#login").css("display","none");
                  
                      window.localStorage.setItem("roleId",  $scope.roleId);
                      window.localStorage.setItem("userId", $scope.userId);  
                      checkrunning();  
                      $scope.onlyhome = true;
                      $scope.onlyhome1 = true;  
                      if ($scope.betonoff == "can") {
                        $scope.act = true;
                        $scope.actbetimg = true;   
                        $scope.bgbetonoff = null;
                      } 
                      else{
                        $scope.act = false;
                        $scope.actbetimg = false;   
                        $scope.bgbetonoff = false;
                      }

                      if ($scope.mixbetonoff == "can") {
                        $scope.onlyhome1 = true;
                      } 
                      else{
                        $scope.onlyhome1 = false;   
                      }                                                                      
                                                          
                      $("#dashsection").removeClass("col-md-10");  
                      $("#dashsection").addClass("col-md-12");  
                      $scope.mid = "and a.member_id="+$scope.userId;    
                     // $location.path('/');
                  }
                }  
            else{
              $("#black-overlay").css("display","block");                      
              $("#loginerrormsg").css("display","block");
              $scope.errorTxt=response.data;
            }                              
          })
    }                      
    } 

  $scope.actbetbody = function(a,b){
    $scope.betid = a;
    $scope.Home = b.Home;
    $scope.Away = b.Away;
    $scope.tdate = b.tdate;
    $scope.ttime = b.ttime;
    $scope.bodyname = b.bodyname;
    $scope.body_value = b.body_value;
    $scope.hperold = b.hper;
    $scope.aperold = b.aper;
    
    $scope.bio = b.bio_id;
    $scope.blimitamt = b.blimitamt;
    $scope.lbamount = b.lbamount;
    $scope.glimitamt = b.glimitamt;
    $scope.lgamount = b.lgamount;
    $scope.bless = b.bless;

    $http.post("query.php", {"dashid":a, "type":"dash","btn":"bet","mid":$scope.mid})
    .then(function(response){
      $scope.dashval = response.data.dashval;
      $scope.hper = $scope.dashval[0].hper;
      $scope.aper = $scope.dashval[0].aper;

      $scope.alldata = response.data;
      $scope.league = response.data.leag;
      $scope.dashes = response.data.dash;
      $scope.total = response.data.m;     
      $scope.mbrname =response.data.mname;   
    })
   


    $http.post("query.php",{"type":"testing", "btn":"betbodyamt", "dashid":$scope.betid, "lbamt":b.lbamount, "blimitamt":b.blimitamt})
                    .then(function (response) {
                      $scope.warning = response.data;
                    })

    if ($scope.bio==2) {
          $scope.biohshow = false;
          $scope.bioashow = true;
    } else if($scope.bio==3){
          $scope.bioashow = false;
          $scope.biohshow = true;
    } else if ($scope.bio==1) {
          $scope.biohshow = true;
          $scope.bioashow = true;
    }
     $scope.betbody = true;
    $scope.betgoal = false;
    $("#black-overlay").css("display","block");
    $("#dashedit").css("display","block");
  }

  $scope.actbetgoal = function(a,b){
    $scope.betid = a;
    $scope.tdate = b.tdate;
    $scope.ttime = b.ttime;
    $scope.goalname = b.goalname;
    $scope.goal_value = b.goalplus_value;
    $scope.homename = b.Home;
    $scope.awayname = b.Away;
    $scope.uperold = b.uper;
    $scope.dperold = b.dper;
   
    $scope.gio = b.gio_id;
    $scope.blimitamt = b.blimitamt;
    $scope.lbamount = b.lbamount;
    $scope.glimitamt = b.glimitamt;
    $scope.lgamount = b.lgamount;
    $scope.gless = b.gless;

    $http.post("query.php", {"dashid":a, "type":"dash","btn":"bet","mid":$scope.mid})
    .then(function(response){
      $scope.dashval = response.data.dashval;
      $scope.oper = $scope.dashval[0].uper;
      $scope.dper = $scope.dashval[0].dper;
      

      $scope.alldata = response.data;
      $scope.league = response.data.leag;
      $scope.dashes = response.data.dash;
      $scope.total = response.data.m;     
      $scope.mbrname =response.data.mname;   
    })

    $http.post("query.php",{"type":"testing", "btn":"betgoalamt", "dashid":$scope.betid, "lgamt":b.lgamount, "glimitamt":b.glimitamt})
    .then(function (response) {
      $scope.warning = response.data;
    })

    if ($scope.gio==2) {
          $scope.gioOshow = false;
          $scope.gioDshow = true;
    } else if($scope.gio==3){
          $scope.gioDshow = false;
          $scope.gioOshow = true;
    } else if ($scope.gio==1) {
          $scope.gioDshow = true;
          $scope.gioOshow = true;
    }
     $scope.betbody = false;
      $scope.betgoal = true;
    $("#black-overlay").css("display","block");
     $("#dashedit").css("display","block");     
  }

  $scope.hoverh = function(){
   $("#awaydiv").css("opacity","0.4");
  }
  $scope.leaveh = function(){
    $("#awaydiv").css("opacity","1");
  }
   $scope.hovera= function(){
   $("#homediv").css("opacity","0.4");
  }
  $scope.leavea = function(){
    $("#homediv").css("opacity","1");
  }
   $scope.hovero = function(){
   $("#downdiv").css("opacity","0.4");
  }
  $scope.leaveo = function(){
    $("#downdiv").css("opacity","1");
  }
   $scope.hoverd= function(){
   $("#overdiv").css("opacity","0.4");
  }
  $scope.leaved = function(){
    $("#overdiv").css("opacity","1");
  }
$scope.bDone = function(){
          $("#mixbetdiv").css("display","none");
          $("#dashedit").css("display","none");
          $("#black-overlay").css("display","none");
          $("#successalert").css("display","none");
          $scope.testing = false;
          $scope.amount = null;
          $scope.errormsg = null;
          $scope.cteam = undefined;
          $scope.mixdiv = [];
          $scope.mixlength = [];
 } 

$scope.betmember = function(b){
  $scope.testing = true;
  $http.post("query.php", {"dashid":b, "type":"checkpercent","btn":"check"})
    .then(function(response){
      $scope.betreal(response.data.chdata,b);
    })   
  }

  $scope.betreal = function(chdata,b){
    console.log(chdata);
  $scope.bodyvalue = chdata[0].body_value;
  $scope.hpervalue = chdata[0].hper;
  $scope.apervalue = chdata[0].aper;
  $scope.goalvalue = chdata[0].goalplus_value;
  $scope.upervalue = chdata[0].uper;
  $scope.dpervalue = chdata[0].dper;

  $scope.testing = true;
    $scope.m = window.localStorage.getItem("userId");
         if($scope.betbody == true){
           $scope.gb = "Body";
         } 
         else {
          $scope.gb = "Goal+";
         }
    if ($scope.amount == null || $scope.amount == "") {
      $scope.errormsg = "Please Add Amount"; 
      $scope.testing = false;
    }
    else if ($scope.cteam == undefined || $scope.cteam == null) {
      //alert("Please Select Team");
      $scope.errormsg = "Please Select Team";      
      $scope.testing = false;
    }
    else{
      if ($scope.gb == "Body") {
     // var confirmupdate = confirm("Body (%) : "+$scope.bodyvalue+"% \nHome (%) : "+$scope.hpervalue+"% \nAway (%) : "+$scope.apervalue+"%");
        //if (confirmupdate == true) {
            if (parseInt($scope.amount)<parseInt($scope.bless)) {
              $scope.errormsg = "Please Bet at least "+$scope.bless+" ks";
              var conbet = false;
            }
            else{
                if ($scope.cteam == "Home") {
                  $scope.betteam = $scope.Home;
                }else{
                  $scope.betteam = $scope.Away;
                }
                if ($scope.body_value != $scope.bodyvalue || $scope.hperold != $scope.hpervalue || $scope.aperold != $scope.apervalue) {
                //var conbet = confirm($scope.betteam+" : "+$scope.bodyname+"\n\nBody (%) : "+$scope.body_value+"% --> "+$scope.bodyvalue+"%\nHome (%) : "+$scope.hperold+"% --> "+$scope.hpervalue+"% \nAway (%) : "+$scope.aperold+"% --> "+$scope.apervalue+"% \n\nBet Amount : "+$scope.amount+" ks \n\n"+"Are you sure this betting?");  
                alert("ODD Changes!");  
                var conbet = false;
                }
                else{
                  //var conbet = confirm($scope.betteam+" : "+$scope.bodyname+"\n\nBody (%) : "+$scope.bodyvalue+"%\nHome (%) : "+$scope.hpervalue+"% \nAway (%) : "+$scope.apervalue+"% \n\nBet Amount : "+$scope.amount+" ks \n\n"+"Are you sure this betting?");  
                  var conbet = confirm("Are you sure this betting?\nMatch >> "+$scope.Home+" & "+$scope.Away+"\nBet >> "+$scope.betteam+" : "+$scope.bodyname+" ["+$scope.bodyvalue+"]\nAmount : "+$scope.amount+" ks \nHome (%) : "+$scope.hpervalue+"\nAway (%) : "+$scope.apervalue);  
                }
              }
        /*}
        else{
          var conbet = false;
        } */               
      }
      else{
        //var confirmupdate = confirm("Goal+ (%) : "+$scope.goalvalue+"% \nOver (%) : "+$scope.upervalue+"% \nDown (%) : "+$scope.dpervalue+"%");
        //if (confirmupdate == true) {
          if (parseInt($scope.amount)<parseInt($scope.gless)) {
               $scope.errormsg = "Please Bet at least "+$scope.gless+" ks";
               var conbet = false;
            }
            else{
              if ($scope.goal_value != $scope.goalvalue || $scope.uperold != $scope.upervalue || $scope.dperold != $scope.dpervalue) {
                //var conbet = confirm($scope.cteam+" : "+$scope.goalname+"\n\nGoal (%) : "+$scope.goal_value+"% --> "+$scope.goalvalue+"%\nOver (%) : "+$scope.uperold+"% --> "+$scope.upervalue+"% \nDown (%) : "+$scope.dperold+"% --> "+$scope.dpervalue+"%\n\nBet Amount : "+$scope.amount+" ks \n\n"+"Are you sure this betting?");
                alert("ODD Changes!");                
                var conbet = false;
              }
              else{
                //var conbet = confirm($scope.cteam+" : "+$scope.goalname+"\n\nGoal (%) : "+$scope.goalvalue+"%\nOver (%) : "+$scope.upervalue+"% \nDown (%) : "+$scope.dpervalue+"%\n\nBet Amount : "+$scope.amount+" ks \n\n"+"Are you sure this betting?");
                var conbet = confirm("Are you sure this betting?\nMatch >> "+$scope.homename+" & "+$scope.awayname+"\nBet >> "+$scope.cteam+" : "+$scope.goalname+" ["+$scope.goalvalue+"]\nAmount : "+$scope.amount+" ks \nOver (%) : "+$scope.upervalue+"\nDown (%) : "+$scope.dpervalue);  
              }
                //var conbet = confirm("Are you sure this betting? \n"+$scope.betteam+" : "+$scope.bodyname+"["+$scope.bodyvalue+"]\nHome (%) : "+$scope.hpervalue+"% \nAway (%) : "+$scope.apervalue+"% \n\nBet Amount : "+$scope.amount+" ks");
            } 
        /*}
        else{
          var conbet = false;
        }  */  
        console.log(conbet);  
      }
      
      if (conbet == true) {
          $http.post("query.php", {"dashid":b, "type":"checkpercent","btn":"check"})
          .then(function(response){
            $scope.bodyvalue = response.data.chdata[0].body_value;
            $scope.hpervalue = response.data.chdata[0].hper;
            $scope.apervalue = response.data.chdata[0].aper;
            $scope.goalvalue = response.data.chdata[0].goalplus_value;
            $scope.upervalue = response.data.chdata[0].uper;
            $scope.dpervalue = response.data.chdata[0].dper;

            console.log(response.data);

            if ($scope.gb == "Body") {              
              if ($scope.body_value != $scope.bodyvalue || $scope.hperold != $scope.hpervalue || $scope.aperold != $scope.apervalue) {
                alert("ODD Changes!");
                $scope.testing = false;
                $scope.goal_value = $scope.goalvalue;
                $scope.uperold = $scope.upervalue;
                $scope.dperold = $scope.dpervalue;
                $scope.body_value = $scope.bodyvalue;
                $scope.hperold = $scope.hpervalue;
                $scope.aperold = $scope.apervalue;
              }
              else{
                $scope.realbet(b);
              }
            }
            else{
              console.log($scope.gb);
              if ($scope.goal_value != $scope.goalvalue || $scope.uperold != $scope.upervalue || $scope.dperold != $scope.dpervalue) {
                alert("ODD Changes!");  
                $scope.testing = false;
                $scope.goal_value = $scope.goalvalue;
                $scope.uperold = $scope.upervalue;
                $scope.dperold = $scope.dpervalue;
                $scope.body_value = $scope.bodyvalue;
                $scope.hperold = $scope.hpervalue;
                $scope.aperold = $scope.apervalue;
              }
              else{
                $scope.realbet(b);
              }

            }     
           
          })  
        
      }
        else
        {
          $scope.testing = false;
          $scope.goal_value = $scope.goalvalue;
          $scope.uperold = $scope.upervalue;
          $scope.dperold = $scope.dpervalue;
          $scope.body_value = $scope.bodyvalue;
          $scope.hperold = $scope.hpervalue;
          $scope.aperold = $scope.apervalue;
        }         
    }  
      getdata();
}

  $scope.realbet = function(b) {
    if ($scope.warning !=1 && $scope.warning !=2) {
            if (parseInt($scope.amount)>parseInt($scope.warning)) {
                    $scope.errormsg = "Please Check Your amount. You can bet only "+$scope.warning+" ks";        
                    $scope.testing = false;

            } else{
                      if (parseInt($scope.total)<parseInt($scope.amount)) {
                              $scope.errormsg = "Please Check Your amount.";
                               $scope.testing = false;
                        } else{

                              $http.post("query.php",{"type":"betmember","amount":$scope.amount, "beton":$scope.cteam, "betas":$scope.gb,"mid":$scope.m,"dashid":b, "mamount":$scope.total})
                              .then(function (response) {
                                console.log(response.data);
                                $("#dashedit").css("display","none");
                                  $("#successalert").css("display","block");

                                  $scope.testing = false;
                                  $scope.errormsg = null;
                                  $scope.amount = null;
                                  $scope.cteam = undefined;
                                  $scope.gb = null;
                                  $scope.testing = false;
                                  $scope.responsedata = response.data;
                                  
                              });
                              
                        }
            }
            
    } else if($scope.warning ==1){
     
          if ((($scope.gb == "Body")&&(parseInt($scope.amount)>parseInt($scope.blimitamt))) || ((parseInt($scope.amount)>parseInt($scope.glimitamt))&&($scope.gb == "Goal+"))) {
               $scope.errormsg = "Your Amount's beyond Bet Limit.";
               $scope.testing = false;
          } else{
                if (parseInt($scope.total)<parseInt($scope.amount)) {
                      $scope.errormsg = "Please Check Your amount.";   
                      $scope.testing = false;                   
                } else{
                      $http.post("query.php",{"type":"betmember","amount":$scope.amount, "beton":$scope.cteam, "betas":$scope.gb,"mid":$scope.m,"dashid":b, "mamount":$scope.total})
                      .then(function (response) {
                        console.log(response.data);
                        $("#successalert").css("display","block");
                        $("#dashedit").css("display","none");
                          $scope.testing = false;                                             
                          $scope.errormsg = null;
                          $scope.amount = null;
                          $scope.cteam = undefined;
                          $scope.gb = null;
                          
                          $scope.responsedata = response.data;
                          
                      });           
                }
          }

    }
getdata();
}

})


.controller("mcreateController", function($scope, $http, $location) {
  $scope.joinagentid = 0;
            $scope.match=function(){
                if ($scope.pass==$scope.conpass) {
                        $scope.IsMatch=false;
                        return false;
                }
                else   
                {
                    $scope.IsMatch=true;
                }
            }

            $scope.save = function(){
              //console.log($scope.agentfinanceid);
              if ($scope.mname==null || $scope.txtloginid==null || $scope.pass==null || $scope.ph==null) {
                   $scope.loginerror="Please Fill Completely.";                        
              } 
              else{
                if ($scope.agent == 2) {
                  if ( $scope.agentfinanceid!='') {
                    if ($scope.mail==null) {
                          $scope.mail="";
                      } 
                      if ($scope.tdate==null) {
                          $scope.tdate="";
                      }  
                        testagentid();
                  }
                   else{
                      $scope.loginerror="Please Fill Agent Finance ID.";
                    } 
                        //testloginid();   
                }
                else{
                  if ($scope.mail==null) {
                          $scope.mail="";
                      } 
                      if ($scope.tdate==null) {
                          $scope.tdate="";
                      }  
                        testloginid();   
                      }                        
                  }
            }

              function cansave(){
                //console.log($scope.joinagentid);
                if ($scope.agentfinanceid == undefined || $scope.agentfinanceid == '') {
                  $scope.agentfinanceid = 0;
                }
                      $http.post("query.php",{"username":$scope.mname,"finid":$scope.financeid ,"loginid":$scope.loginid, "pass":$scope.pass,"mail":$scope.mail,"dob":$scope.tdate,"ph":$scope.ph, "joinagent":$scope.joinagentid,"type":"member","btn":"save"})
                            .then(function (response) {
                                $scope.names = response.data;
                                alert("                    Success ! \nYou can login now. Click Back to Login.");
                                $location.path("/");
                                $scope.loginsuccess = true;
                                $scope.mname = null;
                                $scope.pass = null;
                                $scope.conpass = null;
                                $scope.txtloginid = null;
                                $scope.mail = null;
                                $scope.tdate = null;
                                $scope.ph = null; 
                            });                            
              }

              function testagentid(){
                    $http.post("query.php",{"testagentid":$scope.agentfinanceid,"type":"testing","btn":"agentuniqueid"})
                    .then(function (response) {
                        if (response.data.can == 1) {
                          $scope.joinagentid = response.data.agentid;
                          testloginid();
                          //$scope.loginid = $scope.txtloginid;
                          //testid();
                        } else{
                          alert("Invalid Agent Finance ID.");
                        };
                      })
              }

              function testloginid(){
                    $http.post("query.php",{"testlogid":$scope.txtloginid,"type":"testing","btn":"loguniqueid"})
                    .then(function (response) {
                        if (response.data == 1) {
                          $scope.loginid = $scope.txtloginid;
                          testid();
                        } else{
                          alert("Existing LoginId. Try another.");
                        };
                      })
              }

              function testid(){
                    $scope.testfid = Math.random().toString().substr(2, 16);
                    $http.post("query.php",{"testfinid":$scope.testfid,"type":"testing","btn":"finuniqueid"})
                      .then(function (response) {
                        if (response.data == 1) {
                          $scope.financeid = $scope.testfid;
                          cansave();
                        } else{
                          testid();
                        };
                      })
              }
        })

.controller("mixbetlistController", function($rootScope, $scope, $http, $interval, $filter, $location, Excel, $timeout, $routeParams) {
  $scope.resarr = [];
    if (window.localStorage.getItem("roleId")) {
      $("#wrapper").css("display","block");
      if (window.localStorage.getItem("roleId")!=3) {
           if (window.localStorage.getItem("roleId")==2) {
              $("#accmenu").css("display","block");
              $location.path("/");
            }
            else if (window.localStorage.getItem("roleId")==1) {
              $("#adminmenu").css("display","block");
              $("#navbar-data1 .adminmenu").css("display","block");
              
              $scope.fromD = "";
              $scope.toD = "";
              $scope.otherD = "";
              $scope.datesign = "";
              getmixbetlistdata(); 
            }
      }
      else{
       $("#adminmenu").css("display","none");
        $("#mmenu").css("display","block");
        $("#navbar-data1 .adminmenu").css("display","none");
        $("#navbar-data1 .mmenu").css("display","block");
        $("#login").css("display","none");
        $location.path("/");
    } 
  }
  else{
    $location.path("/");
  }

  

  $scope.exportToExcel=function(tableId){ // ex: '#my-table'
      var exportHref=Excel.tableToExcel(tableId,'Mix Betting');
      $timeout(function(){location.href=exportHref;},100); // trigger download
  }

   Array.prototype.contains = function(v) {
      for(var i = 0; i < this.length; i++) {
          if(this[i].mid === v) return true;
      }
      return false;
    };

   Array.prototype.unique = function() {
      var arr = [];
      for(var i = 0; i < this.length; i++) {
          if(!arr.contains(this[i].mid)) {
              arr.push(this[i]);
          }
      }
      return arr; 
    }  

  $scope.selectall = function (){

    /*$scope.$watchCollection('allfilter', function(newValue, oldValue) {
    filterallfun();
  })*/

    $scope.$watchCollection('allfilter', function(newValue, oldValue) {
          var x = $filter('filter')($scope.mixledger, $scope.abetstatusfilter);    
           for (var i = x.length - 1; i >= 0; i--) {
            if (x[i].checked == 1) {
                x[i].checked = 0;
            } else{
                x[i].checked = 1;
            };
            
            }
            //console.log(x);
            //console.log($scope.mixledger);
            x = x.unique();
            //console.log(x);
  }); 

      /*var filtered = $scope.mixledger.filter(
            function (value) {
                value.checked = true;
            }
          )
      angular.forEach(filtered, function(item) {
         item.checked = true;
      });*/
   };

   $scope.typechange = function(){
        if ($scope.datefiltertype == "btw") {
          $scope.otherdate = null;
          $scope.between = true;
          $scope.othertype = false;      
          $scope.searchbtn = true;      
        }
        else if ($scope.datefiltertype == ">" || $scope.datefiltertype == "<" || $scope.datefiltertype == "=") {
          $scope.fFilterDate = null;
          $scope.tFilterDate = null;
          $scope.between = false;
          $scope.othertype = true; 
          $scope.searchbtn = true;
        }
        else if ($scope.datefiltertype == "all") {
          $scope.between = false;
          $scope.othertype = false; 
          $scope.searchbtn = true;
          $scope.fFilterDate = null;
          $scope.tFilterDate = null;
          $scope.otherdate = null;
        }
        else{
          $scope.between = false;
          $scope.othertype = false; 
          $scope.searchbtn = false;
          $scope.fFilterDate = null;
          $scope.tFilterDate = null;
          $scope.otherdate = null;
        }
    }

$scope.statusallchange = function(a){
    var c = confirm("Change all selected rows !");

    if (c == true) {
        var ar = $scope.mixledger.filter(
              function (value) {
                if (value.checked == 1) {
                  return true;
                } else {
                  return false;
                }
              }
              );
           for (var i =ar.length - 1; i >= 0; i--) {            
            ar[i].betstateid=$scope.statusall;
           }
           ar = ar.unique();
//console.log($scope.statusall);
console.log(ar);
           $http.post("query.php",{"type":"mixbetlist","btn":"chbetstate", "arrdata":ar,"fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign})
            .then(function (response) {
              console.log(response.data);
              $scope.alldata = response.data;
              $scope.mixledger = response.data.mixledger;
              $scope.mixledger1 = response.data.mixledger;
              $scope.totalrow = response.data.totalrow;
              $scope.mixid = response.data.mixid;
              $scope.turnover = response.data.turnover;
              $scope.betamt = response.data.bet;
              $scope.result = response.data.result;
              $scope.mixdata = response.data.mix;  
              $scope.mixdata.splice(0,0, {mix_id:0,mixname:"-- Mix --"});        
              $scope.allfilter.mixfilter = $scope.mixdata[0];  
              $scope.betstate = response.data.betstate;      
              $scope.allfilter.betstatefilter = $scope.betstate[0];
              $scope.abetstatusall = response.data.statusdata;
              $scope.allfilter.abetstatusfilter = $scope.abetstatusall[0];
              //$scope.statusfilter = "";
              $scope.statusall = ""; 
              filterallfun();              
            })           
      }
      else{
        $scope.statusall = "";                    
      }                
  }

  $scope.$watchCollection('allfilter', function(newValue, oldValue) {
    filterallfun();
  })

    function filterallfun(){
      var expression = {};
      var expression2 = {};
      
              if($scope.allfilter.filterDate!=undefined)
              {
                expression2.bet_date = $scope.allfilter.filterDate || !!$scope.allfilter.filterDate || undefined;                      
              }

              if($scope.allfilter.usrname!=undefined)
              {
                expression2.username = $scope.allfilter.usrname || !!$scope.allfilter.usrname || undefined;                      
              }

              if($scope.allfilter.loginid!=undefined)
              {
                expression2.loginid = $scope.allfilter.loginid || !!$scope.allfilter.loginid || undefined;                      
              }

              if($scope.allfilter.mixfilter!=undefined)
             {
               if ($scope.allfilter.mixfilter.mix_id!="0") 
                {
                   expression.mix_id =$scope.allfilter.mixfilter.mix_id || !!$scope.allfilter.mixfilter.mix_id|| undefined;
                }                     
             }
              
              if($scope.allfilter.betstatefilter!=undefined)
             {
               if ($scope.allfilter.betstatefilter.bs_gs_id!="0") 
                {
                   expression.betstateid =$scope.allfilter.betstatefilter.bs_gs_id || !!$scope.allfilter.betstatefilter.bs_gs_id|| undefined;
                }                     
             }               

                if($scope.allfilter.abetstatusfilter!=undefined)
                   {
                     if ($scope.allfilter.abetstatusfilter.status_id!="0") 
                      {
                         expression.status_id =$scope.allfilter.abetstatusfilter.status_id || !!$scope.allfilter.abetstatusfilter.status_id || undefined;         
                      }                     
                 }
               $scope.filtered = $filter('filter')($scope.mixledger1,expression,true);
               $scope.first = $scope.filtered;
               $scope.filtered2 = $filter('filter')($scope.first,expression2);
               $scope.mixledger = $scope.filtered2;
    }

$scope.calculatemix = function(a,b,c){
    console.log(a);
    console.log(b);
    console.log(c);
    var mbr = 0;
    var mpp = 1;
    var mmval = 0;
    var bmt = 0;
    var checkstatus = 1;
    for(var i = 0; i<b; i++){   
      for(var j = 0; j<a.length; j++){
            if (a[j].mixledger_id == c[i] && a[j].betstateid != 9) {
                  if (a[j].bgstatusid != 0 && a[j].bgstatusid != 2 && a[j].bgstatusid != 6) {
                    checkstatus = 1;
                  }
                  else{
                    checkstatus = 0;
                  }
                  mbr = a[j].member_id;
                  mmval = a[j].mmval;
                  bmt = a[j].bet_amount;
                  mpp = mpp*a[j].mp;
                  checkstatus = checkstatus*1;  
            }  
       }

      var turnover = mpp*mmval*bmt;
      var resamt = (mpp*mmval*bmt)-bmt;
      if (resamt>bmt) {      
        var stid = 1;
      }
      else if(turnover == 0){
        var stid = 4;
      }
      else if(turnover < bmt && turnover > 0){
        var stid = 8;
      }
      if (checkstatus == 1) {
        $scope.resarr.push({mbrid:mbr,mixid:c[i],resval:mpp,turnval:turnover,resamtval:resamt,status:stid});
      }      
      mpp = 1;   
    }
    console.log($scope.resarr);
    //angular.extend(a,$scope.resarr);
    $http.post("query.php",{"type":"mixbetlist","btn":"save", "arrdata":$scope.resarr,"fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign})
    .then(function (response) {
      console.log(response.data);
      $scope.alldata = response.data;
      $scope.mixledger = response.data.mixledger;
      $scope.mixledger1 = response.data.mixledger;
      $scope.totalrow = response.data.totalrow;
      $scope.mixid = response.data.mixid;
      $scope.turnover = response.data.turnover;
      $scope.betamt = response.data.bet;
      $scope.result = response.data.result;
      $scope.mixdata = response.data.mix;  
      $scope.mixdata.splice(0,0, {mix_id:0,mixname:"-- Mix --"});        
      $scope.allfilter.mixfilter = $scope.mixdata[0];  
      $scope.betstate = response.data.betstate;      
      $scope.allfilter.betstatefilter = $scope.betstate[0];
      $scope.abetstatusall = response.data.statusdata;
      $scope.allfilter.abetstatusfilter = $scope.abetstatusall[0];
      alert("Successfully Calculated!");
      filterallfun();
    })
  //console.log($scope.resarr);
  }

  function getmixbetlistdata(){  
      $scope.wltotal = 0;
      $scope.turntotal = 0;
      $scope.staketotal = 0;
      $http.post("query.php",{"type":"mixbetlist","btn":"","fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign})
      .then(function (response) {
        console.log(response.data);
        $scope.alldata = response.data;
        $scope.mixledger = response.data.mixledger;
        $scope.mixledger1 = response.data.mixledger;
        $scope.totalrow = response.data.totalrow;
        $scope.mixid = response.data.mixid;
        $scope.turnover = response.data.turnover;
        $scope.betamt = response.data.bet;
        $scope.result = response.data.result;
        $scope.mixdata = response.data.mix;
        $scope.mixdata.splice(0,0, {mix_id:0,mixname:"-- Mix --"});       
        $scope.allfilter.mixfilter = $scope.mixdata[0];   
        $scope.betstate = response.data.betstate;
        $scope.allfilter.betstatefilter = $scope.betstate[0];
        $scope.abetstatusall = response.data.statusdata;
        $scope.allfilter.abetstatusfilter = $scope.abetstatusall[0];
        filterallfun();
        //$scope.agoal = response.data.agoal;
        //$scope.abody = response.data.abody;
        //$scope.bg = response.data.bgval;
        /* if (response.data.mixledger == "No Record") {
              $scope.betusr = 0;
              $scope.wltotal = 0;
              $scope.turntotal = 0;
              $scope.staketotal = 0;
            }else{
              $scope.betusr = response.data.ledger.length;
               for (var i = $scope.mixledger.length - 1; i >= 0; i--) {
                    $scope.wltotal += $scope.mledger[i].result_amount=="RUNNING"?0:parseInt($scope.mledger[i].result_amount);
                    $scope.turntotal += $scope.mledger[i].net_amount=="RUNNING"?0:parseInt($scope.mledger[i].net_amount);
                    $scope.staketotal += $scope.mledger[i].bet_amount=="RUNNING"?0:parseInt($scope.mledger[i].bet_amount);
               }                        
            }*/
      });                 
  }

$scope.searchdate = function(){
        if ($scope.datefiltertype != null || $scope.datefiltertype != undefined) {
           $scope.datesign = $scope.datefiltertype;

        if ($scope.datefiltertype == "btw") {

              if ($scope.tFilterDate == undefined || $scope.tFilterDate == null || $scope.fFilterDate == undefined || $scope.fFilterDate == null) {
                alert("Please Fill From Date & To Date");
              }
              else if (($scope.tFilterDate != undefined || $scope.tFilterDate != null) && ($scope.fFilterDate != undefined || $scope.fFilterDate != null)) {
                $scope.fromD = $scope.fFilterDate;
                $scope.toD = $scope.tFilterDate;
              }
              else{
                $scope.fromD = "";
                $scope.toD = "";
              }
        }
        else if($scope.datefiltertype == ">" || $scope.datefiltertype == "<" || $scope.datefiltertype == "="){
            if ($scope.otherdate == undefined || $scope.otherdate == null) {
                alert("Please Fill Date");
            }
            else if ($scope.otherdate != undefined && $scope.otherdate != null) {
                $scope.otherD = $scope.otherdate;
            }
            else{
              $scope.otherD = "";          
            }
        }
        else if ($scope.datefiltertype == "all") {
          $scope.otherD = "";    
          $scope.fromD = "";
          $scope.toD = "";
        }
       
       getmixbetlistdata();
        }   
}

})

.controller("userlistController", function($rootScope, $scope, $http, $interval, $filter, $location, Excel, $timeout, $routeParams) {
  $scope.changeshow = true;
  if (window.localStorage.getItem("roleId")) {
  $(".bgbettingshow").css("display","block");
  $("#wrapper").css("display","block");
            if (window.localStorage.getItem("roleId")!=3) {
              $scope.stallchangeshow = true;
               if (window.localStorage.getItem("roleId")==2) {
                $scope.adshow=2;
                  $("#accmenu").css("display","block");
                }
                else if (window.localStorage.getItem("roleId")==1) {
                  $scope.adshow=1;
                  $("#adminmenu").css("display","block");
                  $("#navbar-data1 .adminmenu").css("display","block");
                }
                $scope.fromD = "";
                $scope.toD = "";
                $scope.otherD = "";
                $scope.datesign = "";

            $scope.astatusall = [{state_id:"0",status_name:"-- Status Filter(All) --"},{state_id:"1",status_name:"Confirm"},{state_id:"2",status_name:"Pending"},{state_id:"3",status_name:"Reject"}];
            $scope.abgall = [{abg_id:"0",abg_name:"-- Body or Goal --"},{abg_id:"1",abg_name:"Body"},{abg_id:"2",abg_name:"Goal+"}];
            $scope.abetonall = [{beton_id:"0",beton_name:"-- Bet On --"},{beton_id:"1",beton_name:"Home"},{beton_id:"2",beton_name:"Away"},{beton_id:"3",beton_name:"Over"},{beton_id:"4",beton_name:"Down"}];
            $scope.abetstatusall = [{abs_id:"0",abs_name:"-- Bet Status Filter --"},{abs_id:"6",abs_name:"Running"},{abs_id:"2",abs_name:"Waiting"},{abs_id:"3",abs_name:"Reject"},{abs_id:"1",abs_name:"Win"},{abs_id:"4",abs_name:"Lose"},{abs_id:"1",abs_name:"Win"},{abs_id:"5",abs_name:"Draw"}];
            
            $http.post("query.php",{"type":"formulalist","btn":""})
              .then(function (response) {
                 forname=response.data.description;
            })  

            if ($routeParams.pagetype) {
              window.localStorage.setItem("pagetype","all");
            };

              $scope.refreshuserlistfun = function(){
                if (window.localStorage.getItem("pagetype")=="all"){
                  getalldaydata();
                  filterallfun();
                }
              }

              $scope.$watchCollection('allfilter', function(newValue, oldValue) {
                filterallfun();
              })

$scope.typechange = function(){
  if ($scope.datefiltertype == "btw") {
    $scope.otherdate = null;
    $scope.between = true;
    $scope.othertype = false;      
    $scope.searchbtn = true;      
  }
  else if ($scope.datefiltertype == ">" || $scope.datefiltertype == "<" || $scope.datefiltertype == "=") {
    $scope.fFilterDate = null;
    $scope.tFilterDate = null;
    $scope.between = false;
    $scope.othertype = true; 
    $scope.searchbtn = true;
  }
  else if ($scope.datefiltertype == "all") {
    $scope.between = false;
    $scope.othertype = false; 
    $scope.searchbtn = true;
    $scope.fFilterDate = null;
    $scope.tFilterDate = null;
    $scope.otherdate = null;
  }
  else{
    $scope.between = false;
    $scope.othertype = false; 
    $scope.searchbtn = false;
    $scope.fFilterDate = null;
    $scope.tFilterDate = null;
    $scope.otherdate = null;
  }
}

$scope.searchdate = function(){
  if ($scope.datefiltertype != null || $scope.datefiltertype != undefined) {
     $scope.datesign = $scope.datefiltertype;

  if ($scope.datefiltertype == "btw") {

        if ($scope.tFilterDate == undefined || $scope.tFilterDate == null || $scope.fFilterDate == undefined || $scope.fFilterDate == null) {
          alert("Please Fill From Date & To Date");
        }
        else if (($scope.tFilterDate != undefined || $scope.tFilterDate != null) && ($scope.fFilterDate != undefined || $scope.fFilterDate != null)) {
          $scope.fromD = $scope.fFilterDate;
          $scope.toD = $scope.tFilterDate;
        }
        else{
          $scope.fromD = "";
          $scope.toD = "";
        }
  }
  else if($scope.datefiltertype == ">" || $scope.datefiltertype == "<" || $scope.datefiltertype == "="){
      if ($scope.otherdate == undefined || $scope.otherdate == null) {
          alert("Please Fill Date");
      }
      else if ($scope.otherdate != undefined && $scope.otherdate != null) {
          $scope.otherD = $scope.otherdate;
      }
      else{
        $scope.otherD = "";          
      }
  }
  else if ($scope.datefiltertype == "all") {
    $scope.otherD = "";    
    $scope.fromD = "";
    $scope.toD = "";
  }
  getusrlistdata();
  }   
}

function filterallfun(){
  var expression = {};
  var expression2 = {};
  
          if($scope.allfilter.allfilterDate!=undefined)
          {
            expression2.bet_date = $scope.allfilter.allfilterDate || !!$scope.allfilter.allfilterDate || undefined;                      
          }

          if($scope.allfilter.allusrname!=undefined)
          {
            expression2.username = $scope.allfilter.allusrname || !!$scope.allfilter.allusrname || undefined;                      
          }

          if($scope.allfilter.allteamnamea!=undefined)
          {
            expression2.a = $scope.allfilter.allteamnamea || !!$scope.allfilter.allteamnamea || undefined;                      
          }

          if($scope.allfilter.allteamname!=undefined)
          {
            expression2.h = $scope.allfilter.allteamname || !!$scope.allfilter.allteamname || undefined;                      
          }

          if($scope.allfilter.allloginid!=undefined)
          {
            expression2.loginid = $scope.allfilter.allloginid || !!$scope.allfilter.allloginid || undefined;                      
          }
          
          if($scope.allfilter.astatusfilter!=undefined)
         {
           if ($scope.allfilter.astatusfilter.state_id!="0") 
            {
               expression.betstateid =$scope.allfilter.astatusfilter.state_id || !!$scope.allfilter.astatusfilter.state_id|| undefined;
            }                     
         }
        
         if($scope.allfilter.afilterbg!=undefined)
         {
           if ($scope.allfilter.afilterbg.abg_name!="-- Body or Goal --") 
            {
               expression.bet =$scope.allfilter.afilterbg.abg_name || !!$scope.allfilter.afilterbg.abg_name|| undefined;
            }                     
         }

         if($scope.allfilter.afilterbeton!=undefined)
               {
                 if ($scope.allfilter.afilterbeton.beton_name!="-- Bet On --") 
                  {
                     expression.bet_on =$scope.allfilter.afilterbeton.beton_name || !!$scope.allfilter.afilterbeton.beton_name || undefined;         
                  }                     
               }

            if($scope.allfilter.abetstatusfilter!=undefined)
               {
                 if ($scope.allfilter.abetstatusfilter.abs_id!="0") 
                  {
                     expression.status_id =$scope.allfilter.abetstatusfilter.abs_id || !!$scope.allfilter.abetstatusfilter.abs_id || undefined;         
                  }                     
               }
           $scope.filtered = $filter('filter')($scope.mledger1,expression,true);
           $scope.first = $scope.filtered;
           $scope.filtered2 = $filter('filter')($scope.first,expression2);
           $scope.mledger = $scope.filtered2;

            var totalwl = 0;
            var totalto = 0;
            var totalba = 0;
            if ($scope.mledger) {
              for (var i = $scope.mledger.length - 1; i >= 0; i--) {
                //console.log(angular.isNumber(parseInt($scope.mledger[i].result_amount)));
                if (!isNaN(parseInt($scope.mledger[i].result_amount)) && angular.isNumber(parseInt($scope.mledger[i].result_amount))) {
                  totalwl += parseInt($scope.mledger[i].result_amount);
                }       

                if (!isNaN(parseInt($scope.mledger[i].net_amount)) && angular.isNumber(parseInt($scope.mledger[i].net_amount))) {
                  totalto += parseInt($scope.mledger[i].net_amount);
                }

                if (!isNaN(parseInt($scope.mledger[i].bet_amount)) && angular.isNumber(parseInt($scope.mledger[i].bet_amount))) {
                  totalba += parseInt($scope.mledger[i].bet_amount);
                }         
              }   

              $scope.allTotalwl = totalwl;
              $scope.allTotalto = totalto;
              $scope.allTotalba = totalba;
              $scope.totalrows = $scope.mledger.length;
            }
}

function getalldaydata(){
    $scope.alldayfilter = true;
    $scope.adshow = 3;
    $scope.wltotal = 0;
    $scope.turntotal = 0;
    $scope.staketotal = 0;
    $http.post("query.php",{"type":"allusrlist","btn":"alllist","fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign})
    .then(function (response) {
      console.log(response.data);
        $scope.alldata = response.data;
        $scope.mledger = response.data.ledger;
        $scope.mledger1 = response.data.ledger;
        $scope.agoal = response.data.agoal;
        $scope.abody = response.data.abody;
        $scope.bg = response.data.bgval;
         if (response.data.ledger == "No Record") {
              $scope.betusr = 0;
              $scope.wltotal = 0;
              $scope.turntotal = 0;
              $scope.staketotal = 0;
            }else{
              $scope.betusr = response.data.ledger.length;
               for (var i = $scope.mledger.length - 1; i >= 0; i--) {
                // $scope.wltotal = $scope.mledger[i].result_amount;
                  $scope.wltotal += $scope.mledger[i].result_amount=="RUNNING"?0:parseInt($scope.mledger[i].result_amount);
                  $scope.turntotal += $scope.mledger[i].net_amount=="RUNNING"?0:parseInt($scope.mledger[i].net_amount);
                  $scope.staketotal += $scope.mledger[i].bet_amount=="RUNNING"?0:parseInt($scope.mledger[i].bet_amount);
                }              
            }
            filterallfun();
      }); 
}

function getleaguedata(){
  $scope.wltotal = 0;
  $scope.turntotal = 0;
  $scope.staketotal = 0;
  $http.post("query.php",{"type":"usrlistleague","betstateid":0, "tid":window.localStorage.getItem("timetableid"),
    "btn":"","fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign})
      .then(function (response) {
          $scope.alldata = response.data;
          $scope.mledger = response.data.ledger;
          $scope.agoal = response.data.agoal;
          $scope.abody = response.data.abody;
          $scope.bg = response.data.bgval;
          if (response.data.ledger == "No Record") {
            $scope.betusr = 0;
            $scope.wltotal = 0;
            $scope.turntotal = 0;
            $scope.staketotal = 0;
          }else{
            $scope.betusr = response.data.ledger.length;
             for (var i = $scope.mledger.length - 1; i >= 0; i--) {
                    $scope.wltotal += $scope.mledger[i].result_amount=="RUNNING"?0:parseInt($scope.mledger[i].result_amount);
                    $scope.turntotal += $scope.mledger[i].net_amount=="RUNNING"?0:parseInt($scope.mledger[i].net_amount);
                    $scope.staketotal += $scope.mledger[i].bet_amount=="RUNNING"?0:parseInt($scope.mledger[i].bet_amount);
                  }
          }        
    });  
}

function getusrlistdata(){
  $scope.wltotal = 0;
  $scope.turntotal = 0;
  $scope.staketotal = 0;
  $http.post("query.php",{"type":"usrlist","betstateid":0, "tid":window.localStorage.getItem("timetableid"),
    "btn":"","fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign})
  .then(function (response) {
      $scope.alldata = response.data;
      $scope.mledger = response.data.ledger;
      $scope.agoal = response.data.agoal;
      $scope.abody = response.data.abody;
      $scope.bg = response.data.bgval;
       if (response.data.ledger == "No Record") {
            $scope.betusr = 0;
            $scope.wltotal = 0;
            $scope.turntotal = 0;
            $scope.staketotal = 0;
          }else{
            $scope.betusr = response.data.ledger.length;
             for (var i = $scope.mledger.length - 1; i >= 0; i--) {
                     $scope.wltotal += $scope.mledger[i].result_amount=="RUNNING"?0:parseInt($scope.mledger[i].result_amount);
                    $scope.turntotal += $scope.mledger[i].net_amount=="RUNNING"?0:parseInt($scope.mledger[i].net_amount);
                    $scope.staketotal += $scope.mledger[i].bet_amount=="RUNNING"?0:parseInt($scope.mledger[i].bet_amount);
                  }                        
          }
  }); 
}

  if (window.localStorage.getItem("pagetype")=="team") {
      getusrlistdata() ;          
      $interval(function(){
      getusrlistdata();
      },10000);                
  }
  else if (window.localStorage.getItem("pagetype")=="league") {
      getleaguedata();          
      $interval(function(){
      getleaguedata();
      },10000);                
  }
  else if (window.localStorage.getItem("pagetype")=="all") {
    $scope.showrefresh = true;
    getalldaydata();
  }       
                     
   $scope.exportToExcel=function(tableId){ // ex: '#my-table'
          var exportHref=Excel.tableToExcel(tableId,'Alluser');
          $timeout(function(){location.href=exportHref;},100); // trigger download
      }

$scope.selectall = function (){
    $scope.$watch('statusfilter', function(newValue, oldValue) {
          var x = $filter('filter')($scope.mledger, $scope.statusfilter);    
           for (var i = x.length - 1; i >= 0; i--) {
            if (x[i].checked == 1) {
                x[i].checked = 0;
            } else{
                x[i].checked = 1;
            };                      
            }
    }); 

      var filtered = $scope.mledger.filter(

            function (value) {
                value.checked.selected = true;
            }
          )
      angular.forEach(filtered, function(item) {
         item.checked = true;
      });
};

    $scope.statusallchange = function(a){
      var c = confirm("Change all selected rows !");
      if (c == true) {
          var ar = $scope.mledger.filter(
                function (value) {
                  if (value.checked == 1) {
                    return true;
                  } else {
                    return false;
                  }
                }
                );
             for (var i =ar.length - 1; i >= 0; i--) {            
              ar[i].betstateid=$scope.statusall;
              cboselectchange(ar[i]);
             }
             $scope.statusfilter = "";
        }
        else{
          $scope.statusall = "";                    
        }                
    }

    $scope.statuschange = function(a){
        cboselectchange(a);
    };  

    function cboselectchange(a){
      var hper = a.hper;
      var aper = a.aper;                              
      var bdy = a.body_value;                              
      var bamt = a.bet_amount;                
      var uper = a.uper;
      var dper = a.dper;
      var gol = a.goalplus_value;
      var s = a.betstateid;
      $scope.userid = a.member_id;    

      $http.post("query.php",{"type":"formulalist","btn":"formula","bg":a.bet,"bgid":a.accbgid})
                      .then(function (response) {
                       formula = response.data.formula;        

                        if(s==1){
                          if (a.accbgid == 0) {
                            turnval = 0;
                            resultval = 0;
                            stid = 6;
                          }else if (a.accbgid == 5) {
                          turnval = bamt;
                          resultval = 0;
                          stid = 5;
                        }else{                                                                   
                                   var str =String(formula);
                                   str = str.replace(/Beton/g,a.bet_on);
                                                for (var i =forname.length - 1; i >= 0; i--) {
                                                  var ff = forname[i];
                                                  if (ff == "H%") {
                                                      str = str.replace(/H%/g,hper);
                                                  } 
                                                  else if(ff == "A%"){
                                                      str = str.replace(/A%/g,aper);
                                                  }
                                                  else if (ff == "U%") {
                                                    str = str.replace(/U%/g,uper);
                                                  } 
                                                  else if (ff == "D%") {
                                                    str = str.replace(/D%/g,dper);
                                                  }
                                                  else if (ff == "Body%") {
                                                    str = str.replace(/Body%/g,bdy/100);
                                                  }
                                                  else if (ff == "Goal%") {
                                                    str = str.replace(/Goal%/g,gol/100);
                                                  }
                                                  else if (ff == "Stake") {
                                                    str = str.replace(/Stake/g,bamt);
                                                  }
                                      }
                                  resultval = $scope.$eval(str);
                                     if (resultval>0) {
                                          stid = 1;
                                     } else if(resultval<0){
                                          stid = 4;
                                     }else if(resultval == 0){
                                          stid = 5;
                                     }
                                     turnval =  parseInt(resultval)+parseInt(bamt);
                              }
                        }
                        else if(s==2){
                            turnval = a.net_amount;
                            resultval = a.result_amount;
                            stid = 2;
                        }
                        else if(s==3){
                            turnval = a.bet_amount;
                            resultval = 0;
                            stid = 3;
                        }

                        if (window.localStorage.getItem("pagetype") == "league") {
                            if (s!=2 || a.net_amount!="WAITING") {
                                  $http.post("query.php",{"type":"usrlistleague","accbg":a.accbgid, "betstateid":s, "net":turnval, "result":resultval,"status":stid, "mid":a.mid, "tid":window.localStorage.getItem("timetableid"), "memberid":a.member_id,
                                    "btn":"save","fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign})
                                   .then(function (response) {
                                    $scope.alldata = response.data; 
                                  $scope.mledger = response.data.ledger;
                                  $scope.agoal = response.data.agoal;
                                  $scope.abody = response.data.abody;
                                  $scope.bg = response.data.bgval;
                                });
                            }
                        }
                        else if (window.localStorage.getItem("pagetype") == "team") {
                            if (s!=2 || a.net_amount!="WAITING") {
                                  $http.post("query.php",{"type":"usrlist","accbg":a.accbgid, "betstateid":s, "net":turnval, "result":resultval,"status":stid, "mid":a.mid, "tid":window.localStorage.getItem("timetableid"), "memberid":a.member_id,
                                    "btn":"save","fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign})
                                   .then(function (response) {
                                    $scope.alldata = response.data; 
                                  $scope.mledger = response.data.ledger;
                                  $scope.agoal = response.data.agoal;
                                  $scope.abody = response.data.abody;
                                  $scope.bg = response.data.bgval;
                                });
                            }
                        }        
       });
    }
  
    $scope.betconfirm = function(a){
        $http.post("query.php",{"type":"betconfirm","mledgerid":a})
          .then(function (response) {
              $scope.mledger = response.data.ledger;                      
        }); 
    }

           /*   $scope.changemix = function(){
                //$scope.changebet = "mix";
                $scope.changeshow = false;
                $(".mixbettingshow").css("display","block");
                $(".bgbettingshow").css("display","none");
              
              } 

              $scope.changebg = function(){
                //$scope.changebet = "bg";
                $(".mixbettingshow").css("display","none");
                $(".bgbettingshow").css("display","block");
                $scope.changeshow = true;
              }*/
  }
  else{
     $("#adminmenu").css("display","none");
      $("#mmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","none");
      $("#navbar-data1 .mmenu").css("display","block");

      $("#login").css("display","none");
      $location.path("/");
  } 
}
else{
  $location.path("/");
}
})

.directive('timepicker', function() {
    return {
        restrict: 'A',
        require : 'ngModel',
        link : function (scope, element, attrs) {
            $( function() {
            $( "#time" ).timepicker(  
                {
                timeInput: true,
                timeFormat: "hh:mm tt",
                showHour: true,
                showMinute: true,
                onSelect: function(time) {
                        scope.ttime=time;
                        scope.$apply();
                     }
                } );
            } );
        }
    }
})
.controller("accbodyController", function($scope,$http,$location) {
if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
    if (window.localStorage.getItem("roleId")!=3) {
       if (window.localStorage.getItem("roleId")==2) {
          $("#accmenu").css("display","block");
        }
        else if (window.localStorage.getItem("roleId")==1) {
          $("#adminmenu").css("display","block");
          $("#navbar-data1 .adminmenu").css("display","block");
        }
    
           $scope.txtcondition="";
           $scope.txttrue="";
           $scope.txtfalse="";
           $scope.txtformula="";

           $scope.showabody=true;
           $scope.formula=true;
           $http.post("query.php",{"type":"accbody", "btn":""})
                    .then(function (response) {
                        $scope.names = response.data.accbody;
                        $scope.cvariables = response.data.fromula;
                        $scope.tvariables = response.data.fromula2;
                        $scope.fvariables = response.data.fromula3;
                        $scope.forvariables = response.data.fromula4;
                        $scope.cvariable =  $scope.cvariables[0];
                        $scope.tvariable= $scope.tvariables[0];
                        $scope.fvariable=$scope.fvariables[0];
                        $scope.forvariable =  $scope.forvariables[0];
                    });   
           $scope.saveabody= function(){
            if ($scope.wholeformula == null || $scope.des == null) {
                alert("Please Fill Completely");
            } else{
                $http.post("query.php",{"des":$scope.des, "formula":$scope.wholeformula, "type":"accbody", "btn":"save"})
                        .then(function (response) {
                            $scope.names = response.data.accbody;
                            $scope.cvariables = response.data.fromula;
                            $scope.tvariables = response.data.fromula2;
                            $scope.fvariables = response.data.fromula3;
                            $scope.forvariables = response.data.fromula4;
                            $scope.cvariable =  $scope.cvariables[0];
                            $scope.tvariable= $scope.tvariables[0];
                            $scope.fvariable=$scope.fvariables[0];
                            $scope.forvariable =  $scope.forvariables[0];
                             alert("Successful Added");
                             $scope.des= null;
                              $scope.wholeformula = null;
                              $scope.txtcondition = null;
                             $scope.txttrue = null;
                             $scope.txtfalse = null;
                             $scope.txtformula = null;
                        });
                        
            }
                    
            }
           $scope.delabody = function(a){
                    var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"abid":a, "type":"accbody", "btn":"delete"})
                            .then(function (response) {
                              $scope.names = response.data.accbody;
                              $scope.cvariables = response.data.fromula;
                              $scope.tvariables = response.data.fromula2;
                              $scope.fvariables = response.data.fromula3;
                              $scope.forvariables = response.data.fromula4;
                              $scope.cvariable =  $scope.cvariables[0];
                              $scope.tvariable= $scope.tvariables[0];
                              $scope.fvariable=$scope.fvariables[0];
                              $scope.forvariable =  $scope.forvariables[0];
                                 alert("Successful Deleted");
                            });
                    }
           }
           $scope.editabody = function(a,b){
                    $scope.des = a.description;
                    $scope.wholeformula = a.formula;
                    $scope.accbodyid = b;
                    $scope.showabody=false;
           }
           $scope.eabody = function(){
                    $http.post("query.php",{"des":$scope.des, "formula":$scope.wholeformula, "abid":$scope.accbodyid, "type":"accbody", "btn":"edit"})
                    .then(function (response) {
                        $scope.names = response.data.accbody;
                        $scope.cvariables = response.data.fromula;
                        $scope.tvariables = response.data.fromula2;
                        $scope.fvariables = response.data.fromula3;
                        $scope.forvariables = response.data.fromula4;
                        $scope.cvariable =  $scope.cvariables[0];
                        $scope.tvariable= $scope.tvariables[0];
                        $scope.fvariable=$scope.fvariables[0];
                        $scope.forvariable =  $scope.forvariables[0];
                         alert("Successful Edited");
                         $scope.showabody=true;
                          $scope.des= null;
                          $scope.txtcondition = null;
                         $scope.txttrue = null;
                         $scope.txtfalse = null;
                         $scope.txtformula = null;
                         $scope.wholeformula = null;
                    });
                    
           } 

           $scope.fcondition = function(){
                    $scope.conditionset=true;
                    $scope.trueset=false;
                    $scope.falseset=false;
                    $scope.con=true;
                    $scope.tru=false;
                    $scope.fal=false;
                    $scope.formula=false;
           }

           $scope.ftrue = function(){
                    $scope.trueset=true;
                    $scope.conditionset=false;
                    $scope.falseset=false;
                    $scope.con=false;
                    $scope.tru=true;
                    $scope.fal=false;
                    $scope.formula=false;
           }

           $scope.ffalse = function(){
                    $scope.falseset=true;
                    $scope.trueset=false;
                    $scope.conditionset=false;
                    $scope.con=false;
                    $scope.tru=false;
                    $scope.fal=true;
                    $scope.formula=false;
           }

           $scope.fformula = function(){
                    $scope.formulaset=true;
                    $scope.con=false;
                    $scope.tru=false;
                    $scope.fal=false;
                    $scope.formula=true;
           }

           
           $scope.conadd = function(){
                 $scope.txtcondition += $scope.cvariable.description;
           }
           $scope.conopadd = function(){
                    $scope.txtcondition += $scope.coperator;
           }
           $scope.connumadd = function(){
                    $scope.txtcondition += $scope.cnumber;
           }
           $scope.conclear = function(){
                    $scope.txtcondition = null;
           }

           $scope.trueadd = function(){
                    $scope.txttrue += $scope.tvariable.description;
           }
           $scope.trueopadd = function(){
                    $scope.txttrue += $scope.toperator;
           }
           $scope.truenumadd = function(){
                    $scope.txttrue += $scope.tnumber;
           }
           $scope.trueclear = function(){
                    $scope.txttrue = null;
           }

           $scope.falseadd = function(){
                    $scope.txtfalse += $scope.fvariable.description;
           }
           $scope.falseopadd = function(){
                    $scope.txtfalse += $scope.foperator;
           }
           $scope.falsenumadd = function(){
                    $scope.txtfalse += $scope.fnumber;
           }
           $scope.falseclear = function(){
                    $scope.txtfalse = null;
           }

           $scope.fadd = function(){
                    $scope.txtformula += $scope.forvariable.description;
           }
           $scope.fopadd = function(){
                    $scope.txtformula += $scope.foroperator;
           }
           $scope.fornumadd = function(){
                    $scope.txtformula += $scope.fornumber;
           }
           $scope.fclear = function(){
                    $scope.txtformula = null;
           }

           $scope.finish = function(){
                    if ($scope.txtcondition!="" && $scope.txttrue!="" && $scope.txtfalse!="" ) {
                          $scope.wholeformula = $scope.txtcondition+"?"+$scope.txttrue+":"+$scope.txtfalse;
                    }
                    if ($scope.txtformula!="" ) {
                          $scope.wholeformula = $scope.txtformula;
                    }
           }
         }
         else{
          $location.path("/");
         }
        }
        else{
          $location.path("/");
        }
})

.controller("mprofileController", function($filter, $scope, $http, $log, md5, $location, $routeParams) {
  $scope.aaa = true;
  if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
  if (window.localStorage.getItem("roleId")!=3) {

              if (window.localStorage.getItem("roleId")==2) {
                $("#accmenu").css("display","block");
              }
              else if (window.localStorage.getItem("roleId")==1) {
                $("#adminmenu").css("display","block");
                $("#navbar-data1 .adminmenu").css("display","block");
              }
  }
  else{
    $("#header").css("display","block");
                $("#adminmenu").css("display","none");
                $("#mmenu").css("display","block");
                $("#navbar-data1 .adminmenu").css("display","none");
                $("#navbar-data1 .mmenu").css("display","block");

                $("#login").css("display","none");
            }

            if ($routeParams.mid) {
                $scope.mid = $routeParams.mid;
                $scope.aaa = false;
                $("#cardinsert").css("display","none"); 
                $scope.agentdata = [];
                $scope.commission = 0;
            }
            else if (window.localStorage.getItem("userId")) {
                $scope.mid = window.localStorage.getItem("userId");
            }
            $scope.cardbtn = true;
            
            $scope.bankhis = 0;
              $http.post("query.php",{"type":"mpage","mid":$scope.mid,"btn":"mprofile","sub":""})
                  .then(function (response) {
                    console.log(response.data);
                      $scope.mp = response.data.mp;
                      $scope.agenttest = response.data.agent;
                      $scope.financeid = $scope.mp[0].financeid;
                      $scope.fid= $scope.financeid.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();                          
                      $scope.bks = response.data.bank;
                   //   $scope.bankselect = $scope.bks[0];
                       if (response.data.bankcard) {
                              $scope.bkcard = response.data.bankcard;
                          } 
                       if ($scope.agenttest == 1) {
                          $scope.agentdata = response.data.agentdata;
                          $scope.agentval = true;
                          $scope.agentdisable = true;
                          $scope.onoffagent = response.data.commission;
                       }
              });

              $scope.fromD = "";
              $scope.toD = "";
              $scope.otherD = "";
              $scope.datesign = "";    

              $scope.match=function(){
                if ($scope.pass==$scope.conpass) {
                        $scope.IsMatch=false;
                        return false;
                }
                else   
                {
                    $scope.IsMatch=true;
                }
            }
//console.log(window.localStorage.getItem("userId"));
          $scope.agenton = function(){
            var agenton = confirm("Are you sure to set AGENT to this member?");
            if (agenton == true) {
              $scope.agentdisable = true;              
              //console.log($scope.agentval);
             $http.post("query.php",{"type":"mpage","mid":$scope.mid,"btn":"mprofile","sub":"agentsetup","userid":window.localStorage.getItem("userId")})
                  .then(function (response) {

                  }) 
            }
            else{
              $scope.agentval = false;
            }
          }

          $scope.editagent = function(a){
            $scope.editagentdiv = true;
            $("#black-overlay").css("display","block"); 
            $scope.winper = $scope.agentdata[0].winper;
            $scope.loseper = $scope.agentdata[0].loseper;
          }

          $scope.editagentval = function(a){
            console.log($scope.winper+"/"+$scope.loseper+"/"+$scope.onoffagent);           
            if ($scope.winper == "" || $scope.loseper == "" || $scope.winper == null || $scope.loseper == null || $scope.onoffagent == null) {
              alert("Please Fill Completely.");
            }
            else{
              $http.post("query.php",{"type":"mpage", "mid":$scope.mid, "btn":"mprofile", "sub":"editagent", "winper":$scope.winper, "loseper":$scope.loseper, "onoff":$scope.onoffagent})
              .then(function (response) {
                console.log(response.data);
                $scope.mp = response.data.mp;
                $scope.agenttest = response.data.agent;
                $scope.financeid = $scope.mp[0].financeid;
                $scope.fid= $scope.financeid.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();                          
                $scope.bks = response.data.bank;
             //   $scope.bankselect = $scope.bks[0];
                 if (response.data.bankcard) {
                        $scope.bkcard = response.data.bankcard;
                    } 
                 if ($scope.agenttest == 1) {
                    $scope.agentdata = response.data.agentdata;
                    $scope.agentval = true;
                    $scope.agentdisable = true;
                    $scope.onoffagent = response.data.commission;
                 }
                alert("Success");
                $scope.cancelagentval();
              })
            }
          }

          $scope.cancelagentval = function(){
            $("#black-overlay").css("display","none");
            $scope.editagentdiv = false;
          }

           $scope.searchdate = function(a){
            //console.log($scope.datefiltertype);
              if ($scope.datefiltertype != null || $scope.datefiltertype != undefined) {
                 $scope.datesign = $scope.datefiltertype;

              if ($scope.datefiltertype == "btw") {

                    if ($scope.tFilterDate == undefined || $scope.tFilterDate == null || $scope.fFilterDate == undefined || $scope.fFilterDate == null) {
                      alert("Please Fill From Date & To Date");
                    }
                    else if (($scope.tFilterDate != undefined || $scope.tFilterDate != null) && ($scope.fFilterDate != undefined || $scope.fFilterDate != null)) {
                      $scope.fromD = $scope.fFilterDate;
                      $scope.toD = $scope.tFilterDate;
                    }
                    else{
                      $scope.fromD = "";
                      $scope.toD = "";
                    }
              }
              else if($scope.datefiltertype == ">" || $scope.datefiltertype == "<" || $scope.datefiltertype == "="){
                  if ($scope.otherdate == undefined || $scope.otherdate == null) {
                      alert("Please Fill Date");
                  }
                  else if ($scope.otherdate != undefined && $scope.otherdate != null) {
                      $scope.otherD = $scope.otherdate;
                  }
                  else{
                    $scope.otherD = "";          
                  }
              }
              else if ($scope.datefiltertype == "all") {
                $scope.otherD = "";    
                $scope.fromD = "";
                $scope.toD = "";
              }                   
              }              
              $scope.profilebetlist(a);
            }

            $scope.typechange = function(){
              if ($scope.datefiltertype == "btw") {
                $scope.otherdate = null;
                $scope.between = true;
                $scope.othertype = false;      
                $scope.searchbtn = true;      
              }
              else if ($scope.datefiltertype == ">" || $scope.datefiltertype == "<" || $scope.datefiltertype == "=") {
                $scope.fFilterDate = null;
                $scope.tFilterDate = null;
                $scope.between = false;
                $scope.othertype = true; 
                $scope.searchbtn = true;
              }
              else if ($scope.datefiltertype == "all") {
                $scope.between = false;
                $scope.othertype = false; 
                $scope.searchbtn = true;
                $scope.fFilterDate = null;
                $scope.tFilterDate = null;
                $scope.otherdate = null;
              }
              else{
                $scope.between = false;
                $scope.othertype = false; 
                $scope.searchbtn = false;
                $scope.fFilterDate = null;
                $scope.tFilterDate = null;
                $scope.otherdate = null;
              }
            }

          $scope.profilebetlist = function(a){            
              $http.post("query.php",{"type":"mpage","mid":$scope.mid,"btn":"mprofile","sub":"betlist","fromdate":$scope.fromD,"todate":$scope.toD,"otherdate":$scope.otherD, "datesign":$scope.datesign})
              .then(function (response) {
                console.log(response.data);
                $scope.allbetlist = response.data.betlist;
                if ($scope.allbetlist == "No Record") {
                  $scope.allbetlist = [];
                }
                $scope.betlistshow = true;
              })
          }

           $scope.editprofile = function(a){
              $scope.mname=a.username;
              $scope.mail = a.mail;
              $scope.ph = a.phone;
              $scope.tdate = a.dob;
              $scope.loginid = a.loginid;
              $scope.financeid = a.financeid;
              $scope.editshow=true;
           }

           $scope.changepass = function(){
              $("#cpassword").toggle("slow");
           }

           $scope.eprofile = function(){
            if ($scope.oldpass == null || $scope.oldpass == undefined) {
              $scope.errorprofile = "Please Fill Current Password";
            }
            else{
             /* $http.post("checkpass.php",{"oldpass":$scope.mp[0].password,"hashvalue":$scope.oldpass})
              .then(function (response) {
                $scope.testpass = response.data;                
              })*/

            $scope.hashpass = md5.createHash($scope.oldpass);

              if ($scope.hashpass == $scope.mp[0].password) {
                    if (($scope.pass == null || $scope.pass == "" || $scope.pass == undefined) && ($scope.conpass == null || $scope.conpass == "" || $scope.conpass == undefined)) {
                        $scope.pass = $scope.hashpass;
                    }
                    else if ($scope.pass != null && $scope.conpass != null && $scope.pass != $scope.conpass) {
                        $scope.errorprofile = "New Password & Confirm Password don't match";
                    }
                    else{
                        $scope.pass = md5.createHash($scope.pass);
                       }

                      $http.post("query.php",{"username":$scope.mname,"mid":$scope.mid,"pass":$scope.pass,"mail":$scope.mail,"dob":$scope.tdate,"ph":$scope.ph,"type":"mpage", "btn":"mprofile","sub":"edit"})
                            .then(function (response) {
                                    $scope.mp = response.data.mp;
                                    $scope.bks = response.data.bank;
                                 //   $scope.bankselect = $scope.bks[0];
                                     if (response.data.bankcard) {
                                            $scope.bkcard = response.data.bankcard;
                                        } 
                                    $scope.editshow=false;
                                    $scope.mname = null;
                                    $scope.mid = null;
                                    $scope.pass = null;
                                    $scope.conpass = null;
                                    $scope.mail = null;
                                    $scope.tdate = null;
                                    $scope.ph = null;
                                alert("Successfully Edited");
                                $scope.errorprofile = null;
                            });
                   
              } else{
                $scope.errorprofile = "Current Password isn't correct.";
              };
            }
           /* if ($scope.pass == null || $scope.pass != $scope.conpass) {
                alert("Please Enter Password and confirm password match");
            }
            else{
              $http.post("query.php",{"username":$scope.mname,"mid":$scope.mid,"pass":$scope.pass,"mail":$scope.mail,"dob":$scope.tdate,"ph":$scope.ph,"type":"mpage", "btn":"mprofile","sub":"edit"})
                    .then(function (response) {
                            $scope.mp = response.data.mp;
                            $scope.bks = response.data.bank;
                         //   $scope.bankselect = $scope.bks[0];
                             if (response.data.bankcard) {
                                    $scope.bkcard = response.data.bankcard;
                                } 
                            $scope.editshow=false;
                            $scope.mname = null;
                            $scope.mid = null;
                            $scope.pass = null;
                            $scope.conpass = null;
                            $scope.mail = null;
                            $scope.tdate = null;
                            $scope.ph = null;
                        alert("Successfully Edited");
                    });
            }*/
                    
           }

           $scope.addcard = function(){
            if ($scope.cardnum==null) {
                alert("Please Add card number");
            } else{
                $http.post("query.php",{"mid":$scope.mid,"card":$scope.cardnum, "bank":$scope.bankselect.bank_id, "type":"mpage", "btn":"mprofile", "sub":"addcard"})
                    .then(function (response) {
                            $scope.mp = response.data.mp;
                            $scope.bks = response.data.bank;
                           // $scope.bankselect = $scope.bks[0];
                             if (response.data.bankcard) {
                                    $scope.bkcard = response.data.bankcard;
                                } 
                            $scope.cardnum = null;
                            $scope.bankselect = null;
                    });
            }
                    
           }

           $scope.ecard = function(){
                  $http.post("query.php",{"bh":$scope.bankhis, "mid":$scope.mid,"card":$scope.cardnum, "bank":$scope.bankselect.bank_id, "type":"mpage", "btn":"mprofile", "sub":"ecard"})
                    .then(function (response) {
                            $scope.mp = response.data.mp;
                            $scope.bks = response.data.bank;
                         //   $scope.bankselect = $scope.bks[0];
                             if (response.data.bankcard) {
                                    $scope.bkcard = response.data.bankcard;
                                } 

                            $scope.cardnum = null;
                            $scope.bankselect = null;
                            $scope.cardbtn = true;
                        alert("Success!");
                    });
           }

           $scope.editcard = function(a){
                $scope.bankhis = a.bank_history_id;
                $scope.cardnum = a.cardnumber;
                $scope.bankselect = a;
                $scope.cardbtn = false;
           }

           $scope.delcard = function(a){
                var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"bh":a, "mid":$scope.mid, "type":"mpage", "btn":"mprofile", "sub":"delcard"})
                            .then(function (response) {
                                $scope.mp = response.data.mp;
                                $scope.bks = response.data.bank;
                                $scope.bankselect = $scope.bks[0];
                                if (response.data.bankcard) {
                                    $scope.bkcard = response.data.bankcard;
                                }else{
                                    $scope.bkcard ="";
                                }                                
                                alert("Successful Deleted");
                            });
                    }
           }
         }
         else{
          $location.path("/");
         }
        })
.controller("accgoalController", function($scope,$http) {
  if (window.localStorage.getItem("roleId")) {
  $("#wrapper").css("display","block");
    if (window.localStorage.getItem("roleId")!=3) {
              if (window.localStorage.getItem("roleId")==2) {
                $("#accmenu").css("display","block");
              }
              else if (window.localStorage.getItem("roleId")==1) {
                $("#adminmenu").css("display","block");
                $("#navbar-data1 .adminmenu").css("display","block");
              }
    
           $scope.txtcondition="";
           $scope.txttrue="";
           $scope.txtfalse="";
           $scope.txtformula="";

           $scope.formula=true;
           $scope.showagoal=true;
           $http.post("query.php",{"type":"accgoal", "btn":""})
                    .then(function (response) {
                        $scope.names = response.data.accgoal;
                        $scope.cvariables = response.data.fromula;
                        $scope.tvariables = response.data.fromula2;
                        $scope.fvariables = response.data.fromula3;
                        $scope.forvariables = response.data.fromula4;
                        $scope.cvariable =  $scope.cvariables[0];
                        $scope.tvariable= $scope.tvariables[0];
                        $scope.fvariable=$scope.fvariables[0];
                        $scope.forvariable =  $scope.forvariables[0];
                    });   
           $scope.saveagoal= function(){
            if ($scope.wholeformula == null || $scope.des == null) {
                alert("Please Fill Completely");
            } else{
                $http.post("query.php",{"des":$scope.des,"formula":$scope.wholeformula, "type":"accgoal", "btn":"save"})
                        .then(function (response) {
                            $scope.names = response.data.accgoal;
                            $scope.cvariables = response.data.fromula;
                            $scope.tvariables = response.data.fromula2;
                            $scope.fvariables = response.data.fromula3;
                            $scope.forvariables = response.data.fromula4;
                            $scope.cvariable =  $scope.cvariables[0];
                            $scope.tvariable= $scope.tvariables[0];
                            $scope.fvariable=$scope.fvariables[0];
                            $scope.forvariable =  $scope.forvariables[0];
                            alert("Successful Added");
                            $scope.des= null;
                            $scope.wholeformula = null;
                             $scope.txtcondition = null;
                             $scope.txttrue = null;
                             $scope.txtfalse = null;
                             $scope.txtformula = null;
                        });

            }
                    
            }
           $scope.delagoal = function(a){
                    var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"agid":a, "type":"accgoal", "btn":"delete"})
                            .then(function (response) {
                            $scope.names = response.data.accgoal;
                            $scope.cvariables = response.data.fromula;
                            $scope.tvariables = response.data.fromula2;
                            $scope.fvariables = response.data.fromula3;
                            $scope.forvariables = response.data.fromula4;
                            $scope.cvariable =  $scope.cvariables[0];
                            $scope.tvariable= $scope.tvariables[0];
                            $scope.fvariable=$scope.fvariables[0];
                            $scope.forvariable =  $scope.forvariables[0];
                                 alert("Successful Deleted");
                            });
                    }
           }
           $scope.editagoal = function(a,b){
                    $scope.des = a.description;
                    $scope.wholeformula = a.formula;
                    accgoalid = b;
                    $scope.showagoal=false;
           }
           $scope.eagoal = function(){
                    $http.post("query.php",{"des":$scope.des,"formula":$scope.wholeformula, "agid":accgoalid, "type":"accgoal", "btn":"edit"})
                    .then(function (response) {
                        $scope.names = response.data.accgoal;
                        $scope.cvariables = response.data.fromula;
                        $scope.tvariables = response.data.fromula2;
                        $scope.fvariables = response.data.fromula3;
                        $scope.forvariables = response.data.fromula4;
                        $scope.cvariable =  $scope.cvariables[0];
                        $scope.tvariable= $scope.tvariables[0];
                        $scope.fvariable=$scope.fvariables[0];
                        $scope.forvariable =  $scope.forvariables[0];
                         alert("Successful Edited");
                         $scope.showagoal=true;
                         $scope.des= null;
                         $scope.txtcondition = null;
                         $scope.txttrue = null;
                         $scope.txtfalse = null;
                         $scope.txtformula = null;
                         $scope.wholeformula = null;
                    });
                    
           } 

           $scope.fcondition = function(){
                    $scope.conditionset=true;
                    $scope.trueset=false;
                    $scope.falseset=false;
                    $scope.con=true;
                    $scope.tru=false;
                    $scope.fal=false;
                    $scope.formula=false;
           }

           $scope.ftrue = function(){
                    $scope.trueset=true;
                    $scope.conditionset=false;
                    $scope.falseset=false;
                    $scope.con=false;
                    $scope.tru=true;
                    $scope.fal=false;
                    $scope.formula=false;
           }

           $scope.ffalse = function(){
                    $scope.falseset=true;
                    $scope.trueset=false;
                    $scope.conditionset=false;
                    $scope.con=false;
                    $scope.tru=false;
                    $scope.fal=true;
                    $scope.formula=false;
           }

           $scope.fformula = function(){
                    $scope.formulaset=true;
                    $scope.con=false;
                    $scope.tru=false;
                    $scope.fal=false;
                    $scope.formula=true;
           }

           
           $scope.conadd = function(){
                    $scope.txtcondition += $scope.cvariable.description;
           }
           $scope.conopadd = function(){
                    $scope.txtcondition += $scope.coperator;
           }
           $scope.connumadd = function(){
                    $scope.txtcondition += $scope.cnumber;
           }
           $scope.conclear = function(){
                    $scope.txtcondition = null;
           }

           $scope.trueadd = function(){
                    $scope.txttrue += $scope.tvariable.description;
           }
           $scope.trueopadd = function(){
                    $scope.txttrue += $scope.toperator;
           }
           $scope.truenumadd = function(){
                    $scope.txttrue += $scope.tnumber;
           }
           $scope.trueclear = function(){
                    $scope.txttrue = null;
           }

           $scope.falseadd = function(){
                    $scope.txtfalse += $scope.fvariable.description;
           }
           $scope.falseopadd = function(){
                    $scope.txtfalse += $scope.foperator;
           }
           $scope.falsenumadd = function(){
                    $scope.txtfalse += $scope.fnumber;
           }
           $scope.falseclear = function(){
                    $scope.txtfalse = null;
           }

           $scope.fadd = function(){
                    $scope.txtformula += $scope.forvariable.description;
           }
           $scope.fopadd = function(){
                    $scope.txtformula += $scope.foroperator;
           }
           $scope.fornumadd = function(){
                    $scope.txtformula += $scope.fornumber;
           }
           $scope.fclear = function(){
                    $scope.txtformula = null;
           }

           $scope.finish = function(){
                    if ($scope.txtcondition!="" && $scope.txttrue!="" && $scope.txtfalse!="" ) {
                          $scope.wholeformula = $scope.txtcondition+"?"+$scope.txttrue+":"+$scope.txtfalse;
                    }
                    else if ($scope.txtformula!="" ) {
                          $scope.wholeformula = $scope.txtformula;
                    }
                    else{
                       alert("Please Fill Completely");
                    }
                    /*var a = 5;
                    var b =4;
                    alert(a==b?a*b:a+b);*/
           }
         }
         else{
          $location.path("/");
         }
       }
       else{
        $location.path("/");
       }
  })
.controller("bankController", function($scope,$http, $location) {
  
    if (window.localStorage.getItem("roleId")!=3) {
      $("#wrapper").css("display","block");
           if (window.localStorage.getItem("roleId")==2) {
            $("#accmenu").css("display","block");
          }
          else if (window.localStorage.getItem("roleId")==1) {
            $("#adminmenu").css("display","block");
            $("#navbar-data1 .adminmenu").css("display","block");
          }
      
           $scope.showbank=true;
           $http.post("query.php",{"type":"bank", "btn":""})
                    .then(function (response) {
                        $scope.names = response.data.records;
                    });   
           $scope.save= function(){
            if ($scope.bname == null) {
              alert("Please fill Bank Name");
            } else{
              $http.post("query.php",{"desc":$scope.bname, "type":"bank", "btn":"save"})
                        .then(function (response) {
                            $scope.names = response.data.records;
                            $scope.delstatus = response.data.delstatus;
                            alert("Successful");
                        });
                        $scope.bname= null;
                      }                    
            }
           $scope.delbank = function(a){
                    var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"bid":a, "type":"bank", "btn":"delete"})
                            .then(function (response) {
                                $scope.names = response.data.records;
                                $scope.delstatus = response.data.delstatus;
                                if ($scope.delstatus == "cannot") {
                                  alert("Cannot Delete. Please Check Bank Card first.")
                                }else{
                                  alert("Deleted");
                                }                                
                            });
                    }
           }
           $scope.editbank = function(a,b){
                    $scope.bname = a.description;
                    bankid = b;
                    $scope.showbank=false;
           }
           $scope.edit = function(){
                    $http.post("query.php",{"desc":$scope.bname,"bid":bankid, "type":"bank", "btn":"edit"})
                    .then(function (response) {
                        $scope.names = response.data.records;
                        alert("Edit Successful");
                    });
                    $scope.showbank=true;
                    $scope.bname=" ";
           } 
        }
        else{
          $location.path("/");
        }
        })
.controller("bankhistoryController", function($scope,$http,$location) {
  
    if (window.localStorage.getItem("roleId")!=3) {
      $("#wrapper").css("display","block");
            if (window.localStorage.getItem("roleId")==2) {
              $("#accmenu").css("display","block");
            }
            else if (window.localStorage.getItem("roleId")==1) {
              $("#adminmenu").css("display","block");
              $("#navbar-data1 .adminmenu").css("display","block");
            }
       
           $scope.showhistory=true;
           $http.post("query.php",{"type":"hbank", "btn":""})
                    .then(function (response) {
                        $scope.names = response.data.bhistory;
                        $scope.users = response.data.user;
                        $scope.banks = response.data.bank;

                        $scope.selecteduser=$scope.users[0];
                        $scope.selectedbank=$scope.banks[0];
                    });   
           $scope.save= function(){
            if ($scope.cardnumber == null) {
                alert("Please Fill Card Number");
            } else{
                $http.post("query.php",{"m":$scope.selecteduser.member_id,"b":$scope.selectedbank.bank_id,"c":$scope.cardnumber, "type":"hbank", "btn":"save"})
                        .then(function (response) {
                             $scope.names = response.data.bhistory;
                              $scope.users = response.data.user;
                              $scope.banks = response.data.bank;

                              $scope.selecteduser=$scope.users[0];
                              $scope.selectedbank=$scope.banks[0];
                              alert("Successful");
                        });
                        $scope.cardnumber= null;
            }
                    
            }
           $scope.delhistory = function(a){
                    var deleted = confirm("Are you sure to delete?");
                    if ( deleted == true) {
                            $http.post("query.php",{"hid":a, "type":"hbank", "btn":"delete"})
                            .then(function (response) {
                              $scope.names = response.data.bhistory;
                              $scope.users = response.data.user;
                              $scope.banks = response.data.bank;

                              $scope.selecteduser=$scope.users[0];
                              $scope.selectedbank=$scope.banks[0];
                              alert("Deleted");
                            });
                    }
           }
           $scope.edithistory = function(a,b){
                    $scope.cardnumber = a.cardnumber;
                    $scope.selecteduser=a;
                    $scope.selectedbank=a;
                    hbankid = b;
                    $scope.showhistory=false;
           }
           $scope.edit = function(){
                    $http.post("query.php",{"m":$scope.selecteduser.member_id,"b":$scope.selectedbank.bank_id,"c":$scope.cardnumber,"hid":hbankid, "type":"hbank", "btn":"edit"})
                    .then(function (response) {
                              $scope.names = response.data.bhistory;
                              $scope.users = response.data.user;
                              $scope.banks = response.data.bank;

                              $scope.selecteduser=$scope.users[0];
                              $scope.selectedbank=$scope.banks[0];
                              alert("Successful");
                    });
                    $scope.showhistory=true;
                    $scope.cardnumber=" ";
           } 
         }
         else{
          $location.path("/");
         }
        })
/*.directive("datepicker", function () {
        function link(scope, element, attrs,ctrl) {
            element.datepicker({
                dateFormat: "mm-dd-yy",
                onSelect :function(datetext){
                        ctrl.$setViewValue(datetext);
                        ctrl.$render();
                        scope.$apply();                    
                }
            });
        }
        return {
            require: 'ngModel',
            link: link
        };
    })*/

.directive("datepicker", function () {
        function link(scope, element, attrs,ctrl) {
            element.datepicker({
                dateFormat: "mm-dd-yy",
                 changeMonth: true, 
                  changeYear: true,
                  yearRange: "1900:c+20",
                onSelect :function(datetext){
                        ctrl.$setViewValue(datetext);
                        ctrl.$render();
                        scope.$apply();                    
                }
            });
        }
        return {
            require: 'ngModel',
            link: link
        };
    })

.controller("ttcController", function($scope,$http, $location) {
  
    if (window.localStorage.getItem("roleId")==1) {
      $("#wrapper").css("display","block");
      $("#adminmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","block");
       
    $scope.newdata=false;
    $scope.tacid=0;
    $http.post("query.php",{"type":"ttc", "btn":""})
                    .then(function (response) {
                      if (response.data.tacs!="No Record") {
                         $scope.header = response.data.tacs[0].header;
                        $scope.bodies = response.data.tacs[0].body;
                        $scope.footer = response.data.tacs[0].footer;
                         $scope.tacid=response.data.tacs[0].tacid;
                        $scope.newdata=true;
                      };
                    }); 
    $scope.ttc=function(){
      if ($scope.newdata) {
         $http.post("query.php",{ "type":"ttc", "btn":"edit","tacid": $scope.tacid,"h":$scope.header,"b":$scope.bodies,"f":$scope.footer})
                    .then(function (response) {
                      if (response.data.tacs!="No Record") {
                        alert("Edit Successful");
                         $scope.header = response.data.tacs[0].header;
                        $scope.bodies = response.data.tacs[0].body;
                        $scope.footer = response.data.tacs[0].footer;
                         $scope.tacid=response.data.tacs[0].tacid;
                        $scope.newdata=true;
                      };
                      
                    });
      }
      else{
        $http.post("query.php",{ "type":"ttc", "btn":"save","h":$scope.header,"b":$scope.bodies,"f":$scope.footer})
                    .then(function (response) {
                        if (response.data.tacs!="No Record") {
                          alert("Save Successful");
                         $scope.header = response.data.tacs[0].header;
                        $scope.bodies = response.data.tacs[0].body;
                        $scope.footer = response.data.tacs[0].footer;
                         $scope.tacid=response.data.tacs[0].tacid;
                        $scope.newdata=true;
                      };
                    });
             }           
    }
  }
  else{
    $location.path("/");
  }
})
.controller("tandcController", function($scope,$http) {
  
  //  if (window.localStorage.getItem("roleId")!=3) {
      $("#wrapper").css("display","block");
      

      if (window.localStorage.getItem("roleId")!=3) {
                   if (window.localStorage.getItem("roleId")==2) {
                    $("#accmenu").css("display","block");
                  }
                  else if (window.localStorage.getItem("roleId")==1) {
                    $("#adminmenu").css("display","block");
                    $("#navbar-data1 .adminmenu").css("display","block");
                  }
                    $("#header").css("display","block");
                    $("#wrapper").css("display","block");
                 //     $("#adminmenu").css("display","block");
                      $("#mmenu").css("display","none");
                 //     $("#navbar-data1 .adminmenu").css("display","block");
                      $("#navbar-data1 .mmenu").css("display","none");
                    }
                    else if(window.localStorage.getItem("roleId")==3){
                      $("#header").css("display","block");
                      $("#wrapper").css("display","block");
                        $("#adminmenu").css("display","none");
                        $("#mmenu").css("display","block");
                        $("#navbar-data1 .adminmenu").css("display","none");
                        $("#navbar-data1 .mmenu").css("display","block");                       
                    }
                    else{
                      $("#header").css("display","none");
                    $("#wrapper").css("display","none");
                      $("#adminmenu").css("display","none");
                      $("#mmenu").css("display","none");
                      $("#navbar-data1 .adminmenu").css("display","none");
                      $("#navbar-data1 .mmenu").css("display","none");
                    }
       
    $http.post("query.php",{"type":"ttc", "btn":""})
                    .then(function (response) {
                      if ( response.data.tacs!="No Record") {
                         $scope.hdata = response.data.tacs[0].header;
                        $scope.bdata = response.data.tacs[0].body;
                        $scope.fdata = response.data.tacs[0].footer;
                      };                      
                    }); 
   //   }
})
.controller("alluserController", function($scope,$http,$location, Excel,$timeout) {
  if (window.localStorage.getItem("roleId")) {
    $("#wrapper").css("display","block");
       if (window.localStorage.getItem("roleId")!=3) {
          if (window.localStorage.getItem("roleId")==2) {
                    $("#accmenu").css("display","block");
                    $scope.adshow=2;
                  }
                  else if (window.localStorage.getItem("roleId")==1) {
                    $("#adminmenu").css("display","block");
                    $("#navbar-data1 .adminmenu").css("display","block");
                    $scope.adshow=1;
                  }
                  $scope.junjun = [];
                  $scope.onoffarr = [];
                  $scope.onoffarray=[{onoff_id:"1",onoff_name:"Login OFF",onoff_type:"loginonoff"},
                  {onoff_id:"2",onoff_name:"BG Betting OFF",onoff_type:"bettingonoff"},
                  {onoff_id:"3",onoff_name:"Mix OFF",onoff_type:"mixbettingonoff"},
                  {onoff_id:"4",onoff_name:"Deposit OFF",onoff_type:"depositonoff"},
                  {onoff_id:"5",onoff_name:"Withdraw OFF",onoff_type:"withdrawonoff"},
                  {onoff_id:"6",onoff_name:"Transfer OFF",onoff_type:"transferonoff"},
                  {onoff_id:"7",onoff_name:"Commission OFF",onoff_type:"commissiononoff"}];

                  homefun();                               

                  $scope.exportToExcel=function(tableId){ // ex: '#my-table'
                    var exportHref=Excel.tableToExcel(tableId,'Alluser');
                    $timeout(function(){location.href=exportHref;},100); // trigger download
                }

                      /*$scope.init = function(){
                        $scope.status = true;
                      }*/
                      
                      /*$scope.changeStatus = function(){
                        console.log($scope.status);
                        $scope.status = !$scope.status;
                      }*/

                      $scope.funonoff = function(a,b){
                        $("#whiteoverlay").css("display","block");
                        $("#black-overlay").css("display","block");      
                        $scope.thismemberid = a;  
                        $scope.thismembername = b;  
                      //  console.log(b);
                         $http.post("query.php",{"type":"onoff", "btn":"search", "mid":a})
                          .then(function (response) {
                            $scope.totaloff = response.data.totaloff;
                            $scope.onoffdata = response.data.onoffdata;
                            if ($scope.onoffdata != "No Record") {
                              for (var i = $scope.onoffdata.length - 1; i >= 0; i--) {
                                $scope.onoffarr[$scope.onoffdata[i].onofftype] = true;
                              };
                            };
                            
                          })
                      }

                      $scope.allfunonoff = function(){
                        $("#whiteoverlayall").css("display","block");
                        $("#black-overlay").css("display","block"); 
                        $scope.thismemberid = 0;

                        $http.post("query.php",{"type":"onoff", "btn":"search", "mid":0})
                          .then(function (response) {
                            $scope.totaloff = response.data.totaloff;
                            $scope.onoffdata = response.data.onoffdata;
                            if ($scope.onoffdata != "No Record") {
                              for (var i = $scope.onoffdata.length - 1; i >= 0; i--) {
                                $scope.onoffarr[$scope.onoffdata[i].onofftype] = true;
                              };
                            };
                            
                          })
                      }

                      $scope.closefun = function(){
                        $("#whiteoverlay").css("display","none");
                        $("#whiteoverlayall").css("display","none");
                        $("#black-overlay").css("display","none");  
                        $scope.onoffarr = [];
                      }

                      $scope.changeonoff = function(){
                        $("#whiteoverlay").css("display","none");
                        $("#whiteoverlayall").css("display","none");
                        $("#black-overlay").css("display","none");    

                        var ar = $scope.onoffarray.filter(
                        function (value) {
                          if ($scope.onoffarr[value.onoff_type] == true) {
                            return true;
                          } else {
                            return false;
                          }
                        }
                        );

                        $http.post("query.php",{"type":"onoff", "btn":"save", "arraydata":ar, "mid":$scope.thismemberid})
                          .then(function (response) {
                            $scope.totaloff = response.data.totaloff;
                            $scope.onoffarr = []; 
                            $scope.closefun();
                            alert(response.data.successmsg);
                          })
                  
                      }                      

                $scope.transferOff = function(a,b){
                  if (a == 1) {
                    $http.post("query.php",{"type":"alluser", "btn":"tranoff", "off":1, "mid":b})
                    .then(function (response) {
                      $scope.alluser = response.data.alluser;
                      alert("Transfer OFF to this member.");
                    })             
                    
                  }
                  else if(a == 0){
                    $http.post("query.php",{"type":"alluser", "btn":"tranoff", "off":0, "mid":b})
                    .then(function (response) {
                      $scope.alluser = response.data.alluser;
                      alert("Transfer ON to this member.");
                    })                 

                  }
                  
                }

                $scope.alluserdel = function(a){
                  var c = confirm("Are you sure to delete Member ["+a.username+"]?");
                  if (c == true) {
                    $http.post("query.php",{"type":"alluser", "btn":"del", "mbrid":a.member_id})
                    .then(function (response) {
                      console.log(response.data);
                      $scope.alldata = response.data;
                      $scope.alluser = response.data.alluser;
                      $scope.allmembers = $scope.alluser.length;
                      $scope.cannot = response.data.cannot;

                      if ($scope.cannot != "") {
                        alert($scope.cannot);
                      }
                      else{
                        alert("Deleted");
                      }

                      var amttotal = 0;
                      
                        for (var i = $scope.alluser.length - 1; i >= 0; i--) {
                          amttotal += parseInt($scope.alluser[i].amount);                         
                        }
                        $scope.amounttotal = amttotal;                      
                    })
                  }                  
                }
                 
        
                }

  }
  else{
    $location.path("/");
  }
function homefun(){
                    $http.post("query.php",{"type":"alluser", "btn":""})
                    .then(function (response) {
                            $scope.alldata = response.data;
                            $scope.alluser = response.data.alluser;
                            $scope.totaloff = response.data.totaloff;
                            $scope.allmembers = $scope.alluser.length;
                            var amttotal = 0;
                            
                              for (var i = $scope.alluser.length - 1; i >= 0; i--) {
                                amttotal += parseInt($scope.alluser[i].amount);
                                if ($scope.alluser[i].tranoff == 1) {
                                  console.log($scope.alluser[i].tranoff);
                                  $scope.junjun[$scope.alluser[i].loginid] = 1; 
                                  console.log($scope.junjun[$scope.alluser[i].loginid]);
                                }                               
                              }
                              $scope.amounttotal = amttotal;
                          

                  });
                  }
 })
.controller("backupdataController", function($scope,$http,$location, $filter) {
  

    //$scope.db = (new Date).toLocaleFormat("HH:mm:ss");
    $scope.db = $filter('date')(Date.now(), 'HHmmss');
    //$scope.dbdb = $filter('date')(new Date(), 'HH:mm:ss');
    if (window.localStorage.getItem("roleId")==1) {
      if (window.localStorage.getItem("roleId")) {
    $("#wrapper").css("display","block");
    $scope.d = new Date();
   var month=$scope.d.getMonth()+1;
    if (month<10){
    month="0" + month;
    };
    var dday = $scope.d.getDate();
    if (dday<10){
    dday="0" + dday;
    };
    $scope.todayval = month+dday+$scope.d.getFullYear();
          $("#adminmenu").css("display","block");
          $("#navbar-data1 .adminmenu").css("display","block");
          $scope.dbname = "football"+$scope.todayval+$scope.db;
          $scope.dblink = $scope.dbname+".sql";
                  $http.post("backupdata.php",{"ddd":$scope.dblink})
                  .then(function (response) {
                           $scope.alldata = response.data;
                }); 
        }       
        alert("Backup Data Successfully.");
   // $location.path("/");
  }
  else{
    $location.path("/");
  }

 })
.factory('Excel',function($window){
        var uri='data:application/vnd.ms-excel;base64,',
            template='<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="https://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body style="font-size:16px; font-family:zawgyi1;" ><table>{table}</table></body></html>',
            base64=function(s){return $window.btoa(unescape(encodeURIComponent(s)));},
            format=function(s,c){return s.replace(/{(\w+)}/g,function(m,p){return c[p];})};
        return {
            tableToExcel:function(tableId,worksheetName){
                var table=$(tableId),
                    ctx={worksheet:worksheetName,table:table.html()},
                    href=uri+base64(format(template,ctx));
                return href;
            }
        };
    })
.controller("transferlimitController", function($scope,$http, $location) {
  
    if (window.localStorage.getItem("roleId")==1) {
      $("#wrapper").css("display","block");
      $("#adminmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","block");
      $scope.tlimitedit = true;
           $http.post("query.php",{"type":"tranlimit", "btn":"","limittype":"transfer"})
                    .then(function (response) {
                      console.log(response.data);
                      $scope.alldata = response.data;
                        $scope.names = response.data.tlimit;
                    });   
           
           $scope.editbank = function(a){
              $scope.tlimitedit = false;
                    $scope.tranlimit = a.amount;
           }
           $scope.editlimit = function(){
              if ($scope.tranlimit != null && $scope.tranlimit != "") {
                $http.post("query.php",{ "type":"tranlimit", "btn":"edit", "limitdata":$scope.tranlimit, "limittype":"transfer"})
                    .then(function (response) {
                      console.log(response.data);
                      $scope.alldata = response.data;
                        $scope.names = response.data.tlimit;
                        alert("Edit Successful");
                    });
                    $scope.tranlimit=null;
                    $scope.tlimitedit = true;
              }
              else{
                alert("Please Fill Completely.");
                $scope.tlimitedit = false;
              }
                    
           } 
        }
        else{
          $location.path("/");
        }
})

.controller("depositelimitController", function($scope,$http, $location) {
  
    if (window.localStorage.getItem("roleId")==1) {
      $("#wrapper").css("display","block");
      $("#adminmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","block");
      $scope.tlimitedit = true;
           $http.post("query.php",{"type":"tranlimit", "btn":"","limittype":"deposite"})
                    .then(function (response) {
                      $scope.alldata = response.data;
                        $scope.names = response.data.tlimit;
                    });   
           
           $scope.editbank = function(a){
                    $scope.tlimitedit = false;
                    $scope.minlimit = a.min;
                    $scope.maxlimit = a.max;
           }
           $scope.editlimit = function(){
            if ($scope.minlimit != null && $scope.maxlimit != null) {
               $http.post("query.php",{ "type":"tranlimit", "btn":"edit", "min":$scope.minlimit, "max":$scope.maxlimit, "limittype":"deposite"})
                .then(function (response) {
                  console.log(response.data);
                  $scope.alldata = response.data;
                    $scope.names = response.data.tlimit;
                    alert("Edit Successful");
                });
                $scope.minlimit = null;
                $scope.maxlimit = null;
                $scope.tlimitedit = true;
            }
            else{
              alert("Please Fill Completely.");
              $scope.tlimitedit = false;
            }                   
           } 
        }
        else{
          $location.path("/");
        }
})

.controller("withdrawlimitController", function($scope,$http, $location) {
  
    if (window.localStorage.getItem("roleId")==1) {
      $("#wrapper").css("display","block");
      $("#adminmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","block");
      $scope.tlimitedit = true;
           $http.post("query.php",{"type":"tranlimit", "btn":"","limittype":"withdraw"})
                    .then(function (response) {
                      $scope.alldata = response.data;
                        $scope.names = response.data.tlimit;
                    });   
           
           $scope.editbank = function(a){
                    $scope.tlimitedit = false;
                    $scope.minlimit = a.min;
                    $scope.maxlimit = a.max;
           }
           $scope.editlimit = function(){
            if ($scope.minlimit != null && $scope.maxlimit != null) {
               $http.post("query.php",{ "type":"tranlimit", "btn":"edit", "min":$scope.minlimit, "max":$scope.maxlimit, "limittype":"withdraw"})
                .then(function (response) {
                  console.log(response.data);
                  $scope.alldata = response.data;
                    $scope.names = response.data.tlimit;
                    alert("Edit Successful");
                });
                $scope.minlimit = null;
                $scope.maxlimit = null;
                $scope.tlimitedit = true;
            }
            else{
              alert("Please Fill Completely.");
              $scope.tlimitedit = false;
            }                   
           } 
        }
        else{
          $location.path("/");
        }
})

.controller("infosetupController", function($scope,$http, $location) {
  
    if (window.localStorage.getItem("roleId")==1) {
      $("#wrapper").css("display","block");
      $("#adminmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","block");
       
    $scope.newdata=false;
    $scope.infoid=0;
    $http.post("query.php",{"type":"info", "btn":""})
                    .then(function (response) {
                      if (response.data.infodata!="No Record") {
                         $scope.header = response.data.infodata[0].header;
                        $scope.bodies = response.data.infodata[0].body;
                        $scope.footer = response.data.infodata[0].footer;
                         $scope.infoid=response.data.infodata[0].infoid;
                        $scope.newdata=true;
                      };
                    }); 
    $scope.infoedit=function(){
      if ($scope.newdata) {

         $http.post("query.php",{ "type":"info", "btn":"edit","info": $scope.infoid,"h":$scope.header,"b":$scope.bodies,"f":$scope.footer})
                    .then(function (response) {
                      if (response.data.infodata!="No Record") {
                        alert("Edit Successful");
                        $scope.alldata = response.data;
                         $scope.header = response.data.infodata[0].header;
                        $scope.bodies = response.data.infodata[0].body;
                        $scope.footer = response.data.infodata[0].footer;
                         $scope.infoid=response.data.infodata[0].infoid;
                        $scope.newdata=true;
                      };
                      
                    });
      }
      else{
        $http.post("query.php",{ "type":"info", "btn":"save","h":$scope.header,"b":$scope.bodies,"f":$scope.footer})
                    .then(function (response) {
                        if (response.data.infodata!="No Record") {
                          $scope.alldata = response.data;
                          alert("Save Successful");
                         $scope.header = response.data.infodata[0].header;
                        $scope.bodies = response.data.infodata[0].body;
                        $scope.footer = response.data.infodata[0].footer;
                         $scope.infoid=response.data.infodata[0].infoid;
                        $scope.newdata=true;
                      };
                    });
             }           
    }
  }
  else{
    $location.path("/");
  }
})

.controller("infoController", function($scope,$http) {
  
  //  if (window.localStorage.getItem("roleId")!=3) {
      $("#wrapper").css("display","block");
      

      if (window.localStorage.getItem("roleId")!=3) {
                   if (window.localStorage.getItem("roleId")==2) {
                    $("#accmenu").css("display","block");
                  }
                  else if (window.localStorage.getItem("roleId")==1) {
                    $("#adminmenu").css("display","block");
                    $("#navbar-data1 .adminmenu").css("display","block");
                  }
                    $("#header").css("display","block");
                    $("#wrapper").css("display","block");
                 //     $("#adminmenu").css("display","block");
                      $("#mmenu").css("display","none");
                 //     $("#navbar-data1 .adminmenu").css("display","block");
                      $("#navbar-data1 .mmenu").css("display","none");
                    }
                    else if(window.localStorage.getItem("roleId")==3){
                      $("#header").css("display","block");
                      $("#wrapper").css("display","block");
                        $("#adminmenu").css("display","none");
                        $("#mmenu").css("display","block");
                        $("#navbar-data1 .adminmenu").css("display","none");
                        $("#navbar-data1 .mmenu").css("display","block");                       
                    }
                    else{
                      $("#header").css("display","none");
                    $("#wrapper").css("display","none");
                      $("#adminmenu").css("display","none");
                      $("#mmenu").css("display","none");
                      $("#navbar-data1 .adminmenu").css("display","none");
                      $("#navbar-data1 .mmenu").css("display","none");
                    }
       
    $http.post("query.php",{"type":"info", "btn":""})
                    .then(function (response) {
                      if ( response.data.infodata!="No Record") {
                         $scope.hdata = response.data.infodata[0].header;
                        $scope.bdata = response.data.infodata[0].body;
                        $scope.fdata = response.data.infodata[0].footer;
                      };                      
                    }); 
   //   }
})

.controller("resetpassController", function($scope, $http){
   if (window.localStorage.getItem("roleId")==1) {
      $("#wrapper").css("display","block");
      $("#adminmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","block");

      $http.post("query.php",{ "type":"resetpass", "btn":""})
      .then(function (response) {
        $scope.alldata = response.data;
        $scope.allmembers = response.data.allmembers;
      })

      $scope.resetpass = function(a){
        $scope.mbrname = a.username;
        $scope.mbrloginid = a.loginid;
        $scope.mid = a.member_id;
        $scope.mbrmail = a.mail;
        $("#whiteoverlay").css("display","block");
        $("#black-overlay").css("display","block");
      }

      $scope.resetfun = function(){     
        $("#whiteoverlay").css("display","none");
        $("#black-overlay").css("display","none");   
        $http.post("query.php",{ "type":"resetpass", "btn":"reset", "pass":$scope.repass, "mid":$scope.mid})
        .then(function (response) {
          $scope.alldata = response.data;
          $scope.allmembers = response.data.allmembers;
          alert("Successfully Reset!");
        })
      }

      $scope.cancelfun = function(){
        $("#whiteoverlay").css("display","none");
        $("#black-overlay").css("display","none");
      }

      $scope.match=function(){
                if ($scope.repass==$scope.conpass) {
                        $scope.IsMatch=false;
                        return false;
                }
                else   
                {
                    $scope.IsMatch=true;
                }
            }
    }
  else{
    $location.path("/");
  }
})

.controller("historyController", function($scope, $http, Excel, $routeParams, $timeout){
   if (window.localStorage.getItem("roleId")==1) {
      $("#wrapper").css("display","block");
      $("#adminmenu").css("display","block");
      $("#navbar-data1 .adminmenu").css("display","block");

        if ($routeParams.hisid) {
          console.log($routeParams.hisid);
            $http.post("query.php",{ "type":"allhistory", "btn":"", "hisid":$routeParams.hisid})
            .then(function (response) {
              $scope.alldata = response.data;
              $scope.allhistory = response.data.allhistory;
              console.log(response.data);
            })

          $scope.exportToExcel=function(tableId){ // ex: '#my-table'
              var exportHref=Excel.tableToExcel(tableId,'History');
              $timeout(function(){location.href=exportHref;},100); // trigger download
          }

        }
        else{
          $location.path("/");
        }
    }
    else{
      $location.path("/");
    }

})
.controller("agentuserlistController", function($scope, $http, Excel, $routeParams, $timeout, $location){
   if (window.localStorage.getItem("roleId")==1 || window.localStorage.getItem("roleId")==3) {
      if (window.localStorage.getItem("roleId")==1) {
        $("#wrapper").css("display","block");
        $("#adminmenu").css("display","block");
        $("#navbar-data1 .adminmenu").css("display","block");  
        if ($routeParams.mid) {
          $scope.mid = $routeParams.mid;
          $scope.hidecard = true;
          $http.post("query.php",{ "type":"agentuserlist", "btn":"", "mid":$routeParams.mid})
            .then(function (response) {
              $scope.alldata = response.data;
              $scope.auser = response.data.agentuserlist;
              console.log(response.data);
          })
        }   
        else{
          $location.path("/");
        }       
      }
      else if (window.localStorage.getItem("roleId")==3) {
        if(window.localStorage.getItem("agentId")){
            $("#header").css("display","block");
            $("#wrapper").css("display","block");
            $("#adminmenu").css("display","none");
            $("#mmenu").css("display","block");
            $("#navbar-data1 .adminmenu").css("display","none");
            $("#navbar-data1 .mmenu").css("display","block");
            $scope.mid = window.localStorage.getItem("userId");
            $scope.hidecard = false;
            $http.post("query.php",{ "type":"agentuserlist", "btn":"", "mid":window.localStorage.getItem("userId")})
              .then(function (response) {
                $scope.alldata = response.data;
                $scope.auser = response.data.agentuserlist;
                console.log(response.data);
            })
          }
          else{
            $location.path("/");
          }
      }
   }
   else{
    $location.path("/");
   }
 })

.controller("agentuserbetController", function($scope, $http, Excel, $routeParams, $timeout, $location){
   if (window.localStorage.getItem("roleId")==1 || window.localStorage.getItem("roleId")==3) {
      if (window.localStorage.getItem("roleId")==1) {
        
        $("#wrapper").css("display","block");
        $("#adminmenu").css("display","block");
        $("#navbar-data1 .adminmenu").css("display","block");  
        if ($routeParams.mbrid && $routeParams.agid) {
          $scope.mbrid = $routeParams.mbrid;
          $scope.agid = $routeParams.agid;
          $scope.hidecard = true;
          $scope.mixledgertable = false;     
          maindata("bg"); 

          $scope.bgcall = function(){
            $scope.mixledgertable = false;
            maindata("bg");
          }

          $scope.mixcall = function(){
            $scope.mixledgertable = true;
            maindata("mix");
          }         

        }   
        else{
          $location.path("/");
        }       
      }
      else if (window.localStorage.getItem("roleId")==3) {
        if(window.localStorage.getItem("agentId")){
            $("#header").css("display","block");
            $("#wrapper").css("display","block");
            $("#adminmenu").css("display","none");
            $("#mmenu").css("display","block");
            $("#navbar-data1 .adminmenu").css("display","none");
            $("#navbar-data1 .mmenu").css("display","block");
             if ($routeParams.mbrid) {
              $scope.mbrid = $routeParams.mbrid;
                $scope.hidecard = false;
                $scope.mixledgertable = false;
                maindata1("bg");

                $scope.bgcall = function(){
                  $scope.mixledgertable = false;
                  maindata1("bg");
                }

                $scope.mixcall = function(){
                  $scope.mixledgertable = true;
                  maindata1("mix");
                }
            }
          }
          else{
            $location.path("/");
          }
      }
   }
   else{
    $location.path("/");
   }

   function maindata(aa){
            $http.post("query.php",{ "type":"agentuserbet", "btn":aa, "mbrid":$routeParams.mbrid, "agid":$scope.agid})
              .then(function (response) {
                console.log(response.data);
                $scope.alldata = response.data;
                if (response.data.betlist == "No Record") {
                      $scope.betlist = "";
                    }
                    else{
                      $scope.betlist = response.data.betlist;
                    }
            })
          }

   function maindata1(aa){
            $http.post("query.php",{ "type":"agentuserbet", "btn":aa, "mbrid":$scope.mbrid, "agid":window.localStorage.getItem("userId")})
                  .then(function (response) {
                    console.log(response.data);
                    $scope.alldata = response.data;
                    
                    if (response.data.betlist == "No Record") {
                      $scope.betlist = "";
                    }
                    else{
                      $scope.betlist = response.data.betlist;
                    }
                })
          }
 })
;