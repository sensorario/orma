<?php

namespace Sensorario\Orma;

class Insert
{
    public function __construct(
        private string $table,
        private array $model,
    ) { }

    public function sqlStatement()
    {
        $sql = 'insert into ' . $this->table . ' ';
        $sql .= '(' . join(', ', array_keys($this->model)) . ')';
        $sql .= ' values ';
        $sql .= '(' . join(', ', array_values($this->model)) . ')';
        $sql .= ';';

        return $sql;
    }
}