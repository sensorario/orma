<?php

namespace Sensorario\Orma;

class Update
{
    public function __construct(
        private string $table,
        private array $model = [],
        private array $where = [],
    ) { }

    public function sqlStatement()
    {
        $sql = 'update ' . $this->table . ' ';
        $sql .= 'set ' . $this->keyValues();
        $sql .= 'where ' . $this->values() . ';';

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

    public function keyValues()
    {
        $values = '';
        foreach ($this->model as $key => $value) {
            if (is_string($value)) $value = '\''.$value.'\'';
            $values .= $key . ' = ' . $value . ' ';
        }
        return $values;
    }
}
