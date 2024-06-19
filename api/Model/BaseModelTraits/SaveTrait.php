<?php

namespace App\Model\BaseModelTraits;

trait SaveTrait
{
    /**
     * Save Model (( INSERT Data ))
     */
    public function save($insertValues)
    {
        $keys = $this->getKeysSave($insertValues);
        $values = $this->getValuesSave($insertValues);
        $bindValues = $this->getBindValuesSave($insertValues);

        $query = "INSERT INTO $this->tableName ($keys) VALUES ($values)";

        $stmt = $this->conn->prepare($query);

        $paramIndex = 1;
        foreach ($bindValues as $value) {
            if (is_null($value)) {
                $stmt->bindValue($paramIndex, NULL, \PDO::PARAM_NULL);
            } else {
                $stmt->bindValue($paramIndex, $value, \PDO::PARAM_STR);
            }
            $paramIndex++;
        }

        $stmt->execute();
    }

    /**
     * Get Column Names
     */
    private function getKeysSave($values)
    {
        $keys = [];
        foreach ($values as $key => $value) {
            $keys[] = $key;
        }
        return implode(",", $keys);
    }

    /**
     * Get Column Values
     */
    private function getValuesSave($values)
    {
        $formattedValues = [];
        foreach ($values as $value) {
            $formattedValues[] = "?";
        }
        return implode(",", $formattedValues);
    }

    /**
     * Bind Insert Params
     */
    private function getBindValuesSave($values)
    {
        $formattedValues = [];
        foreach ($values as $value) {
            $formattedValues[] = $value;
        }
        return $formattedValues;
    }
}
