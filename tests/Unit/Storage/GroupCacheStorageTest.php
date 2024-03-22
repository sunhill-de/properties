<?php

namespace Sunhill\Properties\Tests\Unit\Managers;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Storage\Exceptions\FieldNotAvaiableException;
use Sunhill\Properties\Tests\TestSupport\Storages\DummySimpleWriteableStorage;
use Sunhill\Properties\Tests\TestSupport\Storages\DummyGroupCacheStorage;
use Illuminate\Support\Facades\Cache;
use Sunhill\Properties\Storage\Exceptions\CacheIDNotSetException;

class GroupCacheStorageTest extends TestCase
{

    public function testReadValue()
    {
        Cache::flush();
        
        $test = new DummyGroupCacheStorage();
        $test->setCacheID('teststorage');
        $this->assertEquals('ValueA', $test->getValue('keyA'));
        $this->assertEquals(1, $test::$call_count);
        
        $test2 = new DummyGroupCacheStorage();
        $test2->setCacheID('teststorage');
        $this->assertEquals('ValueB', $test2->getValue('keyB'));
        $this->assertEquals(1, $test::$call_count);
    }
    
    public function testNoCacheIDSet()
    {
        $this->expectException(CacheIDNotSetException::class);
        
        $test = new DummyGroupCacheStorage();
        $test->getValue('keyA');
        
    }
}