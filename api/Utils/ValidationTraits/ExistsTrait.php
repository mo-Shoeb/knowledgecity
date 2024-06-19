<?php

namespace App\Utils\ValidationTraits;

trait ExistsTrait
{
    public function isExist($key, $val, $validator)
    {
        $validationStatus = [
            "pass" => false,
            "message" => "$key doesn't exist with value: $val",
            "val" => $val
        ];

        $model = '\\App\\Model\\' . explode("-", $validator)[1];
        $column = explode("-", $validator)[2];

        $modelInstance = new $model;

        if($val){
            $count = $modelInstance->where($column, "=", $val)->where("status", "=", "active")->count();
            $count = $count[0]['count'] ?? 0;
            if( $count == 0 ){
                return $validationStatus;
            }
        }

        $validationStatus['pass'] = true;
        
        return $validationStatus;
    }
}
