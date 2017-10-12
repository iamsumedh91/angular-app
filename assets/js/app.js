// MODULE
var angularApp = angular.module('angularApp', ['ngRoute', 'ngCookies']);

angularApp.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider){
    $locationProvider.hashPrefix('');

    // Providing Routes.
    $routeProvider
    .when('/register/views', {
        templateUrl: 'register/views/signup.html',
        controller: 'signupCntrl'
    })
    .when('/authentication/views', {
        templateUrl: 'authentication/views/login.html',
        controller: 'loginCntrl'
    })
    .when('/home/views', {
        templateUrl: 'home/views/home.html',
        controller: 'loginCntrl'
    })
}]);

angularApp.run(['$rootScope', '$location', '$cookieStore', '$http',
    function ($rootScope, $location, $cookieStore, $http) {

        if($cookieStore.get('globals'))
        {
            $rootScope.globals = $cookieStore.get('globals') || {};
        }
        else
        {
            $rootScope.globals = {};
        }

}]);

// CONTROLLERS

/*
* Signup Controller
*/
angularApp.controller('signupCntrl', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {

    /*
    * Initializing values
    */
    $scope.name1 = "name";

    $scope.name = "";
    
    $scope.username = "";
    
    $scope.password = "";

    $scope.confirm_password = "";
    
    $scope.gender = "";

    $scope.address = "";
    
    $scope.email = "";

    $scope.mobile = "";

    $scope.pincode = "";

    $scope.occupation = "";

    $scope.dateofbirth = "";

    $scope.login_username = "";

    $scope.login_password = "";

    /*
    * Adding Users
    */
    $scope.addUser = function(){
        
        /*
        * Sending values from the Form
        */
        $http.post('http://localhost/test_user/rest/signup', {name: $scope.name, username: $scope.username, password: $scope.password, 
            gender: $scope.gender, address: $scope.address, email: $scope.email, 
            mobile: $scope.mobile, pincode: $scope.pincode, occupation: $scope.occupation, dateofbirth: $scope.dateofbirth})
        .then(function(result){
            $scope.new = result.data;
            console.log($scope.new);
    
            /*
            * Resetting the values in form.
            */
            $scope.name = "";
    
            $scope.username = "";
    
            $scope.password = "";

            $scope.confirm_password = "";
    
            $scope.gender = "";

            $scope.address = "";
    
            $scope.email = "";

            $scope.mobile = "";

            $scope.pincode = "";

            $scope.occupation = "";

            $scope.dateofbirth = "";
        })
        .catch(function(data, status){
            $scope.new = data.data
            console.log($scope.new);
        });
    }
}]);

/*
* Menus Controller
*/
angularApp.controller('Home', function($scope, $http, $window, $rootScope) {
      
      // Initialising the variable.
      $scope.menus = [];
    
      // Getting the list of menus.
      $http({
        method : "GET",
        url : "http://localhost/test_user/rest/get_menu"
      }).then(function mySuccess(response) {
        $scope.menus = response.data;
        });

        /*
        * Function to logout the user.
        */
        $scope.logoutUser = function(){

        window.location.href= "http://localhost/login/#/home/views";

        /*
        * Unsetting Login Credentials
        */
        $rootScope.globals = {};
        $cookieStore.remove('globals');
    }
});

/*
* Login Controller
*/
angularApp.controller('loginCntrl', ['$scope', '$http', '$window', '$cookieStore', '$rootScope', function ($scope, $http, $window, $cookieStore, $rootScope) {
    
    /*
    * Initializing Values
    */
    $scope.login_username = "";

    $scope.login_password = "";

    $scope.loginUser = function(){
        $http.post('http://localhost/test_user/rest/login', {username: $scope.login_username, password: $scope.login_password})
        .then(function(result){
            $scope.login = result.data;
            console.log($scope.login);
            if($scope.login.message == "Login Success")
            {
                
                /*
                * Setting User Credentials
                */
                $rootScope.globals = {
                    currentUser: {
                        username: $scope.login_username,
                        password: $scope.login_password
                    }
                };

                /*
                * Setting Cookies
                */
                $cookieStore.put('globals', $rootScope.globals);

                window.location.href= "http://localhost/login/#/home/views";
            }    
            
            /*
            * Resetting Values
            */
            $scope.login_password = "";
        })
        .catch(function(data, status){
            $scope.login = data.data
            console.log($scope.login);
        });
    }
}]);