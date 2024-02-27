<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Theft Status</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Edit Theft Status</h1>

    <?php
    use classes\database;

    require "..\..\classes\database.php";
    require "..\..\classes\status.php";

    $status = new status();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['status_id'])) {
        $status_id = $_POST['status_id'];
        $status_name = trim($_POST["status_name"]);


        $result = $status->updateById($status_id, $status_name);

        if ($result) {
            header("Location: statuses.php");
            exit;
        } else {
            header("Location: error_delete_page.php");
            exit;
        }
    }
    }
    if (isset($_GET['id'])) {
        $status_id = $_GET['id'];

        $result_status = $status->getStatusById($status_id);

        if ($result_status->num_rows > 0) {
            $row_status = $result_status->fetch_assoc();
   ?>
            <form action="" method="post">
                <input type="hidden" name="status_id" value="<?php echo $row_status['id']; ?>">
                <div class="mb-3">
                    <label for="status_name" class="form-label">Status Name</label>
                    <input type="text" class="form-control" id="status_name" name="status_name" value="<?php echo $row_status['status_name']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            <?php
        } else {
            echo '<p>Status not found.</p>';
        }

    } else {
        echo '<p>Status ID not provided.</p>';
    }
    ?>
</div>
</body>
</html>
