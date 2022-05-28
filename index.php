<?php

    header('Access-Control-Allow-Origin: https://scandiwebjwd.herokuapp.com');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');


	define('ROOT_PATH', dirname(__FILE__) );
    $data = json_decode(file_get_contents('php://input'), true);
    
    //code...
    include_once "PSR4Autoloader.php";
    
    foreach ($data as $key => $value) {
        # code...
        $get = htmlspecialchars($value);
        $get = stripslashes($get);
        $get = trim($get);
        $$key = "$get";
    }
    

    $actions = '\Main\\Product\\Actions\\'.$action;
    $action = new $actions($data);

    $action->main();

?>