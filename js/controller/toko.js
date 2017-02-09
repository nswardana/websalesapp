app.controller('TokoCtrl', ['$scope', '$http',  '$filter',  '$location', 'ngTableParams',
    function ($scope, $http, $filter, UsersFactory, UserFactory, $location, ngTableParams) {
       $scope.create = function () {
           console.log("Sales");
        };
       
}]);

app.controller('TokoAddCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','fileUpload','$rootScope',
    function ($scope, $http, $filter,$location, ngTableParams,Data,fileUpload,$rootScope) {
    
       
   // callback for ng-click 'createNewUser':
    $scope.create = function (image) {
      console.log('tambah Toko');
      var toast; toast={};
      
      console.log($scope.toko);
       Data.post('tokos',{data:$scope.toko}).then(function (results) {
        
        console.log(results);
        if (results.status==='success') {
           var file = $scope.myFile;
           var uploadUrl = $rootScope.urlApi+'/tokopicure/'+results.data.id;
           fileUpload.uploadFileToUrl(file, uploadUrl);
         
           toast.status="success";
           toast.message="Berhasil menambahkan data Toko";
           Data.toast(toast);
          $location.path("/toko");
        } else {
           toast.status="error";
           toast.message="Gagal menambahkan data Toko";
           Data.toast(toast);
        }

      }); 

    };

    $scope.strAllPocket=[];
      

    var getAllPocket = function () {
          for (i=1; i<27; i++){
            $scope.strAllPocket.push({id:i,name:'Pocket '+i+''});
          }

    };

    getAllPocket();
    
    var getsales = function() {
      $http.get($rootScope.urlApi+'/getallsales')
        .success(function (data) { $scope.allsales =data;});
    };

    getsales();


   

       
}]);
app.controller('TokoListCtrl', ['$scope', '$http','$filter','Data','$location', 'ngTableParams','$rootScope',
    function ($scope, $http, $filter, Data,$location, ngTableParams,$rootScope) {
                      
    
     $scope.strAllPocket=[];
      

      var getAllPocket = function () {
          for (i=1; i<26; i++){
            $scope.strAllPocket.push({id:i,name:'Pocket '+i+''});
          }

      };

     
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
      getAllPocket();
    

	 var getTokos = function() {

      $scope.tableParams = new ngTableParams({
            page: 1,
            count: 10

        }, {
            total : $scope.total,
	    counts:[10, 25, 50, 100,500,1000,10000],
            getData: function($defer, params) {
                $http.get($rootScope.urlApi+'/tokos', {params: {
                    pageSize:params.count(),
                    pageNumber:params.page() - 1,
                    filter:$scope.filter,
                    selected_area:$scope.selected_area,
                    selected_sales:$scope.selected_sales,
                    selected_pocket:$scope.selected_pocket
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

     
       $scope.exportData = function () {
            var blob = new Blob([document.getElementById('exportJualharian').innerHTML], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
            });
            saveAs(blob, "ReportDaftarToko.xls");
        };
 

        // callback for ng-click 'cancel':
        $scope.edit = function (id) {
            console.log('edit...');
            $location.path('/toko/'+id);
        };

         // callback for ng-click 'cancel':
        $scope.view = function (id) {
            console.log('view...');
            $location.path('/toko/viewtoko/'+id);
        };


         // callback for ng-click 'deleteUser':
        $scope.delete = function (index) {

          console.log(index);
          var todel = $scope.data[index];
          $scope.data.splice(index, 1);
          console.log('Delete Toko');
          var toast; toast={};
          console.log("ID :"+ todel.toko_id);
          Data.delete('tokos/'+todel.toko_id).then(function (results) {
            if (results.id) {
               
               toast.status="success";
               toast.message="Berhasil menghapus data Toko";
               Data.toast(toast);
		 getTokos();
              //$location.path("/Sales");

            } else {
		 getTokos();
               toast.status="error";
               toast.message="Gagal menghapus data Toko";
               Data.toast(toast);
            }

          });


        };

}]);


app.controller('TokoEditCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','$routeSegment','$rootScope','fileUpload',
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
      Data.post('tokos/'+$scope.toko.toko_id,{data:$scope.toko}).then(function (results) {
          if (results.id) {

            if($scope.myFile)
              {
                var file = $scope.myFile;
                var uploadUrl = $rootScope.urlApi+'/tokopicure/'+results.id;
                fileUpload.uploadFileToUrl(file, uploadUrl);
              }
                            
               toast.status="success";
               toast.message="Berhasil menyimpan data Toko";
               Data.toast(toast);
              $location.path("/toko");

            } else {
               toast.status="error";
               toast.message="Gagal menyimpan data Toko";
               Data.toast(toast);
            }

      });

    };

    console.log("Tokos......");
  
    Data.get('tokos/'+$routeSegment.$routeParams.id).then(function (results) {
       $scope.toko =results;
       $scope.map.markers.push(
        {
                    id:results.id,
                    latitude: results.latitude,
                    longitude: results.longitude,
                    showWindow: false,
                    title: results.nama_toko,
                    nama_toko: results.nama_toko,
                    pemilik: results.pemilik,
                    no_toko:results.no_toko,
                  
                    sales_name :results.sales_name,
                    sales_email :results.sales_email,
                    sales_hp:results.sales_hp,
                    alamat :results.alamat,
                    toko_image:results.toko_image,
                    keterangan:results.keterangan
                     
        });

        console.log($scope.map)


       calcFocus();


    });

    console.log($scope.toko);

    var getsales = function() {
      $http.get($rootScope.urlApi+'/getallsales')
        .success(function (data) { $scope.allsales =data;});
      };

    getsales();

    $scope.strAllPocket=[];
    var getAllPocket = function () {
          for (i=1; i<26; i++){
            $scope.strAllPocket.push({id:i,name:'Pocket '+i+''});
          }

    };

    getAllPocket();

    console.log("pocket");
    console.log($scope.strAllPocket);



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

       
}]);

app.controller('TokoViewCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','$routeSegment','$rootScope','fileUpload',
    function ($scope, $http, $filter,$location, ngTableParams,Data,$routeSegment,$rootScope,fileUpload) {
    console.log("TokoViewCtrl......");
  
   
    $scope.toko_id=$routeSegment.$routeParams.id;

    console.log("Tokos......");
  
    Data.get('tokos/'+$routeSegment.$routeParams.id).then(function (results) {
       $scope.toko =results;
       $scope.map.markers.push(
        {
                    id:results.id,
                    latitude: results.latitude,
                    longitude: results.longitude,
                    showWindow: false,
                    title: results.nama_toko,
                    nama_toko: results.nama_toko,
                    pemilik: results.pemilik,
                    no_toko:results.no_toko,
                  
                    sales_name :results.sales_name,
                    sales_email :results.sales_email,
                    sales_hp:results.sales_hp,
                    alamat :results.alamat,
                    toko_image:results.toko_image,
                    keterangan:results.keterangan
                     
        });

        console.log($scope.map)


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
                    $http.get($rootScope.urlApi+'/laporantokospertoko', {params: {
                        pageSize:params.count(),
                        pageNumber:params.page() - 1,
                        filter:$scope.filter,
                        rangeTanggal:$scope.rangeTglPenjualan,
                        toko_id:$scope.toko_id
                        }})
                        .success(function(data, status) {
                           
                           $scope.data = data;
                           $scope.Jualharian = data;

                           //console.log($scope.data);
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




}]);
