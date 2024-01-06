<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public static Application $app;

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function __construct(string $ROOT_DIR)
    {
        self::$ROOT_DIR = $ROOT_DIR;
        self::$app = $this;
        $this->request = Request::getInstance();
        $this->response = new Response();
        $this->router = Router::getInstance($this->request,$this->response);
    }
    public function run(): void
    {
        echo $this->router->resolve();
    }
}