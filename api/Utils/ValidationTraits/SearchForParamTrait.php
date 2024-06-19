<?php

namespace App\Utils\ValidationTraits;

trait SearchForParamTrait
{
    public function searchForParam($param)
    {
        $result = null;

        if (isset($_GET[$param])) {
            $result = $_GET[$param];
        }
        if (isset($_POST[$param])) {
            $result = $_POST[$param];
        }

        $body = file_get_contents('php://input');
        $jsonBody = json_decode($body, true);

        if (isset($jsonBody[$param])) {
            $result = $jsonBody[$param];
        }

        return $result;
    }
}
