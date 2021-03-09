<?php


namespace app\src\validation;


/**
 * Class RegexRule
 * @package app\src\validation
 */
class RegexRule extends ValidationRule
{
    private string $pattern;
    protected string $errorMessage = "Illegal character: '{char}'";

    /**
     * RegexRule constructor.
     * @param $regex
     * @param false $customErrorMessage
     */
    public function __construct($regex, $customErrorMessage = false)
    {
        $this->pattern = $regex;
        parent::__construct($customErrorMessage);
    }

    public function getError(string $input): string
    {
        preg_match("/({$this->pattern})/", $input, $matches);

        if ($matches[0] !== $input) {
            preg_match("/[^({$this->pattern})]/", $input, $illegalCharacters);
            
            return str_replace("{char}", $illegalCharacters[0], $this->errorMessage);
        }

        return false;
    }
}