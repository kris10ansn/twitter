<?php


namespace app\models;


use app\src\validation\EmailRule;
use app\src\validation\MaximumLengthRule;
use app\src\validation\MinimumLengthRule;
use app\src\validation\RequiredRule;

class RegisterFormModel extends FormModel
{
    public array $fields = [
        "email" => "",
        "username" => "",
        "firstname" => "",
        "lastname" => "",
        "password" => ""
    ];
    public array $errors;

    protected function rules(): array
    {
        $nameRules = [new RequiredRule(), new MinimumLengthRule(2), new MaximumLengthRule(45)];

        return [
            "email" => [new RequiredRule(), new EmailRule(), new MaximumLengthRule(255)],
            "username" => $nameRules,
            "firstname" => $nameRules,
            "lastname" => $nameRules,
            "password" => [new RequiredRule(), new MinimumLengthRule(4), new MaximumLengthRule(96)],
        ];
    }
}