<?php


namespace app\views\components\form;


use app\models\FormModel;

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

    public function inputField($attribute, $label): InputField
    {
        return new InputField($this->model, $attribute, $label);
    }
}