<?php

namespace Sensorario\Orma;

interface SqlAdapter
{
    public function setPdo(\PDO $pdo);
    public function createTable(string $tableName);
    public function checkIfColumnExists(string $tableName, string $column);
    public function addColumn(string $tableName, string $column);
    public function insert(string $tableName, array $model);
    public function read(string $tableName, array $where): Outcome;
    public function update(string $tableName, array $model, array $where);
    public function delete(string $tableName, array $where);
}
