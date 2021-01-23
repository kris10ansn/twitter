<?php


namespace app\src\validation;


abstract class ValidationRule
{
    protected string $errorMessage = "Error!";

    public function __construct($customErrorMessage = false)
    {
        if ($customErrorMessage !== false) {
            $this->errorMessage = $customErrorMessage;
        }
    }

    public abstract function getError(string $input): string;
}