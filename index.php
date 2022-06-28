<?php
    if(isset($_SERVER["HTTP_ORIGIN"])){
        if($_SERVER["HTTP_ORIGIN"] == 'http://localhost:3000' || 'https://scandiwebjwd.herokuapp.com')
            header('Access-Control-Allow-Origin: '.$_SERVER["HTTP_ORIGIN"]);
    }
    header("Access-Control-Allow-Headers: Content-Type");

    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        die(json_encode(["code"=>false,"message"=>"not permitted!"]));

	define('ROOT_PATH', dirname(__FILE__) );
    $data = json_decode(file_get_contents('php://input'), true);
    
    //code...
    include_once "PSR4Autoloader.php";

    $actions = '\Main\\Product\\Types\\'.trim($data["productType"]);
    $obj = new $actions($data);
    $action = trim($data["action"]);
    $obj->$action();

?>