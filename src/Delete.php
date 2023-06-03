<?php

namespace Sensorario\Orma;

class Delete
{
    public function __construct(
        private string $table,
        private array $where,
    ) { }

    public function sqlStatement()
    {
        $sql = 'delete from ' . $this->table;
        $sql .= ' where ' . $this->values() . '';

        return $sql;
    }

    // @todo remove this duplication
    public function values($string = '')
    {
        foreach ($this->where as $key => $element) {
            $string .= $key . ' = ' . $element . ' and ';
        }
        return rtrim($string, 'and ');
    }
}
