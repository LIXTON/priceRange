<?php
include_once 'Testable.php';
include_once '../config/PDODatabase.php';
include_once 'PriceTest.php';
include_once 'PriceControllerTest.php';

$database = new PDODatabase();
$db = $database->getConnection();
$model = new PriceTest($db);
//  Set any attribute to model
$model->priceId = 1;
$model->startDate = "2019-01-05";
$model->endDate = "2019-01-07";
$model->price = 12;
$controller = new PriceControllerTest($db, $database);

$test = new Testable();

echo "<h2>Test for PriceController</h2><br>";
$test->runTests($controller);
var_dump($test->output);

echo "<br><br><h2>Test for Price</h2><br>";
$test->runTests($model);
var_dump($test->output);
?>