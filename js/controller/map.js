app.controller('MapCtrl', ['$scope', '$http',  '$filter',  '$location', 'ngTableParams',
    function ($scope, $http, $filter, UsersFactory, UserFactory, $location, ngTableParams) {
       $scope.create = function () {
           console.log("Map");
        };
       
}]);

app.controller('InfoController', function ($scope, $log) {
    $scope.templateValue = 'hello from the template itself';
    $scope.clickedButtonInWindow = function () {
      var msg = 'clicked a window in the template!';
      $log.info(msg);
      alert(msg);
    }
  });

app.controller('MapListCtrl', ['$scope', '$http','$filter','Data','$location', 'ngTableParams','$rootScope','$timeout','$window',
    function ($scope, $http, $filter, Data,$location, ngTableParams,$rootScope,$timeout,$window) {


  var blueicon = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
  var redicon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
  

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

    $scope.strAllPocket=[];
      

    var getAllPocket = function () {
          for (i=1; i<26; i++){
            $scope.strAllPocket.push({id:i,name:'Pocket '+i+''});
          }

    };

     

    getallareas();
    getallsales();
    getAllPocket();

   $scope.loadmap = function ()
    {
      console.log("loadmap");
               $http.get($rootScope.urlApi+'/tokosnopagging', {
                        params: {
                        selected_area:$scope.selected_area,
                        selected_sales:$scope.selected_sales,
                        selected_pocket:$scope.selected_pocket
                        }})
                        .success(function(data, status) {
                         
                         $scope.alltokos =data;
                          var marker = [];

                          $scope.map.markers = [];

                          angular.forEach(data, function(value, key) {
                             $scope.map.markers.push(
                                {
                                  id:value.toko_id,
                                  toko_id:value.toko_id,
                                  icon: 'images/salesicon/' + value.sales_map_icon,
                                  latitude: value.latitude,
                                  longitude: value.longitude,
                                  showWindow: false,
                                  title: value.nama_toko,
                                  nama_toko: value.nama_toko,
                                  pemilik: value.pemilik,
                                  no_toko:value.no_toko,
                                  pocket_id:value.pocket_id,
                                  
                                  sales_id :value.sales_id,
                                  area_id :value.area_id,
                                  sales_name :value.sales_name,
                                  sales_email :value.sales_email,
                                  sales_hp:value.sales_hp,
                                  alamat :value.alamat,
                                  toko_image:value.toko_image,
                                  keterangan:value.keterangan,
                                  options: {visible: true}
                                  
                                   
                                }
                              );
                          });
                         

                          calcFocus();
                        });
    
    };


        
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
        zoom: 5,
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


//  var oldMarker = null;
  $scope.onMarkerClicked = function (marker) {
//    if(oldMarker){
////      oldMarker.options = {animation:google.maps.Animation.DROP}; // or 2
//      oldMarker.options = {animation:0}; //or null
//    }
    marker.showWindow = false;
    if(marker.options)
      marker.options = null;
    else
      marker.options = {animation:google.maps.Animation.BOUNCE}; //or 1
//    oldMarker =  marker;
    $scope.$apply();
  };

  $scope.onInsideWindowClick = function () {
    alert("Window hit!");
  };


$scope.printDiv =function (div)
{
  $window.print();
}


}]);


app.controller('MapSalesCtrl', ['$scope', '$http','$filter','Data','$location', 'ngTableParams','$rootScope','$window',
    function ($scope, $http, $filter, Data,$location, ngTableParams,$rootScope,$window) {
   
   $scope.map=[];

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

    $scope.strAllPocket=[];
      

    var getAllPocket = function () {
          for (i=1; i<26; i++){
            $scope.strAllPocket.push({id:i,name:'Pocket '+i+''});
          }

    };






    var getMarkerDataCheckIn = function() {
    
     $scope.map.markers=[];

      console.log("rangeTglPenjualan: "+$scope.rangeTglPenjualan);
      console.log("name: "+$scope.filter);

      $http.get($rootScope.urlApi+'/checkinsby', {params: {
          selected_sales:$scope.selected_sales,
          selected_area:$scope.selected_area,
          selected_pocket:$scope.selected_pocket,
          rangeTanggal:$scope.rangeTglPenjualan
          }})
        .success(function(data, status) {
            

            $scope.map.markers = [];

            $scope.allmarkers =data;
            var marker = [];
            var index=1;
            angular.forEach(data, function(value, key) {
               $scope.map.markers.push(
                  {
                    id:index,
                    toko_id:value.toko_id,
                    icon: 'images/salesicon/' + value.sales_map_icon,
                    latitude: value.checkin_latitude,
                    longitude: value.checkin_longitude,
                    showWindow: false,
                    title: value.nama_toko,
                    nama_toko: value.nama_toko,
                    pemilik: value.pemilik,
                    no_toko:value.no_toko,
                    area_id :value.area_id,
            		    pocket_id :value.pocket_id,
                    checkin_hours:value.checkin_hours,
            		    checkin_date:value.checkin_date,

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

    };





  getallareas();
  getallsales();
  getAllPocket();

  //getMarkerDataCheckIn();

   $scope.getDataCheckIn = function() {
      getMarkerDataCheckIn();

    };


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
        zoom: 5,
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

$scope.printDiv =function (div)
{
  $window.print();
}



}]);

