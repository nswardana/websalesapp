app.controller('LaporanTokoCtrl', ['$scope', '$http',  '$filter',  '$location', 'ngTableParams',
    function ($scope, $http, $filter, UsersFactory, UserFactory, $location, ngTableParams) {
       $scope.create = function () {
           console.log("Sales");
        };
       
}]);

app.controller('LaporanTokoAddCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','fileUpload','$rootScope',
    function ($scope, $http, $filter,$location, ngTableParams,Data,fileUpload,$rootScope) {
    
       
   // callback for ng-click 'createNewUser':
    $scope.create = function (image) {
      console.log('tambah Toko');
      var toast; toast={};
      
      console.log($scope.toko);
       Data.post('laporantokos',{data:$scope.toko}).then(function (results) {
        
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

     var getsales = function() {
      $http.get($rootScope.urlApi+'/getallsales')
        .success(function (data) { $scope.allsales =data;});
      };

    getsales();




   

       
}]);
app.controller('LaporanTokoListCtrl', ['$scope', '$http','$filter','Data','$location', 'ngTableParams','$rootScope',
    function ($scope, $http, $filter, Data,$location, ngTableParams,$rootScope) {
         
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
                    $http.get($rootScope.urlApi+'/laporantokos', {params: {
                        pageSize:params.count(),
                        pageNumber:params.page() - 1,
                        filter:$scope.filter,
                        rangeTanggal:$scope.rangeTglPenjualan,
                        selected_area:$scope.selected_area,
                        selected_sales:$scope.selected_sales,
                        selected_toko:$scope.selected_toko,
                        selected_pocket:$scope.selected_pocket
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
           
            
            $scope.$watch("selected_sales", function () {
                $scope.tableParams.reload();
            });

            $scope.$watch("selected_area", function () {
                $scope.tableParams.reload();
            });

            $scope.$watch("selected_toko", function () {
                $scope.tableParams.reload();
            });

            $scope.$watch("selected_pocket", function () {
                $scope.tableParams.reload();
            });
          };


      loadbypost();

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

      var getalltokos = function() {
      $http.get($rootScope.urlApi+'/getalltokos')
          .success(function (data) { 
            $scope.alltokos =data;
            
          });
    };

    $scope.strAllPocket=[];
      

    var getAllPocket = function () {
          for (i=1; i<26; i++){
            $scope.strAllPocket.push({id:i,name:'Pocket '+i+''});
          }

    };

     


    getallareas();
    getallsales();
    getalltokos();
    getAllPocket();


      
    var toast; toast={};
     




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

        

        // callback for ng-click 'cancel':
        $scope.edit = function (id) {
            console.log('edit...');
            $location.path('/toko/'+id);
        };


         // callback for ng-click 'deleteUser':
        $scope.delete = function (index) {

          console.log(index);
          var todel = $scope.data[index];
          $scope.data.splice(index, 1);
          console.log('Delete LaporanTokos');
          var toast; toast={};
          console.log("ID :"+ todel.id);
          Data.delete('laporantokos/'+todel.laporan_id).then(function (results) {
            if (results.status=='success') {
               toast.status="success";
               toast.message="Berhasil menghapus data";
               Data.toast(toast);

            } else {
               toast.status="error";
               toast.message="Gagal menghapus data";
               Data.toast(toast);
            }

          });
        };



        //item

        $scope.showModal = false;
        $scope.selecteditem={};
        
        $scope.edititem = function(index) {
            console.log('call edititem');

            $scope.selecteditem=$scope.daftarItemPenjualan[index];
            $scope.selecteditem.selectedindex=index;

            console.log($scope.selecteditem)
            $scope.showModal = !$scope.showModal;
            
        }

         $scope.delitem = function(index) {
            console.log('call delitem');
          
            var todel = $scope.daftarItemPenjualan[index];

            console.log(todel.item_id);
            $scope.daftarItemPenjualan.splice(index, 1);

                $http
                        .delete('deleteitem/' + todel.item_id + '')
                        .success(function(data, status, headers, config) {

                            //calculateHargaAfterEdit();

                          toast.status="error";
                          toast.message="Berhasil menghapus data";
                          Data.toast(toast);


                           // load();
                        }).error(function(data, status, headers, config) {
                });

        
        }

        $scope.simpanitem = function() {
            //$scope.daftarItemPenjualan[$scope.selecteditem.selectedindex]=$scope.selecteditem;

            //console.log( $scope.daftarItemPenjualan[$scope.selecteditem.selectedindex]);
            console.log( $scope.daftarItemPenjualan);

            $http.post('updateitem/'+$scope.selecteditem.item_id, {
                params: {
                    id: $scope.selecteditem.item_id,
                    jumlah:$scope.selecteditem.jumlah
                }})
                .success(function(data, status) {
                       //calculateHargaAfterEdit();
                       $scope.showModal = false;
                       //$scope.data = data;

            });


            
            
        }


        var calculateHargaAfterEdit= function () {

             console.log('call calculateHargaAfterEdit()...');
             console.log($scope.daftarItemPenjualan);
             
               
               var totalHarga=0;
              
                angular.forEach($scope.daftarItemPenjualan,function(value,index){

                     console.log(value);
                    totalHarga=parseInt(totalHarga)+(parseInt(value.Jualharianitem.Qty) * parseInt(value.Jualharianitem.HargaSatuan));
                 
                });

                console.log("totalHarga"+totalHarga);
                            
                $scope.JualharianSelected.Jualharian.subtotal  = totalHarga;
                $scope.JualharianSelected.Jualharian.total=$scope.JualharianSelected.Jualharian.subtotal-$scope.JualharianSelected.Jualharian.diskon;
               

               $http.get($rootScope.appUrl+'/updatejualanharian', {
                params: {
                    id: $scope.JualharianSelected.Jualharian.Id,
                    subtotal:$scope.JualharianSelected.Jualharian.subtotal ,
                    total:$scope.JualharianSelected.Jualharian.total
                }})
                .success(function(data, status) {
                       
                       $scope.data = data;

                });

               
        }



        $scope.exportData = function () {
            var blob = new Blob([document.getElementById('exportJualharian').innerHTML], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
            });
            saveAs(blob, "ReportJualanharian.xls");
        };

         $scope.exportDataItem = function () {
            var blob = new Blob([document.getElementById('exportJualharianitem').innerHTML], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
            });
            saveAs(blob, "ReportItem.xls");
        };


}]);

app.controller('LaporanTokoExcelCtrl', ['$scope', '$http','$filter','Data','$location', 'ngTableParams','$rootScope',
    function ($scope, $http, $filter, Data,$location, ngTableParams,$rootScope) {
         
      $scope.selected_sales={};
      $scope.selected_toko={};
      $scope.selected_area={};
      $scope.selected_pocket={};
      
      
         
    $scope.strAllPocket=[];
    var getAllPocket = function () {
          for (i=1; i<26; i++){
            $scope.strAllPocket.push({id:i,name:'Pocket '+i+''});
          }

    };

    $scope.loadbypost = function ()
         {
            $scope.tableParams = new ngTableParams({
                page: 1,
                count: 10000000000000 // hides pager
                

            }, {
                counts: [], // hides page sizes
                total : $scope.total,
                getData: function($defer, params) {
                    $http.get($rootScope.urlApi+'/laporantoexcel', {params: {
                        pageSize:params.count(),
                        pageNumber:params.page() - 1,
                        filter:$scope.filter,
                        rangeTanggal:$scope.rangeTglPenjualan,
                        selected_area:$scope.selected_area.id,
                        selected_sales:$scope.selected_sales.id,
                        selected_toko:$scope.selected_toko.id,
                        selected_pocket:$scope.selected_pocket
                        }})
                        .success(function(data, status) {
                           
                           $scope.data = data;
                           $scope.header = $scope.data[0];
                           console.log($scope.header);
                           
                           $scope.Jualharian = data;

                           var totalOmset=0;
                           var totalOmset=0;
                            angular.forEach(data, function(value, key) {
                              if(value.omset != 'Omset')
                              {
                              totalOmset=parseInt(totalOmset)+parseInt(value.omset);
                              }
                          
                            });
 
			   $scope.InttotalOmset=totalOmset;
                           $defer.resolve(data);
                        });
                },
            });

            $scope.tableParams.settings().$scope = $scope;
            $scope.tableParams.reload();
           
            /*
            $scope.$watch("selected_sales", function () {
                $scope.tableParams.reload();
            });

            $scope.$watch("selected_area", function () {
                $scope.tableParams.reload();
            });

             $scope.$watch("selected_toko", function () {
                $scope.tableParams.reload();
            });
          */

          };


      //loadbypost();

      var arrArea={};
      var getallareas = function() {
      $http.get($rootScope.urlApi+'/areas')
          .success(function (data) { 
            $scope.allareas =data;
            $scope.allareas.push({"id":0,"area_name":""});
          });
      };


    var getallsales = function() {
      $http.get($rootScope.urlApi+'/getallsales')
          .success(function (data) { 
            $scope.allsales =data;
            $scope.allsales.push({"id":0,"sales_name":""});
            
          });
    };

    var getalltokos = function() {
    $http.get($rootScope.urlApi+'/getalltokos')
          .success(function (data) { 
            $scope.alltokos =data;
            $scope.alltokos.push({"id":0,"nama_toko":""});
            
          });
    };

    $scope.strAllPocket=[];
    var getAllPocket = function () {
          for (i=1; i<26; i++){
            $scope.strAllPocket.push({id:i,name:'Pocket '+i+''});
          }

    };



    getallareas();
    getallsales();
    getalltokos();
    getAllPocket();


      
        
     
        $scope.exportData = function () {
            var blob = new Blob([document.getElementById('exportJualharian').innerHTML], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
            });
            saveAs(blob, "ReportPenjualanToko.xls");
        };

    

}]);


app.controller('LaporanTokoEditCtrl', ['$scope', '$http','$filter','$location', 'ngTableParams','Data','$routeSegment','$rootScope','fileUpload',
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
      Data.post('LaporanTokos/'+$scope.toko.id,{data:$scope.toko}).then(function (results) {
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
  
    Data.get('LaporanTokos/'+$routeSegment.$routeParams.id).then(function (results) {
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
