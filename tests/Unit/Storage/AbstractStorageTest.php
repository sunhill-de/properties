<?php

namespace Sunhill\Properties\Tests\Unit\Managers;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Storages\TestAbstractStorage;
use Illuminate\Support\Facades\Cache;

class AbstractStorageTest extends TestCase
{

    public function testReadValue()
    {
        $test = new TestAbstractStorage();
        $this->assertEquals('TESTVALUE', $test->getValue('test'));
    }
    
    public function testWriteValue()
    {
        $test = new TestAbstractStorage();
        $test->setValue('new','NEWVALUE');
        $this->assertEquals('NEWVALUE', $test->getValue('new'));
    }
    
    public function testUpdateValue()
    {
        $test = new TestAbstractStorage();
        $test->setValue('test', 'NEWVALUE');
        $this->assertEquals('NEWVALUE', $test->getValue('test'));
    }
    
    public function testCacheMissWhileReading()
    {
        Cache::flush();
        
        $test = new TestAbstractStorage();
        $test->setCacheID('teststorage');
        $test->getValue('test');
        
        $this->assertEquals('TESTVALUE', Cache::get('teststorage.test'));
    }
    
    public function testCacheHitWhileReading()
    {
        Cache::flush();
        
        $test = new TestAbstractStorage();
        Cache::put('teststorage.test','cachedvalue');
        $test->setCacheID('teststorage');
        
        $this->assertEquals('cachedvalue', $test->getValue('test'));
        
    }
    
    public function testCacheUpdateWhileWriting()
    {
        Cache::flush();
        
        $test = new TestAbstractStorage();
        $test->setCacheID('teststorage');
        $test->setValue('new', 'NEWVALUE');
        $this->assertEquals('NEWVALUE', Cache::get('teststorage.new'));
    }
        
    public function testCacheUpdateWhileUpdating()
    {
        Cache::flush();
        
        $test = new TestAbstractStorage();
        $test->setCacheID('teststorage');
        $test->getValue('test');
        $this->assertEquals('TESTVALUE', Cache::get('teststorage.test'));
        
        $test->setValue('test', 'NEWVALUE');
        $this->assertEquals('NEWVALUE', Cache::get('teststorage.test'));
    }
    
    public function testCacheOutdate()
    {
        Cache::flush();
        
        $test = new TestAbstractStorage();
        $test->setCacheID('teststorage')->setCacheTime(1); // Set caching time to 1 second
        Cache::put('teststorage.test','cached',1);
        sleep(2);
        $this->assertEquals('TESTVALUE', $test->getValue('test'));        
    }
    
    public function testArrayAccess()
    {
        $test = new TestAbstractStorage();
        $this->assertEquals('DEF',$test->getIndexedValue('array_val',1));
    }
     
    public function testArrayOverwrite()
    {
        $test = new TestAbstractStorage();
        $test->setIndexedValue('array_val',1,'XYZ');
        $this->assertEquals('XYZ',$test->getIndexedValue('array_val',1));        
    }
    
    public function testArrayAppend()
    {
        $test = new TestAbstractStorage();
        $test->setIndexedValue('array_val',null,'XYZ');
        $this->assertEquals('XYZ',$test->getIndexedValue('array_val',2));
    }
    
    public function testArrayCount()
    {
        $test = new TestAbstractStorage();
        $this->assertEquals(2, $test->getElementCount('array_val'));
    }
}