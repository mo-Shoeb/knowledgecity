<?php

namespace App\Model\BaseModelTraits;

trait JoinTrait
{
    /**
     * Selecet Data While Joining anohter Table
     * Usage:
     * @param $tableName = tableName = "courses"
     * @param $on = ON Conidition = "`courses`.`category_id` = `categories`.`id`"
     * @param $type = Join Type = INNER by default, LEFT, OUTER , etc.
     * 
     * "courses", "`courses`.`category_id` = `categories`.`id`", "INNER"
     */
    private $join;
    public function join(string $tableName, string $on, string $type = "INNER")
    {
        $this->join = "$type JOIN $tableName ON $on";
        return $this;
    }

    public function resetJoinTrait()
    {
        $this->join = NULL;
    }
}
