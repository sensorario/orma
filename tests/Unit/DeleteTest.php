<?php

namespace Sensorario\Orma\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sensorario\Orma\Delete;

class DeleteTest extends TestCase
{
    /** @test */
    public function shouldAbstractInsertInstruction()
    {
        $insert = new Delete('tab', [ 'id' => 42 ]);
        $this->assertEquals('delete from tab where id = 42', $insert->sqlStatement()); 
    }
}

