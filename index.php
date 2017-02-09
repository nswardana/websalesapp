<?php

require __DIR__.'/vendor/autoload.php';

$app = new Slim\Slim();

$app->get('/', function() use ($app) {
    $app->render('home.php');
});



require 'routes/auth.php';
require 'routes/pegawai.php';
require 'routes/user.php';
require 'routes/event.php';
require 'routes/attendance.php';
require 'routes/product.php';
require 'routes/sales.php';

require 'routes/toko.php';
require 'routes/laporantoko.php';
require 'routes/checkin.php';
require 'routes/itemlaporantoko.php';

require 'routes/area.php';


$app->run();
?>