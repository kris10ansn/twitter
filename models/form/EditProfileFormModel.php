<?php


namespace app\models\form;


use app\src\Session;
use app\src\util\Text;
use app\src\Validation;
use app\src\validation\EmailRule;
use app\src\validation\MaximumLengthRule;
use app\src\validation\MinimumLengthRule;
use app\src\validation\RegexRule;
use app\src\validation\RequiredRule;
use app\src\validation\UniqueRule;

class EditProfileFormModel extends FormModel
{
    public array $fields = [
        "username" => "",
        "biography" => "",
        "email" => ""
    ];

    public function apply(): bool
    {
        $user = Session::getUser();

        foreach ($this->fields as $field => $value) {
            if ($field === "biography") {
                $user->biography = Text::process($value);
                continue;
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