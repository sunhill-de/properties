<?php

namespace Sunhill\Properties\Tests\Unit\InfoMarket;

use Sunhill\Properties\InfoMarket\Market;

class TestMarket extends Market
{
    
    protected function initializeElements()
    {
        $this->addElement('marketeer1', new TestMarketeer1());
        $this->addElement('marketeer2', new TestMarketeer2());
    }
    
}