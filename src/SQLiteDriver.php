<?php

namespace Sensorario\Orma;

use PDO;

class SQLiteDriver implements SqlAdapter
{
    private PDO $pdo;

    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

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
    
    public function insert(string $tableName, array $model)
    {
        $insert = new Insert($tableName, $model);
        $stmt = $this->pdo->prepare($insert->sqlStatement());
        $stmt->execute();
    }

    public function read(string $tableName, array $where): Outcome
    {
        $read = new Read($tableName, $where);
        $stmt = $this->pdo->prepare($read->sqlStatement());
        $stmt->execute();

        $results = $stmt->fetchAll();

        return new Outcome(
            founded: count($results),
            results: $results,
        );
    }

    public function update(string $tableName, array $model, array $where)
    {
        $update = new Update($tableName, $model, $where);
        $stmt = $this->pdo->prepare($update->sqlStatement());
        $stmt->execute();
    }
}
