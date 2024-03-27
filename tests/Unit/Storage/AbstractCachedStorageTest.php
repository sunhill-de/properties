<?php

namespace Sunhill\Properties\Tests\Unit\Managers;

use Sunhill\Properties\Storage\AbstractCachedStorage;
use Sunhill\Properties\Tests\TestCase;

class TestAbstractCachedStorage extends AbstractCachedStorage
{
    
    public $data = ['test_str'=>'ABC','test_int'=>123, 'test_array'=>['abc','def']];
    
    public $already_stored = false;
    
    public function getReadCapability(string $name): ?string
    {
        return null; // No need to test
    }
    
    public function getIsReadable(string $name): bool
    {
        return true;
    }
    
    public function getIsWriteable(string $name): bool
    {
        return true;
    }
    
    protected function doGetValue(string $name)
    {
        return $this->values[$name];
    }
    
    public function getWriteCapability(string $name): ?string
    {
        return null;
    }
    
    public function getWriteable(string $name): bool
    {
        return true;
    }
    
    protected function doGetIsInitialized(string $name): bool
    {
        return true;
    }
    
    public function getModifyCapability(string $name): ?string
    {
        return null;
    }
    
    protected function doReadFromUnderlying()
    {
        $this->values = $this->data;    
    }
    
    protected function doWriteToUnderlying()
    {
        $this->data = $this->values;
        $this->already_stored = true;
    }
    
    protected function doUpdateUnderlying()
    {
        $this->data = $this->values;        
    }
    
    protected function isAlreadyStored(): bool
    {
        return $this->already_stored;    
    }
    
}

class AbstractCachedStorageTest extends TestCase
{

    public function testReadValue()
    {
        $test = new TestAbstractCachedStorage();
        $test->already_stored = true;
        $this->assertEquals('ABC', $test->getValue('test_str'));
    }
    
    public function testWriteValue()
    {
        $test = new TestAbstractCachedStorage();
        $test->setValue('test_str', 'DEF');
        $this->assertEquals('DEF', $test->getValue('test_str'));
        $this->assertTrue($test->isDirty());
    }
    
    public function testStoreValue()
    {
        $test = new TestAbstractCachedStorage();
        $test->setValue('test_str', 'DEF');
        $test->commit();
        $this->assertEquals('DEF', $test->data['test_str']);
        $this->assertFalse($test->isDirty());
    }
    
    public function testUpdateValue()
    {
        $test = new TestAbstractCachedStorage();
        $test->already_stored = true;
        $test->setValue('test_str', 'DEF');
        $test->commit();
        $this->assertEquals('DEF', $test->data['test_str']);
    }
    
    public function testRollback()
    {
        $test = new TestAbstractCachedStorage();
        $test->already_stored = true;
        $test->setValue('test_str', 'DEF');
        $this->assertEquals('DEF', $test->getValue('test_str'));
        $test->rollback();
        $this->assertEquals('ABC', $test->getValue('test_str'));
    }
    
    public function testArrayRead()
    {
        $test = new TestAbstractCachedStorage();
        $test->already_stored = true;
        $this->assertEquals('abc', $test->getIndexedValue('test_array', 0));
    }
    
    public function testArrayAppend()
    {
        $test = new TestAbstractCachedStorage();
        $test->setIndexedValue('test_array', 2, 'ghi');
        $this->assertEquals('ghi', $test->getIndexedValue('test_array', 2));
        $this->assertTrue($test->isDirty());        
    }

    public function testArrayChange()
    {
        $test = new TestAbstractCachedStorage();
        $test->setIndexedValue('test_array', 1, 'ghi');
        $this->assertEquals('ghi', $test->getIndexedValue('test_array', 1));
        $this->assertTrue($test->isDirty());
    }
    
    
}