<?php
namespace app\core;

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
    protected function layoutContent() {
        $layout = Application::$app->layout;
        if (Application::$app->controller){
            $layout = Application::$app->layout;
        }
        ob_start();
        require_once Application::$ROOT_DIR."/Views/_layouts/$layout.php";
        return ob_get_clean();
    }
    public function renderView($view, $params = []) {
        $_layout = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace("{{view}}",$viewContent,$_layout);
    }
    protected function renderOnlyView($view, $params = []){
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        require_once Application::$ROOT_DIR."/Views/$view.php";
        return ob_get_clean();
    }
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->Method();
        //checking if the path exists 
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback) {
            if(is_string($callback)){
                return $this->renderView($callback);
            }elseif(is_array($callback)){  
                $callback[0] = new $callback[0];
                Application::$app->setController($callback[0]);
            }
            return call_user_func($callback,$this->request,$this->response, $this->session);
            
        }else{
            Application::$app->response->setStatusCode(404);
            return $this->renderView("404",[
                "Title" => "Error 404"
            ]);
        }
    }
}