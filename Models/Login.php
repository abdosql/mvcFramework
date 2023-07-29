<?php

namespace app\Models;

use app\core\Application;
use app\core\Model;

class Login extends Model
{
    public string $email = "";
    public string $password = "";
    public function Rules(): array
    {
        return[
            "email" => [self::RULE_REQUIRED, self::RULE_Email],
            "password" => [self::RULE_REQUIRED],
        ];
    }
    public function login(){
        $U = new User();
        //Finding the user
        $User = $U->FindOne(["email" => $this->email]);
        if (!$User){
            $this->addError("email", "Their is no user with this email.");
        }elseif (!password_verify($this->password, $User->password)){
            $this->addError("password", "The password is incorrect");
            return false;
        }
        var_dump($User);
        return Application::$app->login();
    }
}