<?php

namespace App\Controllers;

use App\Model\User;
use App\Utils\Response;
use App\Utils\ValidateTrait;

class AdminController
{
    use ValidateTrait;

    /**
     * Update admin name & Password
     */
    public function update()
    {
        // validate user input
        $validation = $this->validate([
            "username" => "string",
            "password" => "string",
        ]);

        if( @$validation->password ){
            if( strlen($validation->password) < 6 ){
                Response::error("Min Password Length is 6 Chars");
            }
            $validation->password = password_hash($validation->password, PASSWORD_BCRYPT);
        }

        (new User())->update($validation, ["id" => 1]);

        Response::success("User Updated");
    }
}
