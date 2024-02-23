<?php

use classes\database;

require "classes\database.php";

$db = new database("stolen_autos_db");

$conn=$db->getConnection();

if(!$db->checkDbExistence()){
    $db->createDb();
    $db->createTables();
    $db->createUser("artem6","superpassword");
}
?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content=
    "width=device-width, initial-scale=1" />
    <link href=
          "https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity=
          "sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
          crossorigin="anonymous" />
</head>
<body>
<div class="container">

    <h1>Wlcome to lab1!</h1>
    <?php
    // Fetch data from the theft_record table
    $sql = "SELECT tr.id, tr.car_info_id, tr.status_id, tr.car_number, tr.owner_surname, tr.date_created,
            ts.status_name, ci.brand_name, ci.model_name
            FROM theft_record tr
            INNER JOIN theft_status ts ON tr.status_id = ts.id
            INNER JOIN car_info ci ON tr.car_info_id = ci.id
            ORDER BY tr.id";
    $db = new database("stolen_autos_db");

    $conn=$db->getConnection();
    $conn->select_db("stolen_autos_db");
    $result = $conn->query($sql);

    // Display data in a table
    echo '<table class="table">
        <thead>
        <tr>
            <th scope="col">Record id</th>
            <th scope="col">Car Info</th>
            <th scope="col">Status</th>
            <th scope="col">Car Number</th>
            <th scope="col">Owner Surname</th>
            <th scope="col">Date Created</th>
        </tr>
        </thead>
        <tbody>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                <th scope="row">' . $row["id"] . '</th>
                <td>' . $row["brand_name"] . ' ' . $row["model_name"]. '</td>
                <td>' . $row["status_name"] . '</td>
                <td>' . $row["car_number"] . '</td>
                <td>' . $row["owner_surname"] . '</td>
                <td>' . $row["date_created"] . '</td>
              </tr>';
        }
    } else {
        echo '<tr><td colspan="6">No records found</td></tr>';
    }

    echo '</tbody>
      </table>';
    ?>
</div>
</body>
</html>