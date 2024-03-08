<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\NonAbstractArrayProperty;


class AbstractArrayPropertyTest extends TestCase
{
     
    public function testSimpleAccess()
    {
        $test = new NonAbstractArrayProperty();
        $this->assertEquals(2, $test->count());
    }
    
}