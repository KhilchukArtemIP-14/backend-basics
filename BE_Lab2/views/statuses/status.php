<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theft Status Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <h1>Theft Status Details</h1>

    <?php

    require "..\..\classes\status.php";
    require '..\..\classes\record.php';

    if (isset($_GET['id'])) {
        $status_id = $_GET['id'];

        $status = new status();

        $result_status = $status->getStatusById($status_id);


        if ($result_status->num_rows > 0) {
            $row_status = $result_status->fetch_assoc();
            echo '<h5>&emsp;Status Name: ' . $row_status["status_name"] . '</h5>';
            echo '<h5>&emsp;Date Created: ' . $row_status["date_created"] . '</h5>';

            $record=new record();

            $result_records = $record->getRecords($status_id);

            if ($result_records->num_rows > 0) {

                echo '<h3>Theft Records</h3>';
                echo '<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Record ID</th>
                                    <th scope="col">Car Info ID</th>
                                    <th scope="col">Car Number</th>
                                    <th scope="col">Owner Surname</th>
                                    <th scope="col">Date Created</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>';


                while ($row_record = $result_records->fetch_assoc()) {
                    echo '<tr>
                                <td>' . $row_record["id"] . '</td>
                                <td>' . $row_record["brand_name"] . ' ' . $row_record["model_name"]. '</td>
                                <td>' . $row_record["car_number"] . '</td>
                                <td>' . $row_record["owner_surname"] . '</td>
                                <td>' . $row_record["date_created"] . '</td>
                                <td><a class="btn btn-primary" href="/./views/records/record.php?id='. $row_record["id"] . '">View</a></td>
                              </tr>';
                }

                echo '</tbody>
                          </table>';
            } else {
                echo '<p>No theft records found for this status.</p>';
            }
        } else {
            echo '<p>Status not found.</p>';
        }
    } else {
        echo '<p>Status ID not provided.</p>';
    }
    ?>
</div>
</body>

</html>
