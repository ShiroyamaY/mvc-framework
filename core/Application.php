<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public function __construct(string $ROOT_DIR)
    {
        self::$ROOT_DIR = $ROOT_DIR;
        $this->request = Request::getInstance();
        $this->router = Router::getInstance($this->request);
    }
    public function run(): void
    {
        echo $this->router->resolve();
    }
}