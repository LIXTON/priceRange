<?php
include_once '../config/PDODatabase.php';
include_once '../models/Price.php';
include_once '../controllers/PriceController.php';

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

$listPrice = $controller->indexView();

//  Execute the action view if something went wrong display it
if (!empty($controller->error)) {
    // set response code - 503 service unavailable
    http_response_code(503);
    die($controller->printError());
}

// set response code - 200 OK
http_response_code(200);
?>
<a href="reset.php">Reset</a>
<br>
<br>
<a href="create.php">Create</a>
<br>
<table>
    <tr>
        <th>Id</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php foreach($listPrice as $l): ?>
    <tr>
        <td><?php echo $l->priceId; ?></td>
        <td><?php echo $l->startDate; ?></td>
        <td><?php echo $l->endDate; ?></td>
        <td><?php echo "$" . number_format($l->price, 2); ?></td>
        <td>
            <a href="update.php?id=<?php echo $l->priceId; ?>">Update</a>
            <a href="delete.php?id=<?php echo $l->priceId; ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
