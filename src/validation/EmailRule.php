<?php


namespace app\src\validation;


class EmailRule extends ValidationRule
{

    public function getError(string $input): string
    {
        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return "Invalid e-mail!";
        }
        return false;
    }
}