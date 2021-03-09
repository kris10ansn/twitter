<?php


namespace app\src\validation;


/**
 * Class EmailRule
 * @package app\src\validation
 */
class EmailRule extends ValidationRule
{
    protected string $errorMessage = "Invalid e-mail!";

    public function getError(string $input): string
    {
        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return $this->errorMessage;
        }
        return false;
    }
}