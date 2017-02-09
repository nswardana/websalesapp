<?php


$app->get('/getalltokos', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  $aData = \Toko::get();
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $aData->toJson();
});


$app->get('/tokosnopagging', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

    $filter = '';
    if(array_key_exists('filter', $_GET))
      $filter = $_GET['filter'];

     $sales_id = '';
    if(array_key_exists('sales_id', $_GET))
    {
      $sales_id = $_GET['sales_id'];
      $_GET['selected_sales']=$_GET['sales_id'];
    }

    $selected_area = '';
    if(array_key_exists('selected_area', $_GET) && $_GET['selected_area'] <> 0)
      $selected_area = $_GET['selected_area'];

    $selected_sales = '';
    if(array_key_exists('selected_sales', $_GET) && $_GET['selected_sales'] <> 0)
      $selected_sales = $_GET['selected_sales'];

   $selected_pocket = '';
    if(array_key_exists('selected_pocket', $_GET) && $_GET['selected_pocket'] <> 0)
      $selected_pocket = $_GET['selected_pocket'];
      


  if($selected_pocket=='')
  {
  
      if($selected_area && $selected_sales )
      {
           $aData = \Toko::where('tokos.sales_id', '=',$selected_sales)
           ->where('sales.area_id', '=',$selected_area)
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();

      }else if($selected_area && $selected_sales =='')
      {

        $aData = \Toko::where('sales.area_id', '=',$selected_area)
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();
      }
      else if($selected_area=="" && $selected_sales)
      {
        
        $aData = \Toko::where('tokos.sales_id', '=',$selected_sales)
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();
      }

      else if(($filter <> '') AND ($sales_id <> ''))
      {
        // query database for all articles
        $aData = \Toko::where('nama_toko', 'LIKE', '%'.$filter.'%')
          ->where('tokos.sales_id', '=',$sales_id)
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();

      }else if($filter)
      {
        $aData = \Toko::where('nama_toko', 'LIKE', '%'.$filter.'%')
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();

      }else if($sales_id <> '')
      {
        // query database for all articles
        $aData = \Toko::where('tokos.sales_id', '=',$sales_id)
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();

      }
      else
      {
        $aData = \Toko::leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();
      }


  }else
  {
     if($selected_area && $selected_sales )
      {
           $aData = \Toko::Pocket()->where('tokos.sales_id', '=',$selected_sales)
           ->where('sales.area_id', '=',$selected_area)
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();

      }else if($selected_area && $selected_sales =='')
      {

        $aData = \Toko::Pocket()->where('sales.area_id', '=',$selected_area)
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();
      }
      else if($selected_area=="" && $selected_sales)
      {
        
        $aData = \Toko::Pocket()->where('tokos.sales_id', '=',$selected_sales)
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();
      }

      else if(($filter <> '') AND ($sales_id <> ''))
      {
        // query database for all articles
        $aData = \Toko::Pocket()->where('nama_toko', 'LIKE', '%'.$filter.'%')
          ->where('tokos.sales_id', '=',$sales_id)
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();

      }else if($filter)
      {
        $aData = \Toko::Pocket()->where('nama_toko', 'LIKE', '%'.$filter.'%')
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();

      }else if($sales_id <> '')
      {
        // query database for all articles
        $aData = \Toko::Pocket()->where('tokos.sales_id', '=',$sales_id)
          ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();

      }
      else
      {
        $aData = \Toko::Pocket()->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
          ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
          ->orderBy('tokos.id', 'DESC')
          ->get();
      }

  }


  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results

  echo $aData->toJson();
});

//tokospersalesandpocket

$app->get('/tokospersalesandpocket', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

    $pageNumber = 0;
    if(array_key_exists('pageNumber', $_GET))
        $pageNumber = $_GET['pageNumber'];

    $pageSize = 10;
    if(array_key_exists('pageSize', $_GET))
        $pageSize = $_GET['pageSize'];


    $selected_sales = '';
    if(array_key_exists('selected_sales', $_GET) && $_GET['selected_sales'] <> 0)
      $selected_sales = $_GET['selected_sales'];

    $selected_pocket = '';
    if(array_key_exists('selected_pocket', $_GET) && $_GET['selected_pocket'] <> 0)
      $selected_pocket = $_GET['selected_pocket'];

   


  
  if(( $selected_pocket OR $selected_pocket==0) && $selected_sales)
  {
    $aData = \Toko::Sales()->Pocket()
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }else if ($selected_pocket=='' && $selected_sales)
  {
    $aData = \Toko::Sales()
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();
    
  }
  else if ($selected_pocket && $selected_sales=="")
  {

    $aData = \Toko::Pocket()
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }

  $app->response()->header('Content-Type', 'application/json');
  echo $aData->toJson();

});




$app->get('/tokos', function () use ($app) {  
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

    $sales_id = '';
    if(array_key_exists('sales_id', $_GET))
      $sales_id = $_GET['sales_id'];

    $selected_area = '';
    if(array_key_exists('selected_area', $_GET) && $_GET['selected_area'] <> 0)
      $selected_area = $_GET['selected_area'];

    $selected_sales = '';
    if(array_key_exists('selected_sales', $_GET) && $_GET['selected_sales'] <> 0)
      $selected_sales = $_GET['selected_sales'];

    $selected_pocket = '';
    if(array_key_exists('selected_pocket', $_GET) && $_GET['selected_pocket'] <> 0)
      $selected_pocket = $_GET['selected_pocket'];

   


  
  if($selected_area && $selected_sales && $selected_pocket && $filter)
  {

    $aData = \Toko::Sales()->Area()->Pocket()->where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }else if($selected_area=='' && $selected_pocket=='' && $selected_sales && $filter)
  {

    $aData = \Toko::Sales()->where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }
  else if($selected_area &&  $selected_pocket=='' && $selected_sales =='' && $filter)
  {

    $aData = \Toko::Area()->where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }
  else if($selected_area=='' && $selected_sales=='' &&  $selected_pocket=='' && $filter)
  {

    $aData = \Toko::where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }

  else if($selected_area=='' && $selected_pocket=='' && $selected_sales && $filter)
  {

    $aData = \Toko::Sales()->where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->where('tokos.sales_id', '=',$sales_id)
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }
  else if($selected_area  &&  $selected_pocket=='' && $selected_sales=='' && $filter=='')
  {

    $aData = \Toko::Area()
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }
  else if($selected_area=='' && $selected_sales &&  $selected_pocket=='' && $filter=='')
  {

    $aData = \Toko::Sales()
      ->where('tokos.sales_id', '=',$selected_sales)
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }

 else if($selected_area=='' && $selected_sales=='' &&  $selected_pocket=='' && $filter)
   {
    $aData = \Toko::where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }

  //dengan pocket
  else if($selected_area=='' && $selected_pocket && $selected_sales && $filter)
  {

    $aData = \Toko::Sales()->Pocket()->where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }
  else if($selected_area &&  $selected_pocket && $selected_sales =='' && $filter)
  {

    $aData = \Toko::Area()->Pocket()->where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }
  else if($selected_area=='' && $selected_sales=='' &&  $selected_pocket && $filter)
  {

    $aData = \Toko::Pocket()->where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }

  else if($selected_area=='' && $selected_pocket && $selected_sales && $filter)
  {

    $aData = \Toko::Sales()->Pocket()->where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->where('tokos.sales_id', '=',$sales_id)
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }
  else if($selected_area  && $selected_pocket && $selected_sales=='' && $filter=='')
  {

    $aData = \Toko::Area()->Pocket()
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }
  else if($selected_area=='' && $selected_sales &&  $selected_pocket && $filter=='')
  {

    $aData = \Toko::Sales()->Pocket()
      ->where('tokos.sales_id', '=',$selected_sales)
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }

 else if($selected_area=='' && $selected_sales=='' &&  $selected_pocket && $filter)
   {
    $aData = \Toko::Pocket()->where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }

  else if($selected_area=='' && $selected_sales=='' &&  $selected_pocket && $filter=="")
   {
    $aData = \Toko::Pocket()->where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }
  



  else if(($filter <> '') AND ($sales_id <> ''))
  {
    // query database for all articles
    $aData = \Toko::where('nama_toko', 'LIKE', '%'.$filter.'%')
      ->where('tokos.sales_id', '=',$sales_id)
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }else if($sales_id <> ''  )
  {
    // query database for all articles
    $aData = \Toko::where('tokos.sales_id', '=',$sales_id)
      ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();

  }
  else
  {
    $aData = \Toko::leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
      ->take($pageSize)->orderBy('tokos.id', 'DESC')
      ->get();
  }


  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results

  echo $aData->toJson();
});







$app->post('/tokopocket', function () use ($app) {  
    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');

    
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

   
   $arrData= $input->data;

   $arrData=$arrData[0];

  


    $aToko=$arrData->aToko;
    $pocket_id=$arrData->pocket_id;

     
    foreach ($aToko as $i=>$tokoId)
    {
        $aData = Toko::find($tokoId);
        $aData->pocket_id = $pocket_id;
        $aData->save();

    }
   
    $response['status'] = "success";
    $response['data'] = $input;
   
    echoResponse(200, $response);

});

$app->post('/tokos', function () use ($app) {  
    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');

    
 	  $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $aData = new Toko;

  	$aData->nama_toko = $input->data->nama_toko;
    $aData->no_toko = $input->data->no_toko;
    $aData->no_telp = $input->data->no_telp;
    $aData->pemilik = $input->data->pemilik;
    $aData->alamat = $input->data->alamat;
    $aData->keterangan = $input->data->keterangan;
    $aData->longitude = $input->data->longitude;
    $aData->latitude = $input->data->latitude;
    $aData->sales_id = $input->data->sales_id;
    $aData->pocket_id = $input->data->pocket_id;
       


    if( $aData->save() )
    {
      $response['data'] = $aData;
      $response['status'] = "success";
      $response['message'] = 'Berhasil menambah data';   
    }else
    {
      $response['status'] = "error";
      $response['message'] = 'Gagal menambah data';   
    }

    echoResponse(200, $response);

});

$app->get('/tokobysales', function () use ($app) {  
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

    $sales_id = '';
    if(array_key_exists('sales_id', $_GET))
      $sales_id = $_GET['sales_id'];

    $pocket_id = '';
    if(array_key_exists('pocket_id', $_GET))
      $pocket_id = $_GET['pocket_id'];

    if($filter=='undefined')
        $filter='';
    if($pocket_id==0)
      $pocket_id='';

  

    if(($filter <> '') AND ($sales_id <> '') AND ($pocket_id <> ''))
    {
      // query database for all articles
      $aData = \Toko::where('nama_toko', 'LIKE', '%'.$filter.'%')
        ->where('tokos.sales_id', '=',$sales_id)
        ->where('tokos.pocket_id', '=',$pocket_id)
        ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
        ->skip($pageSize*$pageNumber)
        ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
        ->take($pageSize)->orderBy('tokos.id', 'DESC')
        ->get();

    }
    else if(($filter <> '') AND ($sales_id <> '') AND ($pocket_id ==''))
    {
         // query database for all articles
      $aData = \Toko::where('nama_toko', 'LIKE', '%'.$filter.'%')
        ->where('tokos.sales_id', '=',$sales_id)
        ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
        ->skip($pageSize*$pageNumber)
        ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
        ->take($pageSize)->orderBy('tokos.id', 'DESC')
        ->get();

    }
    else if(($filter == '') AND ($sales_id <> '') AND ($pocket_id <> ''))
    {
         // query database for all articles
      $aData = \Toko::where('tokos.sales_id', '=',$sales_id)
        ->where('tokos.pocket_id', '=',$pocket_id)
        ->leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
        ->skip($pageSize*$pageNumber)
        ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
        ->take($pageSize)->orderBy('tokos.id', 'DESC')
        ->get();

    }
    else if($sales_id <> '' AND ($filter =='') AND ($pocket_id ==''))
    {
      // query database for all articles
      $aData = \Toko::leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
        ->select('tokos.id as toko_id' ,'tokos.*','sales.*')
        ->take($pageSize)->orderBy('tokos.id', 'DESC')
        ->get();

    }
  

  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results

  echo $aData->toJson();
});

$app->get('/tokos/:id', function ($id) use ($app){
    //Show book identified by $id
  $aData = \Toko::leftJoin('sales', 'tokos.sales_id', '=', 'sales.id')
      ->select('tokos.id as toko_id' ,'tokos.sales_id as sales_id','tokos.*','sales.*')
      ->find($id);

  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  // return JSON-encoded response body with query results
  echo $aData->toJson();
});



$app->post('/tokos/:id', function ($id) use ($app) {  

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');


    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $aData = Toko::find($id);
    
    $aData->nama_toko = $input->data->nama_toko;
    $aData->no_toko = $input->data->no_toko;
    $aData->no_telp = $input->data->no_telp;
    $aData->pemilik = $input->data->pemilik;
    $aData->alamat = $input->data->alamat;
    $aData->keterangan = $input->data->keterangan;
    $aData->longitude = $input->data->longitude;
    $aData->latitude = $input->data->latitude;
    $aData->sales_id = $input->data->sales_id;
    $aData->pocket_id = $input->data->pocket_id;

    $aData->save();

    echo $aData->toJson();
});

$app->post('/tokopicure/:id', function ($id) use ($app) {  
    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');

    $response['files']  =$_FILES;
    $filename           ="toko".$id.".jpg";

    if( saveImageToko($filename))
    {
      $aData = Toko::find($id);
      $aData->toko_image = $filename;
      $aData->save();

      $response['status'] = "success";
      $response['message'] = 'Berhasil mengupload data';   
   
    }else
    {
        $response['status'] = "error";
       $response['message'] = 'Gagal mengupload data';   
 
    }
    
   
    echoResponse(200, $response);

});


$app->delete('/tokos/:id', function ($id) use ($app){
    //Show book identified by $id
    $toko = Toko::find($id);
    $toko->delete();
    echo $toko->toJson();

});



$app->get('/getsummarytoko', function () use ($app) {  

 $aData=array();
 
 for($i=0;$i<7;$i++)
 {
  $date=mysql_date_add('now()', "INTERVAL -".$i." DAY");

    $aData['summarybydate']['toko'][$i]['date']   =$date;
    $aData['summarybydate']['toko'][$i]['jumlah']=Toko::where('created_at','<=',$date)->count();

    $aData['summarybydate']['sales'][$i]['date']   =$date;
    $aData['summarybydate']['sales'][$i]['jumlah']=Sales::where('created_at','<=',$date)->count();
    
 }

 $aData['summarybydate']['totaltoko']=Toko::count();
 $aData['summarybydate']['totalsales']=Sales::count();


 echoResponse(200, $aData);


});


function mysql_date_add($now = null, $adjustment )
{     
        // normal mysql format is:   date_add(now(), INTERVAL 1 MONTH)
        // its close to the strtotime() format, but we need to make a few adjustments
        // first we lowercase everything, not sure if this is needed but it seems
        // to be both mysql conventions to be capitalized and php to lowercase this, so
        // i follow suit.
        $adjustment = strtolower($adjustment);
        // next we want to get rid of the INTERVAL part, as neither it nor a corrisponding
        // keyword used in the strtotime() function.   remmeber its lowercase now.
        $adjustment = str_replace('interval', '', $adjustment);
        // now the adjustment is suppsoed to have a + or - next to it to indicate direction
        // since strtotime() can be used to go both ways.  We want to tack this one, but first
        // strip any white space off the begining of the $adjustment so we dont wind up with like
        //  +     1         when we need    +1
        $adjustment = '+' . trim($adjustment);
        // we should now be left with something like '+1 month'  which is valid strtotime() syntax!
        // next we need to handle the $now, normally people would pass now() if they want the current
        // time or a datetime/timestamp.    We will need to account for this as well, we also
        // want to make use of having a default to now() type of behavior.    we want to also
        // trim and lowercase what they send us just to make it easier to compair to
        if (is_null($now) || strtolower(trim($now)) == 'now()')
        {
                // defaulted to or requested a the current time
                $now = time();
        }
        else
        {
                // here we are splitting out each part of the mysql timestamp , and storing it in the $parts array
                 preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $now, $parts);
                // now we use each of the parts to generate a timestamp from it
                $now = mktime($parts[4], $parts[5], $parts[6], $parts[2], $parts[3], $parts[1]);
        }
        // now we finally call strtotime() with the properly formatted text and get the date/time
        // calculates done.  I specify its returned as an integer to make things play more nicely
        // with eachother in case the conversion fails.
        $timestamp = (integer)strtotime($adjustment, $now);
        // finally we have the timestamp of the adjusted date nowe we just convert it back to the mysql
        // format and send it back to them.
        return date('Y-m-d', $timestamp);
}



function saveImageToko($filename){
    if( move_uploaded_file($_FILES['file']['tmp_name'], "images/toko/".$filename) )
      return true;
    else
      return false;

    
}