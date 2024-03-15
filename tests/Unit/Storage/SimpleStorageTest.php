<?php

namespace Sunhill\Properties\Tests\Unit\Managers;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Storage\AbstractStorage;
use Sunhill\Properties\Tests\TestSupport\TestAbstractStorage;
use Sunhill\Properties\Storage\Exceptions\FieldNotAvaiableException;
use Sunhill\Properties\Tests\TestSupport\DummySimpleStorage;

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
    
}