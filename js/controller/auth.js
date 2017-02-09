app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data,localStorageService) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.signup = {};
    $scope.doLogin = function (customer) {
        Data.post('weblogin', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
              console.log(results.status);

            if (results.status == "success") {
                localStorageService.set('uid', results.uid);
                localStorageService.set('name', results.name);
                localStorageService.set('email', results.email);

                $location.path('/dashboard');
            }
        });
    };
    $scope.signup = {email:'',password:'',name:'',phone:'',address:''};
    $scope.signUp = function (customer) {
        Data.post('signUp', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    }
});

app.controller('logoutCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data,localStorageService) {

    Data.get('logout').then(function (results) {
        Data.toast(results);
        localStorageService.remove('uid');
        localStorageService.remove('name');
        localStorageService.remove('email');

        $location.path('login');
    });

});