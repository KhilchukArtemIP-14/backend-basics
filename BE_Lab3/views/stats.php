<?php
require "..\classes\stats.php";
$stats=new stats();

$table1Count=$stats->getCarInfoCount()->fetch_row()[0];
$table2Count=$stats->getRecordsCount()->fetch_row()[0];
$totalLastMonth=$stats->getTotalRecordsLastMonth()->fetch_row()[0];
$lastCarInfo=$stats->getLastCarInfoRecord()->fetch_assoc();
$mostStolen=$stats->getCarInfoWithMostTheftRecords()->fetch_assoc();
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
    <h1>Statistics:</h1>
    <p>Records in Car Info: <?php echo $table1Count?></p>
    <p>Records in Theft Record: <?php echo $table2Count?></p>
    <p>Records in Theft Record: <?php echo $totalLastMonth?></p>
    <p>Last Car Info record is: <?php echo '<a href="cars\car.php?id='.$lastCarInfo["id"].'">'.$lastCarInfo["brand_name"]." ".$lastCarInfo["model_name"].'</a>'?></p>
    <p>Car that is most stolen is: <?php echo '<a href="cars\car.php?id='.$mostStolen["id"].'">'.$mostStolen["brand_name"]." ".$mostStolen["model_name"].'</a>'?></p>
</div>
</body>
</html>