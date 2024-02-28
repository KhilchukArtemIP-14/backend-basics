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
    require '..\..\classes\record.php';

    if (isset($_GET['id'])) {
        $theft_id = $_GET['id'];

        $records=new record();
        $result_theft = $records->getRecordById($theft_id);

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

    } else {
        echo '<p>Theft Record ID not provided.</p>';
    }
    ?>
</div>
</body>
</html>