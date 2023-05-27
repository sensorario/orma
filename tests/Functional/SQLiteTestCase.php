<?php

namespace Sensorario\Orma\Tests\Functional;

use PDO;
use PHPUnit\Framework\TestCase;

class SQLiteTestCase extends TestCase
{ 
    
    public function assertTabletableNotExists(string $tableName)
    {
        $stmt = $this->pdo->prepare(
            "SELECT name FROM sqlite_master WHERE type='table' AND name=:table"
        );
        $stmt->bindParam(':table', $tableName);
        $stmt->execute();

        $this->assertCount(0, $stmt->fetchAll());
    }

    public function assertTabletableExists(string $tableName)
    {
        $stmt = $this->pdo->prepare(
            "SELECT name FROM sqlite_master WHERE type='table' AND name=:table"
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