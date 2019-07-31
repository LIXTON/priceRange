<?php
include_once '../config/PDODatabase.php';
include_once '../models/Price.php';
include_once '../controllers/PriceController.php';

echo "<a href='index.php'>Back</a><br>";

$database = new PDODatabase();
$db = $database->getConnection();
$model = new Price($db);
$controller = new PriceController($model, $database, $model::READ);

//  Check if the services are available and the information is correct
//  Otherwise display the error
if (!empty($controller->error)) {
    // set response code - 503 service unavailable
    http_response_code(503);
    die($controller->printError());
}
    
$controller->deleteView();

//  Execute the action view if something went wrong display it
if(!empty($controller->error)) {
    // set response code - 503 service unavailable
    http_response_code(503);
    die($controller->printError);
}

// set response code - 200 ok
http_response_code(200);
die("Price records was reset.");
?>