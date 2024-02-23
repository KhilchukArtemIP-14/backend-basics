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
    use classes\database;

    require "..\..\classes\database.php";
    // SQL query to fetch data from car_info table
    $sql = "SELECT * FROM car_info";

    $db = new database("stolen_autos_db");

    // Establish a database connection
    $conn = $db->getConnection();
    $conn->select_db("stolen_autos_db");

    // Execute the SQL query
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Output the table headers
        echo '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date Created</th>
                        </tr>
                    </thead>
                    <tbody>';

        // Loop through each row in the result set and output data in table rows
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td><a href="car.php?id='. $row["id"] .'">' . $row["brand_name"] .' '. $row["model_name"] . '</a></td>
                        <td>' . $row["date_created"] . '</td>
                      </tr>';
        }

        echo '</tbody>
                  </table>';
    } else {
        echo '<p>No records found</p>';
    }

    // Close the database connection
    $conn->close();
    ?>
</div>
</body>

</html>
