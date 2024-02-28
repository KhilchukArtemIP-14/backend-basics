<?php

use classes\database;
require_once  "database.php";

class status{
    public function getStatuses($orderByDescending=false){

        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT * FROM theft_status";
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
    public function getStatusById($id){
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT * FROM theft_status WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }
    public function insert($status_name)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "INSERT INTO theft_status (status_name, date_created) VALUES (?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $status_name);
        $stmt->execute();

        $affected_rows = $stmt->affected_rows;

        $stmt->close();
        $conn->close();

        return $affected_rows==1;
    }
    public function deleteById($status_id)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "DELETE FROM theft_status WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $status_id);
        $stmt->execute();

        $affected_rows = $stmt->affected_rows;

        $stmt->close();
        $conn->close();

        return $affected_rows==1;
    }

    public function updateById($status_id,$status_name)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "UPDATE theft_status SET status_name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status_name, $status_id);
        $stmt->execute();

        $affected_rows = $stmt->affected_rows;

        $stmt->close();
        $conn->close();

        return $affected_rows==1;
    }
    public function search($query=null,$template=null,$dateStart=null,$dateEnd=null)
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT * FROM theft_status";
        if($query){
            $sql=$sql." WHERE status_name LIKE '%" . $query . "%'";
        }
        elseif($template){
            $sql=$sql." WHERE status_name REGEXP '" . $template . "'";
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