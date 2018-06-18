angular.module('myApp', ['ngMessages','ngRoute','controller','ngSanitize','angular.filter','textAngular','ngMd5'])
.config(function($routeProvider) {             
            $routeProvider.when('/', {
            	templateUrl : "dash.php",
            	controller: 'DashCtrl'
            }).when('/accdash', {
                templateUrl:'dashcreate.php',
                controller: 'accdashController'
            }).when('/home', {
            	templateUrl:'home1.php',
            	controller: 'homeController'
            }).when('/timetable', {
                templateUrl:'timetable-setup.php',
                controller: 'timeController'
            }).when('/logout', {
                 templateUrl: 'dash.php',
                 controller: 'logoutController'
            }).when('/bank', {
                templateUrl:'bank_setup.php',
                controller: 'bankController'
            }).when('/bankhistory', {
                templateUrl:'bank_history_setup.php',
                controller: 'bankhistoryController'
            }).when('/team', {
            	templateUrl:'team-setup.php',
            	controller: 'teamController'
            }).when('/score', {
                templateUrl:'score-setup.php',
                controller: 'scoreController'
            }).when('/league', {
                templateUrl:'league-setup.php',
                controller: 'leagueController'
            }).when('/mix', {
                templateUrl:'mix_setup.php',
                controller: 'mixController'
            }).when('/goal', {
                templateUrl:'goal-setup.php',
                controller: 'goalController'
            }).when('/member', {
                templateUrl:'m-setup.php',
                controller: 'memberController'
            }).when('/body', {
                templateUrl:'body-setup.php',
                controller: 'bodyController'
            }).when('/user', {
                templateUrl:'user-setup.php',
                controller: 'userController'
            }).when('/mhome', {
                templateUrl:'mhome.php',
                controller: 'mhomeController'
            }).when('/mhome/:datevalue/:mbrid', {
                templateUrl:'mhome.php',
                controller: 'mhomeController'
            }).when('/mhome/:datevalue/:mbrid/:mix', {
                templateUrl:'mhome.php',
                controller: 'mhomeController'
            }).when('/mcreate', {
                templateUrl:'m-create.php',
                controller: 'mcreateController'
            }).when('/userlist', {
                templateUrl:'userlist.php',
                controller: 'userlistController'
            }).when('/userlist/:pagetype', {
                templateUrl:'userlist.php',
                controller: 'userlistController'
            }).when('/accgoal', {
                templateUrl:'accgold_setup.php',
                controller: 'accgoalController'
            }).when('/accbody', {
                templateUrl:'accbodies-setup.php',
                controller: 'accbodyController'
            }).when('/profile', {
                templateUrl:'mprofile.php',
                controller: 'mprofileController'
            }).when('/profile/:mid', {
                templateUrl:'mprofile.php',
                controller: 'mprofileController'
            }).when('/mledger', {
                templateUrl:'mledger.php',
                controller: 'mledgerController'
            }).when('/mledger/:mid', {
                templateUrl:'mledger.php',
                controller: 'mledgerController'
            }).when('/allledger', {
                templateUrl:'allledger.php',
                controller: 'allledgerController'
            }).when('/deposite/:datevalue/:typevalue', {
                templateUrl:'deposite.php',
                controller: 'depositeController'
            }).when('/deposite', {
                templateUrl:'deposite.php',
                controller: 'depositeController'
            }).when('/withdraw/:datevalue/:typevalue', {
                templateUrl:'withdraw.php',
                controller: 'withdrawController'
            }).when('/withdraw', {
                templateUrl:'withdraw.php',
                controller: 'withdrawController'
            }).when('/transfer/:datevalue/:typevalue', {
                templateUrl:'transfer.php',
                controller: 'transferController'
            }).when('/transfer/', {
                templateUrl:'transfer.php',
                controller: 'transferController'
            }).when('/tandcsetup/', {
                templateUrl:'terms.php',
                controller: 'transferController'
            }).when('/term', {
                templateUrl:'tac_setup.php',
                controller: 'ttcController'
            }).when('/tandc', {
                templateUrl:'tandc.php',
                controller: 'tandcController'
            }).when('/allusr', {
                templateUrl:'alluserlist.php',
                controller: 'alluserController'
            }).when('/backupdata', {
                templateUrl : "backup.php",
                controller: 'backupdataController'
            }).when('/transferlimit', {
                templateUrl : "transferlimit.php",
                controller: 'transferlimitController'
            }).when('/depositelimit', {
                templateUrl : "depositelimit.php",
                controller: 'depositelimitController'
            }).when('/withdrawlimit', {
                templateUrl : "withdrawlimit.php",
                controller: 'withdrawlimitController'
            }).when('/infosetup', {
                templateUrl:'info_setup.php',
                controller: 'infosetupController'
            }).when('/info', {
                templateUrl:'info.php',
                controller: 'infoController'
            }).when('/resetpass', {
                templateUrl:'resetpass.php',
                controller: 'resetpassController'
            }).when('/mixbetlist', {
                templateUrl:'mixbetlist.php',
                controller: 'mixbetlistController'
            }).when('/mixdetail/:dashid', {
                templateUrl:'mixdetail.php',
                controller: 'mixdetailController'
            }).when('/mixledger/', {
                templateUrl:'mix_ledger.php',
                controller: 'mixledgerController'
            }).when('/bgledger/', {
                templateUrl:'bg_ledger.php',
                controller: 'bgledgerController'
            }).when('/viewhistory/:hisid', {
                templateUrl:'history.php',
                controller: 'historyController'
            }).when('/agentuserlist/:mid', {
                templateUrl:'agentuserlist.php',
                controller: 'agentuserlistController'
            }).when('/agentuserlist/', {
                templateUrl:'agentuserlist.php',
                controller: 'agentuserlistController'
            }).when('/agentuserbet/:mbrid/:agid', {
                templateUrl:'agentuserbet.php',
                controller: 'agentuserbetController'
            }).when('/detailledger/', {
                templateUrl:'detail_ledger.php',
                controller: 'detailledgerController'
            }).when('/usertypesetup/', {
                templateUrl:'usertypesetup.php',
                controller: 'usertypesetupController'
            }).when('/yearchange/', {
                templateUrl:'yearchange.php',
                controller: 'yearchangeController'
            }).when('/cputest/', {
                templateUrl:'cputest.php',
                controller: 'cpuController'
            }).otherwise({
                redirectTo: "/"
            });
});