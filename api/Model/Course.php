<?php

namespace App\Model;

use App\Model\BaseModel;
use App\DB\DatabaseConnection;

class Course extends BaseModel
{
    /**
     * Database Tables
     */
    public $conn;
    public $tableName = "courses";
    public function __construct()
    {
        $this->conn = DatabaseConnection::connect();
        parent::__construct($this->tableName, $this->conn);

    }

}
