<?php

namespace app\core;
use app\core\middlewares\BaseMiddleware;

class Controller
{
    protected string $layout = "main";
    public string $action = '';
    /**
     * @var array \app\core\middlewares\AuthMiddleware $middlewares
     */
    public array $middlewares = [];

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
    public function getLayout(): string
    {
        return $this->layout;
    }
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function render(string $view,array $array = []) : string{
        return Application::$app->router->renderView($view,$array);
    }
    public function registerMiddleware(BaseMiddleware $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

}