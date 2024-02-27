<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <h1>Car Details</h1>

    <?php

    require "..\..\classes\car.php";
    require '..\..\classes\record.php';


    if (isset($_GET['id'])) {
        $car_id = $_GET['id'];

        $car = new car();
        $result_car = $car->getCarById($car_id);

        if ($result_car->num_rows > 0) {
            $row_car = $result_car->fetch_assoc();
            echo '<h5> &emsp;Car brand: ' . $row_car["brand_name"] . '</h5>';
            echo '<h5> &emsp;Car model: ' . $row_car["model_name"] . '</h5>';
            echo '<h5> &emsp;Date registered: ' . $row_car["date_created"] . '</h5>';

            $record=new record();

            $result_records = $record->getRecords(null,$car_id);

            if ($result_records->num_rows > 0) {
                echo '<h3>Theft Records</h3>';
                echo '<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Record ID</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Car Number</th>
                                    <th scope="col">Owner Surname</th>
                                    <th scope="col">Date Created</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>';

                while ($row_theft = $result_records->fetch_assoc()) {
                    echo '<tr>
                                <td>' . $row_theft["id"] . '</td>
                                <td>' . $row_theft["status_name"] . '</td>
                                <td>' . $row_theft["car_number"] . '</td>
                                <td>' . $row_theft["owner_surname"] . '</td>
                                <td>' . $row_theft["date_created"] . '</td>
                                <td><a class="btn btn-primary" href="/./views/records/record.php?id='. $row_theft["id"] . '">View</a></td>

                              </tr>';
                }

                echo '</tbody>
                          </table>';
            } else {
                echo '<p>No theft records found for this car.</p>';
            }
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