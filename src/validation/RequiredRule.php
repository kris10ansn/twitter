<?php


namespace app\src\validation;


/**
 * Class RequiredRule
 * @package app\src\validation
 */
class RequiredRule extends ValidationRule
{
    protected string $errorMessage = "This field is required";

    public function getError(string $input): string
    {
        if (!isset($input) || $input === "") {
            return $this->errorMessage;
        }

        return false;
    }
}