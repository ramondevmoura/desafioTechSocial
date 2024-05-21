<?php

class Database {
    private $host;
    private $port;
    private $database;
    private $username;
    private $password;
    private $conn;

    public function __construct($host, $port, $database, $username, $password) {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;

        $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->database";
        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            // Configura para lançar exceções em caso de erros
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}