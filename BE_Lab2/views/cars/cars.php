<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <h1>Car Information</h1>
    <?php
    $descending = isset($_GET['descending'])&&$_GET['descending']=== 'true';
    ?>
    <div>
        <a class="btn btn-success" href="createcar.php">Add Car</a>
        Order by date created
        <?php
        if($descending){
            echo '<a type="button" class="btn btn-secondary" href="cars.php?descending=false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
                        <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
                    </svg>
                 </a>';
        }
        else{
            echo'<a type="button" class="btn btn-secondary" href="cars.php?descending=true">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-up" viewBox="0 0 16 16">
                <path d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.5.5 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"></path>
            </svg>
        </a>';
        }
        ?>
    </div>
    <?php
    require_once "..\..\classes\car.php";
    require '..\..\classes\record.php';

    $car = new car();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['car_id'])) {
            $car_id = $_POST['car_id'];

            $result = $car->deleteById($car_id);

            if ($result) {
                header("Location: cars.php");
                exit;
            } else {

            }
        } else {

        }
    }

    $result = $car->getCars($descending);

    if ($result->num_rows > 0) {
        echo '<table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Model</th>
                        <th scope="col">Date Created</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>';

        while ($row = $result->fetch_assoc()) {
            $record= new record();
            $canDelete = $record->getRecords(null,$row["id"])->num_rows==0;
            $hidden = $canDelete ? "hidden":"";
            $disabled= !$canDelete ? "disabled":"";
            echo '<tr>
                    <td>' . $row["id"] . '</td>
                    <td>' . $row["brand_name"] . '</td>
                    <td>' . $row["model_name"] . '</td>
                    <td>' . $row["date_created"] . '</td>
                    <td>
                        <a class="btn btn-primary" href="car.php?id=' . $row["id"] . '">View</a>
                    </td>
                    <td>
                        <a class="btn btn-warning" href="editcar.php?id=' . $row["id"] . '">Edit</a>
                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="car_id" value="' . $row["id"] . '">
                            <button type="submit" class="btn btn-danger" '.$disabled.'>Delete</button>
                            <div class="text-danger" style="max-width: 200px" '. $hidden . '>Please, remove related records first</div>
                        </form>
                    </td>
                </tr>';
        }

        echo '</tbody>
            </table>';
    } else {
        echo '<p>No records found</p>';
    }
    ?>
</div>
</body>

</html>
