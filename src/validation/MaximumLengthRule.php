<?php


namespace app\src\validation;


class MaximumLengthRule extends ValidationRule
{
    private int $maximumLength;

    public function __construct(int $maximumLength)
    {
        $this->maximumLength = $maximumLength;
    }


    public function getError(string $input): string
    {
        if (strlen($input) > $this->maximumLength) {
            return "Can't be longer than $this->maximumLength characters";
        }

        return false;
    }
}