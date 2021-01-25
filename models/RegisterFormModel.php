<?php


namespace app\models;


use app\src\Database;
use app\src\Session;
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

    public function register(): bool
    {
        // Hash passord
        $this->fields["password"] = (string) password_hash($this->fields["password"], PASSWORD_DEFAULT);

        $db = Database::getInstance();

        $attributes_string = implode(",", array_keys($this->fields));
        $values_string = implode(",", array_map(fn($key) => ":$key", array_keys($this->fields)));

        $statement = $db->pdo->prepare("INSERT INTO user ($attributes_string) VALUES ($values_string)");

        foreach ($this->fields as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();
        $id = $db->pdo->lastInsertId();

        Session::set("user", $id);

        return true;
    }

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