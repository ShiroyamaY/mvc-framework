<?php

namespace app\core;

class Application
{
    public Router $router;
    public Request $request;
    public function __construct()
    {
        $this->request = Request::getInstance();
        $this->router = Router::getInstance($this->request);
    }
    public function run(): void
    {
        $this->router->resolve();
    }
}