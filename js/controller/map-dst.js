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

app.controller('MapListCtrl', ['$scope', '$http','$filter','Data','$location', 'ngTableParams','$rootScope',
    function ($scope, $http, $filter, Data,$location, ngTableParams,$rootScope) {
   
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



    getallareas();
    getallsales();

   var getalltokos = function() {
      $http.get($rootScope.urlApi+'/tokosnopagging')
          .success(function (data) { 
            $scope.alltokos =data;
            var marker = [];
            angular.forEach(data, function(value, key) {
               $scope.map.markers.push(
                  {
                    id:value.id,
                    toko_id:value.toko_id,
                    icon: 'images/salesicon/' + value.sales_map_icon,
                    latitude: value.latitude,
                    longitude: value.longitude,
                    showWindow: false,
                    title: value.nama_toko,
                    nama_toko: value.nama_toko,
                    pemilik: value.pemilik,
                    no_toko:value.no_toko,
                    
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


   $scope.loadmap = function ()
    {
      console.log("loadmap");
               $http.get($rootScope.urlApi+'/tokosnopagging', {
                        params: {
                        selected_area:$scope.selected_area,
                        selected_sales:$scope.selected_sales
                        }})
                        .success(function(data, status) {
                         
                         $scope.alltokos =data;
                          var marker = [];
                          $scope.map.markers={};
                          
                          angular.forEach(data, function(value, key) {
                             $scope.map.markers.push(
                                {
                                  id:value.id,
                                  toko_id:value.toko_id,
                                  icon: 'images/salesicon/' + value.sales_map_icon,
                                  latitude: value.latitude,
                                  longitude: value.longitude,
                                  showWindow: false,
                                  title: value.nama_toko,
                                  nama_toko: value.nama_toko,
                                  pemilik: value.pemilik,
                                  no_toko:value.no_toko,
                                  
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

    //loadbypost();
    //getalltokos();

    $scope.selectedArea = function()
    {

        var markers = $scope.map.markers;
        var newMarkers=[];

        angular.forEach(markers, function(value, key) {


               var visibility=false
               if(value.area_id ==$scope.selected_area)
                {  visibility=true; }

                //tampilkan semu
                if($scope.selected_area ==0)
                {  visibility=true; }
              

               newMarkers.push(
                  {
                    id:value.id,
                    toko_id:value.toko_id,
                    icon: value.icon,
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
                    options: {visible: visibility}
                     
                  }
                );
        });

        $scope.map.markers=newMarkers;

        console.log($scope.map.markers);

    }


    $scope.selectedSales = function()
    {

        var markers = $scope.map.markers;
        var newMarkers=[];

        angular.forEach(markers, function(value, key) {


               var visibility=false
               if(value.sales_id ==$scope.selected_sales)
                {  visibility=true; }

                //tampilkan semu
                if($scope.selected_sales ==0)
                {  visibility=true; }
              

               newMarkers.push(
                  {
                    id:value.id,
                    toko_id:value.toko_id,
                    icon: value.icon,
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
                    options: {visible: visibility}
                     
                  }
                );
        });

        $scope.map.markers=newMarkers;

        console.log($scope.map.markers);

    }

   
        
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




}]);


app.controller('MapSalesCtrl', ['$scope', '$http','$filter','Data','$location', 'ngTableParams','$rootScope',
    function ($scope, $http, $filter, Data,$location, ngTableParams,$rootScope) {
   
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





    var getMarkerDataCheckIn = function() {
    
     $scope.map.markers=[];

      console.log("rangeTglPenjualan: "+$scope.rangeTglPenjualan);
      console.log("name: "+$scope.filter);

      $http.get($rootScope.urlApi+'/checkinsby', {params: {
          selected_sales:$scope.selected_sales,
          selected_area:$scope.selected_area,
          rangeTanggal:$scope.rangeTglPenjualan
          }})
        .success(function(data, status) {
            
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

  //getMarkerDataCheckIn();

   $scope.getDataCheckIn = function() {
      getMarkerDataCheckIn();

    };


    $scope.selectedArea = function()
    {

        var markers = $scope.map.markers;
        var newMarkers=[];

        angular.forEach(markers, function(value, key) {


               var visibility=false
               if(value.area_id ==$scope.selected_area)
                {  visibility=true; }

                //tampilkan semu
                if($scope.selected_area ==0)
                {  visibility=true; }
              

               newMarkers.push(
                  {
                    id:value.id,
                    toko_id:value.toko_id,
                    icon: value.icon,
                    latitude: value.latitude,
                    longitude: value.longitude,
                    showWindow: false,
                    title: value.nama_toko,
                    nama_toko: value.nama_toko,
                    pemilik: value.pemilik,
                    no_toko:value.no_toko,
                  
                    area_id :value.area_id,
                    sales_name :value.sales_name,
                    sales_email :value.sales_email,
                    sales_hp:value.sales_hp,
                    alamat :value.alamat,
                    toko_image:value.toko_image,
                    keterangan:value.keterangan,
                    options: {visible: visibility}
                     
                  }
                );
        });

        $scope.map.markers=newMarkers;

        console.log($scope.map.markers);

    }
   
        
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




}]);

