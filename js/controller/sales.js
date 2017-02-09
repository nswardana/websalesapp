app.controller('SalesCtrl', ['$scope', '$http',  '$filter',  '$location', 'ngTableParams',
    function ($scope, $http, $filter, UsersFactory, UserFactory, $location, ngTableParams) {
       $scope.create = function () {
           console.log("Sales");
        };
       
}]);

app.controller('SalesAddCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','fileUpload','$rootScope',
    function ($scope, $http, $filter,$location, ngTableParams,Data,fileUpload,$rootScope) {
    
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
    $scope.create = function (image) {
      console.log('tambah Sales');
      var toast; toast={};
      
      console.log($scope.sales);

      $scope.sales.sales_bergabung=$scope.processDate($scope.sales.sales_bergabung);
       
       Data.post('sales',$scope.sales).then(function (results) {
        
        console.log(results);
        if (results.status==='success') {
           var file = $scope.myFile;
           var uploadUrl = $rootScope.urlApi+'/salesuploadpicture/'+results.data.sales.id;
           fileUpload.uploadFileToUrl(file, uploadUrl);
         
           var file = $scope.iconsales;
           var uploadUrl = $rootScope.urlApi+'/salesuploadicon/'+results.data.sales.id;
           fileUpload.uploadFileToUrl(file, uploadUrl);
         

           toast.status="success";
           toast.message="Berhasil menambahkan data Sales";
           Data.toast(toast);
          $location.path("/sales");
        } else {
           toast.status="error";
           toast.message="Gagal menambahkan data Sales";
           Data.toast(toast);
        }

      }); 

    };


    var getarea = function() {
      $http.get($rootScope.urlApi+'/getallareas')
        .success(function (data) { $scope.allarea =data;});
      };
  getarea();
}]);

app.controller('SalesTokoPocketCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','$routeSegment','$rootScope','fileUpload',
    function ($scope, $http, $filter,$location, ngTableParams,Data,$routeSegment,$rootScope,fileUpload) {
    console.log("SalesTokoPocketCtrl......");

    var toast; toast={};
    $scope.sales_id=$routeSegment.$routeParams.id;
    $scope.selected_sales=$scope.sales_id;
    $scope.selection=[];
    $scope.pocket_id='';
    
    $scope.toggleSelection = function toggleSelection(idToko) {
      var idx = $scope.selection.indexOf(idToko);
      if (idx > -1) {
         $scope.selection.splice(idx, 1);
      }
      else {
         $scope.selection.push(idToko);
      }

      console.log($scope.selection);
    };
  


    
    $scope.strAllPocket=[];
      

      var getAllPocket = function () {
          for (i=1; i<27; i++){
            $scope.strAllPocket.push({id:i,name:'Pocket '+i+''});
          }

      };

     
      var getallareas = function() {
      $http.get($rootScope.urlApi+'/areas')
          .success(function (data) { 
            $scope.allareas =data;
            
          });
      };


      getallareas();
      getAllPocket();
    

      var getTokos = function() {

      $scope.tableParams = new ngTableParams({
            page: 1,
            count: 10

        }, {
            total : $scope.total,
      counts:[10, 25, 50, 100,500,1000,10000],
            getData: function($defer, params) {
                $http.get($rootScope.urlApi+'/tokospersalesandpocket', {params: {
                    pageSize:params.count(),
                    pageNumber:params.page() - 1,
                    selected_sales:$scope.sales_id,
                    selected_pocket:0
                    }})
                    .success(function(data, status) {
                      $scope.data = data;
                      params.total(data.length); // set total for recalc pagination
                      $defer.resolve(data.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                      // $defer.resolve(data);
                });
            },
        });

          $scope.tableParams.settings().$scope = $scope;
           
           
            $scope.$watch("filter", function () {
                $scope.tableParams.reload();
            });
             
            $scope.$watch("selected_sales", function () {
                $scope.tableParams.reload();
            });

            $scope.$watch("selected_area", function () {
                $scope.tableParams.reload();
            });

            $scope.$watch("selected_pocket", function () {
                $scope.tableParams.reload();
            });

  };

   

   getTokos();        

    $scope.simpanTokoPocket = function ()
    {

        if($scope.pocket_id=='' )
        {

          toast.status="error";
          toast.message="Pocket Id tidak boleh kosong";
          Data.toast(toast);
          return false;
        }

        $scope.datapost=[];
        $scope.datapost.push({aToko:$scope.selection,pocket_id:$scope.pocket_id});
        console.log($scope.datapost);
        Data.post('tokopocket',{data:$scope.datapost}).then(function (results) {
          console.log(results);
          if (results.status==='success') {
            getTokos();
             toast.status="success";
             toast.message="Berhasil mengupdate data Toko";
             Data.toast(toast);
          } else {
             toast.status="error";
             toast.message="Gagal mengupdate data Toko";
             Data.toast(toast);
          }

        }); 
    };

     
 

        // callback for ng-click 'cancel':
        $scope.edit = function (id) {
            console.log('edit...');
            $location.path('/toko/'+id);
        };

       Data.get('sales/'+$routeSegment.$routeParams.id).then(function (results) {
         $scope.sales =results;
      });
  
        

          
}]);


app.controller('SalesListCtrl', ['$scope', '$http','$filter','Data','$location', 'ngTableParams','$rootScope',
    function ($scope, $http, $filter, Data,$location, ngTableParams,$rootScope) {
                      
 
        
      var getallareas = function() {
      $http.get($rootScope.urlApi+'/areas')
          .success(function (data) { 
            $scope.allareas =data;
            
          });
      };


      var getallsales = function() {
      $http.get($rootScope.urlApi+'/getallsales')
          .success(function (data) { 
            $scope.allsales =data;
            
          });
      };

      getallareas();
      getallsales();
    


      $scope.tableParams = new ngTableParams({
            page: 1,
            count: 10

        }, {
            total : $scope.total,
            getData: function($defer, params) {
                $http.get($rootScope.urlApi+'/sales', {params: {
                    pageSize:params.count(),
                    pageNumber:params.page() - 1,
                    filter:$scope.filter,
                    selected_area:$scope.selected_area,
                    selected_sales:$scope.selected_sales
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
             
            $scope.$watch("selected_sales", function () {
                $scope.tableParams.reload();
            });

            $scope.$watch("selected_area", function () {
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
            $http.get("/e-office/Saless")
            .success(function (data) {
              $scope.gridOptions.totalItems = $scope.gridOptions.data.length;
              var firstRow = (paginationOptions.pageNumber - 1) * paginationOptions.pageSize;
              $scope.gridOptions.data = data.slice(firstRow, firstRow + paginationOptions.pageSize);
            });
          };
           
          getPage();
         
         
          Data.get('Saless').then(function (results) {
           $scope.gridOptions.data= results;
          });
          */
     
        

        // callback for ng-click 'cancel':
        $scope.edit = function (id) {
            console.log('edit...');
            $location.path('/sales/'+id);
        };

          // callback for ng-click 'cancel':
        $scope.view = function (id) {
            console.log('view...');
            $location.path('/sales/viewsales/'+id);
        };

	$scope.exportData = function () {
            var blob = new Blob([document.getElementById('exportJualharian').innerHTML], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
            });
            saveAs(blob, "ReportDaftarSales.xls");
        };


         // callback for ng-click 'deleteUser':
        $scope.delete = function (index) {

          console.log(index);
          var todel = $scope.data[index];
          $scope.data.splice(index, 1);
          console.log('Delete Sales');
          var toast; toast={};
          console.log("ID :"+ todel.sales_id);
          Data.delete('sales/'+todel.sales_id).then(function (results) {
            if (results.id) {
               
               toast.status="success";
               toast.message="Berhasil menghapus data Sales";
               Data.toast(toast);
              //$location.path("/Sales");

            } else {
               toast.status="error";
               toast.message="Gagal menghapus data Sales";
               Data.toast(toast);
            }

          });


        };

}]);


app.controller('SalesEditCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','$routeSegment','$rootScope','fileUpload',
    function ($scope, $http, $filter,$location, ngTableParams,Data,$routeSegment,$rootScope,fileUpload) {
    
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
      Data.post('sales/'+$scope.sales.id,$scope.sales).then(function (results) {
          if (results.id) {

            if($scope.myFile)
              {
                var file = $scope.myFile;
                var uploadUrl = $rootScope.urlApi+'/salesuploadpicture/'+results.id;
                fileUpload.uploadFileToUrl(file, uploadUrl);
              }
              
              if($scope.iconsales)
              {
               var file = $scope.iconsales;
               var uploadUrl = $rootScope.urlApi+'/salesuploadicon/'+results.id;
                fileUpload.uploadFileToUrl(file, uploadUrl);
              }
              
               toast.status="success";
               toast.message="Berhasil menyimpan data Sales";
               Data.toast(toast);
              $location.path("/sales");

            } else {
               toast.status="error";
               toast.message="Gagal menyimpan data Sales";
               Data.toast(toast);
            }

      });

    };

    console.log("Saless......");
  
    Data.get('sales/'+$routeSegment.$routeParams.id).then(function (results) {
       $scope.sales =results;
    });

    console.log($scope.sales);

     var getarea = function() {
      $http.get($rootScope.urlApi+'/getallareas')
        .success(function (data) { $scope.allarea =data;});
      };

    getarea();


}]);

app.controller('SalesViewCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','$routeSegment','$rootScope','fileUpload',
    function ($scope, $http, $filter,$location, ngTableParams,Data,$routeSegment,$rootScope,fileUpload) {
    console.log("SalesViewCtrl......");
    var redicon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
    $scope.sales_id=$routeSegment.$routeParams.id;
    $scope.strAllPocket=[];
    console.log("Sales......");

    Data.get('sales/'+$routeSegment.$routeParams.id).then(function (results) {
       $scope.sales =results;
    });
 	
	function getTotalOmset(){
          var url = $rootScope.urlApi +'/omsetpersalespermonth/'+$scope.sales_id;
           $http({
            method: 'GET',
            url: url,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
          }).success(function (results) {
            $scope.arromset=results;
            console.log($scope.arromset);
          }).finally(function() {
            $scope.$broadcast('scroll.refreshComplete');
         });
      }

  getTotalOmset(); 

  
 
  var getTokos = function() {

          $scope.tableParamTokos = new ngTableParams({
                page: 1,
                count: 10,
                sorting: {
                  nama_lengkap: 'asc'     // initial sorting
                } 

            }, {
                total : $scope.total,
                counts:[10, 25, 50, 100,500,1000,10000],
		getData: function($defer, params) {
                    $http.get($rootScope.urlApi+'/tokos', {params: {
                        pageSize:params.count(),
                        pageNumber:params.page() - 1,
                        filter:$scope.filter,
                        selected_sales:$scope.sales_id
                        }})
                        .success(function(data, status) {
                           $scope.toko = data;
                           $defer.resolve(data);
                        });
                },
            });

            $scope.tableParamTokos.settings().$scope = $scope;
             
              $scope.$watch("filter", function () {
                  $scope.tableParamTokos.reload();
              });
               
              $scope.$watch("selected_sales", function () {
                  $scope.tableParamTokos.reload();
              });

              $scope.$watch("selected_area", function () {
                  $scope.tableParamTokos.reload();
              });

        
      };

      //getTokos();
      

     $http.get($rootScope.urlApi+'/tokobysales?pageSize=100000', {params: {
        sales_id:$scope.sales_id
        }})
        .success(function(data, status) {
        $scope.toko =data;
        
          $scope.allmarkers =data;
            var marker = [];
            var index=1;
            angular.forEach(data, function(value, key) {
               $scope.map.markers.push(
                  {
                    id:index,
                    toko_id:value.toko_id,
                    //icon: redicon,
                    icon: 'images/salesicon/' + value.sales_map_icon,
		    latitude: value.latitude,
                    longitude: value.longitude,
                    showWindow: false,
                    title: value.nama_toko,
                    nama_toko: value.nama_toko,
                    pemilik: value.pemilik,
                    no_toko:value.no_toko,
                    area_id :value.area_id,

                    sales_id :value.sales_id,
                    sales_name :value.sales_name,
                    sales_email :value.sales_email,
                    sales_hp:value.sales_hp,
                    alamat :value.alamat,
                    toko_image:value.toko_image,
                    keterangan:value.keterangan,
                    options: {visible: true}
                    
                     
                  }
                );

               index=index+1;
            });

        calcFocus();

    });

   
    angular.extend($scope, {
      map: {
        control: {},
        center: {
          latitude: 45,
          longitude: -73
        },
        options: {
          streetViewControl: false,
          panControl: false,
          maxZoom: 20,
          minZoom: 3
        },
        zoom: 8,
        dragging: false,
        bounds: {},
        markers: [],
        dynamicMarkers: [],
        refresh: function () {
          $scope.map.control.refresh(origCenter);
        }
      }
    });

   
    function calcFocus(){
        var lats = [], longs = [], counter = [];

        for(i=0; i<$scope.map.markers.length; i++)
        {
            lats[i] = $scope.map.markers[i].latitude;
            longs[i] = $scope.map.markers[i].longitude;
        }

        var latCount = 0;
        var longCount = 0;

        for (i=0; i<lats.length; i++){
            latCount += lats[i];
            longCount += longs[i];
        }

        latCount = latCount / lats.length;
        longCount = longCount / longs.length;

        $scope.map.center.latitude = $scope.map.markers[0].latitude;
        $scope.map.center.longitude = $scope.map.markers[0].longitude;
       
    };

     $scope.windows = [{
        id: 1,
        options: {
          boxClass:"custom-info-window",
          disableAutoPan : true
        }
      }];


    

  var origCenter = {latitude: $scope.map.center.latitude, longitude: $scope.map.center.longitude};




   var loadbypost = function ()
         {
            $scope.tableParams = new ngTableParams({
                page: 1,
                count: 10,
                sorting: {
                  nama_lengkap: 'asc'     // initial sorting
                } 

            }, {
                total : $scope.total,
		counts:[10, 25, 50, 100,500,1000,10000],
                getData: function($defer, params) {
                    $http.get($rootScope.urlApi+'/laporantokospersales', {params: {
                        pageSize:params.count(),
                        pageNumber:params.page() - 1,
                        filter:$scope.filter,
                        rangeTanggal:$scope.rangeTglPenjualan,
                        sales_id:$scope.sales_id
                        }})
                        .success(function(data, status) {
                           
                           $scope.data = data;
                           $scope.Jualharian = data;
		
var totalOmset=0;
                            angular.forEach(data, function(value, key) {
                              totalOmset=totalOmset+value.omset;
                            });
                            console.log(data)
                            $scope.totalOmset=totalOmset;

                           $defer.resolve(data);
                        });
                },
            });

            $scope.tableParams.settings().$scope = $scope;
            
            $scope.$watch("filter", function () {
                $scope.tableParams.reload();
            });
          };


      loadbypost();

      $scope.getDataByDate= function ()
      {
        loadbypost();
      }

       var loadItemPenjualan = function(id) {
            
                // Create the http post request
                console.log('call loadItemPenjualan()...');
                console.log($scope.rangeTglPenjualan);
               
                $scope.loading = true;
                $http.get($rootScope.urlApi + "/itemlaporans?laporan_id="+id)
                    .success(function(data, status, headers, config) {
                        $scope.daftarItemPenjualan  = data;
                        console.log(data);
                        $scope.loading = false;

                        Data.toast(data);
            

                    }) 
                    .
                    error(function(data, status) {
                        $scope.data = data || "Request failed";
                        $scope.status = status;         
                    });


      }

       $scope.showItemPenjualan=function (index)
        {

            console.log('showItemPenjualan');
            console.log($scope.rangeTglPenjualan);

             $scope.$watch('rangeTglPenjualan', function(newValue, oldValue) {
              console.log(newValue);
              console.log(oldValue);
            });


            var todel = $scope.Jualharian[index];
            console.log(todel.laporan_id);
            $scope.JualharianSelected=$scope.Jualharian[index];
            console.log($scope.JualharianSelected);
            
            

            loadItemPenjualan(todel.laporan_id);
           
            //$scope.daftarItemPenjualan=$scope.dataJualharian.data[index];

            
            
           
        }


      var getAllPocket = function () {
        console.log("strAllPocket");
        for (i=1; i<27; i++){
          $scope.strAllPocket.push({id:i,name:'Pocket '+i+''});
        }
      };
  
      getAllPocket();

      var loadTokoByPocketAndSales = function(pocket_id) {
            
                console.log('call loadTokoByPocketAndSales()...');
                
                $http.get($rootScope.urlApi+'/tokospersalesandpocket', {
                    params: {
                    selected_sales:$scope.sales_id,
                    selected_pocket:pocket_id
                    }})
                    .success(function(data, status) {
                      $scope.datapocket = data;
                    });


      }
      $scope.showTokoByPocket=function (index)
      {
            console.log('showTokoByPocket');
            
            var todel = $scope.strAllPocket[index];
            console.log(todel.id);
            $scope.pocketSelected=$scope.strAllPocket[index];
            console.log($scope.pocketSelected);

            loadTokoByPocketAndSales(todel.id);
           
            
      }

      // callback for ng-click 'cancel':
        $scope.edit = function (id) {
            console.log('edit...');
            $location.path('/toko/'+id);
        };





     


}]);
