<?php

$app->get('/birthdays', function () use ($app) {  
  // query database for all articles
  $books = \User::take(10)->get();
   
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $books->toJson();
});


$app->get('/users', function () use ($app) {  

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
  $books = \User::where('username', 'LIKE', '%'.$filter.'%')->skip($pageSize*$pageNumber)->take($pageSize)->orderBy('id', 'DESC')->get();
   
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results
  echo $books->toJson();
});


$app->options('/users', function () use ($app) {  

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
  $books = \User::where('username', 'LIKE', '%'.$filter.'%')->skip($pageSize*$pageNumber)->take($pageSize)->get();
   
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
 
  
  // return JSON-encoded response body with query results
  echo $books->toJson();
});


$app->get('/users-count', function () use ($app) {  
  
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo \User::count();
});


$app->get('/users/:id', function ($id) use ($app){
    //Show book identified by $id
    $books = \User::find($id);
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  // return JSON-encoded response body with query results
  echo $books->toJson();
});

$app->delete('/users/:id', function ($id) use ($app){
    //Show book identified by $id
    $user = User::find($id);
    $user->delete();
    echo $user->toJson();

});

$app->post('/users', function () use ($app) {  
 	  $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $user = new User;

  	$user->name = $input->name;
    $user->username = $input->username;
    $user->email = $input->email;
    $user->password = $input->password;
    
  	$user->save();

    echo $user->toJson();
});

$app->post('/users/:id', function ($id) use ($app) {  
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $user = User::find($input->id);
    
    $user->name = $input->name;
    $user->username = $input->username;
    $user->email = $input->email;
    $user->password = $input->password;

    $user->save();

    echo $user->toJson();
});

$app->post('/changepasswd/:id', function ($id) use ($app) {  
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');


    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $user = User::find($id);
    $user->password = $input->data->password;
    
    if(  $user->save() )
    {
      $response['status'] = "success";
      $response['message'] = 'Berhasil mengubah data';   
   
    }else
    {
      $response['status'] = "error";
      $response['message'] = 'Gagal mengubah data';   
    }
     
     echoResponse(200, $response);

});