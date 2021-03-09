<?php


namespace app\views\components\form;


use app\models\form\FormModel;

/**
 * Class InputField
 * @package app\views\components\form
 */
class InputField extends Field
{
    public const TYPE_TEXT = "text";
    public const TYPE_PASSWORD = "password";

    public string $type;

    /**
     * InputField constructor.
     * @param FormModel $model
     * @param string $attribute
     * @param string $label
     */
    public function __construct(FormModel $model, string $attribute, string $label)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute, $label);
    }


    public function password(): InputField
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function render(): string
    {
        return sprintf('
            <input type="%s" name="%s" value="%s" class="%s" autocomplete="off">
            ',
            $this->type,
            $this->attribute,
            $this->model->fields[$this->attribute],
            $this->model->getFirstError($this->attribute) ? "invalid" : "",
        );
    }
}