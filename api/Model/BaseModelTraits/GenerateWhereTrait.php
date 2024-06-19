<?php

namespace App\Model\BaseModelTraits;

trait GenerateWhereTrait
{
    private $generatedQuery;

    /**
     * Generate Where Conditions
     */
    public function generateWhere($query)
    {
        $this->generatedQuery = $query;

        // checks if needs where condition

        if (count($this->whereConditions) > 0) {

            $stmt = $this->generateWhereQueryConditions();

        } else {

            $this->addQueryOptions();

            $stmt = $this->conn->prepare($this->generatedQuery);
        }

        $stmt->execute();

        $output = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $this->resetClass();

        return $output;
    }

    /**
     * Bind Where Params To PDO
     */
    private function generateWhereQueryConditions()
    {
        $conditions = [];

        foreach ($this->whereConditions as $condition) {

            $column = $condition['column'];
            $operator = $condition['operator'];
            $value = $condition['value'];

            $conditions[] = "`$this->tableName`.`$column` $operator ?";
        }

        $this->generatedQuery .= " WHERE " . implode(" AND ", $conditions);

        $this->addQueryOptions();

        $stmt = $this->conn->prepare($this->generatedQuery);

        $paramIndex = 1;

        foreach ($this->whereConditions as $condition) {

            $value = $condition['value'];

            $stmt->bindValue($paramIndex++, $value, \PDO::PARAM_STR);

        }

        return $stmt;
    }

    /**
     * Add Other Query Options Like LIMIT, GROUP
     */
    private function addQueryOptions()
    {
        if (!is_null($this->joinCountGroup)) {
            $this->generatedQuery .= " " . $this->joinCountGroup;
        }

        if (!is_null($this->limit)) {
            $this->generatedQuery .= " LIMIT $this->limit";
        }
    }

    public function resetGenerateWhereTrait()
    {
        $this->generatedQuery = NULL;
    }
}
