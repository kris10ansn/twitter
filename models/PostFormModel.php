<?php


namespace app\models;


use app\src\Database;
use app\src\Session;
use app\src\validation\MinimumLengthRule;
use app\src\validation\RequiredRule;

class PostFormModel extends FormModel
{
    use DBModel;

    public array $fields = [
        "text" => "",
        "user_id" => "",
    ];

    public function post(): bool
    {
        $user = Session::getUser();
        if (!$user) {
            die("User not found");
        }

        $this->fields["user_id"] = $user->id;
        return $this->insert("post");
    }

    protected function rules(): array
    {
        return [
            "text" => [new RequiredRule("What do you want to post?")],
        ];
    }
}