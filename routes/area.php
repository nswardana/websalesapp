<?php


$app->get('/areas', function () use ($app) {  
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
  $aData = \Area::where('area_name', 'LIKE', '%'.$filter.'%')->skip($pageSize*$pageNumber)->take($pageSize)->orderBy('id', 'DESC')->get();
   
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results
  echo $aData->toJson();
});


$app->get('/getallareas', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  
 // query database for all articles
  $aData = \Area::get();
   
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results
  echo $aData->toJson();
});



$app->post('/areas', function () use ($app) {  

    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');

    
 	  $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 


    $aData = new Area;
  	$aData->area_name = $input->area_name;
    $aData->area_desc = $input->area_desc;
         

    if( $aData->save() )
    {
        $response['data']['areas'] = $aData;
        $response['status'] = "success";
        $response['message'] = 'Berhasil menambah data';   
     
    }else
    {
      $response['status'] = "error";
      $response['message'] = 'Gagal menambah data';   
    }

    echoResponse(200, $response);

});


$app->get('/areas/:id', function ($id) use ($app){
    //Show book identified by $id
  $aData = \Area::find($id);
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  // return JSON-encoded response body with query results
  echo $aData->toJson();
});



$app->post('/areas/:id', function ($id) use ($app) {  

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');


    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $aData = Area::find($input->id);
    $aData->area_name = $input->area_name;
    $aData->area_desc = $input->area_desc;
    $aData->save();

    echo $aData->toJson();
});


$app->delete('/areas/:id', function ($id) use ($app){
    //Show book identified by $id
    $areas = Area::find($id);
    $areas->delete();
    echo $areas->toJson();

});


