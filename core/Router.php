<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    private static ?Router $instance = null;
    public Request $request;
    public Response $response;
    protected array $routes = [];
    public static function getInstance(Request $request,Response $response): self
    {
        if(!self::$instance instanceof self){
            self::$instance = new self($request,$response);
            return self::$instance;
        }
        return self::$instance;
    }
    private function __construct(Request $request,Response $response){
        $this->request = $request;
        $this->response  = $response;
    }
    public function get(string $path, $callback){
        $this->routes['get'][$path] = $callback;
    }
    public function post(string $path, $callback){
        $this->routes['post'][$path] = $callback;
    }
    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }
        if (is_string($callback)){
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback)){
            /** @var Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach ($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request,$this->response);
    }
}