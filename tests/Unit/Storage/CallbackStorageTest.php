<?php

namespace Sunhill\Properties\Tests\Unit\Managers;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Storage\Exceptions\FieldNotAvaiableException;
use Sunhill\Properties\Tests\TestSupport\Storages\DummyCallbackStorage;

class CallbackStorageTest extends TestCase
{

    public function testReadValue()
    {
        $test = new DummyCallbackStorage();
        $this->assertEquals('ABC', $test->getValue('readonly'));
    }
    
    public function testReadUnknownValue()
    {
        $this->expectException(FieldNotAvaiableException::class);
        
        $test = new DummyCallbackStorage();
        $help = $test->getValue('NonExisting');
    }
    
    public function testGetReadableOnReadonly()
    {
        $test = new DummyCallbackStorage();
        
        $this->assertTrue($test->getIsReadable('readonly'));
    }
    
    public function testGetWriteableOnReadonly()
    {
        $test = new DummyCallbackStorage();
        
        $this->assertFalse($test->getIsWriteable('readonly'));
    }

    public function testWriteReadonly()
    {
        $this->expectException(FieldNotAvaiableException::class);
        
        $test = new DummyCallbackStorage();
        $test->setValue('readonly', 'RRR');        
    }
    
    public function testEmptyCapsOnReadonly()
    {
        $test = new DummyCallbackStorage();
        
        $this->assertNull($test->getReadCapability('readonly'));
    }
    
    public function testReadReadWrite()
    {
        $test = new DummyCallbackStorage();
        $this->assertEquals('DEF', $test->getValue('readwrite'));
    }

    public function testWriteReadWrite()
    {
        $test = new DummyCallbackStorage();
        $test->setValue('readwrite','ZZZ');
        $this->assertEquals('ZZZ', $test->readwrite);
    }
    
    public function testGetReadableOnReadwrite()
    {
        $test = new DummyCallbackStorage();
        
        $this->assertTrue($test->getIsReadable('readwrite'));
    }
    
    public function testGetWriteableOnReadwrite()
    {
        $test = new DummyCallbackStorage();
        
        $this->assertTrue($test->getIsWriteable('readwrite'));
    }

    public function testGetCapabilitiesOnRestricted()
    {
        $test = new DummyCallbackStorage();
        
        $this->assertEquals('write_cap', $test->getWriteCapability('restricted'));
    }
    
    public function testInitialize()
    {
        $test = new DummyCallbackStorage();
        
        $this->assertFalse($test->getIsInitialized('uninitialized'));
        $test->setValue('uninitialized','GHI');
        $this->assertTrue($test->getIsInitialized('uninitialized'));
        $this->assertEquals('GHI', $test->uninitialized);
    }
}