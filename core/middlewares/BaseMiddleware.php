<?php

namespace app\core\middlewares;

abstract class BaseMiddleware
{
    abstract function execute();
}