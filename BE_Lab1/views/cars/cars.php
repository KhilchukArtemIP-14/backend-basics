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

    require "..\..\classes\car.php";

    $car = new car();

    $result = $car->getCars();


    if ($result->num_rows > 0) {

        echo '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date Created</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>';


        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td><a ">' . $row["brand_name"] .' '. $row["model_name"] . '</a></td>
                        <td>' . $row["date_created"] . '</td>
                        <td><a class="btn btn-primary" href="car.php?id='. $row["id"] . '">View</a></td>
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
