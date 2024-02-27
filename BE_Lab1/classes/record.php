<?php

use classes\database;
require_once  "database.php";

class record
{
    public function getRecords($status_id=null, $info_id=null)
    {

        $sql = "SELECT tr.id, tr.car_info_id, tr.status_id, tr.car_number, tr.owner_surname, tr.date_created,
            ts.status_name, ci.brand_name, ci.model_name
            FROM theft_record tr
            INNER JOIN theft_status ts ON tr.status_id = ts.id
            INNER JOIN car_info ci ON tr.car_info_id = ci.id
            ";
        if($status_id){
            $sql = $sql . " WHERE status_id = " . $status_id;
        }
        if($info_id){
            $sql = $sql . " WHERE car_info_id = " . $info_id;
        }
        $sql=$sql . " ORDER BY tr.id";

        $db = new database("stolen_autos_db");

        $conn=$db->getConnection();
        $conn->select_db("stolen_autos_db");

        $stmt=$conn->prepare($sql);
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

        $conn=$db->getConnection();
        $conn->select_db("stolen_autos_db");

        $stmt=$conn->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }
}