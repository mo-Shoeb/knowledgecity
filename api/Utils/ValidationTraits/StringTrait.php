<?php

namespace App\Utils\ValidationTraits;

trait StringTrait
{
    public function isString($key, $val)
    {
        $validationStatus = [
            "pass" => false,
            "message" => "$key should be a string",
            "val" => $val
        ];

        if($val && !is_string($val)){
            return $validationStatus;
        }

        $validationStatus['pass'] = true;
        
        return $validationStatus;
    }
}
