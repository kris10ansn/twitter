<?php


namespace app\src\validation;


class MinimumLengthRule extends ValidationRule
{
    private int $minimumLength;
    protected string $errorMessage = "Needs to be at least {min} characters";

    public function __construct(int $minimumLength, $customErrorMessage = false)
    {
        $this->minimumLength = $minimumLength;
        parent::__construct($customErrorMessage);
    }

    public function getError(string $input): string
    {
        if (strlen($input) < $this->minimumLength) {
            return str_replace("{min}", $this->minimumLength, $this->errorMessage);
        }

        return false;
    }
}