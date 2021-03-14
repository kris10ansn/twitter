<?php


namespace app\models\form\validation;


/**
 * Class ValidationRule
 * @package app\models\form\validation
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