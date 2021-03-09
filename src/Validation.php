<?php


namespace app\src;


use app\src\validation\ValidationRule;

/**
 * Class Validation
 * @package app\src
 */
class Validation
{
    /** @var ValidationRule[] $rules */
    private array $rules = [];

    /** @param ValidationRule[] $rules */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param $input
     * @return string
     */
    public function getFirstError($input): string
    {
        foreach ($this->rules as $rule) {
            $error = $rule->getError($input);
            if ($error) {
                return $error;
            }
        }

        return false;
    }
}