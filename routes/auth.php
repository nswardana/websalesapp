<?php

function getSession(){
    //session_start();

    if (!isset($_SESSION)) {
        session_start();
    }
    $sess = array();

    print_r($_SESSION);


    if(isset($_SESSION['uid']))
    {
        $sess["uid"] = $_SESSION['uid'];
        $sess["name"] = $_SESSION['name'];
        $sess["email"] = $_SESSION['email'];
        $sess["sales_id"] = $_SESSION['sales_id'];
    }
    else
    {
        $sess["uid"] = '';
        $sess["name"] = '';
        $sess["email"] = '';
        $sess["sales_id"] = '';
    }
    return $sess;
}

function destroySession(){
    if (!isset($_SESSION)) {
    session_start();
    }
    if(isSet($_SESSION['uid']))
    {
        unset($_SESSION['uid']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        unset($_SESSION['sales_id']);
        $info='info';
        if(isSet($_COOKIE[$info]))
        {
            setcookie ($info, '', time() - $cookie_time);
        }
        $msg="Logged Out Successfully...";
    }
    else
    {
        $msg = "Not logged in...";
    }
    return $msg;
}

function verifyRequiredParams($required_fields,$request_params) {
    $error = false;
    $error_fields = "";
    foreach ($required_fields as $field) {
        if (!isset($request_params->$field) || strlen(trim($request_params->$field)) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["status"] = "error";
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(200, $response);
        $app->stop();
    }
}

function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->get('/session', function() {
    
    

    //$session = getSession();
    
    print_r($_SESSION);
    $response["uid"] = $session['uid'];
    $response["email"] = $session['email'];
    $response["name"] = $session['name'];
    $response["sales_id"] = $session['sales_id'];

    /*
    $response["uid"]    = '1';
    $response["email"]  = "email";
    $response["name"]   = 'session name';
    */
    
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {

    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');


    $r = json_decode($app->request->getBody());

    verifyRequiredParams(array('username', 'password'),$r->customer);
    $response = array();
    $password = $r->customer->password;
    $username = $r->customer->username;

    $users = \User::where("username", '=', $r->customer->username)
        ->leftJoin('sales', 'users.sales_id', '=', 'sales.id')
        ->select('users.sales_id as sales_id','users.id as uid' ,'users.*','sales.*')
        ->get();

    $user = $users[0];

     if ($user != NULL) {

        if($user['password'] == $password){
            $response['status'] = "success";
            $response['message'] = 'Logged in successfully.';

            $response['name'] = $user['name'];
            $response['uid'] = $user['uid'];
            $response['email'] = $user['sales_email'];
            $response['sales_hp'] = $user['sales_hp'];
            $response['sales_map_icon'] = $user['sales_map_icon'];
            $response['sales_foto'] = $user['sales_foto'];
            $response['sales_id'] = 1;
           
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $user['uid'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['sales_id'] = 1;


            
     
        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect password';
        }
    }else {
        $response['status'] = "error";
        $response['message'] = 'No such user is registered';
    }

    echoResponse(200, $response);
});


//authtest

$app->get('/authtest', function() use ($app) {

    $response['name'] = "John Doe";
    $response['roles'][0] = 'ADMIN';
    $response['roles'][1] = 'USER';
    $response['anonymous'] = false;
    
    echoResponse(200, $response);


});

$app->post('/weblogin', function() use ($app) {

    $_SESSION=array();

    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');


    $r = json_decode($app->request->getBody());

    verifyRequiredParams(array('username', 'password'),$r->customer);
    $response = array();
    $password = $r->customer->password;
    $username = $r->customer->username;

    $users = \User::where("username", '=', $r->customer->username)
        ->leftJoin('sales', 'users.sales_id', '=', 'sales.id')
        ->select('sales.id as sales_id','users.id as users_id' ,'users.*','sales.*')
        ->get();


     if (count ($users ) > 0) {

        $user = $users[0];

       
        if($user['password'] == $password && ($user['sales_id'] == 0) ){
            $response['status'] = "success";
            $response['message'] = 'Logged in successfully.';

            $response['name'] = $user['name'];
            $response['uid'] = $user['users_id'];
            $response['email'] = $user['sales_email'];
            $response['sales_hp'] = $user['sales_hp'];
            $response['sales_map_icon'] = $user['sales_map_icon'];
            $response['sales_foto'] = $user['sales_foto'];
            $response['sales_id'] = $user['sales_id'];
           
            if (!isset($_SESSION)) {
                session_start();
            }
            
            $_SESSION['uid'] = $user['users_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['sales_id'] = $user['sales_id'];

            //print_r($_SESSION);

            
     
        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect password';
        }
    }else {
        $response['status'] = "error";
        $response['message'] = 'No such user is registered';
    }

    echoResponse(200, $response);
});


$app->get('/logout', function() use ($app){
    $app->response()->header('Content-Type', 'application/json');
    $app->response()->header('Access-Control-Allow-Origin', '*');

    destroySession();
    $response["status"] = "success";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});
