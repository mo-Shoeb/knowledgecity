<?php

namespace App\Model;

use App\Model\BaseModel;
use App\DB\DatabaseConnection;

class Category extends BaseModel
{
    /**
     * Database Tables
     */
    public $conn;
    public $tableName = "categories";

    public function __construct()
    {
        $this->conn = DatabaseConnection::connect();
        parent::__construct($this->tableName, $this->conn);
    }
}
