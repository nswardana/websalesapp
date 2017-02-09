<?php


$app->get('/getallsales', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  $aData = \Sales::get();
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $aData->toJson();
});

/*
$app->get('/sales', function () use ($app) {  
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
    $aData = \Sales::where('sales_name', 'LIKE', '%'.$filter.'%')
      ->leftJoin('areas', 'sales.area_id', '=', 'areas.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'sales.*','areas.*')
      ->take($pageSize)->orderBy('sales.id', 'DESC')
      ->get();
  }else
  {
    $aData = \Sales::leftJoin('areas', 'sales.area_id', '=', 'areas.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'sales.*','areas.*')
      ->take($pageSize)->orderBy('sales.id', 'DESC')
      ->get();
  }


  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results
  echo $aData->toJson();
});

*/


$app->get('/sales', function () use ($app) {  
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

 
    $selected_area = '';
    if(array_key_exists('selected_area', $_GET) && $_GET['selected_area'] <> 0)
      $selected_area = $_GET['selected_area'];

    $selected_sales = '';
    if(array_key_exists('selected_sales', $_GET) && $_GET['selected_sales'] <> 0)
      $selected_sales = $_GET['selected_sales'];
   


  if($selected_area && $selected_sales && $filter)
  {

     // query database for all articles
    $aData = \Sales::Area()->Sales()->where('sales_name', 'LIKE', '%'.$filter.'%')
      ->leftJoin('areas', 'sales.area_id', '=', 'areas.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'sales.*','areas.*')
      ->take($pageSize)->orderBy('sales.id', 'DESC')
      ->get();

  }
  else if($selected_area && $selected_sales=="" && $filter)
  {

     // query database for all articles
    $aData = \Sales::Area()->where('sales_name', 'LIKE', '%'.$filter.'%')
      ->leftJoin('areas', 'sales.area_id', '=', 'areas.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'sales.*','areas.*')
      ->take($pageSize)->orderBy('sales.id', 'DESC')
      ->get();

  }
   else if($selected_area=="" && $selected_sales && $filter)
  {

     // query database for all articles
    $aData = \Sales::Sales()->where('sales_name', 'LIKE', '%'.$filter.'%')
      ->leftJoin('areas', 'sales.area_id', '=', 'areas.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'sales.*','areas.*')
      ->take($pageSize)->orderBy('sales.id', 'DESC')
      ->get();

  }
  else if($selected_area && $selected_sales && $filter=="")
  {
     // query database for all articles
    $aData = \Sales::Area()->Sales()
      ->leftJoin('areas', 'sales.area_id', '=', 'areas.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'sales.*','areas.*')
      ->take($pageSize)->orderBy('sales.id', 'DESC')
      ->get();

  }

  else if($selected_area && $selected_sales=="" && $filter=="")
  {
     // query database for all articles
    $aData = \Sales::Area()
      ->leftJoin('areas', 'sales.area_id', '=', 'areas.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'sales.*','areas.*')
      ->take($pageSize)->orderBy('sales.id', 'DESC')
      ->get();

  }

 else if($selected_area=="" && $selected_sales && $filter=="")
  {
     // query database for all articles
    $aData = \Sales::Sales()
      ->leftJoin('areas', 'sales.area_id', '=', 'areas.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'sales.*','areas.*')
      ->take($pageSize)->orderBy('sales.id', 'DESC')
      ->get();

  }
   else if($selected_area=="" && $selected_sales=="" && $filter)
  {
    // query database for all articles
    $aData = \Sales::where('sales_name', 'LIKE', '%'.$filter.'%')
      ->leftJoin('areas', 'sales.area_id', '=', 'areas.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'sales.*','areas.*')
      ->take($pageSize)->orderBy('sales.id', 'DESC')
      ->get();

  }
  else
  {
    $aData = \Sales::leftJoin('areas', 'sales.area_id', '=', 'areas.id')
      ->skip($pageSize*$pageNumber)
      ->select('sales.id as sales_id' ,'sales.*','areas.*')
      ->take($pageSize)->orderBy('sales.id', 'DESC')
      ->get();
  }


  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results
  echo $aData->toJson();
});


$app->post('/sales', function () use ($app) {  

    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');

    
 	  $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 



    $aData = new Sales;
  	$aData->sales_name = $input->sales_name;
    $aData->sales_email = $input->sales_email;
    $aData->sales_alamat = $input->sales_alamat;
    $aData->sales_hp = $input->sales_hp;
    $aData->sales_bergabung = $input->sales_bergabung;
    $aData->sales_password = $input->sales_password;
    $aData->area_id = $input->area_id;
         

    if( $aData->save() )
    {

        $user = new User;
        $user->name = $aData->sales_name;
        $user->username = $aData->sales_email;
        $user->email = $aData->sales_email;
        $user->password = $aData->sales_password;
        $user->sales_id = $aData->id;
        
        if($user->save())
        {
            $updateuser = Sales::find($aData->id);
            $updateuser->user_id = $user->id;
            $updateuser->save();

            $response['data']['sales'] = $aData;
            $response['data']['user'] = $user;
            $response['status'] = "success";
            $response['message'] = 'Berhasil menambah data';   
        }else
        {
            $response['status'] = "error";
            $response['message'] = 'Gagal menambah data';   
        }
     
    }else
    {
      $response['status'] = "error";
      $response['message'] = 'Gagal menambah data';   
    }

    echoResponse(200, $response);

});

$app->post('/salesuploadpicture/:id', function ($id) use ($app){
  
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

    $filename           ="sales".$id."-".$_FILES['file']['name'];

    if( saveSalesImage($filename))
    {
      $aData = Sales::find($id);
      $aData->sales_foto = $filename;
      $aData->save();
      $response['status'] = "success";
      $response['message'] = 'Berhasil mengupload data';   
   
    }else
    {
       $response['status'] = "error";
       $response['message'] = 'Gagal mengupload data';   
 
    }

  // return JSON-encoded response body with query results
  echoResponse(200, $response);

});


$app->post('/salesuploadicon/:id', function ($id) use ($app){
  
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

   $filename           ="sales".$id."-".$_FILES['file']['name'];
    if( saveSalesIcon($filename))
    {
      $aData = Sales::find($id);
      $aData->sales_map_icon = $filename;
      $aData->save();
      $response['status'] = "success";
      $response['message'] = 'Berhasil mengupload data';   
   
    }else
    {
       $response['status'] = "error";
       $response['message'] = 'Gagal mengupload data';   
 
    }

  // return JSON-encoded response body with query results
  echoResponse(200, $response);

});



function saveSalesImage($filename){
    
    if( move_uploaded_file($_FILES['file']['tmp_name'], "images/sales/".$filename) )
      return true;
    else
      return false;

    
}

function saveSalesIcon($filename){
    
    if( move_uploaded_file($_FILES['file']['tmp_name'], "images/salesicon/".$filename) )
      return true;
    else
      return false;

    
}

$app->get('/sales/:id', function ($id) use ($app){
    //Show book identified by $id
  $aData = \Sales::find($id);
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  // return JSON-encoded response body with query results
  echo $aData->toJson();
});



$app->post('/sales/:id', function ($id) use ($app) {  

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');


    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $aData = Sales::find($input->id);
    
    $aData->sales_name = $input->sales_name;
    $aData->sales_email = $input->sales_email;
    $aData->sales_alamat = $input->sales_alamat;
    $aData->sales_hp = $input->sales_hp;
    $aData->sales_bergabung = $input->sales_bergabung;
    $aData->sales_password = $input->sales_password;
    $aData->area_id = $input->area_id;
   
     

    $aData->save();

    echo $aData->toJson();
});

$app->post('/salespicure/:id', function ($id) use ($app) {  
    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');

    $response['files']  =$_FILES;
    $filename           ="sale".$id.".jpg";

    if( saveImage($filename))
    {
      $aData = sales::find($id);
      $aData->sales_image = $filename;
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



$app->delete('/sales/:id', function ($id) use ($app){
    //Show book identified by $id

    $aSales = \Sales::find($id);

    if($aSales->delete() )
    {

       $aUser = \User::find($aSales->user_id);
       $aUser->delete();

   
      echo $aSales->toJson();
    }
    else
    {
      echo "gagal";
    }



});


function saveImage($filename){

    if( move_uploaded_file($_FILES['file']['tmp_name'], "images/sale/".$filename) )
      return true;
    else
      return false;

    
}