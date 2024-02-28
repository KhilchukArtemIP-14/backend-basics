<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Edit Car Information</h1>

    <?php
    use classes\database;

    require_once "..\..\classes\database.php";
    require_once "..\..\classes\car.php";

    $car = new car();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['car_id'])) {
            $car_id = $_POST['car_id'];
            $brand_name = trim($_POST["brand_name"]);
            $model_name = trim($_POST["model_name"]);

            $result = $car->updateById($car_id, $brand_name, $model_name);

            if ($result) {
                header("Location: cars.php");
                exit;
            } else {
                header("Location: error_page.php");
                exit;
            }
        }
    }

    if (isset($_GET['id'])) {
        $car_id = $_GET['id'];

        $result_car = $car->getCarById($car_id);

        if ($result_car->num_rows > 0) {
            $row_car = $result_car->fetch_assoc();
            ?>
            <form action="" method="post">
                <input type="hidden" name="car_id" value="<?php echo $row_car['id']; ?>">
                <div class="mb-3">
                    <label for="brand_name" class="form-label">Brand Name</label>
                    <input type="text" class="form-control" id="brand_name" name="brand_name" value="<?php echo $row_car['brand_name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="model_name" class="form-label">Model Name</label>
                    <input type="text" class="form-control" id="model_name" name="model_name" value="<?php echo $row_car['model_name']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            <?php
        } else {
            echo '<p>Car not found.</p>';
        }
    } else {
        echo '<p>Car ID not provided.</p>';
    }
    ?>
</div>
</body>
</html>
