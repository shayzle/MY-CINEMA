<?php

class Database {

    private $host = "127.0.0.1";
    private $database_name = "my_cinema";
    private $username = "root";
    private $password = "";

    public function connect() {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->database_name};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    // Force charset + collation
                    PDO::MYSQL_ATTR_INIT_COMMAND =>
                        "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci", // utf8 for full Unicode support

                    // Throw exceptions on errors
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // error handling

                    // Fetch associative arrays
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // fetch mode
                ]
            );

            return $pdo;

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
            "error" => "Database connection ain't found"
            ]);
            exit;
        }
    }

    public function getConnection() { 
        return $this->connect();
    }
}
