<?php


namespace app\src\validation;


class MinimumLengthRule extends ValidationRule
{
    private int $minimumLength;

    public function __construct(int $minimumLength)
    {
        $this->minimumLength = $minimumLength;
    }

    public function getError(string $input): string
    {
        if (strlen($input) < $this->minimumLength) {
            return "Needs to be at least $this->minimumLength characters";
        }

        return false;
    }
}