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
    use classes\database;

    require "..\..\classes\database.php";

    // Check if the ID parameter is set in the URL
    if (isset($_GET['id'])) {
        // Get the car ID from the URL parameter
        $car_id = $_GET['id'];

        // Create an instance of the database class
        $db = new database("stolen_autos_db");

        // Establish a database connection
        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        // Fetch car model data by ID
        $sql_car = "SELECT * FROM car_info WHERE id = ?";
        $stmt_car = $conn->prepare($sql_car);
        $stmt_car->bind_param("i", $car_id);
        $stmt_car->execute();
        $result_car = $stmt_car->get_result();

        // Check if the car ID exists in the database
        if ($result_car->num_rows > 0) {
            $row_car = $result_car->fetch_assoc();
            echo '<h5> &emsp;Car brand: ' . $row_car["brand_name"] . '</h5>';
            echo '<h5> &emsp;Car model: ' . $row_car["model_name"] . '</h5>';
            echo '<h5> &emsp;Date registered: ' . $row_car["date_created"] . '</h5>';

            // Fetch theft records featuring the car
            $sql_theft = "SELECT tr.id, tr.status_id, ts.status_name, tr.car_number, tr.owner_surname, tr.date_created
                          FROM theft_record tr
                          INNER JOIN theft_status ts ON tr.status_id = ts.id
                          WHERE tr.car_info_id = ?";
            $stmt_theft = $conn->prepare($sql_theft);
            $stmt_theft->bind_param("i", $car_id);
            $stmt_theft->execute();
            $result_theft = $stmt_theft->get_result();

            // Check if there are any theft records featuring the car
            if ($result_theft->num_rows > 0) {
                // Output the table headers for theft records
                echo '<h3>Theft Records</h3>';
                echo '<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Record ID</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Car Number</th>
                                    <th scope="col">Owner Surname</th>
                                    <th scope="col">Date Created</th>
                                </tr>
                            </thead>
                            <tbody>';

                // Loop through each theft record and output data in table rows
                while ($row_theft = $result_theft->fetch_assoc()) {
                    echo '<tr>
                                <td>' . $row_theft["id"] . '</td>
                                <td>' . $row_theft["status_name"] . '</td>
                                <td>' . $row_theft["car_number"] . '</td>
                                <td>' . $row_theft["owner_surname"] . '</td>
                                <td>' . $row_theft["date_created"] . '</td>
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

        // Close the prepared statements
        $stmt_car->close();
        $stmt_theft->close();

        // Close the database connection
        $conn->close();
    } else {
        echo '<p>Car ID not provided.</p>';
    }
    ?>
</div>
</body>

</html>
