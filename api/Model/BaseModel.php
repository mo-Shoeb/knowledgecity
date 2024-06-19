<?php

namespace App\Model;

use App\Model\BaseModelTraits\LimitTrait;
use App\Model\BaseModelTraits\GetTrait;
use App\Model\BaseModelTraits\CountTrait;
use App\Model\BaseModelTraits\GenerateWhereTrait;
use App\Model\BaseModelTraits\JoinCountTrait;
use App\Model\BaseModelTraits\JoinTrait;
use App\Model\BaseModelTraits\SaveTrait;
use App\Model\BaseModelTraits\WhereTrait;
use App\Model\BaseModelTraits\UpdateTrait;

class BaseModel
{
    /**
     * Base Model For Default Functions Like SELECT,JOIN,UPDATE,INSERT,LIMIT,GROUP
     */
    use LimitTrait, GetTrait, CountTrait, GenerateWhereTrait, JoinCountTrait, JoinTrait, SaveTrait, WhereTrait, UpdateTrait;
    private $tableName;
    private $conn;

    public function __construct(string $tableName, $conn)
    {
        $this->tableName = $tableName;
        $this->conn = $conn;
    }

    /**
     * Reset Class After Every Use To Prevent Any Unhandled Scenario Errors
     */
    public function resetClass() {
        // Use reflection to get all methods of the class
        $methods = get_class_methods($this);

        foreach ($methods as $method) {
            // Call the reset methods from traits
            if (
                strpos($method, "reset") !== false &&
                strpos($method, "Trait") !== false
            ) {
                $this->$method();
            }
        }
    }
    
}
