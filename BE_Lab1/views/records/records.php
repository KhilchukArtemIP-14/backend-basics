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

    <h1>Theft records</h1>
    <?php
    require '..\..\classes\record.php';

    $records=new record();
    $result = $records->getRecords();


    echo '<table class="table">
        <thead>
        <tr>
            <th scope="col">Record id</th>
            <th scope="col">Car Info</th>
            <th scope="col">Status</th>
            <th scope="col">Car Number</th>
            <th scope="col">Owner Surname</th>
            <th scope="col">Date Created</th>
            <th scope="col"></th>
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
                <td><a class="btn btn-primary" href="record.php?id=' .  $row["id"]  . '">View</a></td>

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