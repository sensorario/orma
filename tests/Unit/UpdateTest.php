<?php

namespace Sensorario\Orma\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sensorario\Orma\Update;

class UpdateTest extends TestCase
{
    /** @test */
    public function shouldAbstractInsertInstruction()
    {
        $insert = new Update('tab', [ 'foo' => 'bar' ], [ 'id' => 42 ]);
        $this->assertEquals('update tab set foo = \'bar\' where id = 42;', $insert->sqlStatement()); 
    }
}

