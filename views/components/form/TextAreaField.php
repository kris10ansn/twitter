<?php


namespace app\views\components\form;


use app\models\form\FormModel;

/**
 * Class TextAreaField
 * @package app\views\components\form
 */
class TextAreaField extends Field
{
    public string $rows;
    public string $cols;

    /**
     * TextAreaField constructor.
     * @param FormModel $model
     * @param string $attribute
     * @param string $label
     * @param string $rows
     * @param string $cols
     */
    public function __construct(FormModel $model, string $attribute, string $label, $rows="", $cols="")
    {
        $this->rows = $rows;
        $this->cols = $cols;
        parent::__construct($model, $attribute, $label);
    }

    public function render(): string
    {
        return "
            <textarea
                id='{$this->attribute}'
                name='{$this->attribute}',
                rows='{$this->rows}'
                cols='{$this->cols}'
            >{$this->model->fields[$this->attribute]}</textarea>
        ";
    }
}