<?php


namespace app\src\validation;


/**
 * Class ValidationRule
 * @package app\src\validation
 */
abstract class ValidationRule
{
    protected string $errorMessage = "Error!";

    /**
     * ValidationRule constructor.
     * @param false $customErrorMessage
     */
    public function __construct($customErrorMessage = false)
    {
        if ($customErrorMessage !== false) {
            $this->errorMessage = $customErrorMessage;
        }
    }

    public abstract function getError(string $input): string;
}