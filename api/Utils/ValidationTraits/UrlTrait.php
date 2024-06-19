<?php

namespace App\Utils\ValidationTraits;

trait UrlTrait
{
    public function isUrl($key, $val)
    {
        $validationStatus = [
            "pass" => false,
            "message" => "$key should be a valid url",
            "val" => $val
        ];

        if($val && filter_var($val, FILTER_VALIDATE_URL) === false){
            return $validationStatus;
        }

        $validationStatus['pass'] = true;
        
        return $validationStatus;
    }
}
