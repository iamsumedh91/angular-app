// MODULE
var angularApp = angular.module('angularApp', ['ngRoute', 'ngCookies']);

angularApp.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider){
    $locationProvider.hashPrefix('');

    // Providing Routes.
    $routeProvider
    .when('/register', {
        templateUrl: 'register/views/signup.html',
        controller: 'signupCntrl'
    })
    .when('/login', {
        templateUrl: 'authentication/views/login.html',
        controller: 'loginCntrl'
    })
    .when('/home', {
        templateUrl: 'home/views/home.html',
        controller: 'loginCntrl'
    }).otherwise({redirectTo: '/home'});
}]);
// Default Run
angularApp.run(['$rootScope', '$location', '$cookieStore', '$http', '$window',
    function ($rootScope, $location, $cookieStore, $http, $window) {

        if($cookieStore.get('globals'))
        {
            $rootScope.globals = $cookieStore.get('globals') || {};
        }
        else
        {
            $rootScope.globals = {};
        }

        if($cookieStore.get('user'))
        {
            $rootScope.signup_message = $cookieStore.get('user') || {};
        }
        else
        {
            $rootScope.signup_message = {};
        }
        
        window.onbeforeunload = function () {
            $cookieStore.remove('user');
    };
}]);

// CONTROLLERS

/*
* Menus Controller
*/
angularApp.controller('Home', function($scope, $http, $window, $rootScope, $cookieStore) {
      
      // Initialising the variable.
      $scope.menus = [];
    
      // Getting the list of menus.
      $http({
        method : "GET",
        url : "http://localhost/login/test_user/rest/get_menu"
      }).then(function mySuccess(response) {
        $scope.menus = response.data;
        });

        /*
        * Function to logout the user.
        */
        $scope.logoutUser = function(){

        window.location.href= "http://localhost/login/#/home";

        /*
        * Unsetting Login Credentials
        */
        $rootScope.globals = {};
        $rootScope.signup_message = {};
        $cookieStore.remove('globals');
        $cookieStore.remove('user');
    }
});