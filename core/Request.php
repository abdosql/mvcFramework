<?php
namespace app\core;
class Request
{
    public function getPath(){
        $path = $_SERVER["REQUEST_URI"] ?? "/";
        $position = strpos($path, "?");
        if($position){
            $path = substr($path, 0, $position);
        }
        return $path;
    }
    public function Method(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }
    public function isGet(): bool
    {
        return $this->Method() === 'get';
    }
    public function isPost(): bool
    {
        return $this->Method() === 'post';

    }
    public function getBody(): array
    {
        $body = [];
        if($this->Method() == "get"){
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }elseif ($this->Method() == "post") {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }

        }
        return $body;
    }
}