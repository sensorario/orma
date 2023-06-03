<?php

namespace Sensorario\Orma\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sensorario\Orma\Read;

class ReadTest extends TestCase
{
    /** @test */
    public function shouldAbstractSelectInstruction()
    {
        $insert = new Read('tab', [ 'id' => 42 ]);
        $this->assertEquals('select * from tab where id = 42', $insert->sqlStatement()); 
    }

    /** @test */
    public function shouldAbstractComplexSelectInstruction()
    {
        $insert = new Read('tab', [ 'id' => 42, 'foo' => 'bar', 'x' => 43 ]);
        $this->assertEquals('select * from tab where id = 42 and foo = \'bar\' and x = 43', $insert->sqlStatement()); 
    }
}


