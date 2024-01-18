<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{
    protected Model $model;
    protected string $attribute;
    abstract public function renderInput();
    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(\app\core\Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    public function __toString(){
        return sprintf('
            <div class="mb-3">
                <label class="form-label">%s</label>
                %s
                <div class="invalid-feedback">
                %s
                </div>
            </div>
        ',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}