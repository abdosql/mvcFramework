<?php
namespace app\core;

use app\core\Exceptions\NotFoundException;

class Router
{
    protected array $routes = [];
    private Request $request;
    private Response $response;
    private Session $session;

    public function __construct(Request $request, Response $response, Session $session)
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
    }
    //saving the callbacks in the array $routes with the type of the callback 'post' or 'get'

    public function get($path, $callback)
    {
        $this->routes["get"][$path] = $callback;
    }
    public function post($path, $callback)
    {
        $this->routes["post"][$path] = $callback;
    }
    /**
     * @throws NotFoundException
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->Method();
        //checking if the path exists 
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback) {
            if(is_string($callback)){
                return Application::$app->view->renderView($callback);
            }elseif(is_array($callback)){
                /** @var Controller $controller */
                $controller = new $callback[0]();
                Application::$app->controller = $controller;
                $controller->action = $callback[1];
                $callback[0] = $controller;
                foreach ($controller->getMiddleware() as $Middleware) {
                    $Middleware->execute();
                }
            }
            return call_user_func($callback,$this->request,$this->response, $this->session);
            
        }else{
            throw new NotFoundException();
        }
    }
}