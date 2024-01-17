<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    private array $actions;
    public function __construct(array $actions = []){
        $this->actions = $actions;
    }

    function execute(): void
    {
        if (Application::isGuest()){
            if (empty($this->actions) || in_array(Application::$app->controller->action,$this->actions)){
                throw new ForbiddenException();
            }
        }
    }
}