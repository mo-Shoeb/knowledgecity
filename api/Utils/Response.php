<?php

namespace App\Utils;

class Response
{
    /**
     * Respond With Success JSON object
     * has option to remove protected columns if needed OPTIONAL
     * and to change page location if needed OPTIONAL
     */
    public static function success($response, $code = 200, $removeProtectedColumns = true, $location = NULL)
    {
        http_response_code($code);

        if (!is_null($location)) {
            header("Location: $location");
        }

        $protectedColumns = array("status");
        if ($removeProtectedColumns) {
            foreach ($protectedColumns as $protectedColumn) {
                if (is_array($response) || is_object($response)) {
                    // Convert object to array if it's an object
                    if (is_object($response)) {
                        $response = (array) $response;
                    }
                    // Remove 'status' key if it exists
                    if (array_key_exists($protectedColumn, $response)) {
                        unset($response[$protectedColumn]);
                    }

                    foreach ($response as $key => $r) {
                        if (!is_array($r)) break;
                        unset($response[$key][$protectedColumn]);
                    }
                }
            }
        }

        echo json_encode($response, JSON_PRETTY_PRINT);

        die();
    }

    /**
     * Respond With Failute JSON object
     * has option to remove protected columns if needed OPTIONAL
     * and to change page location if needed OPTIONAL
     */
    public static function error($response, $code = 400, $location = NULL)
    {

        http_response_code($code);

        if (!is_null($location)) {
            header("Location: $location");
        }

        echo json_encode($response, JSON_PRETTY_PRINT);

        die();
    }
}
