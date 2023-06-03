<?php

namespace Sensorario\Orma;

use PDO;

class PostgreSQLDriver implements SqlAdapter
{
    private PDO $pdo;

    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function createTable(string $tableName)
    {
        return sprintf('create table if not exists %s (id serial primary key)', $tableName);
    }
    
    public function checkIfColumnExists(string $tableName, string $columnName)
    {
        $stmt = $this->pdo->prepare(
            "SELECT column_name FROM information_schema.columns WHERE table_name = :table AND column_name = :column"
        );
        $stmt->bindParam(':table', $tableName);
        $stmt->bindParam(':column', $columnName);
        $stmt->execute();
    
        return $stmt->rowCount() > 0;
    }
    
    public function addColumn(string $tableName, string $column)
    {
        return sprintf('ALTER TABLE %s ADD COLUMN %s VARCHAR(55);', $tableName, $column);
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

    public function delete(string $tableName, array $where)
    {
        $delete = new Delete($tableName, $where);
        $stmt = $this->pdo->prepare($delete->sqlStatement());
        $stmt->execute();
    }
}
