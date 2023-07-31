<?php

namespace app\core;

class Session
{
    protected const FLASH_KEY = "flash_messages";
    public function __construct(){
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $index => &$flashMessage) {
            $flashMessage["removed"] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
    public function setFlash($key, $message){
        $_SESSION[self::FLASH_KEY][$key] = [
            "removed" => false,
             "value" => $message,
        ];
    }
    public function getFlash($key): string
    {
        $message = $_SESSION[self::FLASH_KEY][$key]["value"] ?? null;
        if (isset($message)){
            return '<div class="alert alert-'.$key.'">'.$message.'</div>';
        }else{
            return "";
        }


    }
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY];
        foreach ($flashMessages as $index => $flashMessage) {
            if ($flashMessage["removed"] === true){
                unset($_SESSION[self::FLASH_KEY][$index]);
            }
        }
    }

    public function set(string $key, string $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        $session = "";
        if (isset($_SESSION[$key])) {
            $session = $_SESSION[$key];
        }
        return $session;
    }
    public function remove($key){
        unset($_SESSION[$key]);
    }
}