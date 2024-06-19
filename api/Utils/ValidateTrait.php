<?php

namespace App\Utils;

use App\Utils\ValidationTraits\RequiredTrait;
use App\Utils\ValidationTraits\StringTrait;
use App\Utils\ValidationTraits\UrlTrait;
use App\Utils\ValidationTraits\SearchForParamTrait;
use App\Utils\ValidationTraits\ExistsTrait;
use App\Utils\ValidationTraits\UniqueTrait;
use stdClass;

trait ValidateTrait
{
    use UniqueTrait, ExistsTrait, RequiredTrait, StringTrait, UrlTrait, SearchForParamTrait;
    public function validate($validationObject, $options = null)
    {
        if ($options === null) {
            $options = new stdClass();
        }
        
        $pass = (object) [];
        $errors = [];
        foreach ($validationObject as $key => $validation) {

            foreach (explode("|", $validation) as $requiredValidation) {

                $check = $this->initTraits($key, $requiredValidation);

                if (!$check['pass']) {
                    // add error + message
                    $errors[] = $check['message'];
                } else {
                    // add value to pass arr
                    if (!@$pass->$key) {
                        $pass->$key = $check['val'];
                    }
                }
            }
        }

        if (count($errors) > 0) {
            Response::error([
                "success" => false,
                "message" => $errors
            ]);
        }

        $data = $this->removeNullValues($pass);
        if( count(get_object_vars($data)) < ($options->min ?? 0) ){
            $msg = $options->min ?? 0;
            Response::error("At least ($msg) item(s) should be passed");
        }
        return $data;
    }

    /**
     * All Validation Traits Should Be Called Here
     */
    private function initTraits($key, $validation)
    {
        if ($validation == "required") return $this->isRequired($key, $this->searchForParam($key));
        if ($validation == "string") return $this->isString($key, $this->searchForParam($key));
        if ($validation == "url") return $this->isUrl($key, $this->searchForParam($key));
        if (strpos($validation, "validateExists-") !== false) return $this->isExist($key, $this->searchForParam($key), $validation);
        if (strpos($validation, "validateUnique-") !== false) return $this->isUnique($key, $this->searchForParam($key), $validation);
    }

    /**
     * Remove any NULL values
     */
    private function removeNullValues($object)
    {
        // Convert the object to an associative array
        $array = (array) $object;

        // Filter out null values
        $filteredArray = array_filter($array, function ($value) {
            return ($value !== null && $value !== "");
        });

        // Convert the array back to an object
        return (object) $filteredArray;
    }
}
