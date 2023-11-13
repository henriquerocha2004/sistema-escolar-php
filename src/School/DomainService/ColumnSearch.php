<?php

namespace App\School\DomainService;

class ColumnSearch
{
    private string $column;
    private string $value;

    public function __construct(string $column, string $value)
    {
        $column = htmlspecialchars($column, ENT_QUOTES);
        $column = filter_var($column, FILTER_SANITIZE_SPECIAL_CHARS);
        $value = htmlspecialchars($value, ENT_QUOTES);

        $this->column = $column;
        $this->value = $value;
    }


    public function getColumn(): string
    {
        return $this->column;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
