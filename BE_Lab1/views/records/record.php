<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Theft Record Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />
</head>
<body>
<div class="container">
    <h1>Theft Record Details</h1>

    <?php
    use classes\database;

    require "..\..\classes\database.php";

    // Check if the ID parameter is set in the URL
    if (isset($_GET['id'])) {
        // Get the theft record ID from the URL parameter
        $theft_id = $_GET['id'];

        // Create an instance of the database class
        $db = new database("stolen_autos_db");

        // Establish a database connection
        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        // Fetch theft record data by ID
        $sql_theft = "SELECT tr.id, tr.car_info_id, tr.status_id, tr.car_number, tr.owner_surname, tr.date_created,
                      ts.status_name, ci.brand_name, ci.model_name
                      FROM theft_record tr
                      INNER JOIN theft_status ts ON tr.status_id = ts.id
                      INNER JOIN car_info ci ON tr.car_info_id = ci.id
                      WHERE tr.id = ?";
        $stmt_theft = $conn->prepare($sql_theft);
        $stmt_theft->bind_param("i", $theft_id);
        $stmt_theft->execute();
        $result_theft = $stmt_theft->get_result();

        // Check if the theft record ID exists in the database
        if ($result_theft->num_rows > 0) {
            $row_theft = $result_theft->fetch_assoc();
            echo '<h5> &emsp;Car Info: ' . $row_theft["brand_name"] . ' ' . $row_theft["model_name"] . '</h5>';
            echo '<h5> &emsp;Status: ' . $row_theft["status_name"] . '</h5>';
            echo '<h5> &emsp;Car Number: ' . $row_theft["car_number"] . '</h5>';
            echo '<h5> &emsp;Owner Surname: ' . $row_theft["owner_surname"] . '</h5>';
            echo '<h5> &emsp;Date Created: ' . $row_theft["date_created"] . '</h5>';
        } else {
            echo '<p>Theft record not found.</p>';
        }

        // Close the prepared statement
        $stmt_theft->close();

        // Close the database connection
        $conn->close();
    } else {
        echo '<p>Theft Record ID not provided.</p>';
    }
    ?>
</div>
</body>
</html>
