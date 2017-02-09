<?php


$app->get('/getallcheckin', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  $aData = \Sales::get();
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $aData->toJson();
});


$app->get('/checkins', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

    $pageNumber = 0;
    if(array_key_exists('pageNumber', $_GET))
        $pageNumber = $_GET['pageNumber'];

    $pageSize = 10;
    if(array_key_exists('pageSize', $_GET))
        $pageSize = $_GET['pageSize'];

    $filter = '';
    if(array_key_exists('filter', $_GET))
      $filter = $_GET['filter'];

 // query database for all articles
  if($filter)
  {
    // query database for all articles
    $aData = \Checkin::where('sales.sales_name', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'checkins.*','areas.*')
      ->take($pageSize)->orderBy('checkins.id', 'DESC')
      ->get();
  }else
  {
    $aData = \Checkin::leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'checkins.*','sales.*')
      ->take($pageSize)->orderBy('checkins.id', 'DESC')
      ->get();
  }


  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results
  echo $aData->toJson();
});


$app->get('/checkinsby', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');



  $checkin_date = date("Y-m-d");
  $rangeTanggal="";
  if(array_key_exists('rangeTanggal', $_GET))
    {
      $checkin_date ='';

      $rangeTanggal=$_GET['rangeTanggal'];
      $aDataRange=json_decode($rangeTanggal);


      $timestamp = strtotime(trim($aDataRange->startDate));
      $startDate=date("Y-m-d", $timestamp);
    
      $timestamp = strtotime(trim($aDataRange->endDate));
      $endDate=date("Y-m-d", $timestamp);
    }


    

 $selected_sales = '';
    if(array_key_exists('selected_sales', $_GET) && $_GET['selected_sales'] <> 0 )
    {
        $selected_sales = $_GET['selected_sales'];

    }

 $selected_area = '';
    if(array_key_exists('selected_area', $_GET) && $_GET['selected_area'] <> 0 )
        $selected_area = $_GET['selected_area'];

  $selected_pocket = '';
    if(array_key_exists('selected_pocket', $_GET) && $_GET['selected_pocket'] <> 0 )
        $selected_pocket = $_GET['selected_pocket'];



 $filter = '';
    if(array_key_exists('filter', $_GET))
      $filter = $_GET['filter'];



  if($selected_pocket=="")
  {
     
     // query database for all articles
      if($selected_sales && $selected_area && $rangeTanggal)
      {
        // query database for all articles
        $aData = \Checkin::where('sales.id', '=', $selected_sales)
          ->where('sales.area_id', '=', $selected_area)
          ->where('checkin_date','>=',$startDate)->where('checkin_date','<=',$endDate)
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
      
      else if($selected_area && $rangeTanggal)
      {


        // query database for all articles
        $aData = \Checkin::where('sales.area_id', '=', $selected_area)
          ->where('checkin_date','>=',$startDate)->where('checkin_date','<=',$endDate)
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
       else if($selected_sales && $rangeTanggal)
      {
        // query database for all articles
        $aData = \Checkin::where('sales.id', '=', $selected_sales)
           ->where('checkin_date','>=',$startDate)->where('checkin_date','<=',$endDate)
         ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }

      else if($filter && $rangeTanggal)
      {

        // query database for all articles
        $aData = \Checkin::where('sales.sales_name', 'LIKE', "'%".$filter."%'")
          ->where('checkin_date','>=',$startDate)->where('checkin_date','<=',$endDate)
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }

      if($selected_sales && $selected_area && $checkin_date)
      {
        // query database for all articles
        $aData = \Checkin::where('sales.id', '=', $selected_sales)
          ->where('sales.area_id', '=', $selected_area)
          ->where("checkin_date", '=',"".$checkin_date."")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
      
      else if($selected_area && $checkin_date)
      {
        // query database for all articles
        $aData = \Checkin::where('sales.area_id', '=', $selected_area)
          ->where("checkin_date", '=',"".$checkin_date."")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
       else if($selected_sales && $checkin_date)
      {
        // query database for all articles
        $aData = \Checkin::where('sales.id', '=', $selected_sales)
          ->where("checkin_date", '=',"".$checkin_date."")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }

      else if($filter && $checkin_date)
      {

        // query database for all articles
        $aData = \Checkin::where('sales.sales_name', 'LIKE', "'%".$filter."%'")
          ->where("checkin_date", '=',"".$checkin_date."")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }

      else if($checkin_date && $filter)
      {

        // query database for all articles
        $aData = \Checkin::where("checkin_date", '=',"".$checkin_date."")
          ->where('sales.sales_name', 'LIKE', "'%".$filter."%'")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
        
      }

       else if($checkin_date && $filter=='')
      {

        // query database for all articles
        $aData = \Checkin::where("checkin_date", '=',"".$checkin_date."")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
        
      }

      else if($rangeTanggal && $selected_area=="" && $selected_sales=="")
      {


        // query database for all articles
        $aData = \Checkin::where('checkin_date','>=',$startDate)->where('checkin_date','<=',$endDate)
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
      else if($filter)
      {
        // query database for all articles
        $aData = \Checkin::where('sales.sales_name', 'LIKE', "'%".$filter."%'")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
  }else
  {

      // query database for all articles
      if($selected_sales && $selected_area && $rangeTanggal)
      {
        // query database for all articles
        $aData = \Checkin::Pocket()->where('sales.id', '=', $selected_sales)
          ->where('sales.area_id', '=', $selected_area)
          ->where('checkin_date','>=',$startDate)->where('checkin_date','<=',$endDate)
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
      
      else if($selected_area && $rangeTanggal)
      {


        // query database for all articles
        $aData = \Checkin::Pocket()->where('sales.area_id', '=', $selected_area)
          ->where('checkin_date','>=',$startDate)->where('checkin_date','<=',$endDate)
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
       else if($selected_sales && $rangeTanggal)
      {
        // query database for all articles
        $aData = \Checkin::Pocket()->where('sales.id', '=', $selected_sales)
           ->where('checkin_date','>=',$startDate)->where('checkin_date','<=',$endDate)
         ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }

      else if($filter && $rangeTanggal)
      {

        // query database for all articles
        $aData = \Checkin::Pocket()->where('sales.sales_name', 'LIKE', "'%".$filter."%'")
          ->where('checkin_date','>=',$startDate)->where('checkin_date','<=',$endDate)
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }

      if($selected_sales && $selected_area && $checkin_date)
      {
        // query database for all articles
        $aData = \Checkin::where('sales.id', '=', $selected_sales)
          ->where('sales.area_id', '=', $selected_area)
          ->where("checkin_date", '=',"".$checkin_date."")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
      
      else if($selected_area && $checkin_date)
      {
        // query database for all articles
        $aData = \Checkin::Pocket()->where('sales.area_id', '=', $selected_area)
          ->where("checkin_date", '=',"".$checkin_date."")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
       else if($selected_sales && $checkin_date)
      {
        // query database for all articles
        $aData = \Checkin::Pocket()->where('sales.id', '=', $selected_sales)
          ->where("checkin_date", '=',"".$checkin_date."")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }

      else if($filter && $checkin_date)
      {

        // query database for all articles
        $aData = \Checkin::Pocket()->where('sales.sales_name', 'LIKE', "'%".$filter."%'")
          ->where("checkin_date", '=',"".$checkin_date."")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }

      else if($checkin_date && $filter)
      {

        // query database for all articles
        $aData = \Checkin::Pocket()->where("checkin_date", '=',"".$checkin_date."")
          ->where('sales.sales_name', 'LIKE', "'%".$filter."%'")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
        
      }

       else if($checkin_date && $filter=='')
      {

        // query database for all articles
        $aData = \Checkin::Pocket()->where("checkin_date", '=',"".$checkin_date."")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
        
      }

      else if($rangeTanggal && $selected_area=="" && $selected_sales=="")
      {


        // query database for all articles
        $aData = \Checkin::Pocket()->where('checkin_date','>=',$startDate)->where('checkin_date','<=',$endDate)
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }
      else if($filter)
      {
        // query database for all articles
        $aData = \Checkin::Pocket()->where('sales.sales_name', 'LIKE', "'%".$filter."%'")
          ->leftJoin('sales', 'checkins.sales_id', '=', 'sales.id')
          ->leftJoin('tokos', 'checkins.toko_id', '=', 'tokos.id')
          ->select('checkins.id as id','sales.id as sales_id' ,'checkins.*','sales.*','tokos.*')
          ->orderBy('checkins.id', 'DESC')
          ->get();
      }


  }

  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results
  echo $aData->toJson();
});



$app->post('/checkins', function () use ($app) {  

    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');

    
 	  $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $aData = new Checkin;
    $aData->toko_id = $input->data->toko_id;
    $aData->sales_id = $input->data->sales_id;
    $aData->checkin_longitude = $input->data->longitude;
    $aData->checkin_latitude = $input->data->latitude;
    $aData->checkin_hours   =date('H:i:s');
    
    
    $aData->checkin_note = "checkin";
    $aData->checkin_date = date('Y-m-d H:i:s');
        

    if( $aData->save() )
    {
      $response['status'] = "success";
      $response['message'] = 'Berhasil menambah data';   
   
    }else
    {
      $response['status'] = "error";
      $response['message'] = 'Gagal menambah data';   
    }

    echoResponse(200, $response);

});


