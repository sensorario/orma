<?php

namespace Sensorario\Orma;

use PDO;

class SQLiteDriver implements SqlAdapter
{
    public function __construct(private PDO $pdo) { }

    public function createTable(string $tableName)
    {
        return sprintf('create table if not exists %s (id)', $tableName);
    }
    
    public function checkIfColumnExists(string $tableName, string $columnName)
    {
        $stmt = $this->pdo->prepare("PRAGMA table_info($tableName)");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($columns as $column) {
            if ($column['name'] === $columnName) {
                return true;
            }
        }

        return false;
    }

    public function addColumn(string $tableName, string $column)
    {
        return sprintf('alter table %s add %s', $tableName, $column);
    }
}