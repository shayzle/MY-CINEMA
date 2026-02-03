<?php

class Database {

    private $localhost = "localhost"; 
    private $database_name = "my_cinema";
    private $username = "root";
    private $password = "root";

    public function connect() {
        try {
            $pdo = new PDO(
                "mysql:host={$this->localhost};dbname={$this->database_name};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    // Force charset + collation
                    PDO::MYSQL_ATTR_INIT_COMMAND =>
                        "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci", // utf8mb4 for full Unicode support

                    // Throw exceptions on errors
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // error handling

                    // Fetch associative arrays
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // fetch mode
                ]
            );

            return $pdo;

        } catch (PDOException $e) {
            die("ERROR MESSAGE !! " . $e->getMessage());
        }
    }

    public function getConnection() { 
        return $this->connect();
    }
}
