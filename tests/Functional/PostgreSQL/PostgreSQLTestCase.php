<?php

namespace Sensorario\Orma\Tests\Functional\PostgreSQL;

use PDO;
use PHPUnit\Framework\TestCase;

class PostgreSQLTestCase extends TestCase
{ 
    
    public function assertTabletableNotExists(string $tableName)
    {
        $stmt = $this->pdo->prepare(
            "SELECT tablename FROM pg_tables WHERE schemaname = 'public' AND tablename = :table"
        );
        $stmt->bindParam(':table', $tableName);
        $stmt->execute();

        $this->assertCount(0, $stmt->fetchAll());
    }

    public function assertTabletableExists(string $tableName)
    {
        $stmt = $this->pdo->prepare(
            "SELECT tablename FROM pg_tables WHERE schemaname = 'public' AND tablename = :table"
        );
        $stmt->bindParam(':table', $tableName);
        $stmt->execute();
        
        $this->assertCount(1, $stmt->fetchAll());
    }

    public function assertColumnExists(string $tableName, string $columnName): bool
    {
        $stmt = $this->pdo->prepare("PRAGMA table_info($tableName)");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $return = false;
        foreach ($columns as $column) {
            if ($column['name'] === $columnName) {
                $return = true;
            }
        }
        
        $this->assertTrue($return);
    }
}
