<?php

namespace app\core;
use app\core\Database\Database;
use app\core\Database\DbModel;

class Application
{
    public string $layout = "main";
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public ?UserModel $User;
    public DbModel $userClass;
    public ?Controller $controller = null;
    public Database $db;
    public View $view;
    public static string $ROOT_DIR;
    public static Application $app;
    public function __construct($mainPath, array $config){
        $this->User = null;
        self::$app = $this;
        self::$ROOT_DIR = $mainPath;
        $this->request = new Request;
        $this->view = new View();
        $this->response = new Response;
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response, $this->session);
        $this->db = new Database($config["db"]);
        $userId = $this->session->get('user');
        $this->userClass = new $config["userClass"];
        if ($userId){
            $primaryKey = $this->userClass->primaryKey();
            $this->User = $this->userClass->FindOne([$primaryKey => $userId]);
        }
    }
    public function run(){
        try {
            echo $this->router->resolve();
        }catch (\Exception $e){
            Application::$app->response->setStatusCode($e->getCode());
            echo $this->view->renderView("_error", [
                "exception" => $e
            ]);
        }
    }
    public function setController(Controller $controller){
        $this->controller = $controller;
    }
    public function getController(): Controller{
        return $this->controller;
    }
    public function isGuest(): bool{
        return !self::$app->User;
    }
    public function login(DbModel $user): bool{
        echo $user->
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set("user", $primaryValue);
        return true;
    }
    public function _logout(){
        $this->User = null;
        $this->session->remove("user");
    }
}