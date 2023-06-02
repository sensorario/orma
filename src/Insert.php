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
        $sql .= '(' . $this->values() . ')';
        $sql .= ';';

        return $sql;
    }

    public function values($string = '')
    {
        foreach (array_values($this->model) as $element) {
            if (is_string($element)) {
                $element = '\'' . $element . '\'';
            }
            $string .= $element . ', ';
        }
        return rtrim($string, ', ');
    }
}