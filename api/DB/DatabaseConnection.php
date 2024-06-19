<?php

namespace App\DB;

class DatabaseConnection
{

    /**
     * PDO Data Base Connection
     */
    public static function connect()
    {
        $host = '172.18.0.3';
        $db_name = 'course_catalog';
        $username = 'test_user';
        $password = 'test_password';
        $conn = null;
        try {
            $conn = new \PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $exception) {
            die("Connection error: " . $exception->getMessage());
        }
        
        return $conn;
    }
}
