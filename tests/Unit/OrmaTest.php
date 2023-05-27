<?php

namespace Sensorario\Orma\Tests\Unit;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Sensorario\Orma\Orma;
use Sensorario\Orma\SqlAdapter;

class OrmaTest extends TestCase
{
    private PDO $pdo;

    private PDOStatement $pdoStatement;

    private SqlAdapter $sqlAdapter;

    public function setUp(): void
    {
        $this->pdo = $this
            ->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sqlAdapter = $this
            ->getMockBuilder(SqlAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pdoStatement = $this
            ->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->getMock();
    }    

    /** @test */
    public function shouldCreateTable()
    {
        $tableName = 'table_name';

        $this->pdoStatement
            ->expects($this->once())
            ->method('execute');

        // new PDO('sqlite:database')
        $this->pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStatement);

        $this->sqlAdapter->expects($this->once())
            ->method('createTable')
            ->with($tableName)
            ->willReturn(
                sprintf('crerate table if not exists %s (id)', $tableName)
            );

        $orma = new Orma(
            $this->pdo,
            $this->sqlAdapter
        );

        $orma($tableName)->createTable();
    }

    /** @test */
    public function shouldAddColumnInATable()
    {
        $tableName = 'table_name';
        $columnName = 'foo';

        $this->sqlAdapter->expects($this->once())
            ->method('checkIfColumnExists')
            ->with($tableName, $columnName)
            ->willReturn(false);
        $this->sqlAdapter->expects($this->once())
            ->method('addColumn')
            ->with($tableName, $columnName)
            ->willReturn('foo');

        $this->pdoStatement
            ->expects($this->once())
            ->method('execute');

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with('foo')
            ->willReturn($this->pdoStatement);

        $orma = new Orma(
            $this->pdo,
            $this->sqlAdapter
        );

        $orma($tableName)->addColumn($columnName);
    }

    /** @test */
    public function shouldNeverAddColumnWheneverAlreadyExists()
    {
        $tableName = 'table_name';
        $columnName = 'foo';

        $this->sqlAdapter->expects($this->once())
            ->method('checkIfColumnExists')
            ->with($tableName, $columnName)
            ->willReturn(true);
        $this->sqlAdapter->expects($this->never())
            ->method('addColumn');

        $orma = new Orma(
            $this->pdo,
            $this->sqlAdapter
        );

        $orma($tableName)->addColumn($columnName);
    }
}
