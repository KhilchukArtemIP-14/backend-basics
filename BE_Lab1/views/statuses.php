<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theft Status</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <h1>Theft Status</h1>

    <?php
    use classes\database;

    require "..\..\classes\database.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate input data
        if (isset($_POST['status_id'])) {
            $status_id = $_POST['status_id'];

            // Create an instance of the database class
            $db = new database("stolen_autos_db");

            // Establish a database connection
            $conn = $db->getConnection();
            $conn->select_db("stolen_autos_db");

            // Prepare and execute the SQL query to delete the theft status record
            $sql = "DELETE FROM theft_status WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $status_id);

            if ($stmt->execute()) {
                // Redirect to a success page or display a success message
                header("Location: statuses.php");
                exit;
            } else {
                // Redirect to an error page or display an error message
                header("Location: error_delete_page.php");
                exit;
            }

            // Close the prepared statement and database connection
            $stmt->close();
            $conn->close();
        } else {
            // Redirect to an error page or display an error message if status ID is not provided

        }
    }

    $db = new database("stolen_autos_db");


    $conn = $db->getConnection();
    $conn->select_db("stolen_autos_db");


    $sql = "SELECT * FROM theft_status";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Status Name</th>
                            <th scope="col">Date Created</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td>' . $row["status_name"] . '</td>
                        <td>' . $row["date_created"] . '</td>
                        <td> 
                                <form action="" method="post">
                                    <a class="btn btn-primary" href="status.php?id=' . $row["id"] . '">View</a>
                                    <button type="submit" class="btn btn-danger" name="status_id" value="'. $row["id"] .'">Delete</button>
                                </form>
                        </td>
                      </tr>';
        }

        echo '</tbody>
                  </table>';
    } else {
        echo '<p>No records found</p>';
    }

    $conn->close();
    ?>
</div>
</body>

</html>
