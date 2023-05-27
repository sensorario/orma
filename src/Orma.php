<?php

namespace Sensorario\Orma;

use PDO;

class Orma
{
    private string $tableName;

    public function __construct(
        protected PDO $pdo,
        private SqlAdapter $sqlAdapter,
    ) { }

    public function __invoke(string $tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function createTable()
    {
        $sql = $this->sqlAdapter->createTable($this->tableName);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function addColumn(string $column)
    {
        $exists = $this->sqlAdapter->checkIfColumnExists($this->tableName, $column);
        if ($exists) return;
        $sql = $this->sqlAdapter->addColumn($this->tableName, $column);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }
}