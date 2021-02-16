<?php


namespace app\views\components\form;


use app\models\FormModel;

abstract class Field
{
    protected FormModel $model;
    public string $attribute;
    public string $label;

    /**
     * Field constructor.
     * @param FormModel $model
     * @param string $attribute
     * @param string $label
     */
    public function __construct(FormModel $model, string $attribute, string $label)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->label = $label;
    }

    abstract public function render(): string;

    public function __toString(): string
    {
        return sprintf('
            <label>%s</label>
            %s
            <p class="error">%s</p>
        ',
            $this->label,
            $this->render(),
            $this->model->getFirstError($this->attribute) ? "*{$this->model->getFirstError($this->attribute)}" : ""
        );
    }
}