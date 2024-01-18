<?php

namespace app\core\form;

use app\core\Model;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'NUMBER';
    private string $type;

    public function __construct(\app\core\Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    public function passwordField(): static
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function renderInput()
    {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control %s">',
            $this->attribute,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? 'is-invalid' : ''
        );
    }
}