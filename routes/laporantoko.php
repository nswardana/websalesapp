<?php
use Illuminate\Database\Query\Expression as raw;

$app->get('/laporantokospersales', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

	 $rangeTanggal='';

    if(array_key_exists('rangeTanggal', $_GET))
    {
      $rangeTanggal=$_GET['rangeTanggal'];
      $aDataRange=json_decode($rangeTanggal);
      
      $timestamp = strtotime(trim($aDataRange->startDate));
      $startDate=date("Y-m-d", $timestamp);
    
      $timestamp = strtotime(trim($aDataRange->endDate));
      $endDate=date("Y-m-d", $timestamp);
    }

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


 $app->response()->header('Content-Type', 'application/json');
  if($sales_id <> '' && $rangeTanggal)
{
$aData = \Laporan::where('laporans.sales_id', '=',$sales_id)
	  ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
      ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
      ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
      ->take($pageSize)->orderBy('laporans.id', 'DESC')
      ->get();

    echo $aData->toJson();
	
}
  else if(($sales_id <> ''))
  {
    $aData = \Laporan::where('laporans.sales_id', '=',$sales_id)
      ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
      ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
      ->take($pageSize)->orderBy('laporans.id', 'DESC')
      ->get();

    echo $aData->toJson();

  }

  // send response header for JSON content type

});



$app->get('/laporantokospertoko', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');


    $toko_id=$_GET['toko_id'];
	
	$rangeTanggal='';

    if(array_key_exists('rangeTanggal', $_GET))
    {
      $rangeTanggal=$_GET['rangeTanggal'];
      $aDataRange=json_decode($rangeTanggal);
      
      $timestamp = strtotime(trim($aDataRange->startDate));
      $startDate=date("Y-m-d", $timestamp);
    
      $timestamp = strtotime(trim($aDataRange->endDate));
      $endDate=date("Y-m-d", $timestamp);
    }



    $pageNumber = 0;
    if(array_key_exists('pageNumber', $_GET))
        $pageNumber = $_GET['pageNumber'];

    $pageSize = 10;
    if(array_key_exists('pageSize', $_GET))
        $pageSize = $_GET['pageSize'];

    $filter = '';
    if(array_key_exists('filter', $_GET))
      $filter = $_GET['filter'];

  
if(($toko_id <> '' && $rangeTanggal))
{
	$aData = \Laporan::where('laporans.toko_id', '=',$toko_id)
	  ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
      ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
      ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
      ->take($pageSize)->orderBy('laporans.id', 'DESC')
      ->get();

    echo $aData->toJson();

}
  else if(($toko_id <> ''))
  {
    $aData = \Laporan::where('laporans.toko_id', '=',$toko_id)
      ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
      ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
      ->skip($pageSize*$pageNumber)
      ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
      ->take($pageSize)->orderBy('laporans.id', 'DESC')
      ->get();

    echo $aData->toJson();

  }

  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results

});

$app->get('/laporantokos', function () use ($app) {  
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

    
    $rangeTanggal='';

    if(array_key_exists('rangeTanggal', $_GET))
    {
      $rangeTanggal=$_GET['rangeTanggal'];
      $aDataRange=json_decode($rangeTanggal);
      
      $timestamp = strtotime(trim($aDataRange->startDate));
      $startDate=date("Y-m-d", $timestamp);
    
      $timestamp = strtotime(trim($aDataRange->endDate));
      $endDate=date("Y-m-d", $timestamp);
    }

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
     {
    	 $_GET['selected_sales']=$_GET['sales_id'];
    	 $sales_id = $_GET['sales_id'];
    }
    $toko_id =  $selected_toko = '';
    if(array_key_exists('toko_id', $_GET))
      $toko_id = $_GET['toko_id'];

    if(array_key_exists('selected_toko', $_GET) && $_GET['selected_toko'] <> 0)
      $selected_toko = $_GET['selected_toko'];

    if(isset($selected_toko))
      $toko_id=$selected_toko;
          
    
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
      if($selected_sales && $selected_area=='' && $selected_toko=='' && $rangeTanggal=='')
      {


        $aData = \Laporan::Sales()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();

      }else if($selected_area && $selected_sales=='' && $selected_toko=='' && $rangeTanggal=="")
      {
        $aData = \Laporan::Area()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if($selected_toko && $selected_sales=='' && $selected_area=='' && $rangeTanggal=="")
      {
        $aData = \Laporan::Toko()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }else if ($selected_sales && $selected_area && $rangeTanggal=="")
      {

        $aData = \Laporan::Sales()->Area()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if ($selected_sales && $selected_toko && $rangeTanggal=='')
      {

        $aData = \Laporan::Sales()->Toko()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if ($selected_area && $selected_toko && $rangeTanggal=="")
      {

        $aData = \Laporan::Area()->Toko()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }

      else if ($selected_area && $selected_toko && $selected_sales && $rangeTanggal=="")
      {

        $aData = \Laporan::Area()->Toko()->Sales()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }




      // menggunakan tanggal
      if($selected_sales && $selected_area=='' && $selected_toko=='' && $rangeTanggal)
      {

        $aData = \Laporan::Sales()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();

      }else if($selected_area && $selected_sales=='' && $selected_toko=='' && $rangeTanggal)
      {
        $aData = \Laporan::Area()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if($selected_toko && $selected_sales=='' && $selected_area=='' && $rangeTanggal)
      {
        $aData = \Laporan::Toko()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }else if ($selected_sales && $selected_area && $rangeTanggal)
      {

        $aData = \Laporan::Sales()->Area()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if ($selected_sales && $selected_toko && $rangeTanggal)
      {

        $aData = \Laporan::Sales()->Toko()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if ($selected_area && $selected_toko && $rangeTanggal)
      {

        $aData = \Laporan::Area()->Toko()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if ($selected_area && $selected_toko && $selected_sales && $rangeTanggal)
      {

        $aData = \Laporan::Area()->Toko()->Sales()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if($rangeTanggal)
      {
         $aData = \Laporan::where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }else  if ($selected_area=='' && $selected_toko =='' && $selected_sales=='' && $rangeTanggal=='')
      {

        $aData = \Laporan::leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }

    }else
    {

      if($selected_sales && $selected_area=='' && $selected_toko=='' && $rangeTanggal=='')
      {


        $aData = \Laporan::Sales()->Pocket()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();

      }else if($selected_area && $selected_sales=='' && $selected_toko=='' && $rangeTanggal=="")
      {
        $aData = \Laporan::Area()->Pocket()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if($selected_toko && $selected_sales=='' && $selected_area=='' && $rangeTanggal=="")
      {
        $aData = \Laporan::Toko()->Pocket()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }else if ($selected_sales && $selected_area && $rangeTanggal=="")
      {

        $aData = \Laporan::Sales()->Area()->Pocket()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if ($selected_sales && $selected_toko && $rangeTanggal=='')
      {

        $aData = \Laporan::Sales()->Toko()->Pocket()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if ($selected_area && $selected_toko && $rangeTanggal=="")
      {

        $aData = \Laporan::Area()->Toko()->Pocket()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }

      else if ($selected_area && $selected_toko && $selected_sales && $rangeTanggal=="")
      {

        $aData = \Laporan::Area()->Toko()->Sales()->Pocket()
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }

      // menggunakan tanggal
      if($selected_sales && $selected_area=='' && $selected_toko=='' && $rangeTanggal)
      {

        $aData = \Laporan::Sales()->Pocket()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();

      }else if($selected_area && $selected_sales=='' && $selected_toko=='' && $rangeTanggal)
      {
        $aData = \Laporan::Area()->Pocket()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if($selected_toko && $selected_sales=='' && $selected_area=='' && $rangeTanggal)
      {
        $aData = \Laporan::Toko()->Pocket()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }else if ($selected_sales && $selected_area && $rangeTanggal)
      {

        $aData = \Laporan::Sales()->Area()->Pocket()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if ($selected_sales && $selected_toko && $rangeTanggal)
      {

        $aData = \Laporan::Sales()->Toko()->Pocket()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if ($selected_area && $selected_toko && $rangeTanggal)
      {

        $aData = \Laporan::Area()->Toko()->Pocket()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if ($selected_area && $selected_toko && $selected_sales && $rangeTanggal)
      {

        $aData = \Laporan::Area()->Toko()->Sales()->Pocket()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }
      else if($rangeTanggal)
      {
         $aData = \Laporan::Pocket()->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
          ->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }else  if ($selected_area=='' && $selected_toko =='' && $selected_sales=='' && $rangeTanggal=='')
      {

        $aData = \Laporan::Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
          ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
          ->skip($pageSize*$pageNumber)
          ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
          ->take($pageSize)->orderBy('laporans.id', 'DESC')
          ->get();
      }



    }
  


  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  
  
  // return JSON-encoded response body with query results

  echo $aData->toJson();
});


$app->post('/laporantokos', function () use ($app) {  
    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');

    
 	  $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $aData = new Laporan;

  	$aData->toko_id = $input->data->toko_id;
    $aData->tanggal = $input->data->tanggal;
    $aData->omset = $input->data->omset;
    $aData->sales_id = $input->data->sales_id;
    $aData->keterangan = $input->data->keterangan;
    $aData->checkin_hours   =date('H:i:s');
 

    if( $aData->save() )
    {
      $items=$input->data->items;
      $aItem=array();
      
      foreach ($items as $item)
      {
          $aItem= new Itemlaporan;

          $aItem->product_id  =$item->product_id;
          $aItem->harga_satuan  =$item->harga_satuan;
          $aItem->jumlah  =$item->jumlah;
          $aItem->harga  = ( $item->jumlah * $aItem->harga_satuan);
          $aItem->laporan_id  =$aData->id;
          $aItem->save();

      }

      $response['data'] = $aData;
      $response['dataItem'] = $aItem;
      $response['status'] = "success";
      $response['message'] = 'Berhasil menambah data';   
    }else
    {
      $response['status'] = "error";
      $response['message'] = 'Gagal menambah data';   
    }

    echoResponse(200, $response);

});

$app->get('/laporantokos/:id', function ($id) use ($app){
    //Show book identified by $id
  $aData = \Laporan::find($id);
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  // return JSON-encoded response body with query results
  echo $aData->toJson();
});



$app->post('/laporantokos/:id', function ($id) use ($app) {  

  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');


    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body); 

    $aData = Toko::find($input->data->id);
    
    $aData->nama_toko = $input->data->nama_toko;
    $aData->no_toko = $input->data->no_toko;
    $aData->no_telp = $input->data->no_telp;
    $aData->pemilik = $input->data->pemilik;
    $aData->alamat = $input->data->alamat;
    $aData->keterangan = $input->data->keterangan;
    $aData->longitude = $input->data->longitude;
    $aData->latitude = $input->data->latitude;
    $aData->sales_id = $input->data->sales_id;

    $aData->save();

    echo $aData->toJson();
});

$app->delete('/laporantokos/:id', function ($id) use ($app){
    //Show book identified by $id
    $aData = \Laporan::find($id);
    if( $aData->delete())
    {
      $response['status'] = "success";
      $response['message'] = 'Berhasil menghapus data';   

    }else
    {
      $response['status'] = "error";
      $response['message'] = 'Gagal menghapus data';  
    }

    echoResponse(200, $response);
 
});


$app->get('/toptenbestomset', function () use ($app){

 $aData = \Laporan::leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select(new raw("month(tanggal) as month"),'sales.sales_name',new raw("SUM(omset) AS totalOmset"))
        ->groupBy('sales_name','month')
        ->where(new raw("month(tanggal)"),'=',date("m"))
        ->take('10')->orderBy('totalOmset', 'DESC')
        ->get();


  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  // return JSON-encoded response body with query results
  echo $aData->toJson();
});



$app->get('/omsetpersales/:id', function ($id) use ($app){

  $aData = \Laporan::select('sales_id',new raw("SUM(omset) AS totalOmset"))
  ->groupBy('sales_id')
  ->where('sales_id','=',$id)
  ->where('tanggal','=',"'".date('Y-m-d')."'")
  ->first();

  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

if(isset($aData))
  echo $aData->toJson();
else
{
   $response['sales_id'] = $id;
   $response['totalOmset'] = '0';

   echoResponse(200, $response);
}

});



$app->get('/omsetpersalespermonth/:id', function ($id) use ($app){

  $aData = \Laporan::select(new raw("month(tanggal) as month"),'sales_id',new raw("SUM(omset) AS totalOmset"))
  ->groupBy('sales_id','month')
  ->where('sales_id','=',$id)
  ->where(new raw("month(tanggal)"),'=',date("m"))
  ->first();
     
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  // return JSON-encoded response body with query results
  echo $aData->toJson();
});


$app->get('/totalomset', function () use ($app){

  $aData = \Laporan::select(new raw("SUM(omset) AS totalOmset"))
  ->first();
     
  // send response header for JSON content type
  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');

  // return JSON-encoded response body with query results
  echo $aData->toJson();
});


$app->get('/laporantoexcel', function () use ($app){

  /*
   $app->response->headers->set('Pragma', 'public'); 
   $app->response->headers->set('Expires', '0'); 
   $app->response->headers->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0'); 
   $app->response->headers->set('Content-Type', 'application/force-download'); 
   $app->response->headers->set('Content-Type', 'application/octet-stream'); 
   $app->response->headers->set('Content-Type', 'application/download'); 
   $app->response->headers->set('Content-Disposition', 'attachment;filename=srl_statistic.xlsx'); 
   $app->response->headers->set('Content-Transfer-Encoding', 'binary');
  */

    $rangeTanggal='';

    if(array_key_exists('rangeTanggal', $_GET))
    {
      $rangeTanggal=$_GET['rangeTanggal'];
      $aDataRange=json_decode($rangeTanggal);
      
      $timestamp = strtotime(trim($aDataRange->startDate));
      $startDate=date("Y-m-d", $timestamp);
    
      $timestamp = strtotime(trim($aDataRange->endDate));
      $endDate=date("Y-m-d", $timestamp);
    }

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
    {
      $_GET['selected_sales']=$_GET['sales_id'];
      $sales_id = $_GET['sales_id'];
    }

    $toko_id =  $selected_toko = '';
    if(array_key_exists('toko_id', $_GET))
      $toko_id = $_GET['toko_id'];

    if(array_key_exists('selected_toko', $_GET) && $_GET['selected_toko'] <> 0)
      $selected_toko = $_GET['selected_toko'];

    if(isset($selected_toko))
      $toko_id=$selected_toko;
          
    
    $selected_area = '';
    if(array_key_exists('selected_area', $_GET) && $_GET['selected_area'] <> 0)
      $selected_area = $_GET['selected_area'];

    $selected_sales = '';
    if(array_key_exists('selected_sales', $_GET) && $_GET['selected_sales'] <> 0)
      $selected_sales = $_GET['selected_sales'];


    $selected_pocket = '';
    if(array_key_exists('selected_pocket', $_GET) && $_GET['selected_pocket'] <> 0)
      $selected_pocket = $_GET['selected_pocket'];


  $app->response()->header('Content-Type', 'application/json');
  $app->response()->header('Access-Control-Allow-Origin', '*');


if($selected_pocket=='')
{
 // Tidak menggunakan tanggal
  if($selected_sales && $selected_area=='' && $selected_toko=='' && $rangeTanggal=='')
  {
       $aDataLaporan = \Laporan::Sales()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales && $selected_area && $selected_toko=='' && $rangeTanggal=='')
  {
       $aDataLaporan = \Laporan::Sales()->Area()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales && $selected_area && $selected_toko && $rangeTanggal=='')
  {
       $aDataLaporan = \Laporan::Sales()->Area()->Toko()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();

  }
 else if($selected_sales=="" && $selected_area && $selected_toko=='' && $rangeTanggal=='')
  {
       $aDataLaporan =Laporan::Area()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales=="" && $selected_area && $selected_toko && $rangeTanggal=='')
  {
       $aDataLaporan = \Laporan::Area()->Toko()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales=="" && $selected_area=='' && $selected_toko && $rangeTanggal=='')
  {
       $aDataLaporan = \Laporan::Toko()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales && $selected_area=='' && $selected_toko=='' && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Sales()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales && $selected_area && $selected_toko=='' && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Sales()->Area()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales && $selected_area && $selected_toko && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Sales()->Area()->Toko()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();

  }
 else if($selected_sales=="" && $selected_area && $selected_toko=='' && $rangeTanggal)
  {
       $aDataLaporan =Laporan::Area()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales=="" && $selected_area && $selected_toko && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Area()->Toko()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales=="" && $selected_area=='' && $selected_toko && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Toko()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
   else if($selected_sales=="" && $selected_area=='' && $selected_toko=="" && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  
  else
  {

   $aDataLaporan = \Laporan::leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();

  }

}else
{

  // Tidak menggunakan tanggal
  if($selected_sales && $selected_area=='' && $selected_toko=='' && $rangeTanggal=='')
  {
       $aDataLaporan = \Laporan::Sales()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales && $selected_area && $selected_toko=='' && $rangeTanggal=='')
  {
       $aDataLaporan = \Laporan::Sales()->Area()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales && $selected_area && $selected_toko && $rangeTanggal=='')
  {
       $aDataLaporan = \Laporan::Sales()->Area()->Toko()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();

  }
 else if($selected_sales=="" && $selected_area && $selected_toko=='' && $rangeTanggal=='')
  {
       $aDataLaporan =Laporan::Area()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales=="" && $selected_area && $selected_toko && $rangeTanggal=='')
  {
       $aDataLaporan = \Laporan::Area()->Toko()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales=="" && $selected_area=='' && $selected_toko && $rangeTanggal=='')
  {
       $aDataLaporan = \Laporan::Toko()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales && $selected_area=='' && $selected_toko=='' && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Sales()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales && $selected_area && $selected_toko=='' && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Sales()->Area()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales && $selected_area && $selected_toko && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Sales()->Area()->Toko()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();

  }
 else if($selected_sales=="" && $selected_area && $selected_toko=='' && $rangeTanggal)
  {
       $aDataLaporan =Laporan::Area()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales=="" && $selected_area && $selected_toko && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Area()->Toko()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  else if($selected_sales=="" && $selected_area=='' && $selected_toko && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Toko()->Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
   else if($selected_sales=="" && $selected_area=='' && $selected_toko=="" && $rangeTanggal)
  {
       $aDataLaporan = \Laporan::Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->where('tanggal','>=',$startDate)->where('tanggal','<=',$endDate)
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();


  }
  
  else
  {

   $aDataLaporan = \Laporan::Pocket()->leftJoin('tokos', 'laporans.toko_id', '=', 'tokos.id')
        ->leftJoin('sales', 'laporans.sales_id', '=', 'sales.id')
        ->select('laporans.id as laporan_id','laporans.keterangan as laporan_keterangan' ,'laporans.*','tokos.*','sales.*')
        ->skip($pageSize*$pageNumber)
        ->take($pageSize)->orderBy('laporans.id', 'DESC')
        ->get();

  }


}
   $aDataItem = \Itemlaporan::leftJoin('products', 'itemlaporans.product_id', '=', 'products.id')
        ->select('itemlaporans.laporan_id as laporan_id','products.id as product_id',new raw("SUM(jumlah) AS totalitem"))
        ->orderBy('itemlaporans.id', 'DESC')
        ->groupBy('laporan_id','product_id')
        ->get();

  $aProduct = \Product::orderBy('id', 'ASC')->get();
 
  $aArea = \Area::get();
 

  $arrArea=array();
  foreach ($aArea as $key => $value) {
    $arrArea[$value['attributes']['id']]=$value['attributes']['area_name'];
  }
  

   
  
  $aData=array();
  foreach($aDataLaporan as $i=>$arrayData)
  {
    $aData[$i]['penjualan']=$arrayData['attributes'];
    
    foreach ($aDataItem as $a=>$arrayitem)
    {
      $aData[$i]['item'][0]=array('product_id'=>'0','totalitem'=>0);

      if($arrayData['attributes']['laporan_id']==$arrayitem['attributes']['laporan_id'])
        $aData[$i]['item'][$arrayitem['attributes']['product_id']]=$arrayitem['attributes'];
    }

  } 




  
  $arrDataLaporan[0]['nama_toko']='Nama Toko';
  $arrDataLaporan[0]['no_toko']='No Toko';
  $arrDataLaporan[0]['alamat']='Alamat';
  $arrDataLaporan[0]['no_telp']='Telp';
  $arrDataLaporan[0]['sales_name']='Sales';
  $arrDataLaporan[0]['area']='Area';
  $arrDataLaporan[0]['pocket']='';
  $arrDataLaporan[0]['tanggal']='Tanggal';
  $arrDataLaporan[0]['omset']='Omset';

  foreach($aProduct as $i=>$_aProduct)
  {
    $arrDataLaporan[0]['item'][$_aProduct->id]=$_aProduct->product_name." (".$_aProduct->product_price.")";

  }



 


  
  foreach($aData as $i=>$aaData)
  {
    $area_id=$aaData['penjualan']['area_id'];
    if(isset($area_id))
        $area_name=$arrArea[$area_id];
    else
        $area_name="";
          

    $arrDataLaporan[$i+1]['nama_toko']=$aaData['penjualan']['nama_toko'];
    $arrDataLaporan[$i+1]['no_toko']=$aaData['penjualan']['no_toko'];
    $arrDataLaporan[$i+1]['alamat']=$aaData['penjualan']['alamat'];
    $arrDataLaporan[$i+1]['no_telp']=$aaData['penjualan']['no_telp'];

	  $arrDataLaporan[$i+1]['sales_name']=$aaData['penjualan']['sales_name'];
    $arrDataLaporan[$i+1]['area']=$area_name;
    $arrDataLaporan[$i+1]['pocket']=$aaData['penjualan']['pocket_id'];
    $arrDataLaporan[$i+1]['tanggal']=$aaData['penjualan']['tanggal'];
    $arrDataLaporan[$i+1]['omset']=$aaData['penjualan']['omset'];

    foreach($aProduct as $y=>$_aProduct)
    {
     
      if(isset($aaData['item'][$_aProduct->id]))
       $arrDataLaporan[$i+1]['item'][$_aProduct->id]=$aaData['item'][$_aProduct->id]['totalitem'];
      else
        $arrDataLaporan[$i+1]['item'][$_aProduct->id]=0;

    }



  }

  
  /*
  
  echo "<pre>";
  print_r($arrDataLaporan);
  print_r($arrDataLaporan);
  */

  echo json_encode($arrDataLaporan,true);
  

  


});


