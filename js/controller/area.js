app.controller('AreaCtrl', ['$scope', '$http',  '$filter',  '$location', 'ngTableParams',
    function ($scope, $http, $filter, UsersFactory, UserFactory, $location, ngTableParams) {
       $scope.create = function () {
           console.log("Area");
        };
       
}]);

app.controller('AreaAddCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','fileUpload','$rootScope',
    function ($scope, $http, $filter,$location, ngTableParams,Data,fileUpload,$rootScope) {
  
   // callback for ng-click 'createNewUser':
    $scope.create = function (image) {
      console.log('tambah Area');
      var toast; toast={};
      
      console.log($scope.area);

       Data.post('areas',$scope.area).then(function (results) {
        console.log(results);
        if (results.status==='success') {
           toast.status="success";
           toast.message="Berhasil menambahkan data Area";
           Data.toast(toast);
          $location.path("/area");
        } else {
           toast.status="error";
           toast.message="Gagal menambahkan data Area";
           Data.toast(toast);
        }

      }); 

    };

   

       
}]);
app.controller('AreaListCtrl', ['$scope', '$http','$filter','Data','$location', 'ngTableParams','$rootScope',
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
                $http.get($rootScope.urlApi+'/areas', {params: {
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
            $http.get("/e-office/Areas")
            .success(function (data) {
              $scope.gridOptions.totalItems = $scope.gridOptions.data.length;
              var firstRow = (paginationOptions.pageNumber - 1) * paginationOptions.pageSize;
              $scope.gridOptions.data = data.slice(firstRow, firstRow + paginationOptions.pageSize);
            });
          };
           
          getPage();
         
         
          Data.get('Areas').then(function (results) {
           $scope.gridOptions.data= results;
          });
          */
     
        

        // callback for ng-click 'cancel':
        $scope.edit = function (id) {
            console.log('edit...');
            $location.path('/area/'+id);
        };


         // callback for ng-click 'deleteUser':
        $scope.delete = function (index) {

          console.log(index);
          var todel = $scope.data[index];
          $scope.data.splice(index, 1);
          console.log('Delete Area');
          var toast; toast={};
          console.log("ID :"+ todel.id);
          Data.delete('areas/'+todel.id).then(function (results) {
            if (results.id) {
               
               toast.status="success";
               toast.message="Berhasil menghapus data Area";
               Data.toast(toast);
              //$location.path("/Area");

            } else {
               toast.status="error";
               toast.message="Gagal menghapus data Area";
               Data.toast(toast);
            }

          });


        };

}]);


app.controller('AreaEditCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','$routeSegment','$rootScope','fileUpload',
    function ($scope, $http, $filter,$location, ngTableParams,Data,$routeSegment,$rootScope,fileUpload) {
    
   // callback for ng-click '':
    $scope.edit = function () {
      var toast; toast={};
      Data.post('areas/'+$scope.area.id,$scope.area).then(function (results) {
          if (results.id) {

               toast.status="success";
               toast.message="Berhasil menyimpan data Area";
               Data.toast(toast);
              $location.path("/area");

            } else {
               toast.status="error";
               toast.message="Gagal menyimpan data Area";
               Data.toast(toast);
            }

      });

    };

    console.log("Areas......");
  
    Data.get('areas/'+$routeSegment.$routeParams.id).then(function (results) {
       $scope.area =results;
    });

    console.log($scope.area);






       
}]);




