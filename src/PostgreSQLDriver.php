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
    
}
