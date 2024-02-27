<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Theft Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />
</head>
<body>
<div class="container">
    <h1>Edit Theft Record</h1>
    <?php
    require '..\..\classes\record.php';
    require '..\..\classes\status.php';
    require '..\..\classes\car.php';

    $recordObj = new record();
    $statusObj = new status();
    $carObj = new car();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate input data
        $id = $_POST["id"];
        $car_info_id = $_POST["car_info_id"];
        $status_id = $_POST["status_id"];
        $car_number = $_POST["car_number"];
        $owner_surname = $_POST["owner_surname"];

        $result = $recordObj->updateById($id, $car_info_id, $status_id, $car_number, $owner_surname);

        if ($result) {
            header("Location: records.php");
            exit;
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to update record.</div>';
        }
    } elseif (isset($_GET['id'])) {
        $id = $_GET['id'];

        $recordResult = $recordObj->getRecordById($id);
        $statusResult = $statusObj->getStatuses();
        $carResult = $carObj->getCars();

        if ($recordResult->num_rows > 0) {
            $row = $recordResult->fetch_assoc();
            ?>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="mb-3">
                    <label for="car_info_id" class="form-label">Car Info ID</label>
                    <select class="form-select" id="car_info_id" name="car_info_id" required>
                        <?php while ($carRow = $carResult->fetch_assoc()): ?>
                            <option value="<?php echo $carRow['id']; ?>" <?php if ($carRow['id'] == $row['car_info_id']) echo 'selected'; ?>><?php echo $carRow['brand_name'] . ' ' . $carRow['model_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status_id" class="form-label">Status ID</label>
                    <select class="form-select" id="status_id" name="status_id" required>
                        <?php while ($statusRow = $statusResult->fetch_assoc()): ?>
                            <option value="<?php echo $statusRow['id']; ?>" <?php if ($statusRow['id'] == $row['status_id']) echo 'selected'; ?>><?php echo $statusRow['status_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="car_number" class="form-label">Car Number</label>
                    <input type="text" class="form-control" id="car_number" name="car_number" value="<?php echo $row['car_number']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="owner_surname" class="form-label">Owner Surname</label>
                    <input type="text" class="form-control" id="owner_surname" name="owner_surname" value="<?php echo $row['owner_surname']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            <?php
        } else {
            echo '<div class="alert alert-danger" role="alert">Record not found.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Record ID not provided.</div>';
    }
    ?>
</div>
</body>
</html>
