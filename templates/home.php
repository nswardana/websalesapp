<!DOCTYPE html>
<html ng-app="usercatApp">
    <head>
        <meta charset="UTF-8">
        <title>Sistem Applikasi Sales</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link rel="stylesheet" href="bower_components/bootstrap/bower_components/bootstrap/dist/css/bootstrap.css">

        <link rel="stylesheet" href="bower_components/angularjs-toaster/toaster.css">
        <link rel="styleSheet" href="bower_components/angular-ui-grid/ui-grid.css"/>
       
        
        <!-- font Awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="css/ionicons.min.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="css/morris/morris.css">
        <!-- fullCalendar -->
        <link rel="stylesheet" href="css/fullcalendar/fullcalendar.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="css/daterangepicker/daterangepicker-bs3.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="css/AdminLTE.css">
        <link rel="stylesheet" href="bower_components/fullcalendar/fullcalendar.css"/>
        
        
    </head>
    <body class="skin-green" ng-controller="MainCtrl">
        <header class="header">
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle butto\n-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
              
            </nav>
        </header>
        

        <toaster-container></toaster-container>
        <route-loading-indicator></route-loading-indicator>
        <div class="wrapper row-offcanvas row-offcanvas-left"  app-view-segment="0  
        \]\]">
        </div>
        <!-- add new calendar event modal -->
    </body>

          <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>   
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js"></script>
        <!-- fullCalendar -->
        <script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="js/plugins/jqueryKnob/jquery.knob.js"></script>
        
        
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/AdminLTE/dashboard.js"></script>

        <!--<script src='//maps.googleapis.com/maps/api/js?sensor=false'></script>-->
	
	<!--
	<script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>        
        -->
	<script src="bower_components/angular/angular.js"></script>
        <script src="bower_components/angular-bootstrap/ui-bootstrap.js"></script>
        <script src="bower_components/angular-bootstrap/ui-bootstrap-tpls.js"></script>
        <script src="bower_components/angular-route/angular-route.js"></script>
        <script src="bower_components/angular-resource/angular-resource.js"></script>
        <script src="bower_components/ng-table/ng-table.js"></script>
        <script src="bower_components/angular-datepicker/app/scripts/datePicker.js"></script>
        <script src="bower_components/angular-datepicker/app/scripts/dateRange.js"></script>
        <script src="bower_components/angular-datepicker/app/scripts/input.js"></script>
        <script src="bower_components/angular-animate/angular-animate.js"></script>
        <script src="bower_components/angularjs-toaster/toaster.js"></script>
        <script src="bower_components/angular-route-segment/build/angular-route-segment.js"></script>
        <!-- <script src="bower_components/angular-ui-grid/ui-grid.js"></script> -->
        <script src="bower_components/angular-ui-grid/ui-grid-unstable.js"></script>
        <script src="bower_components//angular-local-storage/dist/angular-local-storage.min.js"></script>

        <script type="text/javascript" src="bower_components/angular-ui-calendar/src/calendar.js"></script>
        <script type="text/javascript" src="bower_components/fullcalendar/fullcalendar.js"></script>
        <script type="text/javascript" src="bower_components/fullcalendar/gcal.js"></script>

 <script src="bower_components/angular-loading-bar/build/loading-bar.min.js"></script>
        <link href="bower_components/angular-loading-bar/build/loading-bar.min.css" rel='stylesheet' />

        <script src='js/angular-google-maps.min.js'></script>
        <script src='js/lodash.js'></script>
        
        <!-- daterangepicker -->
        <script src="js/plugins/angular-daterangepicker.js"></script>
        <script src="js/plugins/currency/ng-currency.js"></script>
        <script src="js/plugins/ngToast/ngToast.js"></script>
        <script src="js/plugins/ngToast/angular-sanitize.js"></script>
        <script src="js/plugins/FileSaver.js"></script>
                



        <script src="js/imageupload.js"></script>
        <script src="js/ng-upload.js"></script>
    
        <script src="js/app.js"></script>
        <script src="js/services.js"></script>
        <script src="js/factory.js"></script>
        <script src="js/directives.js"></script>
        <script src="js/controllers.js"></script>
        <script src="js/controller/auth.js"></script>
        <script src="js/controller/pegawai.js"></script>
        <script src="js/controller/product.js"></script>
        <script src="js/controller/user.js"></script>
        <script src="js/controller/sales.js"></script>
        <script src="js/controller/toko.js"></script>
        <script src="js/controller/area.js"></script>
        <script src="js/controller/map.js"></script>
       <script src="js/controller/laporantoko.js"></script>
       
        <script src="js/controller/dashboard.js"></script>
        <script src="js/controller/user.js"></script>
        <script src="js/controller/event.js"></script>
        <script src="js/controller/attendance.js"></script>

</html>
