<?php


namespace app\src\validation;


abstract class ValidationRule
{
    public abstract function getError(string $input): string;
}