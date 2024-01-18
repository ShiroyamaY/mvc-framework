<?php

namespace app\core\form;

use app\core\Model;

class Form
{
    public static function begin(string $action,string $method) : self{
        echo sprintf('<form action="%s" method="%s">',$action,$method);
        return new self();
    }
    public static function end(){
        echo '</form>';
    }
    public function field(Model $model, $attribute):InputField{
        return new InputField($model,$attribute);
    }
}