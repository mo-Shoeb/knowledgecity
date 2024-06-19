<?php

namespace App\Controllers\Services\Admin;

use App\Model\User;
use App\Utils\ValidateTrait;
use App\Utils\Response;

class AdminLogin
{
    use ValidateTrait;

    public static function adminLoginService($validation)
    {
        // get user
        $user = (new User())->where("username", "=", $validation->username)->get();

        if (!$user) {
            Response::error(["success" => false, "message" => "User/Password incorrect"]);
        }

        // validate password
        if (!password_verify($validation->password, $user[0]['password'])) {
            Response::error(["success" => false, "message" => "User/Password incorrect"]);
        }

        // make sure data is correct
        session_start();
        $_SESSION['isAuthenticated'] = 'true';
        Response::success(["success" => true, "message" => "Welcome back :) ..."]);
    }
}
