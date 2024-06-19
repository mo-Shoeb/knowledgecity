<?php

namespace App\Model\BaseModelTraits;

trait GetTrait
{
    /**
     * Select From Table, Add Join Statment if requested
     */
    public function get()
    {
        $query = "SELECT * FROM " . $this->tableName;

        if (!is_null($this->join)) {

            $query .= " $this->join"; // adds join query

        } elseif (!is_null($this->joinCount)) {

            $query = "SELECT $this->tableName.*, $this->joinCountString FROM " . $this->tableName . " " . $this->joinCount; // join with
        }

        return $this->generateWhere($query);
    }
}
