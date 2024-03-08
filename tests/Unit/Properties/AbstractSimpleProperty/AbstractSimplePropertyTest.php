<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\NonAbstractSimpleProperty;


class AbstractSimplePropertyTest extends TestCase
{
     
    public function testDefault()
    {
        $test = new NonAbstractSimpleProperty();
        $test->default(5);
        
        $this->assertEquals(5, $test->getDefault());
    }
    
    public function testNullable()
    {
        $test = new NonAbstractSimpleProperty();
        $test->nullable();
        
        $this->assertTrue($test->getNullable());        
    }
}