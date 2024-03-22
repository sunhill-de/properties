<?php

namespace Sunhill\Properties\Tests\TestSupport\Marketeers;

use Sunhill\Properties\InfoMarket\Marketeer;
use Sunhill\Properties\Storage\SimpleStorage;

class TestStorage2 extends SimpleStorage
{
    protected function readValues(): array
    {
        return ['key1'=>'Value1','key2'=>'value2'];
    }
}

class TestMarketeer2 extends Marketeer
{
    
    protected function initializeElements()
    {
        $storage = new TestStorage1();
        $this->addElement('key1', $this->createProperty('string'))->setStorage($storage);
        $this->addElement('key2', $this->createProperty('string'))->setStorage($storage);
        $this->addElement('key3', new TestMarketeer1());
    }
}