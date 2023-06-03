<?php

namespace Sensorario\Orma\Tests\Functional\SQLite;

use PDO;
use PDOStatement;
use Sensorario\Orma\Orma;
use Sensorario\Orma\SqlAdapter;
use Sensorario\Orma\SQLiteDriver;

class SQLiteTest extends SQLiteTestCase
{

    private SqlAdapter $sqlAdapter;

    protected PDO $pdo;
    
    const FILE = __DIR__ . '/../../database.sqlite';

    private string $dns = 'sqlite:' . self::FILE;
    
    public function setUp(): void
    {
        $this->pdo = new PDO($this->dns);
        $this->sqlAdapter = new SQLiteDriver($this->pdo);
    }    

    /** @test */
    public function shouldCreateTable()
    {
        $tableName = 'table_name';
        $this->assertTabletableNotExists($tableName);

        $orma = new Orma(
            $this->pdo,
            $this->sqlAdapter
        );

        $orma($tableName)->createTable();
        $this->assertTabletableExists($tableName);
    }
    
    /** @test */
    public function shouldAddColumnInATable()
    {
        $tableName = 'table_name';
        $columnName = 'foo';
        
        $orma = new Orma(
            $this->pdo,
            $this->sqlAdapter
        );
        
        $this->assertFalse($this->sqlAdapter->checkIfColumnExists($tableName, $columnName));
        $orma($tableName)->createTable();
        $orma($tableName)->addColumn($columnName);
        $this->assertTrue($this->sqlAdapter->checkIfColumnExists($tableName, $columnName));
    }
    
    /** @test */
    public function shouldInsertNewRecordsInATable()
    {
        $tableName = 'table_name';
        $columnName = 'foo';
        
        $orma = new Orma(
            $this->pdo,
            $this->sqlAdapter
        );
        
        $orma($tableName)->createTable();
        $this->assertCountItems(0, $tableName);

        $orma($tableName)->insert([ 'id' => 42, ]);
        $this->assertCountItems(1, $tableName);

        $outcome = $orma($tableName)->read([ 'id' => 42, ]);
        $this->assertEquals(1, $outcome->founded);
    }
    
    /** @test */
    public function shouldAddColumnAndUpdateJustOneOfTheme()
    {
        $tableName = 'table_name';
        
        $orma = new Orma(
            $this->pdo,
            $this->sqlAdapter
        );
        
        $orma($tableName)->createTable();
        $orma->addColumn('username');
        $orma->addColumn('password');
        $orma->insert([
            'id' => 44,
            'username' => 'simone',
            'password' => 'simone',
        ]);
        $orma->update([ 'password' => 'password' ], [ 'id' => 44 ]);
        $after = $orma->read([ 'id' => 44, ]);
        $this->assertEquals('password', $after->results[0]['password']);
    }
    
    public function tearDown(): void
    {
        unlink(self::FILE);
    }
}
