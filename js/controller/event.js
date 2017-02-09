
app.controller('EventCtrl', ['$scope', '$http',  '$filter', 'EventsFactory', 'EventFactory', '$location', 'ngTableParams',
    function ($scope, $http, $filter, EventsFactory, EventFactory, $location, ngTableParams) {

      $scope.eventSources = [];

      /* config object */
    $scope.uiConfig = {
      calendar:{
        height: 450,
        editable: true,
        header:{
          left: 'month basicWeek basicDay agendaWeek agendaDay',
          center: 'title',
          right: 'today prev,next'
        },
        dayClick: $scope.alertEventOnClick,
        eventDrop: $scope.alertOnDrop,
        eventResize: $scope.alertOnResize
      }
    };

}]);


app.controller('EventListCtrl', ['$scope', '$http',  '$filter', 'EventsFactory', 'EventFactory', '$location', 'ngTableParams',
    function ($scope, $http, $filter, EventsFactory, EventFactory, $location, ngTableParams) {

        $scope.editEvent = function (eventId) {
            $location.path('/event-detail/' + eventId);
        };

        $scope.deleteEvent = function (eventId) {
            EventFactory.delete({ id: eventId });
            $scope.tableParams.reload();
        };

        $scope.createNewEvent = function () {
            $location.path('/event-creation');
        };

        $scope.attendEvent = function (eventId) {
            $location.path('/attendaces/' + eventId);
        };

        $http.get('/events-count').success(function(totalFromDb, status){
                        
            $scope.total = totalFromDb;
        });
                       
        $scope.tableParams = new ngTableParams({
            page: 1,
            count: 10
        }, {
            total : $scope.total,
            getData: function($defer, params) {

                $http.get('/events', {params: {
                    pageSize:params.count(),
                    pageNumber:params.page() - 1,
                    filter:$scope.filter
                    }})
                    .success(function(data, status) {
                       
                       $scope.data = data;
                       $defer.resolve(data);
                    });
            },
        });

        $scope.tableParams.settings().$scope = $scope;
        
        $scope.$watch("filter", function () {
            $scope.tableParams.reload();
        });
}]);

app.controller('EventDetailCtrl', ['$scope', '$routeParams', 'EventFactory', '$location',
    function ($scope, $routeParams, EventFactory, $location) {

        // callback for ng-click 'updateUser':
        $scope.updateEvent = function () {
            EventFactory.update($scope.event);
            $location.path('/event-list');
        };

        // callback for ng-click 'cancel':
        $scope.cancel = function () {
            $location.path('/event-list');
        };

        $scope.event = EventFactory.show({id: $routeParams.id});
    }]);

app.controller('EventCreationCtrl', ['$scope', 'EventsFactory', '$location',
    function ($scope, EventsFactory, $location) {

        $scope.today = function() {
            $scope.dt = new Date();
          };
          $scope.today();

          $scope.clear = function () {
            $scope.dt = null;
          };

          // Disable weekend selection
          $scope.disabled = function(date, mode) {
            return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
          };

          $scope.toggleMin = function() {
            $scope.minDate = $scope.minDate ? null : new Date();
          };
          $scope.toggleMin();

          $scope.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened = true;
          };

          $scope.dateOptions = {
            formatYear: 'yy',
            startingDay: 1
          };


        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[0];
        // callback for ng-click 'createNewUser':
        $scope.createNewEvent = function () {
            EventsFactory.create($scope.event);
            $location.path('/event-list');
        }
    }]);