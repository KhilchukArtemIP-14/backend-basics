<?php

use classes\database;
require_once  "database.php";

class car
{
    public function getCars()
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT * FROM car_info";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }
    public function getCarById($id)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT * FROM car_info WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }
}