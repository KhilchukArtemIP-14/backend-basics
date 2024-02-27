<?php

use classes\database;
require_once "database.php";

class record
{
    public function getRecords($status_id = null, $info_id = null,$orderByDescending=false)
    {

        $sql = "SELECT tr.id, tr.car_info_id, tr.status_id, tr.car_number, tr.owner_surname, tr.date_created,
            ts.status_name, ci.brand_name, ci.model_name
            FROM theft_record tr
            INNER JOIN theft_status ts ON tr.status_id = ts.id
            INNER JOIN car_info ci ON tr.car_info_id = ci.id
            ";
        if ($status_id) {
            $sql = $sql . " WHERE status_id = " . $status_id;
        }
        if ($info_id) {
            // If a status_id condition was already added, use "AND" instead of "WHERE"
            $sql = $status_id ? $sql . " AND car_info_id = " . $info_id : $sql . " WHERE car_info_id = " . $info_id;
        }
        if($orderByDescending){
            $sql=$sql." ORDER BY date_created DESC";
        }
        else{
            $sql = $sql . " ORDER BY tr.id";
        }
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }

    public function getRecordById($id)
    {
        $sql = "SELECT tr.id, tr.car_info_id, tr.status_id, tr.car_number, tr.owner_surname, tr.date_created,
                      ts.status_name, ci.brand_name, ci.model_name
                      FROM theft_record tr
                      INNER JOIN theft_status ts ON tr.status_id = ts.id
                      INNER JOIN car_info ci ON tr.car_info_id = ci.id
                      WHERE tr.id = ?";
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }

    public function insert($car_info_id, $status_id, $car_number, $owner_surname)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "INSERT INTO theft_record (car_info_id, status_id, car_number, owner_surname, date_created) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $car_info_id, $status_id, $car_number, $owner_surname);
        $stmt->execute();

        $affected_rows = $stmt->affected_rows;

        $stmt->close();
        $conn->close();

        return $affected_rows == 1;
    }

    public function deleteById($record_id)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "DELETE FROM theft_record WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $record_id);
        $stmt->execute();

        $affected_rows = $stmt->affected_rows;

        $stmt->close();
        $conn->close();

        return $affected_rows == 1;
    }

    public function updateById($record_id, $car_info_id, $status_id, $car_number, $owner_surname)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "UPDATE theft_record SET car_info_id = ?, status_id = ?, car_number = ?, owner_surname = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissi", $car_info_id, $status_id, $car_number, $owner_surname, $record_id);
        $stmt->execute();

        $affected_rows = $stmt->affected_rows;

        $stmt->close();
        $conn->close();

        return $affected_rows == 1;
    }
}
