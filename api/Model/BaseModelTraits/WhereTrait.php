<?php

namespace App\Model\BaseModelTraits;

trait WhereTrait
{
    /**
     * Build Where Conditions
     */
    private $whereConditions = [];

    public function where(string $col, string $operator, string $val)
    {
        array_push($this->whereConditions, [
            'column' => $col,
            'operator' => $operator,
            'value' => $val
        ]);
        return $this;
    }

    public function resetWhereTrait()
    {
        $this->whereConditions = [];
    }
}
