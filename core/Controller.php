<?php

namespace app\core;

class Controller
{
    protected string $layout = "main";

    public function getLayout(): string
    {
        return $this->layout;
    }
    public function setLayout(string $layout){
        $this->layout = $layout;
    }

    public function render(string $view,array $array = []) : string{
        return Application::$app->router->renderView($view,$array);
    }
}