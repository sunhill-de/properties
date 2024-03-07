<?php

namespace Sunhill\Properties\Tests\Unit\Managers;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Storage\AbstractIDStorage;
use Sunhill\Properties\Tests\TestSupport\TestAbstractIDStorage;

class AbstractIDStorageTest extends TestCase
{

    public function testLoadFromStorage()
    {
        $test = new TestAbstractIDStorage();
        $test->setID(1);
        $this->assertEquals('DEF', $test->getValue('test_str'));
        $this->assertFalse($test->isDirty());
    }
    
    public function testStoreNewEntry()
    {
        $test = new TestAbstractIDStorage();
        $test->setValue('test_str','AAA');
        $test->setValue('test_int',111);
        $test->commit();
        $this->assertEquals(2,$test->getID());
        $this->assertEquals('AAA',$test->data[2]['test_str']);
    }
    
    public function testUpdateEntry()
    {
        $test = new TestAbstractIDStorage();
        $test->setID(1);
        $test->setValue('test_str','AAA');
        $test->setValue('test_int',111);
        $test->commit();
        $this->assertEquals(1, $test->getID());
        $this->assertEquals('AAA', $test->data[1]['test_str']);
    }
}