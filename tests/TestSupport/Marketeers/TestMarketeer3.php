<?php

namespace Sunhill\Properties\Tests\Unit\InfoMarket;

use Sunhill\Properties\InfoMarket\Marketeer;
use Sunhill\Properties\Storage\SimpleStorage;
use Sunhill\Properties\Storage\SimpleWriteableStorage;

class TestStorage3 extends SimpleWriteableStorage
{
    protected function readValues(): array
    {
        return ['stringkey'=>'ValueA','floatkey'=>3.2,'intkey'=>3,'boolkey'=>1,'textkey'=>'Lorep ipsum','datekey'=>'2023-12-24','timekey'=>'11:12:13','datetimekey'=>'2023-12-24 11:12:13'];
    }
}

class TestMarketeer3 extends Marketeer
{
    
    protected function initializeElements()
    {
        $storage = new TestStorage3();
        $this->addElement('stringkey', $this->createProperty('string'))->setStorage($storage);
        $this->addElement('floatkey', $this->createProperty('float'))->setStorage($storage);
        $this->addElement('intkey', $this->createProperty('integer'))->setStorage($storage);
        $this->addElement('boolkey', $this->createProperty('boolean'))->setStorage($storage);
        $this->addElement('textkey', $this->createProperty('text'))->setStorage($storage);
        $this->addElement('datekey', $this->createProperty('date'))->setStorage($storage);
        $this->addElement('timekey', $this->createProperty('time'))->setStorage($storage);
        $this->addElement('datetimekey', $this->createProperty('datetime'))->setStorage($storage);
    }
}