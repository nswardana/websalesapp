app.controller('UserCtrl', ['$scope', '$http',  '$filter',  '$location', 'ngTableParams',
    function ($scope, $http, $filter, UsersFactory, UserFactory, $location, ngTableParams) {
       $scope.create = function () {
           console.log("User");
        };
       
}]);

app.controller('UserAddCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data',
    function ($scope, $http, $filter,$location, ngTableParams,Data) {
    
          $scope.today = function() {
            $scope.tgl_lahir = new Date();
          };
          $scope.today();

          $scope.clear = function () {
            $scope.tgl_lahir = null;
          };

          /*
          // Disable weekend selection
          $scope.disabled = function(date, mode) {
            return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
          };

          $scope.toggleMin = function() {
            $scope.minDate = $scope.minDate ? null : new Date();
          };
          $scope.toggleMin();
          */

          $scope.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened = true;
          };

          $scope.dateOptions = {
            formatYear: 'yyyy',
      
          };


        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[1];      


     $scope.processDate = function(dt) {
      return $filter('date')(dt, 'yyyy-mm-dd');
     }


   // callback for ng-click 'createNewUser':
    $scope.create = function () {
      console.log('tambah User');
      var toast; toast={};
      
      console.log($scope.user);
      Data.post('users',$scope.user).then(function (results) {
        if (results.id) {
           
           toast.status="success";
           toast.message="Berhasil menambahkan data User";
           
           Data.toast(toast);
          $location.path("/user");
        } else {
           toast.status="error";
           toast.message="Gagal menambahkan data User";
           Data.toast(toast);
        }

      });

    };
       
}]);
app.controller('UserListCtrl', ['$scope', '$http','$filter','Data','$location', 'ngTableParams','$rootScope',
    function ($scope, $http, $filter, Data,$location, ngTableParams,$rootScope) {
                      
 
        $scope.tableParams = new ngTableParams({
            page: 1,
            count: 10,
            sorting: {
              nama_lengkap: 'asc'     // initial sorting
            } 

        }, {
            total : $scope.total,
            getData: function($defer, params) {
                $http.get($rootScope.urlApi+'/users', {params: {
                    pageSize:params.count(),
                    pageNumber:params.page() - 1,
                    filter:$scope.filter
                    }})
                    .success(function(data, status) {
                       
                       $scope.data = data;

                       //console.log($scope.data);
                       $defer.resolve(data);
                    });
            },
        });

        $scope.tableParams.settings().$scope = $scope;
        
        $scope.$watch("filter", function () {
            $scope.tableParams.reload();
        });

        /*
        var paginationOptions = {
          pageNumber: 1,
          pageSize: 25,
          sort: null
        };

        $scope.gridOptions = {
            showGridFooter: true,
            showColumnFooter: true,
            enableSorting: true,
            enableFiltering: true,

            enableGridMenu: true,
            enableSelectAll: true,

            paginationPageSizes: [25, 50, 75],
            paginationPageSize: 25,
            useExternalPagination: true,
            useExternalSorting: true,


            columnDefs: [
            { field: 'id',width: '5%' },
            { field: 'nama_lengkap', enableColumnResizing: true},
            { field: 'nip', enableSorting: false },
            { field: 'tempat_lahir' },
            { field: 'tgl_lahir' },
            { field: 'alamat', enableSorting: false ,enableColumnResizing: true}
            
            ],
            onRegisterApi: function( gridApi ) {
                $scope.gridApi = gridApi;
                $scope.gridApi.core.on.sortChanged($scope, function(grid, sortColumns) {
                  if (sortColumns.length == 0) {
                  paginationOptions.sort = null;
                  } else {
                  paginationOptions.sort = sortColumns[0].sort.direction;
                  }
                  getPage();
                });
                  gridApi.pagination.on.paginationChanged($scope, function (newPage, pageSize) {
                  paginationOptions.pageNumber = newPage;
                  paginationOptions.pageSize = pageSize;
                  getPage();
                });

            }
        };
  


          var getPage = function() {
            $http.get("/e-office/Users")
            .success(function (data) {
              $scope.gridOptions.totalItems = $scope.gridOptions.data.length;
              var firstRow = (paginationOptions.pageNumber - 1) * paginationOptions.pageSize;
              $scope.gridOptions.data = data.slice(firstRow, firstRow + paginationOptions.pageSize);
            });
          };
           
          getPage();
         
         
          Data.get('Users').then(function (results) {
           $scope.gridOptions.data= results;
          });
          */
     
        

        // callback for ng-click 'cancel':
        $scope.edit = function (id) {
            console.log('edit...');
            $location.path('/user/'+id);
        };


         // callback for ng-click 'deleteUser':
        $scope.delete = function (index) {

          console.log(index);
          var todel = $scope.data[index];
          $scope.data.splice(index, 1);
          console.log('Delete User');
          var toast; toast={};
         
          console.log("ID :"+ todel.id);
          Data.delete('users/'+todel.id).then(function (results) {
            if (results.id) {
               
               toast.status="success";
               toast.message="Berhasil menghapus data User";
               Data.toast(toast);
              //$location.path("/User");

            } else {
               toast.status="error";
               toast.message="Gagal menghapus data User";
               Data.toast(toast);
            }

          });


        };

}]);


app.controller('UserEditCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','$routeSegment',
    function ($scope, $http, $filter,$location, ngTableParams,Data,$routeSegment) {
    
          $scope.today = function() {
            $scope.tgl_lahir = new Date();
          };
          $scope.today();

          $scope.clear = function () {
            $scope.tgl_lahir = null;
          };

          /*
          // Disable weekend selection
          $scope.disabled = function(date, mode) {
            return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
          };

          $scope.toggleMin = function() {
            $scope.minDate = $scope.minDate ? null : new Date();
          };
          $scope.toggleMin();
          */

          $scope.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened = true;
          };

          $scope.dateOptions = {
            formatYear: 'yyyy',
      
          };


        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[1];      


     $scope.processDate = function(dt) {
      return $filter('date')(dt, 'yyyy-mm-dd');
     }


   // callback for ng-click '':
    $scope.edit = function () {
      var toast; toast={};
      Data.post('users/'+$scope.user.id,$scope.user).then(function (results) {
          if (results.id) {
               toast.status="success";
               toast.message="Berhasil menyimpan data User";
               Data.toast(toast);
              $location.path("/user");

            } else {
               toast.status="error";
               toast.message="Gagal menyimpan data User";
               Data.toast(toast);
            }

      });

    };

    console.log("Users......");
  
    Data.get('users/'+$routeSegment.$routeParams.id).then(function (results) {
       $scope.user =results;
    });

    console.log($scope.user);






       
}]);




