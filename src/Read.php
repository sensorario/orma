<?php

namespace Sensorario\Orma;

class Read
{
    public function __construct(
        private string $table,
        private array $model,
    ) { }

    public function sqlStatement()
    {
        $sql = 'select * from ' . $this->table;
        $sql .= ' where ' . $this->values() . '';

        return $sql;
    }

    public function values($string = '')
    {
        foreach ($this->model as $key => $element) {
            if (is_string($element)) {
                $element = '\'' . $element . '\'';
            }
            $string .= $key . ' = ' . $element . ' and ';
        }
        return rtrim($string, 'and ');
    }
}
