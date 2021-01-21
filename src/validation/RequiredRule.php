<?php


namespace app\src\validation;


class RequiredRule extends ValidationRule
{

    public function getError(string $input): string
    {
        if (!isset($input) || $input === "") {
            return "This field is required";
        }

        return false;
    }
}