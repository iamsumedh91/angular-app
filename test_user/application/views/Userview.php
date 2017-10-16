<html>
<head>
<title>Insert Data Using AngularJS and CodeIgniter</title>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
</head>
<body>
 
<div ng-app="myapp" ng-controller="employeecontroller">
 
</div>
	
	
<script>
var app = angular.module("myapp",[]);
app.controller("employeecontroller",function($scope,$http){
 
	//update function 
	
		$scope.updatedata = function() {
		$http.post("<?php echo base_url(); ?>Actions/get_users/")
		.success(function(data,status,headers,config){
 		
 			console.log(data);
           	$scope.message = data;
			
		});
		
	}
 
 
});
 
</script>
	 
  
	 
	 
</body>
</html>