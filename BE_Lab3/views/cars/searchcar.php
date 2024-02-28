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
    <form class="row" action="" method="post">
        <div class="input-group rounded" style="max-width: 300px">
            <input type="search"
                   class="form-control rounded"
                   placeholder="Search by keyword"
                   aria-label="Search" aria-describedby="search-addon"
                   name="query"
            />
            <button class="input-group-text border-0" id="search-addon"
                    type="submit"
                    name="byQuery"
                    value="byQuery">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
        </div>
        <div class="input-group rounded" style="max-width: 300px">
            <input type="search"
                   class="form-control rounded"
                   placeholder="Search by template"
                   aria-label="Search"
                   aria-describedby="search-addon"
                   name="regexp"/>
            <button class="input-group-text border-0" id="search-addon"
                    type="submit"
                    name="byRegexp"
                    value="byRegexp">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
        </div>
        <input type="date"
               style="max-width: 150px"
               class="form-control rounded ms-2"
               placeholder="Search by template"
               aria-label="Search"
               aria-describedby="search-addon"
               name="startDate"/>
        <input type="date"
               style="max-width: 150px"
               class="ms-2 form-control rounded"
               name="endDate"/>
        <button class=" ms-2 btn btn-primary"
                style="max-width: 150px"
                name="byDate"
                value="byDate">Search by date</button>
    </form>

    <?php
    require "..\..\classes\car.php";

    $car = new car();

    if(isset($_POST["byQuery"])){
        $result = $car->search($_POST["query"]);
    }
    elseif(isset($_POST["byRegexp"])){
        $result = $car->search(null,$_POST["regexp"]);
    }
    elseif(isset($_POST["byDate"])){
        $result = $car->search(null,null,$_POST["startDate"],$_POST["endDate"]);
    }
    else{
        $result = $car->search();
    }


    if ($result->num_rows > 0) {
        echo '<table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Model</th>
                        <th scope="col">Date Created</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row["id"] . '</td>
                    <td>' . $row["brand_name"] . '</td>
                    <td>' . $row["model_name"] . '</td>
                    <td>' . $row["date_created"] . '</td>
                    <td>
                        <a class="btn btn-primary" href="car.php?id=' . $row["id"] . '">View</a>
                    </td>
                </tr>';
        }

        echo '</tbody>
            </table>';
    } else {
        echo '<p>No records found</p>';
    }
    ?>
</div>
</body>

</html>
