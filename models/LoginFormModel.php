<?php


namespace app\models;


use app\src\Session;
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

    public function login(): bool
    {
        $user = User::find(["email" => $this->fields["email"]]);

        if (!$user) {
            $this->setError("email", "No user with that e-mail address");
            return false;
        }

        if (!password_verify($this->fields["password"], $user->password)) {
            $this->setError("password", "Wrong password");
            return false;
        }

        Session::set("user", $user->id);

        return true;
    }

    protected function rules(): array
    {
        return [
            "email" => [new RequiredRule()],
            "password" => [new RequiredRule()]
        ];
    }
}