<?php

namespace Sensorario\Orma\Tests\Functional\PostgreSQL;

use PDO;
use PDOStatement;
use Sensorario\Orma\Orma;
use Sensorario\Orma\SqlAdapter;
use Sensorario\Orma\PostgreSQLDriver;

class PostgreSQLTest extends PostgreSQLTestCase
{

    private SqlAdapter $sqlAdapter;

    protected PDO $pdo;
    
    public function setUp(): void
    {
        $host = 'database';
        $dbname = 'your_database_name';
        $username = 'your_username';
        $password = 'your_password';

        $this->pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $this->sqlAdapter = new PostgreSQLDriver($this->pdo);
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
        
        $orma = new Orma(
            $this->pdo,
            $this->sqlAdapter
        );
        
        $orma($tableName)->createTable();
        $this->assertCountItems(0, $tableName);

        $orma->insert([ 'id' => 42, ]);
        $this->assertCountItems(1, $tableName);

        $outcome = $orma->read([ 'id' => 42, ]);
        $this->assertEquals(1, $outcome->founded);

        $orma->delete([ 'id' => 42, ]);
        $outcome = $orma->read([ 'id' => 42, ]);
        $this->assertEquals(0, $outcome->founded);
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
        $stmt = $this->pdo->prepare('drop table table_name');
        $stmt->execute();
    }
}
