<?php

namespace app\core;
class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public ?DbModel $User;
    public string $userClass;
    public Controller $controller;
    public Database $db;
    public static string $ROOT_DIR;
    public static Application $app;
    public function __construct($mainPath, array $config){
        $this->userClass = $config["userClass"];
        self::$app = $this;
        self::$ROOT_DIR = $mainPath;
        $this->request = new Request;
        $this->response = new Response;
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response, $this->session);
        $this->db = new Database($config["db"]);
        $primaryKeyValue = $this->session->get("user");
        if (isset($primaryKeyValue)){
            $primaryKey = $this->userClass->primaryKey();
            $this->userClass->FindOne([$primaryKey => $primaryKeyValue]);
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
    public function login(DbModel $user){
        $this->User = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set("user", $primaryKey);
    }
}