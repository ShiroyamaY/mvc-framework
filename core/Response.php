<?php

namespace app\core;

class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $url,array $params = []): void
    {
        header("location: /");
    }
}