<?php

namespace app\core\Middlewares;

use app\core\Application;
use app\core\Exceptions\ForbiddenExeption;

class AuthMiddleware extends BaseMiddleware
{
    private array $actions;
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    /**
     * @throws ForbiddenExeption
     */
    public function execute()
    {
        if (Application::$app->isGuest()){
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)){
                throw new ForbiddenExeption();
            }
        }
    }
}