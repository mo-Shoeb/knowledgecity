<?php

namespace App\Controllers;

use App\Utils\Response;
use App\Utils\ValidateTrait;
use App\Migration\CategoryMigrate;
use App\Migration\CourseMigrate;
use App\Migration\UserMigrate;
use App\Controllers\Services\Admin\AdminLogin;

class AdminAuth
{
    use ValidateTrait;
    /**
     * Login admin
     */
    public function login()
    {
        // validate user input
        $validation = $this->validate([
            "username" => "required|string",
            "password" => "required|string",
        ]);

        AdminLogin::adminLoginService($validation);
    }

    /**
     * check if logged in
     */
    public function status()
    {
        Response::success(["success" => true, "message" => "Loggin In"]);
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        unset($_SESSION['isAuthenticated']);
        Response::success("Logged Out");
    }

    /**
     * Run Migrations
     */
    public function seed()
    {
        $category = new CategoryMigrate();
        $category->migrateAndSeed();
        $course = new CourseMigrate();
        $course->migrateAndSeed();
        $user = new UserMigrate();
        $user->migrateAndSeed();
        Response::success("DB Seeded");
    }
}
