/*
* Signup Controller
*/
angularApp.controller('signupCntrl', ['$scope', '$window', '$http', '$rootScope', '$cookieStore', function ($scope, $window, $http, $rootScope, $cookieStore) {

    /*
    * Adding Users
    */
    $scope.addUser = function(){
        
        /*
        * Sending values from the Form
        */
        $http.post('http://localhost/login/test_user/rest/signup', {name: $scope.name, username: $scope.username, password: $scope.password, 
            gender: $scope.gender, address: $scope.address, email: $scope.email, 
            mobile: $scope.mobile, pincode: $scope.pincode, occupation: $scope.occupation, dateofbirth: $scope.dateofbirth})
        .then(function(result){
            $scope.new = result.data;

            $rootScope.signup_message = {
                    currentUser: {
                        username: $scope.username,
                        message: $scope.new.message
                    }
                };
            $cookieStore.put('user', $rootScope.signup_message);
            if($rootScope.signup_message.currentUser.message == "Signup Successful")
            {
                window.location.href= "http://localhost/login/#/login";
            }
        })
        .catch(function(data, status){
            $scope.new = data.data;
            console.log($scope.new);
        });
    }
}]);