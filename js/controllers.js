var app = angular.module('usercatControllers', ['ngTable', 'ui.bootstrap', 'datePicker']);

app.config(function($logProvider){
  $logProvider.debugEnabled(true);
});

app.directive('ngConfirmClick', [
    function(){
        return {
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.confirmedClick;
                element.bind('click',function (event) {
                    if ( window.confirm(msg) ) {
                        scope.$eval(clickAction)
                    }
                });
            }
        };
}]);

var routeLoadingIndicator = function($rootScope) {
    return {
      restrict: 'E',
      template: "<div class='col-lg-12' ng-if='isRouteLoading'><h1>Loading <i class='fa fa-cog fa-spin'></i></h1></div>",
      link: function(scope, elem, attrs) {
        scope.isRouteLoading = false;

        $rootScope.$on('$routeChangeStart', function() {
          scope.isRouteLoading = true;
          console.log("start");
        });

        $rootScope.$on('$routeChangeSuccess', function() {
          scope.isRouteLoading = false;
          console.log("success");
        });
      }
    };
  };
  routeLoadingIndicator.$inject = ['$rootScope'];

app.directive('routeLoadingIndicator', routeLoadingIndicator);

app.directive('focus', function() {
    return function(scope, element) {
        element[0].focus();
    }
});
 
app.directive('passwordMatch', [function () {
    return {
        restrict: 'A',
        scope:true,
        require: 'ngModel',
        link: function (scope, elem , attrs,control) {
            var checker = function () {
                var e1 = scope.$eval(attrs.ngModel);
                var e2 = scope.$eval(attrs.passwordMatch);
                if(e2!=null)
                return e1 == e2;
            };
            scope.$watch(checker, function (n) {
                control.$setValidity("passwordNoMatch", n);
            });
        }
    };
}]);

