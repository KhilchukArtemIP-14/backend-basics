<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />
</head>
<body>
<div class="container">
    <h1>Theft records</h1>
    <?php
    require '..\..\classes\record.php';

    $records = new record();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['record_id'])) {
            $car_id = $_POST['record_id'];

            $result = $records->deleteById($car_id);

            if ($result) {
                header("Location: cars.php");
                exit;
            } else {

            }
        } else {

        }
    }
    $descending = isset($_GET['descending'])&&$_GET['descending']=== 'true';

    ?>
    <div>
        <a class="btn btn-success" href="createrecord.php">Add Record</a>
        Order by date created
        <?php
        if($descending){
            echo '<a type="button" class="btn btn-secondary" href="records.php?descending=false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
                        <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
                    </svg>
                 </a>';
        }
        else{
            echo'<a type="button" class="btn btn-secondary" href="records.php?descending=true">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-up" viewBox="0 0 16 16">
                <path d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.5.5 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"></path>
            </svg>
        </a>';
        }
        ?>
    </div>
    <?php
    $result = $records->getRecords(null,null,$descending);

    echo '    
        <table class="table">
        <thead>
        <tr>
            <th scope="col">Record id</th>
            <th scope="col">Car Info</th>
            <th scope="col">Status</th>
            <th scope="col">Car Number</th>
            <th scope="col">Owner Surname</th>
            <th scope="col">Date Created</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                <td>' . $row["id"] . '</td>
                <td>' . $row["brand_name"] . ' ' . $row["model_name"] . '</td>
                <td>' . $row["status_name"] . '</td>
                <td>' . $row["car_number"] . '</td>
                <td>' . $row["owner_surname"] . '</td>
                <td>' . $row["date_created"] . '</td>
                <td>
                    <a class="btn btn-primary" href="record.php?id=' . $row["id"] . '">View</a>
                    <a class="btn btn-warning" href="editrecord.php?id=' . $row["id"] . '">Edit</a>
                    <form action="deleterecord.php" method="post" style="display: inline;">
                        <input type="hidden" name="record_id" value="' . $row["id"] . '">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
              </tr>';
        }
    } else {
        echo '<tr><td colspan="7">No records found</td></tr>';
    }

    echo '</tbody>
      </table>';
    ?>
</div>
</body>
</html>
