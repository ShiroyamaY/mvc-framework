<?php

namespace app\core;

class Request
{
    
    private static ?Request $instance = null;
    public static function getInstance() : self{
        if(!self::$instance instanceof self) {
            self::$instance = new Request();
        }
        return self::$instance;
    }
    private function __construct(){}
    public function getPath() : string{
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path,'?');
        if($position === false){
            return $path;
        }
        return substr($path,0,$position);
    }
    public function getMethod() : string{
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public function isGet(): bool
    {
        return $this->getMethod() === "get";
    }
    public function isPost(): bool
    {
        return $this->getMethod() === "post";
    }
    public function getBody(): array
    {
        $body = [];
        if ($this->isGet()){
            foreach ($_GET as $key => $value){
                $body[$key] = filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()){
            foreach ($_POST as $key => $value){
                $body[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}