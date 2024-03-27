<?php

namespace Sunhill\Properties\Tests\Unit\Managers;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Storage\Exceptions\FieldNotAvaiableException;
use Sunhill\Properties\Tests\TestSupport\Storages\DummySimpleStorage;

class SimpleStorageTest extends TestCase
{

    public function testReadValue()
    {
        $test = new DummySimpleStorage();
        $this->assertEquals('ValueA', $test->getValue('keyA'));
    }
    
    public function testReadUnknownValue()
    {
        $this->expectException(FieldNotAvaiableException::class);
        
        $test = new DummySimpleStorage();
        $help = $test->getValue('NonExisting');
    }
    
    public function testReadArrayValue()
    {
        $test = new DummySimpleStorage();
        $this->assertEquals('DEF', $test->getIndexedValue('keyC', 1));
    }
    
    public function testArrayCount()
    {
        $test = new DummySimpleStorage();
        $this->assertEquals(2, $test->getElementCount('keyC'));        
    }
}