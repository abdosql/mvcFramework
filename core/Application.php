<?php

namespace app\core;
class Application
{
    public Router $router;
    private string $layout = "main";

    public Request $request;
    public Response $response;
    public Session $session;
    public ?DbModel $User;
    public DbModel $userClass;
    public ?Controller $controller = null;
    public Database $db;
    public static string $ROOT_DIR;
    public static Application $app;
    public function __construct($mainPath, array $config){
        self::$app = $this;
        self::$ROOT_DIR = $mainPath;
        $this->request = new Request;
        $this->response = new Response;
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response, $this->session);
        $this->db = new Database($config["db"]);
        $userId = $this->session->get('user');
        $this->userClass = new $config["userClass"];
        if (isset($userId)){
            $primaryKey = $this->userClass->primaryKey();
            $this->User = $this->userClass->FindOne([$primaryKey => $userId]);
        }else{
            $this->User=null;
        }
    }
    public function run(){
        echo $this->router->resolve();
    }
    public function setController(Controller $controller){
        $this->controller = $controller;
    }
    public function getController(): Controller{
        return $this->controller;
    }
    public function login(DbModel $user): bool{
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set("user", $primaryValue);
        return true;
    }
    public function isGuest(): bool
    {
        return $this->User === null;
    }
    public function _logout(){
        $this->User = null;
        $this->session->remove("user");
    }
}