<?php /** @noinspection ALL */

namespace classes;

use mysqli;
use mysqli_sql_exception;

class database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname;
    public  $conn;

    function __construct($dbname)
    {
        $this->dbname=$dbname;
    }

    public function getConnection()
    {
        $this->conn=null;
        try {
            $this->conn = new mysqli($this->servername, $this->username, $this->password);
        }
        catch (mysqli_sql_exception $e){
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }

    public function checkDbExistence()
    {
        $sql = "SHOW DATABASES LIKE '$this->dbname'";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        $stmt->store_result();
        $result = $this->conn->query($sql);

        return $result && $result->num_rows > 0;
    }

    public function createDb(){

        try {
            $success = $this->conn->query("CREATE DATABASE IF NOT EXISTS $this->dbname");

            return $success;
        } catch (mysqli_sql_exception $e) {
            echo "Creating db failed: " . $e->getMessage();
            return false;
        }
    }

    public function createTables()
    {
        $this->conn->select_db($this->dbname);

        //create tables
        $createCarInfoSql = "CREATE TABLE IF NOT EXISTS car_info (
            id INT AUTO_INCREMENT PRIMARY KEY,
            brand_name VARCHAR(255),
            model_name VARCHAR(255),
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $stmt1 = $this->conn->prepare($createCarInfoSql);
        $stmt1->execute();

        $createStatusSql = "CREATE TABLE IF NOT EXISTS theft_status (
            id INT AUTO_INCREMENT PRIMARY KEY,
            status_name VARCHAR(255),
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $stmt2 = $this->conn->prepare($createStatusSql);
        $stmt2->execute();

        //populate with some data
        $insertStatusSql = "INSERT INTO theft_status (status_name) VALUES
            ('Stolen'),
            ('Recovered')";

        $stmt3 = $this->conn->prepare($insertStatusSql);
        $stmt3->execute();

        $insertCarInfoSql = "INSERT INTO car_info (brand_name, model_name) VALUES
            ('Toyota', 'Camry'),
            ('Honda', 'Civic'),
            ('Ford', 'Focus'),
            ('Chevrolet', 'Malibu'),
            ('Nissan', 'Altima')";
        $stmt4 = $this->conn->prepare($insertCarInfoSql);
        $stmt4->execute();
    }
    public function createUser($username, $password)
    {
        $this->conn->select_db($this->dbname);

        $sqlGrantPrivileges = "GRANT ALL PRIVILEGES ON *.* TO '$username'@'%' WITH GRANT OPTION";
        $this->conn->query($sqlGrantPrivileges);
    }
}