<?php

$app->get('/pegawais', function () use ($app) {  

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
  $books = \Pegawai::where('nama_lengkap', 'LIKE', '%'.$filter.'%' )->skip($pageSize*$pageNumber)->take($pageSize)->orderBy('id', 'DESC')->get();
   

  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $books->toJson();
});

$app->delete('/pegawais/:id', function ($id) use ($app){
    //Show book identified by $id
    $pegawai = Pegawai::find($id);
    $pegawai->delete();

    echo $pegawai->toJson();

});


$app->get('/pegawais/:id', function ($id) use ($app){
    //Show book identified by $id
    $pegawais = \Pegawai::find($id);
   
  
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  // return JSON-encoded response body with query results
  echo $pegawais->toJson();
});




$app->post('/pegawais', function () use ($app) {  
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $pegawai = new Pegawai;

    $pegawai->nama_lengkap  = $input->nama_lengkap;
    $pegawai->nip           = $input->nip;
    $pegawai->alamat           = "asdasd";
   
    $pegawai->tempat_lahir  = $input->tempat_lahir;
    $pegawai->tgl_lahir     = $input->tgl_lahir;
    $pegawai->no_ktp        = $input->no_ktp;
    
    $pegawai->no_npwp        = $input->no_npwp;
    $pegawai->no_hp        = $input->no_hp;
    $pegawai->status_perkawinan        = $input->status_perkawinan;
    $pegawai->jabatan_id        = $input->jabatan_id;
    
    $pegawai->save();

    echo $pegawai->toJson();
});


$app->post('/pegawais/:id', function ($id) use ($app) {  
    $request = $app->request();
    $body = $request->getBody();
  
    $input = new stdClass();
    $input = json_decode($body); 

    $pegawai = Pegawai::find($input->id);
    
    
    $pegawai->nama_lengkap  = $input->nama_lengkap;
    $pegawai->nip           = $input->nip;
    $pegawai->alamat           = "asdasd";
   
    $pegawai->tempat_lahir  = $input->tempat_lahir;
    $pegawai->tgl_lahir     = $input->tgl_lahir;
    $pegawai->no_ktp        = $input->no_ktp;
    
    $pegawai->no_npwp        = $input->no_npwp;
    $pegawai->no_hp        = $input->no_hp;
    $pegawai->status_perkawinan        = $input->status_perkawinan;
    $pegawai->jabatan_id        = $input->jabatan_id;
    
    $pegawai->save();

    echo $pegawai->toJson();

});
