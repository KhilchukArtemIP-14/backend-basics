<?php
use classes\database;

require "..\..\classes\database.php";
require "..\..\classes\status.php";

$status = new status();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $status_name = trim($_POST["status_name"]);

    $result = $status->insert($status_name);

    if ($result) {
        header("Location: statuses.php");
        exit;
    } else {
        header("Location: createstatus.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Theft Status</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Add Theft Status</h1>

    <form action="" method="post">
        <div class="mb-3">
            <label for="status_name" class="form-label">Status Name</label>
            <input type="text" class="form-control" id="status_name" name="status_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
</body>
</html>
