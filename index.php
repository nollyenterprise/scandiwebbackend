<?php
    if($_SERVER["HTTP_ORIGIN"] == 'http://localhost:3000' || 'https://scandiwebjwd.herokuapp.com')
        header('Access-Control-Allow-Origin: '.$_SERVER["HTTP_ORIGIN"]);
    header("Access-Control-Allow-Headers: Content-Type");

    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        die(json_encode(["code"=>false,"message"=>"not permitted!"]));

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

    $actions = '\Main\\Product\\Types\\'.$productType;
    $obj = new $actions($data);
    $obj->$action();

?>