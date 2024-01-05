<?php

namespace app\core;

class Router
{
    private static $instance;
    public Request $request;
    protected array $routes = [];
    public static function getInstance(Request $request): self
    {
        if(!self::$instance instanceof self){
            self::$instance = new self($request);
            return self::$instance;
        }
        return self::$instance;
    }
    private function __construct(Request $request){
        $this->request = $request;
    }
    public function get(string $path, string $callback){
        $this->routes['get'][$path] = $callback;
    }
    public function post(string $path, string $callback){
        $this->routes['post'][$path] = $callback;
    }
    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            return "Not found";
        }
        if (is_string($callback)){
            return $this->renderView($callback);
        }
        return call_user_func($callback);
    }
    public function renderView(string $view): string
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);
        return str_replace("{{content}}",$viewContent,$layoutContent);
    }
    protected function layoutContent() : string{
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }
    protected function renderOnlyView(string $view) : string {
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}