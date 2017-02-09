<?php

use Illuminate\Database\Query\Expression as raw;

$app->get('/attendances', function () use ($app){

	 $pageNumber = 0;
    if(array_key_exists('pageNumber', $_GET))
        $pageNumber = $_GET['pageNumber'];

    $pageSize = 10;
    if(array_key_exists('pageSize', $_GET))
        $pageSize = $_GET['pageSize'];

    $filter = '';
    if(array_key_exists('filter', $_GET))
      $filter = $_GET['filter'];

  if(!array_key_exists('eventId', $_GET))
  	return;

  $event_id = $_GET["eventId"];

  $users = Attendance::where('event_id', '=', $event_id)->get();

  $ids = array();
  foreach ($users as $user) {
  	$ids[] = $user->user_id;
  }

  $atts = \User::whereIn('id', $ids)->skip($pageSize*$pageNumber)->take($pageSize)->get();
 
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $atts->toJson();
});

$app->delete('/attendances/:id', function ($id) use ($app){
    //Show book identified by $id
    $att = Attendance::find($id);
    $att->delete();
});


$app->post('/attendances', function () use ($app) {  
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $att = new Attendance;
    $user = \User::where('no_kad', '=', $input->user_id)->get();
    
    if($user->isEmpty()){
    	echo '{"err":"1", "msg":"Member can not be found"}';
    	return;
    }

    $att->event_id = $input->event_id;
    $att->user_id = $user[0]->id;
    
    $att->save();

    echo '{"err":"0", "msg":"Welcome '.$user[0]->username.'"}';
});