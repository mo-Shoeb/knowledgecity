<?php
namespace App\Model\BaseModelTraits;

trait LimitTrait
{
    /**
     * Limit Query Response
     */
    private $limit;

    public function limit($limit = 1)
    {
        $this->limit = $limit;
        return $this;
    }

    public function resetLimitTrait()
    {
        $this->limit = NULL;
    }
}
