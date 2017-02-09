var usercatApp = angular.module('usercatApp', [
  'ngRoute',
  'usercatControllers',
  'usercatServices',
  'ngAnimate',
  'toaster',
  'route-segment',
  'view-segment',
  'datePicker', 
  'ui.bootstrap',
  'ui.grid',
  'ui.grid.resizeColumns',
  'ui.grid.pagination',
  'ui.calendar',
  'imageupload',
  'uiGmapgoogle-maps',
  'ngToast',
  'ng-currency',
  'daterangepicker',
  'LocalStorageModule',
 'angular-loading-bar'
]);


usercatApp.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = true;
    cfpLoadingBarProvider.includeBar = true;
  }]);

usercatApp.config(function($routeSegmentProvider, $routeProvider) {
    
    // Configuring provider options
    
    $routeSegmentProvider.options.autoLoadTemplates = true;
    
    // Setting routes. This consists of two parts:
    // 1. `when` is similar to vanilla $route `when` but takes segment name instead of params hash
    // 2. traversing through segment tree to set it up
  
    $routeSegmentProvider
    
        .when('/login','login',
            {
                resolve: {
                    access: ["Access", function(Access) { return Access.isAnonymous(); }],
                }
            }
        )
        .when('/logout','logout')
        .when('/dashboard','dashboard',
          {
            /* ... */
            resolve: {
              access: ["Access", function(Access) { return Access.isAuthenticated(); }],
            }
          }

        )
        .when('/dashboard/daftardahsboard',    'dashboard.daftardahsboard')
        
        .when('/event','event')
        .when('/pegawai','pegawai')
        .when('/pegawai/daftarpegawai',    'pegawai.daftarpegawai')
        .when('/pegawai/tambahpegawai',    'pegawai.tambahpegawai')
        .when('/pegawai/:id',      'pegawai.editpegawai')
           
        .when('/product','product')
        .when('/product/daftarproduct',    'product.daftarproduct')
        .when('/product/tambahproduct',    'product.tambahproduct')
        .when('/product/:id',      'product.editproduct')

        .when('/user','user')
        .when('/user/daftaruser',    'user.daftaruser')
        .when('/user/tambahuser',    'user.tambahuser')
        .when('/user/:id',      'user.edituser')

        .when('/sales','sales')
        .when('/sales/daftasales',    'sales.daftarsales')
        .when('/sales/tambahsales',    'sales.tambahsales')
        .when('/sales/viewsales/:id',      'sales.viewsales')
        .when('/sales/addtokopocket/:id',      'sales.addtokopocket')
        .when('/sales/:id',      'sales.editsales')

        .when('/toko','toko')
        .when('/toko/daftartoko',    'toko.daftartoko')
        .when('/toko/tambahtoko',    'toko.tambahtoko')
        .when('/toko/viewtoko/:id',      'toko.viewtoko')
        .when('/toko/:id',      'toko.edittoko')

        .when('/area','area')
        .when('/area/daftararea',    'area.daftararea')
        .when('/area/tambaharea',    'area.tambaharea')
        .when('/area/:id',      'area.editarea')
       
        .when('/map','map')
        .when('/map/index',    'map.index')
        .when('/map/mapsales',    'map.mapsales')
        
         .when('/laporantoko','laporantoko')
        .when('/laporantoko/daftarlaporantoko',    'laporantoko.daftarlaporantoko')
        .when('/laporantoko/laporantokoexcel',    'laporantoko.laporantokoexcel')
        .when('/laporantoko/tambahlaporantoko',    'laporantoko.tambahlaporantoko')
        .when('/laporantoko/:id',      'toko.editlaporantoko')
       


        

        .segment('map', {
            templateUrl: 'partials/map.html',
            controller: 'MapCtrl'})
            .within()
                    .segment('index', {
                        'default': true,
                        controller: 'MapListCtrl',
                        templateUrl: 'partials/map/index.html'})
                    .segment('mapsales', {
                        controller: 'MapSalesCtrl',
                        templateUrl: 'partials/map/mapsales.html'})
            .up()


        .segment('login', {
            templateUrl: 'partials/login.html',
            controller: 'authCtrl'})
        .segment('logout', {
            templateUrl: 'partials/login.html',
            controller: 'logoutCtrl'})
        .segment('dashboard', {
            templateUrl: 'partials/dashboard.html',
            controller: 'DashboardCtrl'})
            .within()
                    .segment('daftardahsboard', {
                        'default': true,
                        controller: 'DashboardListCtrl',
                        templateUrl: 'partials/dashboardtpl/daftardashboard.html'})
            .up()

        .segment('event', {
            templateUrl: 'partials/event/event.html',
            controller: 'EventCtrl'})

        .segment('pegawai', {
            templateUrl: 'partials/pegawai.html',
            controller: 'PegawaiCtrl'})
            .within()
                    .segment('daftarpegawai', {
                        'default': true,
                        controller: 'PegawaiListCtrl',
                        templateUrl: 'partials/pegawai/daftarpegawai.html'})
                        
                    .segment('tambahpegawai', {
                        controller: 'PegawaiAddCtrl',
                        templateUrl: 'partials/pegawai/tambahpegawai.html'})

                    .segment('editpegawai', {
                        controller: 'PegawaiEditCtrl',
                        templateUrl: 'partials/pegawai/editpegawai.html',
                        dependencies: ['id']})
                    
            .up()
        .segment('product', {
            templateUrl: 'partials/product.html',
            controller: 'ProductCtrl'})
            .within()
                    .segment('daftarproduct', {
                        'default': true,
                        controller: 'ProductListCtrl',
                        templateUrl: 'partials/product/daftarproduct.html'})
                        
                    .segment('tambahproduct', {
                        controller: 'ProductAddCtrl',
                        templateUrl: 'partials/product/tambahproduct.html'})

                    .segment('editproduct', {
                        controller: 'ProductEditCtrl',
                        templateUrl: 'partials/product/editproduct.html',
                        dependencies: ['id']})
                    
            .up()

         .segment('user', {
            templateUrl: 'partials/user.html',
            controller: 'UserCtrl'})
            .within()
                    .segment('daftaruser', {
                        'default': true,
                        controller: 'UserListCtrl',
                        templateUrl: 'partials/user/daftaruser.html'})
                        
                    .segment('tambahuser', {
                        controller: 'UserAddCtrl',
                        templateUrl: 'partials/user/tambahuser.html'})

                    .segment('edituser', {
                        controller: 'UserEditCtrl',
                        templateUrl: 'partials/user/edituser.html',
                        dependencies: ['id']})
                    
            .up()
        .segment('sales', {
            templateUrl: 'partials/sales.html',
            controller: 'SalesCtrl'})
            .within()
                    .segment('daftarsales', {
                        'default': true,
                        controller: 'SalesListCtrl',
                        templateUrl: 'partials/sales/daftarsales.html'})
                        
                    .segment('tambahsales', {
                        controller: 'SalesAddCtrl',
                        templateUrl: 'partials/sales/tambahsales.html'})

                    .segment('viewsales', {
                        controller: 'SalesViewCtrl',
                        templateUrl: 'partials/sales/viewsales.html',
                        dependencies: ['id']})

                    .segment('addtokopocket', {
                        controller: 'SalesTokoPocketCtrl',
                        templateUrl: 'partials/sales/addtokopocket.html',
                        dependencies: ['id']})
                    
                    .segment('editsales', {
                        controller: 'SalesEditCtrl',
                        templateUrl: 'partials/sales/editsales.html',
                        dependencies: ['id']})
                    
            .up()


            .segment('toko', {
            templateUrl: 'partials/toko.html',
            controller: 'TokoCtrl'})
            .within()
                    .segment('daftartoko', {
                        'default': true,
                        controller: 'TokoListCtrl',
                        templateUrl: 'partials/toko/daftartoko.html'})
                        
                    .segment('tambahtoko', {
                        controller: 'TokoAddCtrl',
                        templateUrl: 'partials/toko/tambahtoko.html'})

                    .segment('viewtoko', {
                        controller: 'TokoViewCtrl',
                        templateUrl: 'partials/toko/viewtoko.html',
                        dependencies: ['id']})

                    .segment('edittoko', {
                        controller: 'TokoEditCtrl',
                        templateUrl: 'partials/toko/edittoko.html',
                        dependencies: ['id']})

                    
            .up()

             .segment('laporantoko', {
            templateUrl: 'partials/laporantoko.html',
            controller: 'LaporanTokoCtrl'})
            .within()
                    .segment('daftarlaporantoko', {
                        'default': true,
                        controller: 'LaporanTokoListCtrl',
                        templateUrl: 'partials/laporantoko/daftarlaporantoko.html'})
          	     .segment('laporantokoexcel', {
                        controller: 'LaporanTokoExcelCtrl',
                        templateUrl: 'partials/laporantoko/laporantokoexcel.html'})
                    .segment('tambahlaporantoko', {
                        controller: 'LaporanTokoAddCtrl',
                        templateUrl: 'partials/laporantoko/tambahlaporantoko.html'})

                    .segment('editlaporantoko', {
                        controller: 'LaporanTokoEditCtrl',
                        templateUrl: 'partials/laporantoko/editlaporantoko.html',
                        dependencies: ['id']})
                    
            .up()


            .segment('area', {
            templateUrl: 'partials/area.html',
            controller: 'AreaCtrl'})
            .within()
                    .segment('daftararea', {
                        'default': true,
                        controller: 'AreaListCtrl',
                        templateUrl: 'partials/area/daftararea.html'})
                        
                    .segment('tambaharea', {
                        controller: 'AreaAddCtrl',
                        templateUrl: 'partials/area/tambaharea.html'})

                    .segment('editarea', {
                        controller: 'AreaEditCtrl',
                        templateUrl: 'partials/area/editarea.html',
                        dependencies: ['id']})
                    
            .up()


                    
    $routeProvider.otherwise({redirectTo: '/login'}); 

}).run(function ($rootScope, $location, Data,$templateCache,localStorageService,Access) {


console.log(Access);

        $rootScope.urlApi ='http://localhost/sales/'; //global variable

       /* 
         $rootScope.$on('$viewContentLoaded', function() {
                $templateCache.removeAll();

                     $templateCache.put('ng-table/filters/select-multiple.html', '<select ng-options="data.id as data.title for data in column.data" multiple ng-multiple="true" ng-model="params.filter()[name]" ng-show="filter==\'select-multiple\'" class="filter filter-select-multiple form-control" name="{{column.filterName}}"> </select>');
      $templateCache.put('ng-table/filters/select.html', '<select ng-options="data.id as data.title for data in column.data" ng-model="params.filter()[name]" ng-show="filter==\'select\'" class="filter filter-select form-control" name="{{column.filterName}}"> </select>');
      $templateCache.put('ng-table/filters/text.html', '<input type="text" name="{{column.filterName}}" ng-model="params.filter()[name]" ng-if="filter==\'text\'" class="input-filter form-control"/>');
      $templateCache.put('ng-table/header.html', '<tr> <th ng-repeat="column in $columns" ng-class="{ \'sortable\': parse(column.sortable), \'sort-asc\': params.sorting()[parse(column.sortable)]==\'asc\', \'sort-desc\': params.sorting()[parse(column.sortable)]==\'desc\' }" ng-click="sortBy(column, $event)" ng-show="column.show(this)" ng-init="template=column.headerTemplateURL(this)" class="header {{column.class}}"> <div ng-if="!template" ng-show="!template" ng-bind="parse(column.title)"></div> <div ng-if="template" ng-show="template"><div ng-include="template"></div></div> </th> </tr> <tr ng-show="show_filter" class="ng-table-filters"> <th ng-repeat="column in $columns" ng-show="column.show(this)" class="filter"> <div ng-repeat="(name, filter) in column.filter"> <div ng-if="column.filterTemplateURL" ng-show="column.filterTemplateURL"> <div ng-include="column.filterTemplateURL"></div> </div> <div ng-if="!column.filterTemplateURL" ng-show="!column.filterTemplateURL"> <div ng-include="\'ng-table/filters/\' + filter + \'.html\'"></div> </div> </div> </th> </tr>');
      $templateCache.put('ng-table/pager.html', '<div class="ng-cloak ng-table-pager"> <div ng-if="params.settings().counts.length" class="ng-table-counts btn-group pull-right"> <button ng-repeat="count in params.settings().counts" type="button" ng-class="{\'active\':params.count()==count}" ng-click="params.count(count)" class="btn btn-default"> <span ng-bind="count"></span> </button> </div> <ul class="pagination ng-table-pagination"> <li ng-class="{\'disabled\': !page.active}" ng-repeat="page in pages" ng-switch="page.type"> <a ng-switch-when="prev" ng-click="params.page(page.number)" href="">&laquo;</a> <a ng-switch-when="first" ng-click="params.page(page.number)" href=""><span ng-bind="page.number"></span></a> <a ng-switch-when="page" ng-click="params.page(page.number)" href=""><span ng-bind="page.number"></span></a> <a ng-switch-when="more" ng-click="params.page(page.number)" href="">&#8230;</a> <a ng-switch-when="last" ng-click="params.page(page.number)" href=""><span ng-bind="page.number"></span></a> <a ng-switch-when="next" ng-click="params.page(page.number)" href="">&raquo;</a> </li> </ul> </div> ');


        }); 
        */
	$rootScope.$on('$routeChangeStart', function(event, next, current) {
        if (typeof(current) !== 'undefined'){
            $templateCache.remove(current.templateUrl);
        }
	});

    /*
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;

                console.log("localStorageService:"+localStorageService.get('uid'));
                  if (localStorageService.get('uid')) {
                    $rootScope.authenticated = true;
                    $rootScope.uid = localStorageService.get('uid')
                    $rootScope.name = localStorageService.get('name')
                    $rootScope.email = localStorageService.get('email')
                } else {
                        $location.path("/login");
                }
        });

    */

    
    $rootScope.$on("$routeChangeStart", function(event, current, previous, rejection) {
     if (rejection == Access.UNAUTHORIZED) {
      $location.path("/login");
     } else if (rejection == Access.FORBIDDEN) {
      $location.path("/login");
        }
    });


    


});