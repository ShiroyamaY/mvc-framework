<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Database $db;

    public static Application $app;
    public Session $session;

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function __construct(string $ROOT_DIR,array $config)
    {
        self::$ROOT_DIR = $ROOT_DIR;
        self::$app = $this;
        $this->request = Request::getInstance();
        $this->response = new Response();
        $this->router = Router::getInstance($this->request,$this->response);
        $this->db = Database::getInstance($config['db']);
        $this->session = new Session();
    }
    public function run(): void
    {
        echo $this->router->resolve();
    }
}