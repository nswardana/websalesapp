<?php

$app->get('/getallproducts', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  $aData = \Product::get();
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $aData->toJson();
});


$app->get('/products', function () use ($app) {  
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
  $books = \Product::where('product_name', 'LIKE', '%'.$filter.'%' )->skip($pageSize*$pageNumber)->take($pageSize)->orderBy('id', 'DESC')->get();
   

  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $books->toJson();
});

$app->delete('/products/:id', function ($id) use ($app){
 $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  //Show book identified by $id
    $product = Product::find($id);
    $product->delete();

    echo $product->toJson();

});


$app->get('/products/:id', function ($id) use ($app){
    //Show book identified by $id
    $products = \Product::find($id);
   
  
  // send response header for JSON content type
 $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');
 
  // return JSON-encoded response body with query results
  echo $products->toJson();
});




$app->post('/products', function () use ($app) {  
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $product = new Product;

    $product->product_name  = $input->product_name;
    $product->product_price = $input->product_price;
    $product->product_desc  = $input->product_desc;
   
    $product->save();

    echo $product->toJson();
});


$app->post('/products/:id', function ($id) use ($app) {  
    $request = $app->request();
    $body = $request->getBody();
  
    $input = new stdClass();
    $input = json_decode($body); 

    $product = Product::find($input->id);
    
    $product->product_name  = $input->product_name;
    $product->product_price = $input->product_price;
    $product->product_desc  = $input->product_desc;
   
    
    $product->save();

    echo $product->toJson();

});
