<?php

namespace App\Model\BaseModelTraits;

trait CountTrait
{
    /**
     * count From Table
     */
    public function count()
    {
        $query = "SELECT count(*) as count FROM " . $this->tableName;

        return $this->generateWhere($query);
    }
}
