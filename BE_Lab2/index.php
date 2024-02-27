<?php

use classes\database;

require "classes\database.php";

$db = new database("stolen_autos_db");

$conn=$db->getConnection();

if(!$db->checkDbExistence()){
    $db->createDb();
    $db->createTables();
    $db->createUser("artem6","superpassword");
}
?>
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

    <h1>Welcome to lab1!</h1>
    <h3>All tables:</h3>
    <ul class="list-group">
        <a href="views/cars/cars.php" class="list-group-item list-group-item-action">Car information</a>
        <a href="views/statuses/statuses.php" class="list-group-item list-group-item-action">Statuses</a>
        <a href="views/records/records.php" class="list-group-item list-group-item-action">Theft records</a>
    </ul>
</div>
</body>
</html>