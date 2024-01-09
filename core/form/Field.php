<?php

namespace app\core\form;

use app\core\Model;

class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'NUMBER';
    private string $type;
    private Model $model;
    private string $attribute;

    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(\app\core\Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;
    }
    public function passwordField(): static
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
    public function __toString(){
        return sprintf('
            <div class="mb-3">
                <label class="form-label">%s</label>
                <input type="%s" name="%s" value="%s" class="form-control %s">
                <div class="invalid-feedback">
                %s
                </div>
            </div>
        ',
            $this->model->getLabel($this->attribute),
        $this->type,
        $this->attribute,
        $this->model->{$this->attribute},
        $this->model->hasError($this->attribute) ? 'is-invalid' : '',
        $this->model->getFirstError($this->attribute)
        );
    }

}