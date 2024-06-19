<?php

namespace App\Utils\ValidationTraits;

trait RequiredTrait
{
    public function isRequired($key, $val)
    {
        $validationStatus = [
            "pass" => false,
            "message" => "$key is required",
            "val" => $val
        ];

        if(is_null($val) || $val == ""){
            return $validationStatus;
        }

        $validationStatus['pass'] = true;
        
        return $validationStatus;
    }
}
