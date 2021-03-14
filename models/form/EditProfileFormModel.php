<?php


namespace app\models\form;


use app\src\Session;
use app\src\util\Text;
use app\models\form\validation\EmailRule;
use app\models\form\validation\MaximumLengthRule;
use app\models\form\validation\MinimumLengthRule;
use app\models\form\validation\RegexRule;
use app\models\form\validation\RequiredRule;
use app\models\form\validation\UniqueRule;

/**
 * Class EditProfileFormModel
 * @package app\models\form
 */
class EditProfileFormModel extends FormModel
{
    public array $fields = [
        "username" => "",
        "biography" => "",
        "email" => "",
        "favorite_user" => ""
    ];

    public function apply(): bool
    {
        $user = Session::getUser();

        foreach ($this->fields as $field => $value) {
            if ($field === "biography") {
                $user->biography = Text::process($value);
                continue;
            }

            if ($field === "favorite_user" && $value == null) {
                $value = null;
            }

            $user->{$field} = $value;
        }

        return $user->sync();
    }

    public function validate(): bool
    {
        $user = Session::getUser();
        foreach ($this->rules() as $field => $rules) {
            if ($this->fields[$field] !== $user->{$field}) {
                $this->validateField($field, $rules);
            }
        }

        return empty($this->errors);
    }

    protected function rules(): array
    {
        return [
            "username" => [
                new RequiredRule(),
                new MinimumLengthRule(2),
                new MaximumLengthRule(45),
                new RegexRule("\w+")
            ],
            "biography" => [
                new RequiredRule(),
                new MaximumLengthRule(255),
            ],
            "email" => [
                new RequiredRule(),
                new EmailRule(),
                new MaximumLengthRule(255),
                new UniqueRule(
                    "user",
                    "email",
                    "A user with that e-mail already exists"
                ),
            ]
        ];
    }
}