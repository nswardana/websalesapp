<?php
$app->get('/events', function () use ($app) {  

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
  $events = \Event::where('name', 'LIKE', '%'.$filter.'%')->skip($pageSize*$pageNumber)->take($pageSize)->get();
   
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $events->toJson();
});



$app->get('/events-count', function () use ($app) {  
  
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo \Event::count();
});


$app->get('/events/:id', function ($id) use ($app){
    //Show book identified by $id
    $events = \Event::find($id);
   
  
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $events->toJson();
});

$app->delete('/events/:id', function ($id) use ($app){
    //Show book identified by $id
    $event = User::find($id);
    $event->delete();
});

$app->post('/events', function () use ($app) {  
 	
 	$request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $event = new Event;

  	$event->name = $input->name;
    $event->location = $input->location;
    
  	$event->save();

    echo $event->toJson();
});

$app->post('/events/:id', function ($id) use ($app) {  
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $event = Event::find($input->id);
    
    $event->name = $input->name;
    $event->location = $input->location;
    
    $event->save();

    echo $event->toJson();
});