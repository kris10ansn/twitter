<?php


namespace app\src\validation;


class MaximumLengthRule extends ValidationRule
{
    private int $maximumLength;
    protected string $errorMessage = "Can't be longer than {max} characters";

    public function __construct(int $maximumLength, $customErrorMessage = false)
    {
        $this->maximumLength = $maximumLength;
        parent::__construct($customErrorMessage);
    }


    public function getError(string $input): string
    {
        $length = strlen($input);
        if ($length > $this->maximumLength) {
            $error = str_replace("{max}", $this->maximumLength, $this->errorMessage);
            $error = str_replace("{num}", $length, $error);

            return $error;
        }

        return false;
    }
}