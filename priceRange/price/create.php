<?php
include_once '../config/PDODatabase.php';
include_once '../models/Price.php';
include_once '../controllers/PriceController.php';

echo "<a href='index.php'>Back</a><br>";

if (isset($_POST['submit'])) {
    $database = new PDODatabase();
    $db = $database->getConnection();
    $model = new Price($db);
    
    if (!isset($_POST['startDate'], $_POST['endDate'], $_POST['price'])) {
        // set response code - 400 bad request
        http_response_code(400);
        die("Error some values are missing values");
    }
    
    $model->startDate = $_POST['startDate'];
    $model->endDate = $_POST['endDate'];
    $model->price = $_POST['price'];
    
    $controller = new PriceController($model, $database, $model::CREATE);

    //  Check if the services are available and the information is correct
    //  Otherwise display the error
    if (!empty($controller->error)) {
        // set response code - 503 service unavailable
        http_response_code(503);
        die($controller->printError());
    }
    
    $controller->createView();
    
    //  Execute the action view if something went wrong display it
    if (!empty($controller->error)) {
        // set response code - 503 service unavailable
        http_response_code(503);
        die($controller->printError());
    }
    
    http_response_code(201);
    die("Price was created.");
}
?>
<form method="post">
    Start Date: <input type="date" name="startDate" required/><br>
    End Date: <input type="date" name="endDate" required/><br>
    Price: <input type="number" name="price" step="0.01" required/><br>
    <input type="submit" name="submit" />
</form>