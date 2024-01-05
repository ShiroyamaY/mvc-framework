<?php

namespace app\core;

class Router
{
    private static $instance;
    public Request $request;
    protected array $routes = [];
    public static function getInstance(Request $request): Router
    {
        if(!self::$instance instanceof self){
            self::$instance = new Router($request);
            return self::$instance;
        }
        return self::$instance;
    }
    private function __construct(Request $request){
        $this->request = $request;
    }
    public function get($path,$callback){
        $this->routes['get'][$path] = $callback;
    }
    public function post($path,$callback){
        $this->routes['post'][$path] = $callback;
    }
    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            echo "Not found";
            exit;
        }
        echo call_user_func($callback);
    }
}