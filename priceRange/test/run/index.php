<?php
include_once '../Testable.php';
include_once '../../config/PDODatabase.php';
include_once '../../models/Price.php';
include_once '../../controllers/PriceController.php';

$database = new PDODatabase();
$db = $database->getConnection();
$model = new Price($db);
//  Set any attribute to model
$model->priceId = 1;
$model->startDate = "2019-01-05";
$model->endDate = "2019-01-07";
$model->price = 12;
$controller = new PriceController($model, $database, $model::READ);

$test = new Testable();

$test->runTests();
echo "<br><h2>Test for PriceController</h2><br>";
var_dump($test->output);

$test->runTests();
echo "<br><br><h2>Test for Price</h2><br>";
var_dump($test->output);
?>