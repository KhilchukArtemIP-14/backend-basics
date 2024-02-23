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
                        </tr>
                    </thead>
                    <tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td><a href="status.php?id=' . $row["id"] . '">' . $row["status_name"] . '</a></td>
                        <td>' . $row["date_created"] . '</td>
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
