<?php

namespace Sensorario\Orma\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sensorario\Orma\Insert;

class InsertTest extends TestCase
{
    /** @test */
    public function shouldAbstractInsertInstruction()
    {
        $insert = new Insert('tab', [ 'id' => 42 ]);
        $this->assertEquals('insert into tab (id) values (42);', $insert->sqlStatement()); 
    }

    /** @test */
    public function shouldWorkWithMoreThanOneKeyValuePair()
    {
        $insert = new Insert('tab', [ 'id' => 42, 'foo' => 'bar' ]);
        $this->assertEquals('insert into tab (id, foo) values (42, \'bar\');', $insert->sqlStatement()); 
    }
}


