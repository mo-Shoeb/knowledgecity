<?php

namespace App\Migration;

use App\DB\DatabaseConnection;

class UserMigrate
{
    /**
     * Migration File To Auto Create Table & Seed
     */
    private $conn;
    public function __construct()
    {
        $this->conn = DatabaseConnection::connect();
    }

    public function migrateAndSeed()
    {
        // disable forgien key checks
        $query = "SET FOREIGN_KEY_CHECKS = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $query = "DROP TABLE IF EXISTS users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $query = "CREATE TABLE users (
            id int AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password CHAR(60) NOT NULL,
            type ENUM('user', 'admin') DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $password = '"' . password_hash("admin", PASSWORD_BCRYPT) . '"';
        $query = "INSERT INTO users (username, password, type)
        VALUES
            ('admin',$password,'admin')
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // enable forgien key checks
        $query = "SET FOREIGN_KEY_CHECKS = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
}
