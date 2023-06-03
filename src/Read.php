<?php

namespace Sensorario\Orma;

class Read
{
    public function __construct(
        private string $table,
        private array $where,
    ) { }

    public function sqlStatement()
    {
        $sql = 'select * from ' . $this->table;
        $sql .= ' where ' . $this->values() . '';

        return $sql;
    }

    // @todo remove this duplication
    public function values($string = '')
    {
        foreach ($this->where as $key => $element) {
            if (is_string($element)) {
                $element = '\'' . $element . '\'';
            }
            $string .= $key . ' = ' . $element . ' and ';
        }
        return rtrim($string, 'and ');
    }
}
