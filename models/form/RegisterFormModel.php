<?php


namespace app\models\form;


use app\models\DBModel;
use app\src\Database;
use app\src\Session;
use app\models\form\validation\EmailRule;
use app\models\form\validation\MaximumLengthRule;
use app\models\form\validation\MinimumLengthRule;
use app\models\form\validation\RegexRule;
use app\models\form\validation\RequiredRule;
use app\models\form\validation\UniqueRule;

/**
 * Class RegisterFormModel
 * @package app\models\form
 */
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

        $id = Database::getInstance()->lastInsertId();

        Session::set("user", $id);

        return true;
    }

    protected function rules(): array
    {
        $nameRules = [
            new RequiredRule(),
            new MinimumLengthRule(2),
            new MaximumLengthRule(45)
        ];

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
                ...$nameRules,
                new RegexRule("\w+"),
                new UniqueRule("user", "username", "A user with that username already exists")
            ],
            "firstname" => $nameRules,
            "lastname" => $nameRules,
            "password" => [new RequiredRule(), new MinimumLengthRule(4), new MaximumLengthRule(96)],
        ];
    }
}