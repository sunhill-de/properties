<?php

namespace Sunhill\Properties\Tests\Unit\Managers;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Storage\AbstractStorage;
use Sunhill\Properties\Tests\TestSupport\TestAbstractStorage;

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
}