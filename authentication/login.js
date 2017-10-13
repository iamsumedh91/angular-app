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

            if($scope.login.message == "Login Success")
            {
                
                /*
                * Setting User Credentials
                */
                $rootScope.globals = {
                    currentUser: {
                        username: $scope.login.username,
                        password: $scope.login.password
                    }
                };

                /*
                * Setting Cookies
                */
                $cookieStore.put('globals', $rootScope.globals);

                window.location.href= "http://localhost/login/#/home";
            }    

        })
        .catch(function(data, status){
            $scope.login = data.data
            console.log($scope.login);
        });
    }

}]);