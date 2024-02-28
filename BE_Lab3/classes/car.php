<?php

use classes\database;
require_once "database.php";

class car
{
    public function getCars($orderByDescending=false)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT * FROM car_info";
        if($orderByDescending){
            $sql=$sql." ORDER BY date_created DESC";
        }
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

    public function insert($brand_name, $model_name)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "INSERT INTO car_info (brand_name, model_name, date_created) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $brand_name, $model_name);
        $stmt->execute();

        $affected_rows = $stmt->affected_rows;

        $stmt->close();
        $conn->close();

        return $affected_rows == 1;
    }

    public function deleteById($car_id)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "DELETE FROM car_info WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $car_id);
        $stmt->execute();

        $affected_rows = $stmt->affected_rows;

        $stmt->close();
        $conn->close();

        return $affected_rows == 1;
    }

    public function search($query=null,$template=null,$dateStart=null,$dateEnd=null)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT * FROM car_info";
        if($query){
            $sql=$sql." WHERE brand_name LIKE '%" . $query . "%' OR model_name LIKE '%" . $query . "%'";
        }
        elseif($template){
            $sql=$sql." WHERE brand_name REGEXP '" . $template . "' OR model_name REGEXP '" . $template . "'";
        }
        elseif ($dateStart&&$dateEnd){
            $sql=$sql." WHERE date_created between '" . $dateStart . "' and '". $dateEnd . "'";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }
}
