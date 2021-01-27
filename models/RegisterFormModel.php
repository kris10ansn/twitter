<?php


namespace app\models;


use app\src\Database;
use app\src\Session;
use app\src\validation\EmailRule;
use app\src\validation\MaximumLengthRule;
use app\src\validation\MinimumLengthRule;
use app\src\validation\RequiredRule;
use app\src\validation\UniqueRule;

class RegisterFormModel extends FormModel
{
    use DBModel;

    public array $fields = [
        "email" => "",
        "username" => "",
        "firstname" => "",
        "lastname" => "",
        "password" => ""
    ];

    public function register(): bool
    {
        // Hash password
        $this->fields["password"] = (string) password_hash($this->fields["password"], PASSWORD_DEFAULT);
        $this->fields["username"] = strtolower($this->fields["username"]);

        $this->insert("user");

        $id = Database::getInstance()->pdo->lastInsertId();

        Session::set("user", $id);

        return true;
    }

    protected function rules(): array
    {
        $nameRules = [new RequiredRule(), new MinimumLengthRule(2), new MaximumLengthRule(45)];

        return [
            "email" => [
                new RequiredRule(),
                new EmailRule(),
                new MaximumLengthRule(255),
                new UniqueRule(
                    "user",
                    "email",
                    "A user with that e-mail already exists"
                ),
            ],
            "username" => [
                new RequiredRule(),
                new MinimumLengthRule(2),
                new MaximumLengthRule(45),
                new UniqueRule(
                    "user",
                    "username",
                    "A user with that username already exists"
                ),
            ],
            "firstname" => $nameRules,
            "lastname" => $nameRules,
            "password" => [new RequiredRule(), new MinimumLengthRule(4), new MaximumLengthRule(96)],
        ];
    }
}