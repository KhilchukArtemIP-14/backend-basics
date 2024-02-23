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
    use classes\database;

    require "..\..\classes\database.php";

    // Check if the ID parameter is set in the URL
    if (isset($_GET['id'])) {
        // Get the status ID from the URL parameter
        $status_id = $_GET['id'];

        // Create an instance of the database class
        $db = new database("stolen_autos_db");

        // Establish a database connection
        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        // Fetch theft status data by ID
        $sql_status = "SELECT * FROM theft_status WHERE id = ?";
        $stmt_status = $conn->prepare($sql_status);
        $stmt_status->bind_param("i", $status_id);
        $stmt_status->execute();
        $result_status = $stmt_status->get_result();


        if ($result_status->num_rows > 0) {
            $row_status = $result_status->fetch_assoc();
            echo '<h5>&emsp;Status Name: ' . $row_status["status_name"] . '</h5>';
            echo '<h5>&emsp;Date Created: ' . $row_status["date_created"] . '</h5>';

            $sql_records = "SELECT * FROM theft_record WHERE status_id = ?";
            $stmt_records = $conn->prepare($sql_records);
            $stmt_records->bind_param("i", $status_id);
            $stmt_records->execute();
            $result_records = $stmt_records->get_result();

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
                                </tr>
                            </thead>
                            <tbody>';


                while ($row_record = $result_records->fetch_assoc()) {
                    echo '<tr>
                                <td>' . $row_record["id"] . '</td>
                                <td>' . $row_record["car_info_id"] . '</td>
                                <td>' . $row_record["car_number"] . '</td>
                                <td>' . $row_record["owner_surname"] . '</td>
                                <td>' . $row_record["date_created"] . '</td>
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

        // Close the prepared statements
        $stmt_status->close();
        $stmt_records->close();

        // Close the database connection
        $conn->close();
    } else {
        echo '<p>Status ID not provided.</p>';
    }
    ?>
</div>
</body>

</html>
