app.controller('DashboardCtrl', ['$scope', '$http', '$location','$rootScope',
    function ($scope, $http, $location,$rootScope){

        
        $scope.calculate = function (birthday) { // birthday is a date
            if(birthday == null)
                return 0;

            var ageDifMs = Date.now() - birthday.getTime();
            var ageDate = new Date(ageDifMs); // miliseconds from epoch
            return Math.abs(ageDate.getUTCFullYear() - 1970);
        };

        var getsummary = function() {
            $http.get($rootScope.urlApi+'/getsummarytoko')
            .success(function (data) { $scope.summarytoko =data;});
        };

        getsummary();



    }]);

app.controller('DashboardListCtrl', ['$scope', '$http', '$location','$rootScope',
    function ($scope, $http, $location,$rootScope){

        
        $scope.calculate = function (birthday) { // birthday is a date
            if(birthday == null)
                return 0;

            var ageDifMs = Date.now() - birthday.getTime();
            var ageDate = new Date(ageDifMs); // miliseconds from epoch
            return Math.abs(ageDate.getUTCFullYear() - 1970);
        };

        var getsummary = function() {
            $http.get($rootScope.urlApi+'/getsummarytoko')
            .success(function (data) { $scope.summarytoko =data;});
        };

        getsummary();

	
         var getTotalOmset = function() {
            $http.get($rootScope.urlApi+'/totalomset')
            .success(function (data) { $scope.totalOmset =data;});
        };

        getTotalOmset();

         var getTopTenSales = function() {
            $http.get($rootScope.urlApi+'/toptenbestomset')
            .success(function (data) { $scope.topten =data;});
        };

        getTopTenSales();


    }]);


app.controller('MainCtrl', ['$scope', '$http', '$location',
    function ($scope, $http, $location){

    }]);
