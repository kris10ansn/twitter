<?php


namespace app\views\components\form;


use app\models\form\FormModel;

/**
 * Class Form
 * @package app\views\components\form
 */
class Form
{
    public string $action;
    public string $method;
    private FormModel $model;

    /**
     * Form constructor.
     * @param string $action
     * @param string $method
     * @param FormModel $model
     */
    public function __construct(string $action, string $method, FormModel $model)
    {
        $this->action = $action;
        $this->method = $method;
        $this->model = $model;
    }


    public function begin(): string
    {
        return sprintf('<form action="%s" method="%s">', $this->action, $this->method);
    }

    public function end(): string
    {
        return '</form>';
    }

    /**
     * @param $attribute
     * @param $label
     * @return InputField
     */
    public function inputField($attribute, $label): InputField
    {
        return new InputField($this->model, $attribute, $label);
    }

    /**
     * @param $attribute
     * @param $label
     * @param string $rows
     * @param string $cols
     * @return TextAreaField
     */
    public function textAreaField($attribute, $label, $rows="", $cols=""): TextAreaField
    {
        return new TextAreaField($this->model, $attribute, $label, $rows, $cols);
    }
}