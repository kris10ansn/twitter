<?php


namespace app\models;


use app\src\Validation;
use app\src\validation\EmailRule;
use app\src\validation\MaximumLengthRule;
use app\src\validation\MinimumLengthRule;
use app\src\validation\RequiredRule;

class LoginFormModel
{
    public array $fields = [
        "email" => "",
        "password" => ""
    ];
    public array $errors;

    public function loadData($data)
    {
        $this->fields["email"] = $data["email"] ?? "";
        $this->fields["password"] = $data["password"] ?? "";
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

    private function rules(): array {
        return [
            "email" => [new RequiredRule(), new EmailRule(), new MaximumLengthRule(255)],
            "password" => [new RequiredRule(), new MinimumLengthRule(4), new MaximumLengthRule(96)]
        ];
    }
}