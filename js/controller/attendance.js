app.controller('AttendanceListCtrl', ['$scope', 'toaster', '$routeParams', '$http',  '$filter', 'AttendancesFactory', 'EventFactory', '$location', 'ngTableParams',
    function ($scope, toaster, $routeParams, $http, $filter, AttendancesFactory, EventFactory, $location, ngTableParams) {

        $scope.deleteEvent = function (eventId) {
            AttendancesFactory.delete({ id: eventId });
            $scope.tableParams.reload();
        };

        $scope.createNewEvent = function () {
            $location.path('/event-creation');
        };

        $scope.submitAttendance = function(){

            $scope.message = "Please wait ...";

            $http.post('/attendances', {
                user_id : $scope.att.id,
                event_id : $routeParams.id})
                    .success(function(data, status) {   
                        $scope.message = data.msg;
                        $scope.tableParams.reload();
                    });
        }

        $http.get('/events-count').success(function(totalFromDb, status){
                        
            $scope.total = totalFromDb;
        });

        $scope.event = EventFactory.show({id : $routeParams.id});
                       
        $scope.tableParams = new ngTableParams({
            page: 1,
            count: 10
        }, {
            total : $scope.total,
            getData: function($defer, params) {

                $http.get('/attendances', {params: {
                    pageSize:params.count(),
                    pageNumber:params.page() - 1,
                    filter:$scope.filter,
                    eventId: $routeParams.id
                    }})
                    .success(function(data, status) {                       
                       $scope.data = data;
                       $defer.resolve(data);
                    });
            },
        });

        $scope.tableParams.settings().$scope = $scope;
        $scope.message = "Please provide your ID";

        $scope.$watch("filter", function () {
            $scope.tableParams.reload();
        });
}]);
