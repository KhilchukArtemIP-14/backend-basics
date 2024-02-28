<?php
use classes\database;

require_once "..\..\classes\database.php";
require_once "..\..\classes\car.php";

$car = new car();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $brand_name = trim($_POST["brand_name"]);
    $model_name = trim($_POST["model_name"]);

    $result = $car->insert($brand_name, $model_name);

    if ($result) {
        header("Location: cars.php");
        exit;
    } else {
        header("Location: createcar.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Add Car Information</h1>

    <form action="" method="post">
        <div class="mb-3">
            <label for="brand_name" class="form-label">Brand Name</label>
            <input type="text" class="form-control" id="brand_name" name="brand_name" required>
        </div>
        <div class="mb-3">
            <label for="model_name" class="form-label">Model Name</label>
            <input type="text" class="form-control" id="model_name" name="model_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
</body>
</html>
