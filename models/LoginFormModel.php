<?php


namespace app\models;


use app\src\Validation;
use app\src\validation\EmailRule;
use app\src\validation\MaximumLengthRule;
use app\src\validation\MinimumLengthRule;
use app\src\validation\RequiredRule;

class LoginFormModel extends FormModel
{
    public array $fields = [
        "email" => "",
        "password" => ""
    ];
    public array $errors;

    protected function rules(): array
    {
        return [
            "email" => [new RequiredRule(), new EmailRule(), new MaximumLengthRule(255)],
            "password" => [new RequiredRule(), new MinimumLengthRule(4), new MaximumLengthRule(96)]
        ];
    }
}