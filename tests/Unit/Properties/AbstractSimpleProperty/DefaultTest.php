<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\NonAbstractSimpleProperty;
use Sunhill\Properties\Properties\Exceptions\UninitializedValueException;
use Sunhill\Properties\Tests\TestSupport\TestAbstractIDStorage;

class DefaultTest extends TestCase
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
    
    public function testGetValueWithDefault()
    {
        $test = new NonAbstractSimpleProperty();
        $test->default(5);
        $storage = new TestAbstractIDStorage();
        
        $test->setStorage($storage);
        
        $this->assertEquals(5, $test->getValue());
    }
    
    public function testGetValueWithDefaultNull()
    {
        $test = new NonAbstractSimpleProperty();
        $test->default(null);
        $storage = new TestAbstractIDStorage();
        
        $test->setStorage($storage);
        
        $this->assertNull($test->getValue());        
    }
    
    public function testGetValueWithoutDefault()
    {
        $this->expectException(UninitializedValueException::class);
        
        $test = new NonAbstractSimpleProperty();
        $storage = new TestAbstractIDStorage();
        
        $test->setStorage($storage);
        
        $test->getValue();        
    }
}