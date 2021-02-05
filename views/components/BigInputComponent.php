<?php


namespace app\views\components;


use app\models\FormModel;

class BigInputComponent
{
    private FormModel $formModel;
    private string $placeholder;
    private string $action;
    private string $identifier;

    public function __construct(FormModel $formModel, string $placeholder, string $action="")
    {
        $this->formModel = $formModel;
        $this->placeholder = $placeholder;
        $this->action = $action;

        $this->identifier = "input" . rand(0, PHP_INT_MAX);
    }

    public function __toString(): string
    {
        /** @lang HTML */
        return "
        <script>
            function onSubmit{$this->identifier}() {
                const textarea = document.querySelector('#{$this->identifier} textarea');
                const contentEditable = document.querySelector('#{$this->identifier} div.text-input');
                textarea.value = contentEditable.textContent;
            }
        </script>
        <div id='{$this->identifier}' class='big-input'>
            <form action='{$this->action}' method='post' onsubmit='onSubmit{$this->identifier}()'>
                <div class='input'>
                    <div contenteditable data-placeholder='{$this->placeholder}' class='text-input'>{$this->formModel->fields['text']}</div>
                    <button type='submit'>Post</button>
                </div>
                <textarea name='text'></textarea>
                <p class='error'>{$this->formModel->getFirstError('text')}</p>
            </form>
        </div>
        ";
    }
}
?>
<link rel="stylesheet" href="styles/components/big-input.css">

