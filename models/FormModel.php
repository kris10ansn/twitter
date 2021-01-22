<?php


namespace app\models;


use app\src\Validation;

abstract class FormModel
{
    public array $fields = [];
    public array $errors = [];

    protected abstract function rules(): array;

    public function loadData(array $data): void
    {
        foreach (array_keys($this->fields) as $fieldName) {
            $this->fields[$fieldName] = $data[$fieldName] ?? "";
        }
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $field => $rules) {
            $validation = new Validation($rules);
            $error = $validation->getFirstError($this->fields[$field]);

            if ($error) {
                $this->errors[$field] = $error;
            }
        }

        return empty($this->errors);
    }

    public function getFirstError(string $field): string
    {
        return isset($this->errors[$field]) ? $this->errors[$field] : "";
    }
}