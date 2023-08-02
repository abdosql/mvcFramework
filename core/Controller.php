<?php

namespace app\core;

use app\core\Middlewares\BaseMiddleware;

class Controller
{
    private string $layout = "main";
    public string $action ="";
    /**
     *@var BaseMiddleware []
     */
    protected array $Middleware = [];
    public function setLayout($l){
        $this->layout = $l;
    }
    public function getLayout(): string
    {
        return $this->layout;
    }
    public function render($view, $params = []){
        return Application::$app->view->renderView($view, $params);
    }
    public function getBody(): array
    {
        return Application::$app->request->getBody();
    }
    public function NewMiddleware(BaseMiddleware $middleware){
        $this->Middleware[] = $middleware;
    }
    public function getMiddleware(): array{
        return $this->Middleware;
    }
}
