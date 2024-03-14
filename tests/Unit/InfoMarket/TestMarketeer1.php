<?php

namespace Sunhill\Properties\Tests\Unit\InfoMarket;

use Sunhill\Properties\InfoMarket\Marketeer;

class TestMarketeer1 extends Marketeer
{
    
    protected function initializeElements()
    {
        $this->addElement('element1', $this->createProperty('string'))->setValue('Test');
        $this->addElement('element2', $this->createProperty('string'))->setValue('Another test');
    }
}