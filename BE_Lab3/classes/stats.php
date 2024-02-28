<?php
use classes\database;
require_once "database.php";
class stats
{
    public function getCarInfoCount()
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT  COUNT(*) FROM car_info";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }
    public function getRecordsCount()
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT  COUNT(*) FROM theft_record";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }

    public function getTotalRecordsLastMonth()
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT SUM(record_count) AS total_records_last_month FROM (
                SELECT COUNT(*) AS record_count FROM car_info WHERE date_created >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
                UNION ALL
                SELECT COUNT(*) AS record_count FROM theft_record WHERE date_created >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
            ) AS combined_counts";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;//['total_records_last_month'];
    }
    public function getLastCarInfoRecord()
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT * FROM car_info ORDER BY date_created DESC LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }
    public function getCarInfoWithMostTheftRecords()
    {
        $db = new database("stolen_autos_db");

        $conn = $db->getConnection();
        $conn->select_db("stolen_autos_db");

        $sql = "SELECT ci.*, COUNT(tr.car_info_id) AS theft_record_count
            FROM car_info ci
            LEFT JOIN theft_record tr ON ci.id = tr.car_info_id
            GROUP BY ci.id
            ORDER BY theft_record_count DESC
            LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
        $conn->close();

        return $result;
    }

}