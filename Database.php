<?php

class Database{

    private $host = "localhost";
    private $db_name = "task";
    private $username = "root";
    private $password = "pate9gaV!";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function escape($value) {
        return $this->conn->real_escape_string($value);
    }

    public function getLastInsertId() {
        return $this->conn->insert_id;
    }

    public function prepareStatement($sql, $params) {
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $param => $value) {
            $stmt->bindValue(":$param", $value);
        }
        return $stmt;
    }
}
?>