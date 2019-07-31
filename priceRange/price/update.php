<?php
include_once '../config/PDODatabase.php';
include_once '../models/Price.php';
include_once '../controllers/PriceController.php';

echo "<a href='index.php'>Back</a><br>";

$database = new PDODatabase();
$db = $database->getConnection();
$model = new Price($db);

//  This is to update the record
if (isset($_POST['submit'])) {
    if (!isset($_POST['priceId'], $_POST['startDate'], $_POST['endDate'], $_POST['price'])) {
        // set response code - 400 bad request
        http_response_code(400);
        die("Error some values are missing values");
    }
    $model->priceId = $_POST['priceId'];
    $model->startDate = $_POST['startDate'];
    $model->endDate = $_POST['endDate'];
    $model->price = $_POST['price'];
    
    $controller = new PriceController($model, $database, $model::UPDATE);
    
    //  Check if the services are available and the information is correct
    //  Otherwise display the error
    if (!empty($controller->error)) {
        // set response code - 503 service unavailable
        http_response_code(503);
        die($controller->printError());
    }
    
    $controller->updateView();
    
    //  Execute the action view if something went wrong display it
    if (!empty($controller->error)) {
        // set response code - 503 service unavailable
        http_response_code(503);
        die($controller->printError());
    }
    
    http_response_code(200);
    die("Price was updated.");
}

//  This is to display the record
if (isset($_GET['id'])) {
    $model->priceId = $_GET["id"];
    $controller = new PriceController($model, $database, $model::READ);
    
    //  Check if the services are available and the information is correct
    //  Otherwise display the error
    if (!empty($controller->error)) {
        // set response code - 503 service unavailable
        http_response_code(503);
        die($controller->printError());
    }
    
    $controller->readOneView();
    
    //  Execute the action view if something went wrong display it
    if (!empty($controller->error)) {
        // set response code - 503 service unavailable
        http_response_code(503);
        die($controller->printError());
    }
    
    if ($controller->model->price == null) {
        // set response code - 404 Not Found
        http_response_code(404);
        die("The price doesn't exist");
    }
    
    // set response code - 200 ok
    http_response_code(200);
}
?>
<form method="post">
    <input type="hidden" name="priceId" value="<?php echo $model->priceId; ?>" required/>
    Start Date:<br>
    <input type="date" name="startDate" value="<?php echo $model->startDate; ?>" required/><br>
    End Date:<br>
    <input type="date" name="endDate" value="<?php echo $model->endDate; ?>" required/><br>
    Price:<br>
    <input type="number" name="price" value="<?php echo $model->price; ?>" step="0.01" required/><br>
    <input type="submit" name="submit" />
</form>