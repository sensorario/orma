<?php

namespace Sensorario\Orma\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sensorario\Orma\Insert;

class InsertTest extends TestCase
{
    /** @test */
    public function should()
    {
        $insert = new Insert('tab', [ 'id' => 42 ]);
        $this->assertEquals('insert into tab (id) values (42);', $insert->sqlStatement()); 
    }
}


