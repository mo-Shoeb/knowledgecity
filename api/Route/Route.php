<?php
namespace App\Route;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use App\Route\ExtractRouteValuesTrait;
use App\Route\MatchRoutePatternTrait;
use App\Utils\Response;

class Route
{
    use ExtractRouteValuesTrait, MatchRoutePatternTrait;
    /**
     * Make Sure That Admin is Authtincated
     */
    public static function guard()
    {
        session_start();

        if (!isset($_SESSION['isAuthenticated'])) {
            Response::error(["success" => false, "message" => "Not Authenticated"], 401);
            die();
        }
    }

    /**
     * Request Method: GET Middleware
     */
    public static function get($pattern, $controller)
    {
        if (!self::matchRoutePattern($pattern)) return;
        if($_SERVER['REQUEST_METHOD'] !== "GET") return Response::error("Method Not Allowed");
        self::execute($pattern, $controller);
    }

    /**
     * Request Method: POST Middleware
     */
    public static function post($pattern, $controller)
    {
        if (!self::matchRoutePattern($pattern)) return;
        if($_SERVER['REQUEST_METHOD'] !== "POST") return Response::error("Method Not Allowed");
        self::execute($pattern, $controller);
    }

    /**
     * Body Parser Middleware
     */
    public static function body()
    {
        return file_get_contents('php://input');
    }

    /**
     * Headers Parser Middleware
     */
    public static function headers()
    {
        return apache_request_headers();
    }

    /**
     * Initieates Target Class And Target Method
     */
    public static function execute($pattern, $controller)
    {
        
        list($controllerName, $methodName) = explode('@', $controller); // gets class name & method name

        $controllerFile = __DIR__ . '/../Controllers/' . $controllerName . '.php'; // open target class PHP file

        if (!file_exists($controllerFile)) {
            echo "File not found";
            die();
        }

        require_once $controllerFile; // require the target class

        if (!class_exists('App\Controllers\\' . $controllerName)) {
            echo "Class not found";
            die();
        }

        $controllerName = 'App\Controllers\\' . $controllerName; // add namespace
        $controller = new $controllerName();

        if (!method_exists($controller, $methodName)) {
            echo "Method not found";
            die();
        }
        $controller->$methodName(self::extractRouteValues($pattern)); // calls required method

        die();
    }
}
