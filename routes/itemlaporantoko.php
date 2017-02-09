<?php



$app->get('/itemlaporans', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

    $laporan_id=$_GET['laporan_id'];

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


  
  if(($filter <> '') AND ($laporan_id <> ''))
  {
    // query database for all articles
    $aData = \Itemlaporan::where('laporan_id', '=',$laporan_id)
      ->where('tanggal', '=',$filter)
      ->leftJoin('products', 'itemlaporans.product_id', '=', 'products.id')
      ->leftJoin('laporans', 'itemlaporans.laporan_id', '=', 'laporans.id')
      ->skip($pageSize*$pageNumber)
      ->select('laporans.id as laporan_id','itemlaporans.id as item_id','products.*','laporans.*','itemlaporans.*')
      ->take($pageSize)->orderBy('itemlaporans.id', 'DESC')
      ->get();

  }else if($filter)
  {
      $aData = \Itemlaporan::where('tanggal', '=',$filter)
      ->leftJoin('products', 'itemlaporans.product_id', '=', 'products.id')
      ->leftJoin('laporans', 'itemlaporans.laporan_id', '=', 'laporans.id')
      ->skip($pageSize*$pageNumber)
      ->select('laporans.id as laporan_id','itemlaporans.id as item_id','products.*','laporans.*','itemlaporans.*')
      ->take($pageSize)->orderBy('itemlaporans.id', 'DESC')
      ->get();

  }else if($laporan_id <> '')
  {
    // query database for all articles
    $aData = \Itemlaporan::where('laporan_id', '=',$laporan_id)
      ->leftJoin('products', 'itemlaporans.product_id', '=', 'products.id')
      ->leftJoin('laporans', 'itemlaporans.laporan_id', '=', 'laporans.id')
      ->skip($pageSize*$pageNumber)
      ->select('laporans.id as laporan_id','itemlaporans.id as item_id','products.*','laporans.*','itemlaporans.*')
      ->take($pageSize)->orderBy('itemlaporans.id', 'DESC')
      ->get();

  }
  else
  {
    $aData = \Itemlaporan::leftJoin('laporans', 'itemlaporans.laporan_id', '=', 'laporans.id')
      ->skip($pageSize*$pageNumber)
      ->select('laporans.id as laporan_id','itemlaporans.id as item_id' ,'laporans.*','itemlaporans.*')
      ->take($pageSize)->orderBy('itemlaporans.id', 'DESC')
      ->get();
  }


  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results

  echo $aData->toJson();
});




$app->post('/updateitem/:id', function ($id) use ($app) {  

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');


    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

  
    $aData = Itemlaporan::find($input->params->id);
    $aData->jumlah = $input->params->jumlah;
    $aData->save();

    echo $aData->toJson();
});


$app->delete('/deleteitem/:id', function ($id) use ($app){
    //Show book identified by $id
    $aData = Itemlaporan::find($id);
    $aData->delete();
    echo $aData->toJson();

});


