<?php


namespace app\src\validation;


use app\src\Database;

/**
 * Class UniqueRule
 * @package app\src\validation
 */
class UniqueRule extends ValidationRule
{
    private string $table;
    private string $column;

    /**
     * UniqueRule constructor.
     * @param string $table
     * @param string $column
     * @param false $customErrorMessage
     */
    public function __construct(string $table, string $column, $customErrorMessage = false)
    {
        $this->table = $table;
        $this->column = $column;
        parent::__construct($customErrorMessage);
    }

    public function getError(string $input): string
    {
        $db = Database::getInstance();

        $statement = $db->pdo->prepare("SELECT count(*) as matches FROM $this->table WHERE $this->column=:input");
        $statement->bindValue(":input", $input);
        $statement->execute();
        $object = $statement->fetchObject();

        if ($object->matches > 0) {
            return $this->errorMessage;
        }

        return false;
    }
}