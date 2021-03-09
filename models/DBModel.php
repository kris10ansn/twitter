<?php

namespace app\models;

use app\src\Database;

/**
 * Trait DBModel
 * @package app\models
 */
trait DBModel
{
    private function insert(string $table): bool
    {
        $db = Database::getInstance();

        $attributes_string = implode(",", array_keys($this->fields));
        $values_string = implode(",", array_map(fn($key) => ":$key", array_keys($this->fields)));

        $statement = $db->prepare("INSERT INTO $table ($attributes_string) VALUES ($values_string)");

        foreach ($this->fields as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();

        return true;
    }
}