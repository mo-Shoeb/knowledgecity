<?php

namespace App\Model\BaseModelTraits;

trait UpdateTrait
{
    /**
     * Update Model (( REPLACE Data ))
     */
    public function update($updateValues, $where)
    {
        $keys = $this->getKeysUpdate($updateValues);
        $keysWhere = $this->getKeysWhereUpdate($where);
        $bindValues = $this->getBindValuesUpdate($updateValues);
        $bindWhereValues = $this->getBindValuesUpdate($where);

        $query = "UPDATE $this->tableName $keys WHERE $keysWhere";

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

        foreach ($bindWhereValues as $value) {
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
    private function getKeysUpdate($values)
    {
        $keys = [];
        foreach ($values as $key => $value) {
            $keys[] = "$key = ?";
        }
        return "SET " . implode(",", $keys);
    }

    /**
     * Get Where Conditions
     */
    private function getKeysWhereUpdate($values)
    {
        $keys = [];
        foreach ($values as $key => $value) {
            $keys[] = "$key = ?";
        }
        return implode(" AND ", $keys);
    }

    /**
     * Bind Insert Params
     */
    private function getBindValuesUpdate($values)
    {
        $formattedValues = [];
        foreach ($values as $value) {
            $formattedValues[] = $value;
        }
        return $formattedValues;
    }
}
