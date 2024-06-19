<?php

namespace App\Model\BaseModelTraits;

trait JoinCountTrait
{
    /**
     * Count Joined Model
     * Usage:
     * @param $tableName = tablename = "courses"
     * @param $on = ON Conidition = "`courses`.`category_id` = `categories`.`id`"
     * @param $count = Count Query =  "COUNT(courses.course_id) AS count_of_courses"
     * @param $group = Group By as it's esstinal for count = "GROUP BY categories.id"
     * 
     * "courses", "`courses`.`category_id` = `categories`.`id`", "COUNT(courses.course_id) AS count_of_courses", "GROUP BY categories.id"
     */
    private $joinCount;
    private $joinCountString;
    private $joinCountGroup;
    public function joinCount(string $tableName, string $on, string $count, string $group)
    {
        $this->joinCountString = $count;
        $this->joinCountGroup = $group;
        $this->joinCount = "LEFT JOIN $tableName ON $on";
        return $this;
    }

    public function resetJoinCountTrait()
    {
        $this->joinCount = NULL;
        $this->joinCountString = NULL;
        $this->joinCountGroup = NULL;
    }
}
