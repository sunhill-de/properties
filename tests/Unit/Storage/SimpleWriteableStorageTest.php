<?php

namespace Sunhill\Properties\Tests\Unit\Managers;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Storage\Exceptions\FieldNotAvaiableException;
use Sunhill\Properties\Tests\TestSupport\Storages\DummySimpleWriteableStorage;

class SimpleWriteableStorageTest extends TestCase
{

    public function testReadValue()
    {
        $test = new DummySimpleWriteableStorage();
        $this->assertEquals('ValueA', $test->getValue('keyA'));
    }
    
    public function testReadUnknownValue()
    {
        $this->expectException(FieldNotAvaiableException::class);
        
        $test = new DummySimpleWriteableStorage();
        $help = $test->getValue('NonExisting');
    }
    
    public function testOverwrite()
    {
        $test = new DummySimpleWriteableStorage();
        $test->setValue('keyA','NewValue');
        
        $this->assertEquals('NewValue', $test->getValue('keyA'));
    }
        
    public function testWritenew()
    {
        $test = new DummySimpleWriteableStorage();
        $test->setValue('keyC','NewValue');
        
        $this->assertEquals('NewValue', $test->getValue('keyC'));
    }
    
}